@extends('layouts.default')

@section('title', __('page.Discounted Products'))

@php
    $locale = app()->getLocale();
@endphp

@section('content')
    <div class="mb-md-1 pb-md-3"></div>

    <div class="container mb-5">
        <!-- Breadcrumb Section -->
        <div class="mb-3 mb-md-4 pb-2 pb-md-3">
            <nav aria-label="breadcrumb" class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home', $locale) }}" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('navigation.Home') }}</a>
                    </li>
                    <li class="breadcrumb-item active menu-link menu-link_us-s text-uppercase fw-medium" aria-current="page">
                        {{ __('page.Discounted Products') }}
                    </li>
                </ol>
            </nav>
        </div>

        <h1 class="page-title mb-4 mb-md-5 text-center text-md-start">
            {{ __('page.Discounted Products') }}
        </h1>

        <div id="products-container">
            @if($list->isNotEmpty())
                <div id="products-grid" class="products-grid row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
                    @foreach($list as $product)
                        <div class="product-grid-item col">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>

                @if($list->hasMorePages())
                    <div class="load-more-section mt-4 mt-md-5 pt-3" id="load-more-section">
                        <div id="infinite-scroll-trigger" style="height: 1px;"></div>
                        <div class="text-center">
                            <div id="btn-loading-spinner" class="spinner-border text-primary d-none" role="status" style="width: 2.5rem; height: 2.5rem;">
                                <span class="visually-hidden">{{ __('common.Loading...') }}</span>
                            </div>
                            <button id="load-more-btn" 
                                    class="btn btn-outline-primary d-none" 
                                    data-page="{{ $list->currentPage() + 1 }}"
                                    style="display: none;">
                                {{ __('common.Load More') }}
                            </button>
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5 py-md-6 empty-state">
                    <p class="text-secondary mb-4">{{ __('product.No discounted products found.') }}</p>
                    <a href="{{ route('home', $locale) }}" class="btn btn-primary">
                        {{ __('common.Back to Home') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
/* Product Grid Transitions */
#products-grid {
    transition: opacity 0.3s ease;
}
#products-grid.loading {
    opacity: 0.4;
    pointer-events: none;
}

/* Loading Spinner */
#btn-loading-spinner {
    border-width: 3px;
}
</style>
@endpush

@push('scripts')
<script>
(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        const productsGrid = document.getElementById('products-grid');
        const productsContainer = document.getElementById('products-container');
        
        const locale = '{{ $locale }}';
        
        let isLoading = false;
        let currentPage = {{ $list->currentPage() }};
        let infiniteScrollObserver = null;

        // Initialize Infinite Scroll
        initInfiniteScroll();
        
        function initInfiniteScroll() {
            // Disconnect existing observer if any
            if (infiniteScrollObserver) {
                infiniteScrollObserver.disconnect();
            }

            const trigger = document.getElementById('infinite-scroll-trigger');
            const loadMoreBtn = document.getElementById('load-more-btn');
            
            // Only initialize if we have a trigger and a button with a next page
            if (trigger && loadMoreBtn && loadMoreBtn.dataset.page) {
                const options = {
                    root: null,
                    rootMargin: '200px', // Load 200px before reaching bottom
                    threshold: 0.1
                };

                infiniteScrollObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && !isLoading) {
                            const btn = document.getElementById('load-more-btn');
                            if (btn && btn.dataset.page) {
                                currentPage = parseInt(btn.dataset.page);
                                loadProducts(false);
                            }
                        }
                    });
                }, options);

                infiniteScrollObserver.observe(trigger);
            }
        }
        
        function loadProducts(reset = false) {
            if (isLoading) return;
            isLoading = true;
            
            // Loading UI
            if (reset) {
                if (productsGrid) productsGrid.classList.add('loading');
                if (productsContainer) productsContainer.style.opacity = '0.5';
            } else {
                // Show spinner for infinite scroll
                const spinner = document.getElementById('btn-loading-spinner');
                if (spinner) spinner.classList.remove('d-none');
            }
            
            // URL Params
            const params = new URLSearchParams();
            params.set('page', currentPage);
            params.set('_t', new Date().getTime());
            
            const url = `/${locale}/discounts?${params.toString()}`;
            
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(res => {
                if(!res.ok) throw new Error('Network error');
                return res.text();
            })
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const newGrid = doc.getElementById('products-grid');
                const newPagination = doc.querySelector('.load-more-section');

                if (reset) {
                    // Full Replace
                    if (productsContainer) {
                        if(newGrid) {
                            productsContainer.innerHTML = ''; 
                            productsContainer.appendChild(newGrid);
                            
                            if (newPagination) {
                                productsContainer.appendChild(newPagination);
                            }
                        } else {
                             const emptyState = doc.querySelector('.empty-state');
                             if(emptyState) {
                                 productsContainer.innerHTML = '';
                                 productsContainer.appendChild(emptyState);
                             }
                        }
                    }
                    
                    // URL History Update
                    const newUrl = new URL(window.location);
                    newUrl.searchParams.set('page', currentPage);
                    window.history.pushState({}, '', newUrl);
                    
                } else {
                    // Append
                    if (newGrid && productsGrid) {
                        productsGrid.insertAdjacentHTML('beforeend', newGrid.innerHTML);
                    }
                    
                    // Update Pagination Section
                    const currentPagination = document.querySelector('.load-more-section');
                    if (currentPagination) currentPagination.remove();
                    
                    if (newPagination && productsContainer) {
                        productsContainer.appendChild(newPagination);
                    }
                }

                // Re-initialize infinite scroll observer for the new content/trigger
                setTimeout(initInfiniteScroll, 100);
            })
            .catch(err => console.error(err))
            .finally(() => {
                isLoading = false;
                if (reset) {
                    if (productsGrid) productsGrid.classList.remove('loading');
                    if (productsContainer) productsContainer.style.opacity = '1';
                } else {
                     // Hide spinner
                     const spinner = document.getElementById('btn-loading-spinner');
                     if (spinner) spinner.classList.add('d-none');
                }
            });
        }

        // Listen for scroll events as backup
        let scrollTimeout;
        window.addEventListener('scroll', function() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(function() {
                const trigger = document.getElementById('infinite-scroll-trigger');
                if (trigger && !isLoading) {
                    const rect = trigger.getBoundingClientRect();
                    const windowHeight = window.innerHeight || document.documentElement.clientHeight;
                    
                    // If trigger is visible or within 200px of viewport
                    if (rect.top <= windowHeight + 200) {
                        const btn = document.getElementById('load-more-btn');
                        if (btn && btn.dataset.page) {
                            currentPage = parseInt(btn.dataset.page);
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

