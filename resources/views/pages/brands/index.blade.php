@extends('layouts.default')

@section('head')
    {!! $schemaJsonLd ?? '' !!}
@endsection

@section('title', __('page.Brands'))

@section('content')

    <x-breadcrumb :items="[
        ['label' => __('navigation.Home'), 'url' => route('home', app()->getLocale())],
        ['label' => __('navigation.Brands'), 'url' => route('brands.index', app()->getLocale())]
    ]" />

    @if(isset($pageBanner) && $pageBanner && ($pageBanner->getFirstMediaUrl('image') || $pageBanner->getFirstMediaUrl('video')))
        <section class="brand-page-title mb-4 mb-xl-5">
            <div class="container">
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
                            <h2 class="page-title mb-0">{{ $pageBanner->getTranslation('title', app()->getLocale()) ?: __('page.Brands') }}</h2>
                            @if($pageBanner->getTranslation('subtitle', app()->getLocale()))
                                <p class="mb-0 mt-2">{{ $pageBanner->getTranslation('subtitle', app()->getLocale()) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="brand-page container py-4 py-md-5">
        <h2 class="d-none">{{ __('page.Brands') }}</h2>
        @if($items->count() > 0)
            <div class="brand-grid row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6" id="brand-grid">
                @include('pages.brands.partials.brand-items', ['items' => $items])
            </div>
            
            @if($items->hasMorePages())
                <div class="mt-4 d-flex justify-content-center" id="load-more-container">
                    <div class="spinner-border text-primary" role="status" id="loading-spinner" style="display: none;">
                        <span class="visually-hidden">{{ __('common.Loading...') }}</span>
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <p>{{ __('common.No brands found') }}</p>
            </div>
        @endif
    </section>

@push('styles')
<link rel="stylesheet" href="{{ asset('storefront/css/pages/brands.css') }}">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const brandGrid = document.getElementById('brand-grid');
    const loadMoreContainer = document.getElementById('load-more-container');
    const loadingSpinner = document.getElementById('loading-spinner');
    
    if (!brandGrid) return;
    
    let nextPage = 2;
    let isLoading = false;
    let hasMore = {{ $items->hasMorePages() ? 'true' : 'false' }};
    
    // Function to load more brands
    function loadMoreBrands() {
        if (isLoading || !hasMore) return;
        
        isLoading = true;
        if (loadingSpinner) {
            loadingSpinner.style.display = 'block';
        }
        
        // Make AJAX request
        fetch(`{{ route('brands.load-more', app()->getLocale()) }}?page=${nextPage}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                // Create a temporary container to parse HTML
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data.html;
                
                // Append new items to grid
                const newItems = tempDiv.querySelectorAll('.brand-grid__item');
                newItems.forEach(item => {
                    brandGrid.appendChild(item);
                });
            }
            
            // Update state
            hasMore = data.hasMore;
            if (data.hasMore && data.nextPage) {
                nextPage = data.nextPage;
            } else {
                // No more items, hide loading indicator
                if (loadMoreContainer) {
                    loadMoreContainer.style.display = 'none';
                }
            }
            
            isLoading = false;
            if (loadingSpinner) {
                loadingSpinner.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error loading more brands:', error);
            isLoading = false;
            if (loadingSpinner) {
                loadingSpinner.style.display = 'none';
            }
        });
    }
    
    // Scroll event listener
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        // Throttle scroll events
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(function() {
            // Check if user is near bottom of page (within 300px)
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;
            
            // If user is near bottom and not already loading
            if (scrollTop + windowHeight >= documentHeight - 300) {
                loadMoreBrands();
            }
        }, 100);
    });
    
    // Also check on initial load if page is already scrolled
    if (window.innerHeight >= document.documentElement.scrollHeight - 300) {
        loadMoreBrands();
    }
});
</script>
@endpush

@endsection
