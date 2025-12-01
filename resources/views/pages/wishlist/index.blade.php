@extends('layouts.default')

@section('content')
    <div class="mb-md-1 pb-md-3"></div>
    <section class="products-page container py-4 py-md-5">
        <div class="mb-4 pb-md-2">
            <h1 class="page-title mb-3">{{ __('Wishlist') }}</h1>
            <p class="text-secondary" id="wishlistCount">0 {{ __('items') }}</p>
        </div>

        <div id="wishlistProducts" class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-5">
            <div class="col-12 d-flex justify-content-center align-items-center" style="min-height: 60vh;">
                <div class="wishlist-empty-state text-center py-5 py-md-6" style="max-width: 600px; width: 100%; margin: 0 auto;">
                    <div class="wishlist-empty-icon mb-4 mb-md-5 d-flex justify-content-center">
                        <svg width="120" height="120" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.3;">
                            <use href="#icon_heart"/>
                        </svg>
                    </div>
                    <h2 class="wishlist-empty-title mb-3 mb-md-4 mx-auto" style="font-size: 1.5rem; font-weight: 600; color: #222222; text-align: center;">
                        {{ __('Your Wishlist is Empty') }}
                    </h2>
                    <p class="wishlist-empty-text text-secondary mb-4 mb-md-5 mx-auto" style="font-size: 1rem; max-width: 500px; text-align: center;">
                        {{ __('Start adding products to your wishlist to save them for later. Browse our collection and add items you love!') }}
                    </p>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('products.index', app()->getLocale()) }}" class="btn btn-primary btn-lg px-5 py-3" style="text-transform: uppercase; letter-spacing: 0.05em; font-weight: 500;">
                            {{ __('Start Shopping') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
(function() {
    'use strict';
    
    const locale = '{{ app()->getLocale() }}';
    const emptyTitle = @json(__('Your Wishlist is Empty'));
    const emptyText = @json(__('Start adding products to your wishlist to save them for later. Browse our collection and add items you love!'));
    const startShoppingText = @json(__('Start Shopping'));
    const noProductsTitle = @json(__('No Products Found'));
    const noProductsText = @json(__('We couldn\'t find the products in your wishlist. They may have been removed or are no longer available.'));
    const browseProductsText = @json(__('Browse Products'));
    const errorTitle = @json(__('Error Loading Wishlist'));
    const errorText = @json(__('There was an error loading your wishlist. Please try refreshing the page.'));
    const continueShoppingText = @json(__('Continue Shopping'));
    const itemsText = @json(__('items'));
    const loadingText = @json(__('Loading...'));
    const productsUrl = '{{ route('products.index', app()->getLocale()) }}';
    const placeholderImage = '{{ asset('storefront/images/products/placeholder.jpg') }}';
    
    function getWishlist() {
        return JSON.parse(localStorage.getItem('wishlist') || '[]');
    }
    
    async function loadWishlistProducts() {
        const wishlist = getWishlist();
        const container = document.getElementById('wishlistProducts');
        const countEl = document.getElementById('wishlistCount');
        
        if (!container) return;
        
        if (wishlist.length === 0) {
            // Change row classes for empty state
            container.className = 'row row-cols-12 row-cols-md-12 row-cols-lg-12 row-cols-xxl-12';
            container.innerHTML = `
                <div class="col-12 d-flex justify-content-center align-items-center" style="min-height: 60vh;">
                    <div class="wishlist-empty-state text-center py-5 py-md-6" style="max-width: 600px; width: 100%; margin: 0 auto;">
                        <div class="wishlist-empty-icon mb-4 mb-md-5 d-flex justify-content-center">
                            <svg width="120" height="120" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.3;">
                                <use href="#icon_heart"/>
                            </svg>
                        </div>
                        <h2 class="wishlist-empty-title mb-3 mb-md-4 mx-auto" style="font-size: 1.5rem; font-weight: 600; color: #222222; text-align: center;">
                            ${emptyTitle}
                        </h2>
                        <p class="wishlist-empty-text text-secondary mb-4 mb-md-5 mx-auto" style="font-size: 1rem; max-width: 500px; text-align: center;">
                            ${emptyText}
                        </p>
                        <div class="d-flex justify-content-center">
                            <a href="${productsUrl}" class="btn btn-primary btn-lg px-5 py-3" style="text-transform: uppercase; letter-spacing: 0.05em; font-weight: 500;">
                                ${startShoppingText}
                            </a>
                        </div>
                    </div>
                </div>
            `;
            if (countEl) countEl.textContent = '0 ' + itemsText;
            return;
        }
        
        // Reset row classes for products grid
        container.className = 'row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-5';
        if (countEl) countEl.textContent = wishlist.length + ' ' + itemsText;
        
        // Show loading
        container.innerHTML = '<div class="col-12 text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">' + loadingText + '</span></div></div>';
        
        try {
            // Load products from API
            const productPromises = wishlist.map(productId => 
                fetch(`/${locale}/quick-view?product_id=${productId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(res => res.json())
            );
            
            const results = await Promise.all(productPromises);
            const products = results
                .filter(data => data.success && data.product)
                .map(data => data.product);
            
            if (products.length === 0) {
                // Change row classes for empty state
                container.className = 'row row-cols-12 row-cols-md-12 row-cols-lg-12 row-cols-xxl-12';
                container.innerHTML = `
                    <div class="col-12 d-flex justify-content-center align-items-center" style="min-height: 60vh;">
                        <div class="wishlist-empty-state text-center py-5 py-md-6" style="max-width: 600px; width: 100%; margin: 0 auto;">
                            <div class="wishlist-empty-icon mb-4 mb-md-5 d-flex justify-content-center">
                                <svg width="120" height="120" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.3;">
                                    <use href="#icon_heart"/>
                                </svg>
                            </div>
                            <h2 class="wishlist-empty-title mb-3 mb-md-4 mx-auto" style="font-size: 1.5rem; font-weight: 600; color: #222222; text-align: center;">
                                ${noProductsTitle}
                            </h2>
                            <p class="wishlist-empty-text text-secondary mb-4 mb-md-5 mx-auto" style="font-size: 1rem; max-width: 500px; text-align: center;">
                                ${noProductsText}
                            </p>
                            <div class="d-flex justify-content-center">
                                <a href="${productsUrl}" class="btn btn-primary btn-lg px-5 py-3" style="text-transform: uppercase; letter-spacing: 0.05em; font-weight: 500;">
                                    ${browseProductsText}
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                return;
            }
            
            // Reset row classes for products grid
            container.className = 'row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-5';
            
            // Render products
            container.innerHTML = products.map(product => {
                const productUrl = `/${locale}/products/${product.slug}`;
                const imageUrl = product.image || placeholderImage;
                const price = parseFloat(product.price) || 0;
                const salePrice = product.sale_price ? parseFloat(product.sale_price) : null;
                const displayPrice = salePrice && salePrice < price ? salePrice : price;
                const oldPrice = salePrice && salePrice < price ? price : null;
                
                return `
                    <div class="col mb-3 mb-md-4 mb-xxl-5">
                        <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4">
                            <div class="position-relative pb-3">
                                <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                    <a href="${productUrl}">
                                        <img loading="lazy" src="${imageUrl}" width="256" height="256" alt="${product.name}" class="pc__img" style="object-fit: contain; width: 100%; height: 256px;" onerror="this.src='${placeholderImage}'">
                                    </a>
                                </div>
                                <div class="anim_appear-bottom position-absolute w-100 text-center">
                                    <button class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside" data-aside="cartDrawer" data-product-id="${product.id}" title="Add To Cart">
                                        <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_cart"/>
                                        </svg>
                                    </button>
                                    <button class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-wishlist wishlist-active" data-product-id="${product.id}" title="Remove from Wishlist">
                                        <svg class="d-inline-block js-wishlist-icon" width="16" height="16" viewBox="0 0 20 20" fill="#d6001c" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_heart"/>
                                        </svg>
                                    </button>
                                    <button class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view" data-bs-toggle="modal" data-bs-target="#quickView" data-product-id="${product.id}" title="Quick view">
                                        <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_view"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="pc__info position-relative">
                                ${product.brand ? `<p class="pc__category">${product.brand}</p>` : ''}
                                <h6 class="pc__title"><a href="${productUrl}">${product.name}</a></h6>
                                <div class="product-card__price d-flex">
                                    ${oldPrice ? `<span class="money price-old me-2" style="text-decoration: line-through; color: #999;">${oldPrice.toFixed(2)} ${product.currency}</span>` : ''}
                                    <span class="money price fs-5">${displayPrice.toFixed(2)} ${product.currency}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
            
        } catch (error) {
            console.error('Error loading wishlist products:', error);
            // Change row classes for empty state
            container.className = 'row row-cols-12 row-cols-md-12 row-cols-lg-12 row-cols-xxl-12';
            container.innerHTML = `
                <div class="col-12 d-flex justify-content-center align-items-center" style="min-height: 60vh;">
                    <div class="wishlist-empty-state text-center py-5 py-md-6" style="max-width: 600px; width: 100%; margin: 0 auto;">
                        <div class="wishlist-empty-icon mb-4 mb-md-5 d-flex justify-content-center">
                            <svg width="120" height="120" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.3;">
                                <use href="#icon_heart"/>
                            </svg>
                        </div>
                        <h2 class="wishlist-empty-title mb-3 mb-md-4 mx-auto" style="font-size: 1.5rem; font-weight: 600; color: #222222; text-align: center;">
                            ${errorTitle}
                        </h2>
                        <p class="wishlist-empty-text text-secondary mb-4 mb-md-5 mx-auto" style="font-size: 1rem; max-width: 500px; text-align: center;">
                            ${errorText}
                        </p>
                        <div class="d-flex justify-content-center">
                            <a href="${productsUrl}" class="btn btn-primary btn-lg px-5 py-3" style="text-transform: uppercase; letter-spacing: 0.05em; font-weight: 500;">
                                ${continueShoppingText}
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }
    }
    
    // Load products on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadWishlistProducts();
        
        // Listen for wishlist changes
        window.addEventListener('storage', function(e) {
            if (e.key === 'wishlist') {
                loadWishlistProducts();
            }
        });
        
        // Also listen for custom event (for same-tab updates)
        document.addEventListener('wishlistUpdated', function() {
            loadWishlistProducts();
        });
        
        // Listen for wishlist button clicks on this page
        document.addEventListener('click', function(e) {
            const wishlistBtn = e.target.closest('.js-add-wishlist');
            if (wishlistBtn) {
                // Small delay to let localStorage update
                setTimeout(() => {
                    loadWishlistProducts();
                }, 100);
            }
        });
    });
})();
</script>
@endpush

