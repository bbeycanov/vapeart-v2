@extends('layouts.default')

@section('head')
    {!! $schemaJsonLd !!}
@endsection

@section('content')
    <!-- New Products Swow -->
    @php
        $locale = app()->getLocale();
        $productImages = $productData['images'] ?? [];
        $productName = $productData['name'] ?? '';
        $productPrice = $productData['price'] ?? 0;
        $originalPrice = $productData['original_price'] ?? $productPrice;
        $productSalePrice = $productData['sale_price'] ?? null;
        $productCurrency = $productData['currency'] ?? 'AZN';
        $productShortDesc = $productData['short_description'] ?? '';
        $productDesc = $productData['description'] ?? '';
        $productSku = $productData['sku'] ?? 'N/A';
        $productCategories = $productData['categories'] ?? collect();
        $productTags = $productData['tags'] ?? collect();
        $ratingAvg = $productData['rating_avg'] ?? 0;
        $reviewsCount = $productData['reviews_count'] ?? 0;
        $hasImages = !empty($productImages);
        $defaultImage = asset('storefront/images/products/placeholder.jpg');
        $hasDiscount = $productData['has_discount'] ?? false;
        $discountText = $productData['discount_text'] ?? null;
    @endphp
    <div class="mb-md-1 pb-md-3"></div>
    <section class="product-single container">
        <div class="row">
            <div class="col-lg-7">
                <div class="product-single__media" data-media-type="horizontal-thumbnail">
                    <div class="product-single__image position-relative">
                        @if($hasDiscount && $discountText)
                            <div class="position-absolute top-0 start-0 m-3" style="z-index: 10;">
                                <span class="badge text-white px-3 py-2 fw-bold" style="font-size: 0.875rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.5); background: linear-gradient(135deg, #ff4757 0%, #ff6348 100%); border: 1px solid rgba(255, 255, 255, 0.3);">
                                    {{ $discountText }}
                                </span>
                            </div>
                        @endif
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @if($hasImages)
                                    @foreach($productImages as $image)
                                <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="h-auto" src="{{ $image }}" width="788" height="788" alt="{{ $productName }}" onerror="this.src='{{ $defaultImage }}'">
                                            <a data-fancybox="gallery" href="{{ $image }}" data-bs-toggle="tooltip" data-bs-placement="left" title="{{ __('product.Zoom') }}">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_zoom" /></svg>
                                    </a>
                                </div>
                                    @endforeach
                                @else
                                <div class="swiper-slide product-single__image-item">
                                        <img loading="lazy" class="h-auto" src="{{ $defaultImage }}" width="788" height="788" alt="{{ $productName }}">
                                        <a data-fancybox="gallery" href="{{ $defaultImage }}" data-bs-toggle="tooltip" data-bs-placement="left" title="{{ __('product.Zoom') }}">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_zoom" /></svg>
                                    </a>
                                </div>
                                @endif
                            </div>
                            <div class="swiper-button-prev"><svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_sm" /></svg></div>
                            <div class="swiper-button-next"><svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_sm" /></svg></div>
                        </div>
                    </div>
                    @if($hasImages)
                    <div class="product-single__thumbnail">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach($productImages as $image)
                                    <div class="swiper-slide product-single__image-item">
                                        <img loading="lazy" class="h-auto" src="{{ $image }}" width="104" height="104" alt="{{ $productName }}" onerror="this.src='{{ $defaultImage }}'">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-5">
                <div class="d-flex justify-content-between mb-4 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="{{ route('home', $locale) }}" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('navigation.Home') }}</a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="{{ route('products.index', $locale) }}" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('navigation.Products') }}</a>
                    </div><!-- /.breadcrumb -->
                </div>
                <h1 class="product-single__name">{{ $productName }}</h1>
                @if($productData['brand'] && $productData['brand']['logo'])
                <div class="product-single__brand mb-3">
                    @if($productData['brand']['slug'])
                        <a href="{{ route('brands.show', [$locale, $productData['brand']['slug']]) }}" class="d-inline-block">
                            <img src="{{ $productData['brand']['logo'] }}" alt="{{ $productData['brand']['name'] }}" style="max-height: 60px; max-width: 150px; object-fit: contain;">
                        </a>
                    @else
                        <img src="{{ $productData['brand']['logo'] }}" alt="{{ $productData['brand']['name'] }}" style="max-height: 60px; max-width: 150px; object-fit: contain;">
                    @endif
                </div>
                @endif
                @if($reviewsCount > 0 || $ratingAvg > 0)
                <div class="product-single__rating">
                    <div class="reviews-group d-flex">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="review-star {{ $i <= round($ratingAvg) ? 'review-star_active' : '' }}" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg"><use href="#icon_star" /></svg>
                        @endfor
                    </div>
                    @if($reviewsCount > 0)
                        <span class="reviews-note text-lowercase text-secondary ms-1">{{ $reviewsCount }} {{ __('reviews') }}</span>
                    @endif
                </div>
                @endif
                <div class="product-single__price">
                    @if($hasDiscount)
                        <div class="d-flex align-items-center gap-3 flex-wrap mb-2">
                            <span class="current-price price-old text-decoration-line-through" style="font-size: 1.25rem; color: #6c757d !important;">{{ number_format($originalPrice, 2) }} {{ $productCurrency }}</span>
                            @if($discountText)
                                <span class="badge text-white px-3 py-2 fw-bold" style="font-size: 0.875rem; background: linear-gradient(135deg, #ff4757 0%, #ff6348 100%); border-radius: 6px; box-shadow: 0 2px 6px rgba(220, 53, 69, 0.4);">
                                    {{ $discountText }}
                                </span>
                            @endif
                        </div>
                        <span class="current-price fw-bold" style="font-size: 2rem; color: #28a745 !important;">{{ number_format($productPrice, 2) }} {{ $productCurrency }}</span>
                    @elseif($productSalePrice && $productSalePrice < $originalPrice)
                        <span class="current-price price-old">{{ number_format($originalPrice, 2) }} {{ $productCurrency }}</span>
                        <span class="current-price price-sale">{{ number_format($productSalePrice, 2) }} {{ $productCurrency }}</span>
                    @else
                        <span class="current-price">{{ number_format($productPrice, 2) }} {{ $productCurrency }}</span>
                    @endif
                </div>
                @if($productShortDesc)
                <div class="product-single__short-desc">
                    <p>{!! $productShortDesc !!}</p>
                </div>
                @endif
                    <div class="product-single__addtocart">
                    <div class="qty-control position-relative d-inline-block me-2">
                        <input type="number" id="productQuantity" value="1" min="1" class="qty-control__number text-center" style="width: 60px;">
                            <div class="qty-control__reduce">-</div>
                            <div class="qty-control__increase">+</div>
                        </div><!-- .qty-control -->
                    <button type="button" class="btn btn-primary btn-addtocart js-add-cart js-open-aside" 
                            data-aside="cartDrawer" 
                            data-product-id="{{ $productData['id'] }}"
                            id="addToCartBtn">
                        {{ __('buttons.Add to Cart') }}
                    </button>
                    </div>
                <div class="product-single__addtolinks">
                    <a href="#" class="menu-link menu-link_us-s js-add-wishlist" data-product-id="{{ $productData['id'] }}">
                        <svg class="js-wishlist-icon" width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_heart" /></svg>
                        <span class="js-wishlist-text">{{ __('product.Add to Wishlist') }}</span>
                    </a>
                    <share-button class="share-button">
                        <button class="menu-link menu-link_us-s to-share border-0 bg-transparent d-flex align-items-center">
                            <svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_sharing" /></svg>
                            <span>{{ __('product.Share') }}</span>
                        </button>
                        <details id="Details-share-template__main" class="m-1 xl:m-1.5" hidden="">
                            <summary class="btn-solid m-1 xl:m-1.5 pt-3.5 pb-3 px-5">+</summary>
                            <div id="Article-share-template__main" class="share-button__fallback flex items-center absolute top-full left-0 w-full px-2 py-4 bg-container shadow-theme border-t z-10">
                                <div class="field grow mr-4">
                                    <label class="field__label sr-only" for="url">Link</label>
                                    <input type="text" class="field__input w-full" id="url" value="{{ route('products.show', [$locale, $product->slug]) }}" placeholder="Link" onclick="this.select();" readonly="">
                                </div>
                                <button class="share-button__copy no-js-hidden">
                                    <svg class="icon icon-clipboard inline-block mr-1" width="11" height="13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" viewBox="0 0 11 13">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2 1a1 1 0 011-1h7a1 1 0 011 1v9a1 1 0 01-1 1V1H2zM1 2a1 1 0 00-1 1v9a1 1 0 001 1h7a1 1 0 001-1V3a1 1 0 00-1-1H1zm0 10V3h7v9H1z" fill="currentColor"></path>
                                    </svg>
                                    <span class="sr-only">{{ __('quick_view.Copy link') }}</span>
                                </button>
                            </div>
                        </details>
                    </share-button>
                    <script src="./js/details-disclosure.js" defer="defer"></script>
                    <script src="./js/share.js" defer="defer"></script>
                </div>
                <div class="product-single__meta-info">
                    <div class="meta-item">
                        <label>{{ __('product.SKU') }}:</label>
                        <span>{{ $productSku }}</span>
                    </div>
                    @if($productData['brand'])
                    <div class="meta-item">
                        <label>{{ __('product.Brand') }}:</label>
                        <span>
                            @if($productData['brand']['slug'])
                                <a href="{{ route('brands.show', [$locale, $productData['brand']['slug']]) }}" class="text-decoration-none">{{ $productData['brand']['name'] }}</a>
                            @else
                                {{ $productData['brand']['name'] }}
                            @endif
                        </span>
                    </div>
                    @endif
                    @if($productCategories->isNotEmpty())
                    <div class="meta-item">
                        <label>{{ __('product.Categories') }}:</label>
                        <span>
                            @foreach($productCategories as $index => $category)
                                @if($index > 0), @endif
                                <a href="{{ route('products.index', [$locale, 'category_id' => $category['id']]) }}" class="text-decoration-none">{{ $category['name'] }}</a>
                            @endforeach
                        </span>
                    </div>
                    @endif
                    @if($productTags->isNotEmpty())
                    <div class="meta-item">
                        <label>{{ __('product.Tags') }}:</label>
                        <span>
                            @foreach($productTags as $index => $tag)
                                @if($index > 0), @endif
                                {{ $tag['name'] }}
                            @endforeach
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="product-single__details-tab">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab" href="#tab-description" role="tab" aria-controls="tab-description" aria-selected="true">{{ __('product.Description') }}</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore" id="tab-additional-info-tab" data-bs-toggle="tab" href="#tab-additional-info" role="tab" aria-controls="tab-additional-info" aria-selected="false">{{ __('product.Additional Information') }}</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore" id="tab-reviews-tab" data-bs-toggle="tab" href="#tab-reviews" role="tab" aria-controls="tab-reviews" aria-selected="false" data-label="{{ __('product.Reviews') }}">{{ __('product.Reviews') }} ({{ $reviewsCount }})</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-description" role="tabpanel" aria-labelledby="tab-description-tab">
                    <div class="product-single__description">
                        @if($productDesc)
                            {!! $productDesc !!}
                        @else
                            <p class="content">{{ __('common.No description available.') }}</p>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-additional-info" role="tabpanel" aria-labelledby="tab-additional-info-tab">
                    <div class="product-single__addtional-info">
                        @php
                            $attributes = $productData['attributes'] ?? [];
                            $specs = $productData['specs'] ?? [];
                        @endphp
                        @if(!empty($attributes))
                            <h5 class="mb-3">{{ __('product.Attributes') }}</h5>
                            @foreach($attributes as $key => $value)
                                <div class="item mb-3">
                                    <label class="h6">{{ $key }}</label>
                                    <span>{{ $value }}</span>
                        </div>
                            @endforeach
                        @endif
                        @if(!empty($specs))
                            @if(!empty($attributes))
                                <hr class="my-4">
                            @endif
                            <h5 class="mb-3">{{ __('product.Specifications') }}</h5>
                            @foreach($specs as $key => $value)
                                <div class="item mb-3">
                                    <label class="h6">{{ $key }}</label>
                                    <span>{{ $value }}</span>
                        </div>
                            @endforeach
                        @endif
                        @if(empty($attributes) && empty($specs))
                            <p class="text-muted">{{ __('common.No additional information available.') }}</p>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews-tab">
                    <h2 class="product-single__reviews-title">{{ __('product.Reviews') }}</h2>
                    <div class="product-single__reviews-list" id="reviews-list">
                        @if($reviews->count() > 0)
                            @foreach($reviews as $review)
                                @include('pages.products.partials.review-item', ['review' => $review])
                            @endforeach
                        @else
                            <p class="text-muted">{{ __('common.No reviews yet. Be the first to review!') }}</p>
                        @endif
                    </div>
                    <div class="product-single__review-form mt-4">
                        <form id="product-review-form" name="customer-review-form" class="needs-validation" novalidate data-submit-url="{{ route('products.reviews.store', [$locale, $product->slug]) }}">
                            @csrf
                            <h5>{{ __('product.Be the first to review') }} "{{ $productName }}"</h5>
                            <p>{{ __('product.Your email address will not be published. Required fields are marked *') }}</p>
                            <div class="select-star-rating mb-4">
                                <label>{{ __('product.Your rating') }} *</label>
                                <span class="star-rating" id="star-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="star-rating__star-icon" data-rating="{{ $i }}" width="12" height="12" fill="#ccc" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg" style="cursor: pointer;">
                      <path d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z"/>
                    </svg>
                                    @endfor
                  </span>
                                <input type="hidden" id="form-input-rating" name="rating" value="" required>
                            </div>
                            <div class="mb-4">
                                <label for="form-input-title" class="form-label">{{ __('product.Title') }}</label>
                                <input id="form-input-title" name="title" class="form-control form-control-md form-control_gray" placeholder="{{ __('product.Review Title') }}">
                            </div>
                            <div class="mb-4">
                                <textarea id="form-input-review" name="body" class="form-control form-control_gray" placeholder="{{ __('product.Your Review') }}" cols="30" rows="8"></textarea>
                            </div>
                            <div class="form-label-fixed mb-4">
                                <label for="form-input-name" class="form-label">{{ __('product.Name') }} *</label>
                                <input id="form-input-name" name="author_name" class="form-control form-control-md form-control_gray" required>
                            </div>
                            <div class="form-label-fixed mb-4">
                                <label for="form-input-email" class="form-label">{{ __('product.Email address') }} *</label>
                                <input id="form-input-email" name="author_email" type="email" class="form-control form-control-md form-control_gray" required>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input form-check-input_fill" type="checkbox" value="1" id="remember_checkbox" name="remember">
                                <label class="form-check-label" for="remember_checkbox">
                                    {{ __('product.Save my name, email, and website in this browser for the next time I comment.') }}
                                </label>
            </div>
                            <div class="form-action">
                                <button type="submit" class="btn btn-primary">{{ __('product.Submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="products-carousel container">
        <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">{{ __('product.Related') }} <strong>{{ __('product.Products') }}</strong></h2>

        <div id="related_products" class="position-relative">
            <div class="swiper-container js-swiper-slider"
                 data-settings='{
            "autoplay": false,
            "slidesPerView": 4,
            "slidesPerGroup": 4,
            "effect": "none",
            "loop": true,
            "pagination": {
              "el": "#related_products .products-pagination",
              "type": "bullets",
              "clickable": true
            },
            "navigation": {
              "nextEl": "#related_products .products-carousel__next",
              "prevEl": "#related_products .products-carousel__prev"
            },
            "breakpoints": {
              "320": {
                "slidesPerView": 2,
                "slidesPerGroup": 2,
                "spaceBetween": 14
              },
              "768": {
                "slidesPerView": 3,
                "slidesPerGroup": 3,
                "spaceBetween": 24
              },
              "992": {
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "spaceBetween": 30
              }
            }
          }'>
                <div class="swiper-wrapper">
                    @forelse($relatedProducts as $relatedProduct)
                        <div class="swiper-slide">
                            <x-product-card :product="$relatedProduct" />
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <p class="text-center text-muted">{{ __('common.No related products found.') }}</p>
                        </div>
                    @endforelse
                </div><!-- /.swiper-wrapper -->
            </div><!-- /.swiper-container js-swiper-slider -->

            <div class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_md" /></svg>
            </div><!-- /.products-carousel__prev -->
            <div class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_md" /></svg>
            </div><!-- /.products-carousel__next -->

            <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
            <!-- /.products-pagination -->
        </div><!-- /.position-relative -->

    </section><!-- /.products-carousel container -->




@endsection

@push('scripts')
<script>
(function() {
    'use strict';
    
    // Configure Toastr
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            preventDuplicates: false,
            onclick: null,
            showDuration: '300',
            hideDuration: '1000',
            timeOut: '5000',
            extendedTimeOut: '1000',
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Tab persistence with URL hash
        const tabLinks = document.querySelectorAll('[data-bs-toggle="tab"]');
        const hash = window.location.hash;
        const navTabs = document.querySelector('.product-single__details-tab > .nav-tabs');
        
        // Function to scroll active tab to center
        function scrollTabToCenter(tabLink) {
            if (navTabs && window.innerWidth <= 575.98) {
                const navItem = tabLink.closest('.nav-item');
                if (navItem) {
                    const navTabsRect = navTabs.getBoundingClientRect();
                    const navItemRect = navItem.getBoundingClientRect();
                    const scrollLeft = navItem.offsetLeft - (navTabsRect.width / 2) + (navItemRect.width / 2);
                    navTabs.scrollTo({ left: scrollLeft, behavior: 'smooth' });
                }
            }
        }
        
        // Restore active tab from URL hash on page load
        if (hash) {
            const tabLink = document.querySelector(`[href="${hash}"]`);
            if (tabLink) {
                const tab = new bootstrap.Tab(tabLink);
                tab.show();
                setTimeout(() => scrollTabToCenter(tabLink), 100);
            }
        } else {
            // Scroll active tab to center on page load
            const activeTab = document.querySelector('.product-single__details-tab .nav-link.active');
            if (activeTab) {
                setTimeout(() => scrollTabToCenter(activeTab), 100);
            }
        }
        
        // Save active tab to URL hash when tab is changed and scroll to center
        tabLinks.forEach(function(tabLink) {
            tabLink.addEventListener('shown.bs.tab', function(e) {
                const hash = e.target.getAttribute('href');
                if (hash) {
                    history.replaceState(null, null, hash);
                }
                scrollTabToCenter(e.target);
            });
        });
        // Quantity control
        const qtyInput = document.getElementById('productQuantity');
        const qtyReduce = document.querySelector('.qty-control__reduce');
        const qtyIncrease = document.querySelector('.qty-control__increase');
        const addToCartBtn = document.getElementById('addToCartBtn');
        
        if (qtyReduce && qtyInput) {
            qtyReduce.addEventListener('click', function() {
                const currentValue = parseInt(qtyInput.value) || 1;
                if (currentValue > 1) {
                    qtyInput.value = currentValue - 1;
                }
            });
        }
        
        if (qtyIncrease && qtyInput) {
            qtyIncrease.addEventListener('click', function() {
                const currentValue = parseInt(qtyInput.value) || 1;
                qtyInput.value = currentValue + 1;
            });
        }
        
        // Add to cart with quantity
        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.getAttribute('data-product-id');
                const quantity = parseInt(qtyInput ? qtyInput.value : 1) || 1;
                
                // Use existing addToCart function from scripts.blade.php
                if (typeof addToCart === 'function') {
                    addToCart(productId, quantity).then(success => {
                        if (success) {
                            const aside = this.getAttribute('data-aside');
                            if (aside) {
                                const asideEl = document.getElementById(aside);
                                if (asideEl) {
                                    if (typeof UomoHelpers !== 'undefined' && UomoHelpers.showPageBackdrop) {
                                        UomoHelpers.showPageBackdrop();
                                    }
                                    asideEl.classList.add('aside_visible');
                                }
                            }
                        }
                    });
                }
            });
        }
        
        // Review Form - AJAX submission
        const reviewForm = document.getElementById('product-review-form');
        if (reviewForm) {
            const formData = {
                submitUrl: reviewForm.dataset.submitUrl || '',
                csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                locale: document.documentElement.lang || 'en'
            };
            
            // Star rating functionality
            const starIcons = document.querySelectorAll('.star-rating__star-icon');
            const ratingInput = document.getElementById('form-input-rating');
            let selectedRating = 0;

            starIcons.forEach(star => {
                star.addEventListener('click', function() {
                    selectedRating = parseInt(this.dataset.rating);
                    if (ratingInput) ratingInput.value = selectedRating;

                    starIcons.forEach((s, index) => {
                        if (index < selectedRating) {
                            s.setAttribute('fill', '#ffc107');
                        } else {
                            s.setAttribute('fill', '#ccc');
                        }
                    });
                });

                star.addEventListener('mouseenter', function() {
                    const hoverRating = parseInt(this.dataset.rating);
                    starIcons.forEach((s, index) => {
                        if (index < hoverRating) {
                            s.setAttribute('fill', '#ffc107');
                        } else {
                            s.setAttribute('fill', '#ccc');
                        }
                    });
                });
            });

            // Clear validation states on input
            const formInputs = reviewForm.querySelectorAll('.form-control');
            formInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid', 'is-valid');
                    const feedback = this.parentElement.querySelector('.invalid-feedback');
                    if (feedback) feedback.remove();
                });
            });

            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Clear previous validation states
                reviewForm.classList.remove('was-validated');
                formInputs.forEach(input => {
                    input.classList.remove('is-invalid', 'is-valid');
                    input.removeAttribute('aria-invalid');
                });
                const invalidFeedbacks = reviewForm.querySelectorAll('.invalid-feedback');
                invalidFeedbacks.forEach(feedback => feedback.remove());

                let isValid = true;
                const errors = [];

                // Validate rating
                if (!ratingInput || !ratingInput.value) {
                    isValid = false;
                    errors.push('Please select a rating');
                }

                // Validate name
                const nameInput = document.getElementById('form-input-name');
                if (!nameInput || !nameInput.value || nameInput.value.trim() === '') {
                    isValid = false;
                    nameInput.classList.add('is-invalid');
                    const nameFeedback = document.createElement('div');
                    nameFeedback.className = 'invalid-feedback';
                    nameFeedback.textContent = 'Name is required';
                    nameInput.parentElement.appendChild(nameFeedback);
                    errors.push('Name is required');
                }

                // Validate email
                const emailInput = document.getElementById('form-input-email');
                if (!emailInput || !emailInput.value || emailInput.value.trim() === '') {
                    isValid = false;
                    emailInput.classList.add('is-invalid');
                    const emailFeedback = document.createElement('div');
                    emailFeedback.className = 'invalid-feedback';
                    emailFeedback.textContent = 'Email address is required';
                    emailInput.parentElement.appendChild(emailFeedback);
                    errors.push('Email address is required');
                } else if (!emailInput.validity.valid) {
                    isValid = false;
                    emailInput.classList.add('is-invalid');
                    const emailFeedback = document.createElement('div');
                    emailFeedback.className = 'invalid-feedback';
                    emailFeedback.textContent = 'Please enter a valid email address';
                    emailInput.parentElement.appendChild(emailFeedback);
                    errors.push('Please enter a valid email address');
                }

                if (!isValid) {
                    if (typeof toastr !== 'undefined') {
                        toastr.warning(errors.join('<br>'), 'Please fix the errors');
                    } else {
                        alert(errors.join('\n'));
                    }
                    reviewForm.classList.add('was-validated');
                    return;
                }

                const submitData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn ? submitBtn.textContent : '';
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Submitting...';
                }

                fetch(formData.submitUrl, {
                    method: 'POST',
                    body: submitData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': formData.csrfToken
                    }
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        if (data.errors) {
                            const errorMessages = Object.values(data.errors).flat().join('<br>');
                            throw new Error(errorMessages || data.message || 'Validation failed');
                        }
                        throw new Error(data.message || data.error || 'An error occurred');
                    }
                    return data;
                })
                .then(data => {
                    if (data.success) {
                        if (typeof toastr !== 'undefined') {
                            toastr.success(data.message || 'Review submitted successfully!', 'Success');
                        } else {
                            alert(data.message || 'Review submitted successfully!');
                        }

                        // Add review to list
                        const reviewsList = document.getElementById('reviews-list');
                        if (reviewsList) {
                            if (reviewsList.querySelector('.text-muted')) {
                                reviewsList.innerHTML = '';
                            }
                            if (data.review) {
                                reviewsList.insertAdjacentHTML('beforeend', data.review);
                            }
                        }

                        // Update reviews count in tab
                        const reviewsTab = document.getElementById('tab-reviews-tab');
                        if (reviewsTab && data.reviews_count !== undefined) {
                            const reviewsLabel = reviewsTab.getAttribute('data-label') || 'Reviews';
                            reviewsTab.textContent = reviewsLabel + ' (' + data.reviews_count + ')';
                        }

                        // Reset form
                        reviewForm.reset();
                        if (ratingInput) {
                            ratingInput.value = '';
                            selectedRating = 0;
                            starIcons.forEach(s => s.setAttribute('fill', '#ccc'));
                        }

                        // Clear validation
                        reviewForm.classList.remove('was-validated');
                        formInputs.forEach(input => {
                            input.classList.remove('is-invalid', 'is-valid');
                            input.removeAttribute('aria-invalid');
                        });
                        const invalidFeedback = reviewForm.querySelectorAll('.invalid-feedback');
                        invalidFeedback.forEach(feedback => feedback.remove());
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(data.message || 'An error occurred', 'Error');
                        } else {
                            alert(data.message || 'An error occurred');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof toastr !== 'undefined') {
                        toastr.error(error.message || 'An error occurred. Please try again.', 'Error');
                    } else {
                        alert(error.message || 'An error occurred. Please try again.');
                    }
                })
                .finally(() => {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                });
            });
        }
    });
})();
</script>
@endpush
