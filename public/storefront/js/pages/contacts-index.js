// Configure Toastr
if (typeof toastr !== 'undefined') {
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        preventDuplicates: false,
        onclick: null,
        showDuration: '300',
        hideDuration: '1000',
        timeOut: '5000',
        extendedTimeOut: '1000',
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut'
    };
}

document.addEventListener('DOMContentLoaded', function() {
    // Get translation strings from window object
    const contactPageData = window.contactPageData || {};

    // Branch tab change - update map iframe
    const tabButtons = document.querySelectorAll('#branchTabs button[data-bs-toggle="tab"]');
    const mapIframe = document.getElementById('branch-map-iframe');

    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function(e) {
            const mapUrl = this.getAttribute('data-map-iframe');
            if (mapIframe && mapUrl) {
                mapIframe.src = mapUrl;
            }
        });
    });

    // Contact Form AJAX Submit
    const contactForm = document.getElementById('contact-form');
    const submitBtn = document.getElementById('submit-btn');
    const btnText = submitBtn?.querySelector('.btn-text');
    const btnLoading = submitBtn?.querySelector('.btn-loading');

    if (contactForm && submitBtn) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Remove previous validation classes
            this.classList.remove('was-validated');
            const inputs = this.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.classList.remove('is-invalid', 'is-valid');
            });

            // Check form validity
            if (!this.checkValidity()) {
                this.classList.add('was-validated');
                if (typeof toastr !== 'undefined') {
                    toastr.warning(contactPageData.validationErrorText || 'Please fill in all required fields correctly.', contactPageData.validationErrorTitle || 'Validation Error');
                }
                return;
            }

            // Disable submit button
            submitBtn.disabled = true;
            if (btnText) btnText.style.display = 'none';
            if (btnLoading) btnLoading.style.display = 'inline';

            // Get form data
            const formData = new FormData(this);

            // Submit via AJAX
            fetch(contactPageData.submitUrl || '', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(async response => {
                const data = await response.json();

                if (!response.ok) {
                    // Handle validation errors
                    if (response.status === 422 && data.errors) {
                        const errorMessages = Object.values(data.errors).flat().join('<br>');
                        throw new Error(errorMessages);
                    }
                    throw new Error(data.message || contactPageData.genericErrorText || 'An error occurred. Please try again.');
                }

                return data;
            })
            .then(data => {
                if (data.success) {
                    // Show success message
                    if (typeof toastr !== 'undefined') {
                        toastr.success(data.message || contactPageData.successText || 'Your message has been sent successfully!', contactPageData.successTitle || 'Success');
                    }

                    // Reset form
                    contactForm.reset();
                    contactForm.classList.remove('was-validated');
                    inputs.forEach(input => {
                        input.classList.remove('is-invalid', 'is-valid');
                    });
                } else {
                    throw new Error(data.message || contactPageData.genericErrorText || 'An error occurred. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Show error message
                if (typeof toastr !== 'undefined') {
                    toastr.error(error.message || contactPageData.genericErrorText || 'An error occurred. Please try again.', contactPageData.errorTitle || 'Error');
                } else {
                    alert(error.message || contactPageData.genericErrorText || 'An error occurred. Please try again.');
                }
            })
            .finally(() => {
                submitBtn.disabled = false;
                if (btnText) btnText.style.display = 'inline';
                if (btnLoading) btnLoading.style.display = 'none';
            });
        });
    }
});
