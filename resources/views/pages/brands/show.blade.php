@extends('layouts.default')

@section('head')
    {!! $schemaJsonLd !!}
@endsection

@section('title', $brand->getTranslation('meta_title', app()->getLocale()) ?? $brand->getTranslation('name', app()->getLocale()))

@section('content')

    @php
        $locale = app()->getLocale();
        $brandName = $brand->getTranslation('name', $locale);
        $brandDescription = $brand->getTranslation('description', $locale);
        $brandLogo = $brand->getFirstMediaUrl('logo');
        $brandBanner = $brand->getFirstMediaUrl('banner');
    @endphp

    <!-- Brand Banner Section -->
    <section>
        <div style="border-color: #eeeeee;">
            <div class="shop-banner position-relative">
                <div class="background-img background-img_overlay" style="background-color: #eeeeee;">
                    @if($brandBanner)
                        <img loading="lazy" src="{{ $brandBanner }}" width="1903" height="420" alt="{{ $brandName }}" class="slideshow-bg__img object-fit-cover">
                    @else
                        <img loading="lazy" src="{{ asset('storefront/images/blog_title_bg.jpg') }}" width="1903" height="420" alt="{{ $brandName }}" class="slideshow-bg__img object-fit-cover">
                    @endif
                </div>

                <div class="shop-banner__content container position-absolute start-50 top-50 translate-middle">
                    @if($brandLogo)
                        <div class="brand-banner-logo mb-3 mb-xl-4 mb-xl-5 text-center">
                            <img loading="lazy" 
                                 src="{{ $brandLogo }}" 
                                 alt="{{ $brandName }}"
                                 style="max-width: 200px; max-height: 120px; object-fit: contain;">
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
                <a href="{{ route('home', $locale) }}" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('Home') }}</a>
                <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                <a href="{{ route('brands.index', $locale) }}" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('Brands') }}</a>
                <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                <span class="menu-link menu-link_us-s text-uppercase fw-medium">{{ $brandName }}</span>
            </div><!-- /.breadcrumb -->

            <div class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0" aria-label="Sort Items" name="sort" id="sort-select">
                    <option value="">{{ __('Default') }}</option>
                    <option value="featured">{{ __('Featured') }}</option>
                    <option value="name_asc">{{ __('Name A-Z') }}</option>
                    <option value="name_desc">{{ __('Name Z-A') }}</option>
                    <option value="price_asc">{{ __('Price: Low to High') }}</option>
                    <option value="price_desc">{{ __('Price: High to Low') }}</option>
                    <option value="created_desc">{{ __('Newest') }}</option>
                    <option value="created_asc">{{ __('Oldest') }}</option>
                </select>

            </div><!-- /.shop-acs -->
        </div><!-- /.d-flex justify-content-between -->

        @if($list && $list->count() > 0)
            <div class="products-grid row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5" id="products-grid">
                @include('pages.brands.partials.products', ['products' => $list->items()])
            </div><!-- /.products-grid row -->

            @if($list->hasMorePages() || $list->currentPage() > 1)
                <p class="mb-1 text-center fw-medium">
                    {{ __('Showing') }} {{ $list->firstItem() ?? 0 }} {{ __('of') }} {{ $list->total() }} {{ __('items') }}
                </p>
                <div class="progress progress_uomo mb-3 ms-auto me-auto" style="width: 300px;">
                    <div class="progress-bar" 
                         role="progressbar" 
                         style="width: {{ $list->total() > 0 ? ($list->lastItem() / $list->total() * 100) : 0 }}%;" 
                         aria-valuenow="{{ $list->lastItem() ?? 0 }}" 
                         aria-valuemin="0" 
                         aria-valuemax="{{ $list->total() }}">
                    </div>
                </div>

                <div class="text-center" id="load-more-container">
                    @if($list->hasMorePages())
                        <button type="button" class="btn-link btn-link_lg text-uppercase fw-medium" id="load-more-btn" data-page="{{ $list->currentPage() + 1 }}" data-brand-slug="{{ $brand->slug }}" data-locale="{{ $locale }}">
                            {{ __('Show More') }}
                            <span class="spinner-border spinner-border-sm d-none ms-2" role="status" id="btn-loading-spinner">
                                <span class="visually-hidden">{{ __('Loading...') }}</span>
                            </span>
                        </button>
                    @endif
                </div>
            @endif

            @if($list->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $list->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <p>{{ __('No products found for this brand.') }}</p>
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
        const loadMoreBtn = document.getElementById('load-more-btn');
        const btnLoadingSpinner = document.getElementById('btn-loading-spinner');
        const loadMoreContainer = document.getElementById('load-more-container');
        const progressBar = document.querySelector('.progress-bar');
        const showingText = document.querySelector('.mb-1.text-center.fw-medium');
        
        let isLoading = false;
        let currentPage = 1;
        let currentSort = '';
        const locale = '{{ $locale }}';
        const brandSlug = '{{ $brand->slug }}';
        
        // Get current sort from URL
        const urlParams = new URLSearchParams(window.location.search);
        currentSort = urlParams.get('sort') || '';
        currentPage = parseInt(urlParams.get('page')) || 1;
        if (sortSelect && currentSort) {
            sortSelect.value = currentSort;
        }
        
        // Sort functionality with AJAX
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                currentSort = this.value;
                currentPage = 1;
                loadProducts(true);
            });
        }
        
        // Load More functionality
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                if (!isLoading && this.dataset.page) {
                    currentPage = parseInt(this.dataset.page);
                    loadProducts(false);
                }
            });
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
                if (loadMoreBtn) {
                    loadMoreBtn.disabled = true;
                    if (btnLoadingSpinner) btnLoadingSpinner.classList.remove('d-none');
                }
            }
            
            // Add timestamp to prevent cache
            const timestamp = new Date().getTime();
            const url = `/${locale}/brands/${brandSlug}?page=${currentPage}${currentSort ? '&sort=' + encodeURIComponent(currentSort) : ''}&_t=${timestamp}`;
            
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
                        productsGrid.insertAdjacentHTML('beforeend', newProductsGrid.innerHTML);
                    }
                    
                    // Update pagination info
                    const newShowingText = doc.querySelector('.mb-1.text-center.fw-medium');
                    const newProgressBar = doc.querySelector('.progress-bar');
                    const newLoadMoreContainer = doc.querySelector('#load-more-container');
                    
                    if (newShowingText && showingText) {
                        showingText.textContent = newShowingText.textContent;
                    }
                    
                    if (newProgressBar && progressBar) {
                        progressBar.style.width = newProgressBar.style.width;
                        progressBar.setAttribute('aria-valuenow', newProgressBar.getAttribute('aria-valuenow') || '0');
                    }
                    
                    // Update load more button
                    if (newLoadMoreContainer) {
                        const newLoadMoreBtn = newLoadMoreContainer.querySelector('#load-more-btn');
                        if (newLoadMoreBtn && loadMoreBtn) {
                            const nextPage = parseInt(newLoadMoreBtn.dataset.page) || (currentPage + 1);
                            loadMoreBtn.dataset.page = nextPage;
                            loadMoreBtn.disabled = false;
                        } else if (loadMoreContainer) {
                            loadMoreContainer.remove();
                        }
                    } else if (loadMoreContainer) {
                        loadMoreContainer.remove();
                    }
                    
                    // Update current page for next load
                    if (!reset && loadMoreBtn) {
                        currentPage = parseInt(loadMoreBtn.dataset.page) || (currentPage + 1);
                    }
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
                    if (loadMoreBtn) {
                        loadMoreBtn.disabled = false;
                        if (btnLoadingSpinner) btnLoadingSpinner.classList.add('d-none');
                    }
                }
            });
        }
    });
})();
</script>
@endpush

@endsection
