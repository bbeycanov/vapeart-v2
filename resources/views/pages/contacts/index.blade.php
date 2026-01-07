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
            @if(isset($pageBanner) && $pageBanner && ($pageBanner->getFirstMediaUrl('image') || $pageBanner->getFirstMediaUrl('video')))
                <div class="page-banner position-relative rounded-3 overflow-hidden mb-4" style="min-height: 200px;">
                    @if($pageBanner->getFirstMediaUrl('video'))
                        <video autoplay muted loop playsinline class="w-100 h-100 object-fit-cover" style="position: absolute; top: 0; left: 0;">
                            <source src="{{ $pageBanner->getFirstMediaUrl('video') }}" type="video/mp4">
                        </video>
                    @elseif($pageBanner->getFirstMediaUrl('image'))
                        <img loading="lazy" src="{{ $pageBanner->getFirstMediaUrl('image') }}" alt="{{ $pageBanner->getTranslation('title', app()->getLocale()) }}" class="w-100 h-100 object-fit-cover" style="position: absolute; top: 0; left: 0;">
                    @endif
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.3);">
                        <div class="text-center text-white p-4">
                            <h2 class="page-title mb-0">{{ $pageBanner->getTranslation('title', app()->getLocale()) ?: __('page.Contact Us') }}</h2>
                            @if($pageBanner->getTranslation('subtitle', app()->getLocale()))
                                <p class="mb-0 mt-2">{{ $pageBanner->getTranslation('subtitle', app()->getLocale()) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <h2 class="page-title">{{ __('page.Contact Us') }}</h2>
            @endif
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
<link rel="stylesheet" href="{{ asset('storefront/css/pages/contacts-index.css') }}">
@endpush

@push('scripts')
<script>
// Pass data to JavaScript
window.contactPageData = {
    contactUsText: '{{ __('page.Contact Us') }}',
    submitUrl: '{{ route('contacts.store', app()->getLocale()) }}',
    googleMapsApiKey: '{{ config('services.google.maps_api_key') }}',
    validationErrorText: '{{ __("form.Please fill in all required fields correctly.") }}',
    validationErrorTitle: '{{ __("messages.Validation Error") }}',
    genericErrorText: '{{ __("messages.An error occurred. Please try again.") }}',
    successText: '{{ __("messages.Your message has been sent successfully!") }}',
    successTitle: '{{ __("messages.Success") }}',
    errorTitle: '{{ __("messages.Error") }}',
    noApiKeyText: '{{ __("branch.Google Maps API key is not configured.") }}'
};
</script>
<script src="{{ asset('storefront/js/pages/contacts-index.js') }}" defer></script>
@endpush

@endsection
