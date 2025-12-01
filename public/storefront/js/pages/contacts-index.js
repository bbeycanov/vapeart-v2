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

let map;
let markers = [];

function initGoogleMap() {
    // Get data from window object
    const contactPageData = window.contactPageData || {};
    
    // Initialize map with default branch
    const defaultTab = document.querySelector('#branchTabs .nav-link.active');
    if (defaultTab) {
        initMap(
            parseFloat(defaultTab.getAttribute('data-lat')) || 40.4093,
            parseFloat(defaultTab.getAttribute('data-lng')) || 49.8671,
            defaultTab.getAttribute('data-name'),
            defaultTab.getAttribute('data-address')
        );
    } else {
        // Default location (Baku)
        initMap(40.4093, 49.8671, contactPageData.contactUsText || 'Contact Us', '');
    }

    // Tab change event
    const tabButtons = document.querySelectorAll('#branchTabs button[data-bs-toggle="tab"]');
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function(e) {
            const lat = parseFloat(this.getAttribute('data-lat'));
            const lng = parseFloat(this.getAttribute('data-lng'));
            const name = this.getAttribute('data-name');
            const address = this.getAttribute('data-address');

            if (lat && lng) {
                initMap(lat, lng, name, address);
            }
        });
    });
}

function initMap(lat, lng, name, address) {
    if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
        console.warn('Google Maps API not loaded');
        return;
    }

    // Initialize Google Maps
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: lat, lng: lng },
        zoom: 15,
        styles: [
            {
                featureType: 'poi',
                elementType: 'labels',
                stylers: [{ visibility: 'off' }]
            }
        ]
    });

    // Add marker
    const marker = new google.maps.Marker({
        position: { lat: lat, lng: lng },
        map: map,
        title: name,
        animation: google.maps.Animation.DROP
    });

    // Info window
    const infoWindow = new google.maps.InfoWindow({
        content: `<div style="padding: 10px;"><strong style="color: #222222; font-size: 1.1rem;">${name}</strong><br><p style="margin: 5px 0 0 0; color: #767676;">${address || ''}</p></div>`
    });

    marker.addListener('click', () => {
        infoWindow.open(map, marker);
    });

    // Auto open info window
    infoWindow.open(map, marker);

    // Clear previous markers
    markers.forEach(m => m.setMap(null));
    markers = [marker];
}

document.addEventListener('DOMContentLoaded', function() {
    // Get translation strings from window object
    const contactPageData = window.contactPageData || {};
    
    // Wait for Google Maps to load
    if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
        initGoogleMap();
    } else if (contactPageData.googleMapsApiKey) {
        // Load Google Maps script
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=${contactPageData.googleMapsApiKey}&callback=initGoogleMap`;
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    } else {
        // No API key
        const mapEl = document.getElementById('map');
        if (mapEl && contactPageData.noApiKeyText) {
            mapEl.innerHTML = `<div class="alert alert-info m-3">${contactPageData.noApiKeyText}</div>`;
        }
    }

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

