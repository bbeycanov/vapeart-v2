@extends('layouts.default')

@section('head')
    {!! $schemaJsonLd ?? '' !!}
@endsection

@section('title', __('page.Contact Us'))

@section('content')

    <x-breadcrumb :items="[
        ['label' => __('navigation.Home'), 'url' => route('home', app()->getLocale())],
        ['label' => __('navigation.Contact Us'), 'url' => route('contacts.index', app()->getLocale())]
    ]" />

    <section class="contact-page-title mb-4 mb-xl-5">
        <div class="container">
            <h2 class="page-title">{{ __('page.Contact Us') }}</h2>
        </div>
    </section>

    <section class="contact-us py-4 py-md-5">
        <div class="container">
            @if($branches->count() > 0)
                <!-- Branch Tabs -->
                <div class="branch-tabs-wrapper mb-5">
                    <ul class="nav nav-pills branch-tabs" id="branchTabs" role="tablist">
                        @foreach($branches as $index => $branch)
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link branch-tab-btn {{ ($defaultBranch && $defaultBranch->id === $branch->id) || ($index === 0 && !$defaultBranch) ? 'active' : '' }}"
                                    id="branch-tab-{{ $branch->id }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#branch-{{ $branch->id }}"
                                    type="button"
                                    role="tab"
                                    data-lat="{{ $branch->latitude }}"
                                    data-lng="{{ $branch->longitude }}"
                                    data-name="{{ $branch->getTranslation('name', app()->getLocale()) }}"
                                    data-address="{{ $branch->getTranslation('address', app()->getLocale()) }}">
                                    {{ $branch->getTranslation('name', app()->getLocale()) }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Branch Content -->
                <div class="tab-content mb-5" id="branchTabsContent">
                    @foreach($branches as $index => $branch)
                        <div
                            class="tab-pane fade {{ ($defaultBranch && $defaultBranch->id === $branch->id) || ($index === 0 && !$defaultBranch) ? 'show active' : '' }}"
                            id="branch-{{ $branch->id }}"
                            role="tabpanel"
                            aria-labelledby="branch-tab-{{ $branch->id }}">
                            <div class="branch-info-card card shadow-sm border-0 mb-4">
                                <div class="card-body p-4 p-md-5">
                                    <div class="branch-header mb-4 pb-4 border-bottom">
                                        <h3 class="branch-name-contact mb-3">
                                            {{ $branch->getTranslation('name', app()->getLocale()) }}
                                        </h3>
                                        @if($description = $branch->getTranslation('description', app()->getLocale()))
                                            <div class="branch-description">
                                                {!! $description !!}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="branch-contact-info">
                                        <div class="row g-3">
                                            @if($address = $branch->getTranslation('address', app()->getLocale()))
                                                <div class="col-12">
                                                    <div class="contact-item">
                                                        <div class="contact-icon">
                                                            <i class="bi bi-geo-alt-fill"></i>
                                                        </div>
                                                        <div class="contact-content">
                                                            <strong class="contact-label">{{ __('common.Address') }}</strong>
                                                            <p class="contact-value mb-0">{!! nl2br(e($address)) !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($branch->phone)
                                                <div class="col-md-6">
                                                    <div class="contact-item">
                                                        <div class="contact-icon">
                                                            <i class="bi bi-telephone-fill"></i>
                                                        </div>
                                                        <div class="contact-content">
                                                            <strong class="contact-label">{{ __('common.Phone') }}</strong>
                                                            <a href="tel:{{ $branch->phone }}" class="contact-link">{{ $branch->phone }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($branch->email)
                                                <div class="col-md-6">
                                                    <div class="contact-item">
                                                        <div class="contact-icon">
                                                            <i class="bi bi-envelope-fill"></i>
                                                        </div>
                                                        <div class="contact-content">
                                                            <strong class="contact-label">{{ __('common.Email') }}</strong>
                                                            <a href="mailto:{{ $branch->email }}" class="contact-link">{{ $branch->email }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($branch->whatsapp)
                                                <div class="col-md-6">
                                                    <div class="contact-item">
                                                        <div class="contact-icon">
                                                            <i class="bi bi-whatsapp"></i>
                                                        </div>
                                                        <div class="contact-content">
                                                            <strong class="contact-label">{{ __('common.WhatsApp') }}</strong>
                                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $branch->whatsapp) }}" target="_blank" class="contact-link">{{ $branch->whatsapp }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($workingHours = $branch->getTranslation('working_hours', app()->getLocale()))
                                                <div class="col-md-6">
                                                    <div class="contact-item">
                                                        <div class="contact-icon">
                                                            <i class="bi bi-clock-fill"></i>
                                                        </div>
                                                        <div class="contact-content">
                                                            <strong class="contact-label">{{ __('common.Working Hours') }}</strong>
                                                            <p class="contact-value mb-0">{!! nl2br(e($workingHours)) !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Google Maps Container -->
            <div class="google-map-container mb-5">
                <div id="map" class="google-map__wrapper"></div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrapper">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="contact-form-card card shadow-sm border">
                            <div class="card-body p-4 p-md-5">
                                <h3 class="form-title mb-3 text-center">
                                    {{ __('messages.Get In Touch') }}
                                </h3>
                                <p class="text-center text-muted mb-4">{{ __('messages.Fill out the form below and we will get back to you as soon as possible.') }}</p>

                                <form id="contact-form" name="contact-us-form" class="needs-validation" novalidate>
                                    @csrf

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="contact_us_name"
                                                    name="name"
                                                    placeholder="{{ __('form.Name') }} *"
                                                    required>
                                                <label for="contact_us_name">{{ __('form.Name') }} *</label>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input
                                                    type="email"
                                                    class="form-control"
                                                    id="contact_us_email"
                                                    name="email"
                                                    placeholder="{{ __('form.Email address') }} *"
                                                    required>
                                                <label for="contact_us_email">{{ __('form.Email address') }} *</label>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-floating">
                                                <textarea
                                                    class="form-control"
                                                    id="contact_us_message"
                                                    name="message"
                                                    placeholder="{{ __('form.Your Message') }}"
                                                    style="height: 150px;"
                                                    required></textarea>
                                                <label for="contact_us_message">{{ __('form.Your Message') }} *</label>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-lg w-100" id="submit-btn">
                                                <span class="btn-text">{{ __('buttons.Send Message') }}</span>
                                                <span class="btn-loading" style="display: none;">
                                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                                    {{ __('form.Sending...') }}
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
/* Branch Tabs */
.branch-tabs-wrapper {
    padding: 0;
    margin-bottom: 2rem;
}

.branch-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: start;
    margin: 0;
    padding: 0;
    list-style: none;
    background: transparent;
}

.branch-tab-btn {
    background-color: #ffffff;
    color: #222222;
    border: 2px solid #e4e4e4;
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 500;
    font-size: 0.9375rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.branch-tab-btn:hover {
    background-color: #faf9f8;
    border-color: #222222;
    color: #222222;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(34, 34, 34, 0.1);
}

.branch-tab-btn.active {
    background-color: #222222;
    color: #ffffff;
    border-color: #222222;
    box-shadow: 0 4px 12px rgba(34, 34, 34, 0.2);
}

.branch-tab-btn.active:hover {
    background-color: #86BC42;
    border-color: #86BC42;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(134, 188, 66, 0.3);
}

/* Branch Info Card */
.branch-info-card {
    border-radius: 8px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-bottom: 2rem;

}

.branch-info-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1) !important;
}

