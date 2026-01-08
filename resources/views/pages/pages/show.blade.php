@extends('layouts.default')

@section('title', $page->getTranslation('meta_title', app()->getLocale()) ?? $page->getTranslation('title', app()->getLocale()))

@section('og_image'){{ $page->getFirstMediaUrl('featured') ?: $page->getFirstMediaUrl('gallery') ?: asset('storefront/images/placeholder-og.jpg') }}@endsection

@section('head')
    {!! $schemaJsonLdScripts !!}
@endsection

@php
    $locale = app()->getLocale();
    $pageTitle = $page->getTranslation('title', $locale);
    $pageExcerpt = $page->getTranslation('excerpt', $locale);
    $pageBody = $page->getTranslation('body', $locale);
    $featuredImages = $page->getFeaturedImageUrls();
    $galleryImages = $page->getMedia('gallery');
@endphp

@section('content')
    <x-breadcrumb :items="[
        ['label' => __('navigation.Home'), 'url' => route('home', $locale)],
        ['label' => $pageTitle]
    ]" />

    {{-- Hero Section with Featured Image --}}
    @if($featuredImages['desktop'])
        <section class="page-hero mb-4 mb-xl-5">
            <div class="container">
                <div class="page-hero__banner position-relative rounded-3 overflow-hidden" style="min-height: 280px; max-height: 400px;">
                    <picture>
                        {{-- Mobile WebP --}}
                        @if($featuredImages['mobile_webp'])
                            <source media="(max-width: 768px)" srcset="{{ $featuredImages['mobile_webp'] }}" type="image/webp">
                        @endif
                        {{-- Mobile fallback --}}
                        @if($featuredImages['mobile'])
                            <source media="(max-width: 768px)" srcset="{{ $featuredImages['mobile'] }}">
                        @endif
                        {{-- Tablet WebP --}}
                        @if($featuredImages['tablet_webp'])
                            <source media="(max-width: 1024px)" srcset="{{ $featuredImages['tablet_webp'] }}" type="image/webp">
                        @endif
                        {{-- Tablet fallback --}}
                        @if($featuredImages['tablet'])
                            <source media="(max-width: 1024px)" srcset="{{ $featuredImages['tablet'] }}">
                        @endif
                        {{-- Desktop WebP --}}
                        @if($featuredImages['desktop_webp'])
                            <source srcset="{{ $featuredImages['desktop_webp'] }}" type="image/webp">
                        @endif
                        <img loading="lazy"
                             src="{{ $featuredImages['desktop'] }}"
                             alt="{{ $pageTitle }}"
                             class="w-100 h-100 object-fit-cover"
                             style="position: absolute; top: 0; left: 0;">
                    </picture>
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                         style="background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.5));">
                        <div class="text-center text-white p-4">
                            <h1 class="page-hero__title mb-0">{{ $pageTitle }}</h1>
                            @if($pageExcerpt)
                                <p class="page-hero__excerpt mb-0 mt-3 opacity-90">{{ $pageExcerpt }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        {{-- Simple Header without Featured Image --}}
        <section class="page-header mb-4 mb-xl-5">
            <div class="container">
                <div class="page-header__content text-center py-4 py-md-5">
                    <h1 class="page-title mb-0">{{ $pageTitle }}</h1>
                    @if($pageExcerpt)
                        <p class="page-header__excerpt text-muted mt-3 mb-0 mx-auto" style="max-width: 700px;">
                            {{ $pageExcerpt }}
                        </p>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- Main Content --}}
    <article class="page-content py-4 py-md-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8">
                    <div class="page-content__body">
                        {!! $pageBody !!}
                    </div>

                    {{-- Gallery Section --}}
                    @if($galleryImages->isNotEmpty())
                        <div class="page-gallery mt-5 pt-4 border-top">
                            <h3 class="page-gallery__title mb-4">{{ __('page.Gallery') }}</h3>
                            <div class="row g-3 g-md-4">
                                @foreach($galleryImages as $index => $image)
                                    <div class="col-6 col-md-4">
                                        <a href="{{ $image->getUrl() }}"
                                           class="page-gallery__item d-block rounded-3 overflow-hidden"
                                           data-fslightbox="page-gallery">
                                            <img loading="lazy"
                                                 src="{{ $image->getUrl('thumb') ?: $image->getUrl() }}"
                                                 alt="{{ $pageTitle }} - {{ __('page.Image') }} {{ $index + 1 }}"
                                                 class="w-100 h-100 object-fit-cover"
                                                 style="aspect-ratio: 4/3;">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </article>

    {{-- Related Pages / Navigation (optional) --}}
    <section class="page-navigation py-4 py-md-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <a href="{{ route('home', $locale) }}" class="btn btn-outline-secondary">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-2">
                                <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            {{ __('navigation.Home') }}
                        </a>
                        <a href="{{ route('contacts.index', $locale) }}" class="btn btn-primary">
                            {{ __('navigation.Contact Us') }}
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="ms-2">
                                <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
