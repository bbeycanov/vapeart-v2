@extends('layouts.default')

@section('title', __('page.New Products'))

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
                        {{ __('page.New Products') }}
                    </li>
                </ol>
            </nav>
        </div>

        <h1 class="page-title mb-4 mb-md-5 text-center text-md-start">
            {{ __('page.New Products') }}
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
                        </div>
                    </div>
                @endif
            @else
                <div class="col-12">
                    <div class="empty-products-state text-center py-5">
                        <div class="empty-icon mb-4">
                            <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="60" cy="60" r="60" fill="#F8F9FA"/>
                                <path d="M50 40L60 50L70 40" stroke="#ADB5BD" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M60 50V80" stroke="#ADB5BD" stroke-width="3" stroke-linecap="round"/>
                                <rect x="35" y="35" width="50" height="50" rx="4" stroke="#DEE2E6" stroke-width="2" fill="none"/>
                            </svg>
                        </div>
                        <h3 class="fs-4 fw-semibold mb-3">{{ __('product.No New Products Yet') }}</h3>
                        <p class="text-secondary mb-4">{{ __('common.Check back soon for new arrivals!') }}</p>
                        <a href="{{ route('home', $locale) }}" class="btn btn-outline-primary btn-sm">
                            {{ __('common.Back to Home') }}
                        </a>
                    </div>
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

/* Empty Products State */
.empty-products-state {
    min-height: 60vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
}

.empty-products-state .empty-icon {
    animation: fadeInUp 0.6s ease-out;
}

.empty-products-state h3 {
    color: #212529;
    animation: fadeInUp 0.6s ease-out 0.1s both;
}

.empty-products-state p {
    max-width: 500px;
    animation: fadeInUp 0.6s ease-out 0.2s both;
}

.empty-products-state a {
    animation: fadeInUp 0.6s ease-out 0.3s both;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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
                            loadProducts();
                        }
                    }
                });
            }, options);

            infiniteScrollObserver.observe(trigger);
        }
        
        function loadProducts() {
            if (isLoading) return;
            isLoading = true;
            
            // Show spinner
            const spinner = document.getElementById('btn-loading-spinner');
            if (spinner) spinner.classList.remove('d-none');
            
            // URL Params
            const params = new URLSearchParams();
            params.set('page', currentPage);
            params.set('_t', new Date().getTime());
            
            const url = `/${locale}/new-products?${params.toString()}`;
            
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

                // Append new products
                if (newGrid && productsGrid) {
                    Array.from(newGrid.children).forEach(item => {
                        productsGrid.appendChild(item.cloneNode(true));
                    });
                }
                
                // Update Pagination Section
                const currentPagination = document.querySelector('.load-more-section');
                if (currentPagination) currentPagination.remove();
                
                if (newPagination && productsContainer) {
                    productsContainer.appendChild(newPagination.cloneNode(true));
                }

                // Re-initialize infinite scroll
                setTimeout(initInfiniteScroll, 100);
            })
            .catch(err => console.error(err))
            .finally(() => {
                isLoading = false;
                // Hide spinner
                if (spinner) spinner.classList.add('d-none');
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
                    
                    if (rect.top <= windowHeight + 200) {
                        const loadMoreSection = document.querySelector('.load-more-section');
                        if (loadMoreSection && loadMoreSection.style.display !== 'none') {
                            currentPage++;
                            loadProducts();
                        }
                    }
                }
            }, 100);
        });
    });
})();
</script>
@endpush