.branch-info-card .card-body{
    border: 2px solid #e4e4e4;
    border-radius: 8px;
}

.branch-header {
    border-bottom: 1px solid #e4e4e4;
}

.branch-name-contact {
    color: #222222;
    font-weight: 600;
    font-size: 1.75rem;
    margin-bottom: 1rem;
}

.branch-description {
    color: #767676;
    line-height: 1.8;
    font-size: 0.9375rem;
}

.branch-contact-info {
    margin-top: 1.5rem;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.25rem;
    background: #ffffff;
    border-radius: 8px;
    transition: all 0.3s ease;
    border: 2px solid #e4e4e4;
    margin-bottom: 0;
    height: 100%;
}

.contact-item:hover {
    background: #faf9f8;
    border-color: #222222;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.contact-icon {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #222222;
    color: #ffffff;
    border-radius: 8px;
    font-size: 1.1rem;
    flex-shrink: 0;
    transition: background-color 0.3s ease;
}

.contact-item:hover .contact-icon {
    background-color: #86BC42;
}

.contact-content {
    flex: 1;
    min-width: 0;
}

.contact-label {
    color: #222222;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.contact-value {
    color: #767676;
    font-size: 0.9375rem;
    line-height: 1.6;
    margin: 0;
    word-wrap: break-word;
}

.contact-link {
    color: #222222;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
    display: inline-block;
    font-size: 0.9375rem;
    word-break: break-all;
}

.contact-link:hover {
    color: #86BC42;
    text-decoration: none;
}

/* Google Maps Container */
.google-map-container {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    height: 500px;
    background: #faf9f8;
    border: 1px solid #e4e4e4;
}

.google-map__wrapper {
    width: 100%;
    height: 100%;
    border: none;
}

/* Contact Form */
.contact-form-wrapper {
    margin-top: 3rem;
}

.contact-form-card {
    border-radius: 8px;
}

.form-title {
    color: #222222;
    font-weight: 600;
    font-size: 1.75rem;
}

.form-floating > label {
    color: #767676;
    font-weight: 500;
}

.form-control {
    border-color: #e4e4e4;
    border-radius: 8px;
}

.form-control:focus {
    border-color: #222222;
    box-shadow: 0 0 0 0.2rem rgba(34, 34, 34, 0.15);
}

.form-control.is-invalid {
    border-color: #c32929;
}

.form-control.is-valid {
    border-color: #86BC42;
}

.btn-primary {
    background-color: #222222;
    border-color: #222222;
    color: #ffffff;
    padding: 14px 28px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.875rem;
}

.btn-primary:hover {
    background-color: #86BC42;
    border-color: #86BC42;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(134, 188, 66, 0.3);
}

.btn-primary:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Responsive */
@media (max-width: 768px) {
    .branch-tab-btn {
        padding: 10px 16px;
        font-size: 0.875rem;
    }

    .branch-name-contact {
        font-size: 1.5rem;
    }

    .contact-item {
        flex-direction: column;
        text-align: center;
    }

    .contact-icon {
        margin: 0 auto;
    }

    .google-map-container {
        height: 400px;
    }
}
</style>
@endpush

@push('scripts')
<script>
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
        initMap(40.4093, 49.8671, '{{ __('page.Contact Us') }}', '');
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
    // Wait for Google Maps to load
    if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
        initGoogleMap();
    } else {
        // Load Google Maps script
        const script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initGoogleMap';
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    }

    // Contact Form AJAX Submit
    const contactForm = document.getElementById('contact-form');
    const submitBtn = document.getElementById('submit-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');

    if (contactForm) {
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
                    toastr.warning('{{ __("Please fill in all required fields correctly.") }}', '{{ __("Validation Error") }}');
                }
                return;
            }

            // Disable submit button
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';

            // Get form data
            const formData = new FormData(this);

            // Submit via AJAX
            fetch('{{ route('contacts.store', app()->getLocale()) }}', {
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
                    throw new Error(data.message || '{{ __("An error occurred. Please try again.") }}');
                }

                return data;
            })
            .then(data => {
                if (data.success) {
                    // Show success message
                    if (typeof toastr !== 'undefined') {
                        toastr.success(data.message || '{{ __("Your message has been sent successfully!") }}', '{{ __("Success") }}');
                    }

                    // Reset form
                    contactForm.reset();
                    contactForm.classList.remove('was-validated');
                    inputs.forEach(input => {
                        input.classList.remove('is-invalid', 'is-valid');
                    });
                } else {
                    throw new Error(data.message || '{{ __("An error occurred. Please try again.") }}');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Show error message
                if (typeof toastr !== 'undefined') {
                    toastr.error(error.message || '{{ __("An error occurred. Please try again.") }}', '{{ __("Error") }}');
                } else {
                    alert(error.message || '{{ __("An error occurred. Please try again.") }}');
                }
            })
            .finally(() => {
                submitBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
            });
        });
    }
});
</script>
@if(config('services.google.maps_api_key'))
@else
<script>
console.warn('Google Maps API key not configured');
document.getElementById('map').innerHTML = '<div class="alert alert-info m-3">{{ __('branch.Google Maps API key is not configured.') }}</div>';
</script>
@endif
@endpush

@endsection