/* Page Hero */
.page-hero__title {
    font-size: 2rem;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.page-hero__excerpt {
    font-size: 1.1rem;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

@media (min-width: 768px) {
    .page-hero__title {
        font-size: 2.5rem;
    }

    .page-hero__banner {
        min-height: 350px !important;
    }
}

/* Page Header (no image) */
.page-header__content {
    border-bottom: 1px solid #eee;
}

.page-header__excerpt {
    font-size: 1.1rem;
    line-height: 1.6;
}

/* Page Content Body */
.page-content__body {
    font-size: 1rem;
    line-height: 1.8;
    color: #333;
}

.page-content__body h2 {
    font-size: 1.75rem;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #222;
}

.page-content__body h3 {
    font-size: 1.4rem;
    font-weight: 600;
    margin-top: 1.75rem;
    margin-bottom: 0.75rem;
    color: #333;
}

.page-content__body h4 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
    color: #444;
}

.page-content__body p {
    margin-bottom: 1.25rem;
}

.page-content__body ul,
.page-content__body ol {
    margin-bottom: 1.25rem;
    padding-left: 1.5rem;
}

.page-content__body li {
    margin-bottom: 0.5rem;
    line-height: 1.7;
}

.page-content__body strong {
    font-weight: 600;
    color: #222;
}

.page-content__body a {
    color: var(--bs-primary, #0d6efd);
    text-decoration: underline;
    transition: color 0.2s ease;
}

.page-content__body a:hover {
    color: var(--bs-primary-dark, #0a58ca);
}

.page-content__body blockquote {
    border-left: 4px solid var(--bs-primary, #0d6efd);
    padding: 1rem 1.5rem;
    margin: 1.5rem 0;
    background: #f8f9fa;
    border-radius: 0 0.5rem 0.5rem 0;
    font-style: italic;
    color: #555;
}

.page-content__body img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1rem 0;
}

.page-content__body table {
    width: 100%;
    margin-bottom: 1.25rem;
    border-collapse: collapse;
}

.page-content__body table th,
.page-content__body table td {
    padding: 0.75rem;
    border: 1px solid #dee2e6;
}

.page-content__body table th {
    background: #f8f9fa;
    font-weight: 600;
}

/* Gallery */
.page-gallery__title {
    font-size: 1.4rem;
    font-weight: 600;
    color: #333;
}

.page-gallery__item {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.page-gallery__item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}

.page-gallery__item img {
    transition: transform 0.3s ease;
}

.page-gallery__item:hover img {
    transform: scale(1.05);
}

/* Navigation Section */
.page-navigation {
    border-top: 1px solid #dee2e6;
}

/* Responsive */
@media (max-width: 575.98px) {
    .page-content__body {
        font-size: 0.95rem;
    }

    .page-content__body h2 {
        font-size: 1.5rem;
    }

    .page-content__body h3 {
        font-size: 1.25rem;
    }

    .page-navigation .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush
