@extends('layouts.default')

@section('title', $brand->getTranslation('meta_title', app()->getLocale()) ?? $brand->getTranslation('name', app()->getLocale()))

@section('og_image'){{ $brand->getFirstMediaUrl('banner') ?: $brand->getFirstMediaUrl('logo') ?: asset('storefront/images/placeholder-og.jpg') }}@endsection

@section('head')
    {!! $schemaJsonLd !!}
@endsection

@section('content')

    @php
        $locale = app()->getLocale();
        $brandName = $brand->getTranslation('name', $locale);
        $brandDescription = $brand->getTranslation('description', $locale);
        $brandLogoImages = $brand->getLogoImageUrls();
        $brandBannerImages = $brand->getBannerImageUrls();
    @endphp

    <!-- Brand Banner Section -->
    <section>
        <div style="border-color: #eeeeee;">
            <div class="shop-banner position-relative">
                <div class="background-img background-img_overlay" style="background-color: #eeeeee;">
                    @if($brandBannerImages['banner_desktop'])
                        <picture>
                            {{-- Mobile fallback --}}
                            @if($brandBannerImages['banner_mobile'])
                                <source media="(max-width: 768px)" srcset="{{ $brandBannerImages['banner_mobile'] }}">
                            @endif
                            {{-- Tablet fallback --}}
                            @if($brandBannerImages['banner_tablet'])
                                <source media="(max-width: 1024px)" srcset="{{ $brandBannerImages['banner_tablet'] }}">
                            @endif
                            {{-- Desktop fallback --}}
                            <img loading="lazy" src="{{ $brandBannerImages['banner_desktop'] }}" width="1920" height="400" alt="{{ $brandName }}" class="slideshow-bg__img object-fit-cover">
                        </picture>
                    @else
                        <img loading="lazy" src="{{ asset('storefront/images/blog_title_bg.jpg') }}" width="1903" height="420" alt="{{ $brandName }}" class="slideshow-bg__img object-fit-cover">
                    @endif
                </div>

                <div class="shop-banner__content container position-absolute start-50 top-50 translate-middle">
                    @if($brandLogoImages['src'])
                        <div class="brand-banner-logo mb-3 mb-xl-4 mb-xl-5 text-center">
                            <picture>
                                @if($brandLogoImages['webp'])
                                    <source srcset="{{ $brandLogoImages['webp'] }}" type="image/webp">
                                @endif
                                <img loading="lazy"
                                     src="{{ $brandLogoImages['src'] }}"
                                     alt="{{ $brandName }}"
                                     style="max-width: 200px; max-height: 120px; object-fit: contain;">
                            </picture>
                        </div>
                    @endif
                    <h2 class="h1 text-uppercase text-white text-center fw-bold mb-3 mb-xl-4 mb-xl-5">{{ $brandName }}</h2>
                </div><!-- /.shop-banner__content -->
            </div><!-- /.shop-banner position-relative -->
        </div>
    </section>

    <div class="mb-4 pb-lg-3"></div>

    <!-- Brand Description Section -->
    @if($brandDescription)
    <section class="brand-description container mb-4 mb-xl-5">
        <div class="row">
            <div class="col-lg-10 col-xl-8 mx-auto">
                <div class="brand-description__content">
                    {!! $brandDescription !!}
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Products Section -->
    <section class="shop-main container">
        <div class="d-flex justify-content-between mb-4 pb-md-2">
            <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                <a href="{{ route('home', $locale) }}" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('navigation.Home') }}</a>
                <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                <a href="{{ route('brands.index', $locale) }}" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('navigation.Brands') }}</a>
                <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                <span class="menu-link menu-link_us-s text-uppercase fw-medium">{{ $brandName }}</span>
            </div><!-- /.breadcrumb -->

            <div class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0" aria-label="Sort Items" name="sort" id="sort-select">
                    <option value="created_desc" {{ request('sort', 'created_desc') === 'created_desc' ? 'selected' : '' }}>{{ __('product.Newest') }}</option>
                    <option value="featured" {{ request('sort') === 'featured' ? 'selected' : '' }}>{{ __('product.Featured') }}</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>{{ __('product.Name A-Z') }}</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>{{ __('product.Name Z-A') }}</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>{{ __('product.Price: Low to High') }}</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>{{ __('product.Price: High to Low') }}</option>
                    <option value="created_asc" {{ request('sort') === 'created_asc' ? 'selected' : '' }}>{{ __('product.Oldest') }}</option>
                </select>

            </div><!-- /.shop-acs -->
        </div><!-- /.d-flex justify-content-between -->

        @if($list && $list->count() > 0)
            <div class="products-grid row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5" id="products-grid">
                @include('pages.brands.partials.products', ['products' => $list->items()])
            </div><!-- /.products-grid row -->

            @if($list->hasMorePages())
                    <div class="load-more-section mt-4 mt-md-5 pt-3" id="load-more-section">
                        <div id="infinite-scroll-trigger" style="height: 1px;"></div>
                        <div class="text-center">
                            <div id="btn-loading-spinner" class="spinner-border text-primary d-none" role="status" style="width: 2.5rem; height: 2.5rem;">
                                <span class="visually-hidden">{{ __('common.Loading...') }}</span>
                            </div>
                        </div>
                    </div>
                @endif
        @else
            <div class="text-center py-5">
                <p>{{ __('product.No products found for this brand.') }}</p>
            </div>
        @endif
    </section><!-- /.shop-main container -->

