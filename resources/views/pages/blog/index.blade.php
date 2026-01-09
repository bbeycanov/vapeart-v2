@extends('layouts.default')

@section('head')
    {!! $schemaJsonLd ?? '' !!}
@endsection

@section('title', __('page.Blog'))

@section('content')

    <x-breadcrumb :items="[
        ['label' => __('navigation.Home'), 'url' => route('home', app()->getLocale())],
        ['label' => __('page.The Blog'), 'url' => route('blog.index', app()->getLocale())]
    ]" />


    @if($banner)
    @php
         $bannerImages = $banner->getBannerImageUrls();
         $originalImage = $banner->getFirstMediaUrl('desktop');
         $videoUrl = $banner->getFirstMediaUrl('video');
    @endphp
    <section class="blog-page-title mb-4 mb-xl-5">
        <div class="container">
            <div class="title-bg position-relative overflow-hidden">
                @if($videoUrl)
                    <video autoplay muted loop playsinline class="slideshow-bg__video object-fit-cover w-100 h-100">
                        <source src="{{ $videoUrl }}" type="video/mp4">
                    </video>
                @elseif($originalImage || $bannerImages['desktop'])
                    <picture>
                        {{-- Mobile fallback --}}
                        @if($bannerImages['mobile'])
                            <source media="(max-width: 768px)" srcset="{{ $bannerImages['mobile'] }}">
                        @endif
                        {{-- Tablet fallback --}}
                        @if($bannerImages['tablet'])
                            <source media="(max-width: 1024px)" srcset="{{ $bannerImages['tablet'] }}">
                        @endif
                        {{-- Desktop: Original image for best quality --}}
                        <img loading="eager"
                             src="{{ $originalImage ?: $bannerImages['desktop'] }}"
                             alt="{{ $title ?? __('common.Banner') }}"
                             class="slideshow-bg__img object-fit-cover w-100 h-100">
                    </picture>
                @else
                    <img loading="lazy" src="{{ asset('storefront/images/blog_title_bg.jpg') }}" width="1780" height="420" alt="Blog">
                @endif
            </div>
            @if(!$videoUrl) <h2 class="page-title">{{ __('page.The Blog') }}</h2> @endif
        </div>
    </section>
    @endif

    <section class="blog-page container py-4 py-md-5">
        <h2 class="d-none">{{ __('page.The Blog') }}</h2>
        @if($blogs->count() > 0)
            <div class="blog-grid row row-cols-1 row-cols-md-2 row-cols-xl-3" id="blog-grid">
                @include('pages.blog.partials.blog-items', ['blogs' => $blogs->items()])
            </div>

            @if($blogs->hasMorePages())
                <div class="text-center mt-4" id="load-more-container">
                    <button type="button" class="btn btn-primary" id="load-more-btn" data-page="2" data-locale="{{ app()->getLocale() }}">
                        <span class="btn-text">{{ __('common.Load More') }}</span>
                        <span class="spinner-border spinner-border-sm d-none ms-2" role="status" id="btn-loading-spinner">
                            <span class="visually-hidden">{{ __('common.Loading...') }}</span>
                        </span>
                    </button>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <p>{{ __('common.No blog posts found.') }}</p>
            </div>
        @endif
    </section>

@push('styles')
<link rel="stylesheet" href="{{ asset('storefront/css/pages/blog-index.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('storefront/js/pages/blog-index.js') }}" defer></script>
@endpush
@endsection
