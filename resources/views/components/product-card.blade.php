@props([
    'product',
    'showAddToCart' => true,
    'showQuickView' => true,
])

@php
    $productName = $product->getTranslation('name', app()->getLocale());
    $productSlug = $product->slug;
    $productPrice = $product->price ?? 0;
    $productCurrency = $product->currency ?? 'AZN';
    $productImage = $product->getProductImageUrl('large');
    $brandName = $product->brand ? $product->brand->getTranslation('name', app()->getLocale()) : '';
    $productUrl = route('products.show', [app()->getLocale(), $productSlug]);

    // Get discount information
    $bestDiscount = $product->getBestDiscount();
    $discountedPrice = $product->getDiscountedPrice();
    $discountText = $product->getDiscountText();
    $hasDiscount = $bestDiscount !== null;
@endphp

<div class="product-card-wrapper mb-2">
    <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4">
        <div class="position-relative pb-3">
            <!-- Discount Badge -->
            @if($hasDiscount && $discountText)
                <div class="position-absolute top-0 start-0 m-2" style="z-index: 10;">
                    <span class="badge text-white px-2 py-1 fw-bold" style="font-size: 0.75rem; border-radius: 6px; box-shadow: 0 3px 8px rgba(220, 53, 69, 0.4); background: linear-gradient(135deg, #ff4757 0%, #ff6348 100%); border: 1px solid rgba(255, 255, 255, 0.3);">
                        {{ $discountText }}
                    </span>
                </div>
            @endif

            <div class="pc__img-wrapper pc__img-wrapper_wide3">
                <a href="{{ $productUrl }}">
                    <img loading="lazy"
                         src="{{ $productImage }}"
                         width="256" height="256" alt="{{ $productName }}"
                         class="pc__img"
                         style="object-fit: cover;"
                         onerror="this.src='{{ asset('storefront/images/products/placeholder.jpg') }}'">
                </a>
            </div>
            @if($showAddToCart || $showQuickView)
            <div class="anim_appear-bottom position-absolute w-100 text-center">
                @if($showAddToCart)
                <button class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                        data-aside="cartDrawer"
                        data-product-id="{{ $product->id }}"
                        title="Add To Cart">
                    <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_cart"/>
                    </svg>
                </button>
                @endif
                <button class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-wishlist"
                        data-product-id="{{ $product->id }}"
                        title="Add to Wishlist">
                    <svg class="d-inline-block js-wishlist-icon" width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_heart"/>
                    </svg>
                </button>
                @if($showQuickView)
                <button class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                        data-bs-toggle="modal"
                        data-bs-target="#quickView"
                        data-product-id="{{ $product->id }}"
                        title="Quick view">
                    <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view"/>
                    </svg>
                </button>
                @endif
            </div>
            @endif
        </div>
        <div class="pc__info position-relative">
            @if($brandName)
                <p class="pc__category">{{ $brandName }}</p>
            @endif
            <h6 class="pc__title"><a href="{{ $productUrl }}">{{ $productName }}</a></h6>
            <div class="product-card__review d-sm-flex align-items-center">
                <div class="reviews-group d-flex">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                        </svg>
                    @endfor
                </div>
            </div>
            <div class="product-card__price">
                @if($hasDiscount)
                    <div class="d-flex align-items-center gap-2 flex-wrap justify-content-between">
                        <span class="money price text-decoration-line-through" style="font-size: 0.875rem; color: #6c757d !important;">
                            {{ number_format($productPrice, 2) }} {{ $productCurrency }}
                        </span>
                        <span class="money price fw-bold" style="font-size: 1.25rem; color: #28a745 !important;">
                            {{ number_format($discountedPrice, 2) }} {{ $productCurrency }}
                        </span>
                    </div>
                @else
                <span class="money price fs-5">{{ number_format($productPrice, 2) }} {{ $productCurrency }}</span>
                @endif
            </div>
        </div>
    </div>
</div>