@push('styles')
<link rel="stylesheet" href="{{ asset('storefront/css/pages/brands.css') }}">
@endpush

@push('scripts')
<script>
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const productsGrid = document.getElementById('products-grid');
        const sortSelect = document.getElementById('sort-select');

        let isLoading = false;
        let currentPage = {{ $list->currentPage() }};
        let currentSort = '';
        let infiniteScrollObserver = null;
        const locale = '{{ $locale }}';
        const brandSlug = '{{ $brand->slug }}';

        // Get current sort from URL
        const urlParams = new URLSearchParams(window.location.search);
        currentSort = urlParams.get('sort') || '';
        if (sortSelect && currentSort) {
            sortSelect.value = currentSort;
        }

        // Initialize Infinite Scroll
        initInfiniteScroll();

        // Sort functionality with AJAX
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                currentSort = this.value;
                currentPage = 1;
                loadProducts(true);
            });
        }

        /**
         * Initialize Infinite Scroll Observer
         */
        function initInfiniteScroll() {
            // Disconnect existing observer
            if (infiniteScrollObserver) {
                infiniteScrollObserver.disconnect();
            }

            const trigger = document.getElementById('infinite-scroll-trigger');
            if (!trigger) return;

            const options = {
                root: null,
                rootMargin: '200px',
                threshold: 0.1
            };

            infiniteScrollObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !isLoading) {
                        const loadMoreSection = document.querySelector('.load-more-section');
                        if (loadMoreSection && loadMoreSection.style.display !== 'none') {
                            currentPage++;
                            loadProducts(false);
                        }
                    }
                });
            }, options);

            infiniteScrollObserver.observe(trigger);
        }

        function loadProducts(reset = false) {
            if (isLoading) return;

            isLoading = true;

            // Show loading state
            if (reset) {
                if (productsGrid) {
                    productsGrid.style.opacity = '0.5';
                    productsGrid.style.pointerEvents = 'none';
                }
            } else {
                const spinner = document.getElementById('btn-loading-spinner');
                if (spinner) spinner.classList.remove('d-none');
            }

            // Add timestamp to prevent cache
            const timestamp = new Date().getTime();
            const url = `/${locale}/brand/${brandSlug}?page=${currentPage}${currentSort ? '&sort=' + encodeURIComponent(currentSort) : ''}&_t=${timestamp}`;

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html',
                    'Cache-Control': 'no-cache, no-store, must-revalidate',
                    'Pragma': 'no-cache',
                    'Expires': '0'
                },
                cache: 'no-store'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newProductsGrid = doc.getElementById('products-grid');

                if (newProductsGrid && productsGrid) {
                    if (reset) {
                        // Replace products
                        productsGrid.innerHTML = newProductsGrid.innerHTML;
                        // Scroll to top
                        window.scrollTo({ top: productsGrid.offsetTop - 100, behavior: 'smooth' });
                        // Update URL without reload
                        const newUrl = new URL(window.location);
                        if (currentSort) {
                            newUrl.searchParams.set('sort', currentSort);
                        } else {
                            newUrl.searchParams.delete('sort');
                        }
                        newUrl.searchParams.delete('page');
                        window.history.pushState({}, '', newUrl);
                    } else {
                        // Append products
                        Array.from(newProductsGrid.children).forEach(item => {
                            productsGrid.appendChild(item.cloneNode(true));
                        });
                    }

                    // Update load more section
                    const newLoadMoreSection = doc.querySelector('.load-more-section');
                    const currentLoadMoreSection = document.querySelector('.load-more-section');

                    if (currentLoadMoreSection) currentLoadMoreSection.remove();

                    if (newLoadMoreSection) {
                        productsGrid.parentElement.appendChild(newLoadMoreSection.cloneNode(true));
                    }

                    // Re-initialize infinite scroll
                    setTimeout(initInfiniteScroll, 100);
                }
            })
            .catch(error => {
                console.error('Error loading products:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error('{{ __("An error occurred while loading products") }}');
                } else {
                    alert('{{ __("An error occurred while loading products") }}');
                }
            })
            .finally(() => {
                isLoading = false;
                if (reset) {
                    if (productsGrid) {
                        productsGrid.style.opacity = '1';
                        productsGrid.style.pointerEvents = 'auto';
                    }
                } else {
                    const spinner = document.getElementById('btn-loading-spinner');
                    if (spinner) spinner.classList.add('d-none');
                }
            });
        }

        // Backup scroll listener
        let scrollTimeout;
        window.addEventListener('scroll', function() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(function() {
                const trigger = document.getElementById('infinite-scroll-trigger');
                if (trigger && !isLoading) {
                    const rect = trigger.getBoundingClientRect();
                    const windowHeight = window.innerHeight || document.documentElement.clientHeight;

                    if (rect.top <= windowHeight + 200) {
                        const loadMoreSection = document.querySelector('.load-more-section');
                        if (loadMoreSection && loadMoreSection.style.display !== 'none') {
                            currentPage++;
                            loadProducts(false);
                        }
                    }
                }
            }, 100);
        });
    });
})();
</script>
@endpush

@endsection
