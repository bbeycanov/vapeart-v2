/**
 * Blog Show Page - Review Form and Star Rating
 */
(function() {
    'use strict';
    
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
        // Get data from data attributes
        const reviewForm = document.getElementById('blog-review-form');
        if (!reviewForm) return;
        
        const formData = {
            submitUrl: reviewForm.dataset.submitUrl || '',
            csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            locale: document.documentElement.lang || 'en'
        };
        
        // Star rating functionality
        const starIcons = document.querySelectorAll('.star-rating__star-icon');
        const ratingInput = document.getElementById('form-input-rating');
        let selectedRating = 0;

        starIcons.forEach(star => {
            star.addEventListener('click', function() {
                selectedRating = parseInt(this.dataset.rating);
                if (ratingInput) ratingInput.value = selectedRating;

                starIcons.forEach((s, index) => {
                    if (index < selectedRating) {
                        s.setAttribute('fill', '#ffc107');
                    } else {
                        s.setAttribute('fill', '#ccc');
                    }
                });
            });

            star.addEventListener('mouseenter', function() {
                const hoverRating = parseInt(this.dataset.rating);
                starIcons.forEach((s, index) => {
                    if (index < hoverRating) {
                        s.setAttribute('fill', '#ffc107');
                    } else {
                        s.setAttribute('fill', '#ccc');
                    }
                });
            });
        });

        // Clear validation states on input
        const formInputs = reviewForm.querySelectorAll('.form-control');
        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid', 'is-valid');
                const feedback = this.parentElement.querySelector('.invalid-feedback');
                if (feedback) feedback.remove();
            });
        });

        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear previous validation states
            reviewForm.classList.remove('was-validated');
            formInputs.forEach(input => {
                input.classList.remove('is-invalid', 'is-valid');
                input.removeAttribute('aria-invalid');
            });
            const invalidFeedbacks = reviewForm.querySelectorAll('.invalid-feedback');
            invalidFeedbacks.forEach(feedback => feedback.remove());

            let isValid = true;
            const errors = [];

            // Validate rating
            if (!ratingInput || !ratingInput.value) {
                isValid = false;
                errors.push('Please select a rating');
            }

            // Validate name
            const nameInput = document.getElementById('form-input-name');
            if (!nameInput || !nameInput.value || nameInput.value.trim() === '') {
                isValid = false;
                nameInput.classList.add('is-invalid');
                const nameFeedback = document.createElement('div');
                nameFeedback.className = 'invalid-feedback';
                nameFeedback.textContent = 'Name is required';
                nameInput.parentElement.appendChild(nameFeedback);
                errors.push('Name is required');
            }

            // Validate email
            const emailInput = document.getElementById('form-input-email');
            if (!emailInput || !emailInput.value || emailInput.value.trim() === '') {
                isValid = false;
                emailInput.classList.add('is-invalid');
                const emailFeedback = document.createElement('div');
                emailFeedback.className = 'invalid-feedback';
                emailFeedback.textContent = 'Email address is required';
                emailInput.parentElement.appendChild(emailFeedback);
                errors.push('Email address is required');
            } else if (!emailInput.validity.valid) {
                isValid = false;
                emailInput.classList.add('is-invalid');
                const emailFeedback = document.createElement('div');
                emailFeedback.className = 'invalid-feedback';
                emailFeedback.textContent = 'Please enter a valid email address';
                emailInput.parentElement.appendChild(emailFeedback);
                errors.push('Please enter a valid email address');
            }

            if (!isValid) {
                if (typeof toastr !== 'undefined') {
                    toastr.warning(errors.join('<br>'), 'Please fix the errors');
                } else {
                    alert(errors.join('\n'));
                }
                reviewForm.classList.add('was-validated');
                return;
            }

            const submitData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn ? submitBtn.textContent : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Submitting...';
            }

            fetch(formData.submitUrl, {
                method: 'POST',
                body: submitData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': formData.csrfToken
                }
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    if (data.errors) {
                        const errorMessages = Object.values(data.errors).flat().join('<br>');
                        throw new Error(errorMessages || data.message || 'Validation failed');
                    }
                    throw new Error(data.message || data.error || 'An error occurred');
                }
                return data;
            })
            .then(data => {
                if (data.success) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success(data.message || 'Review submitted successfully!', 'Success');
                    } else {
                        alert(data.message || 'Review submitted successfully!');
                    }

                    // Add review to list
                    const reviewsList = document.getElementById('reviews-list');
                    if (reviewsList) {
                        if (reviewsList.querySelector('.text-muted')) {
                            reviewsList.innerHTML = '';
                        }
                        if (data.review) {
                            reviewsList.insertAdjacentHTML('beforeend', data.review);
                        }
                    }

                    // Reset form
                    reviewForm.reset();
                    if (ratingInput) {
                        ratingInput.value = '';
                        selectedRating = 0;
                        starIcons.forEach(s => s.setAttribute('fill', '#ccc'));
                    }

                    // Clear validation
                    reviewForm.classList.remove('was-validated');
                    formInputs.forEach(input => {
                        input.classList.remove('is-invalid', 'is-valid');
                        input.removeAttribute('aria-invalid');
                    });
                    const invalidFeedback = reviewForm.querySelectorAll('.invalid-feedback');
                    invalidFeedback.forEach(feedback => feedback.remove());
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(data.message || 'An error occurred', 'Error');
                    } else {
                        alert(data.message || 'An error occurred');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error(error.message || 'An error occurred. Please try again.', 'Error');
                } else {
                    alert(error.message || 'An error occurred. Please try again.');
                }
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            });
        });
    });
})();

