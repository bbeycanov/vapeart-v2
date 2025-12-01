
<div class="modal fade" id="quickView" tabindex="-1">
    <div class="modal-dialog quick-view modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="product-single">
                <div class="product-single__media m-0">
                    <div class="product-single__image position-relative w-100">
                        <div id="quickViewDiscountBadge" style="position: absolute; top: 0; left: 0; margin: 12px; z-index: 10; display: none;"></div>
                        <div class="swiper-container js-swiper-slider"
                             data-settings='{
                  "slidesPerView": 1,
                  "slidesPerGroup": 1,
                  "effect": "none",
                  "loop": false,
                  "navigation": {
                    "nextEl": ".modal-dialog.quick-view .product-single__media .swiper-button-next",
                    "prevEl": ".modal-dialog.quick-view .product-single__media .swiper-button-prev"
                  }
                }'>
                            <div class="swiper-wrapper" id="quickViewImages">
                                <!-- Images will be loaded dynamically -->
                            </div>
                            <div class="swiper-button-prev"><svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_sm" /></svg></div>
                            <div class="swiper-button-next"><svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_sm" /></svg></div>
                        </div>
                    </div>
                </div>
                <div class="product-single__detail">
                    <h1 class="product-single__name" id="quickViewName">-</h1>
                    <div class="product-single__price">
                        <span class="current-price" id="quickViewPrice">-</span>
                        <span class="old-price" id="quickViewOldPrice" style="display: none;"></span>
                    </div>
                    <div class="product-single__brand mb-3" id="quickViewBrandLogo" style="display: none;">
                        <!-- Brand logo will be added here -->
                    </div>
                    <div class="product-single__rating mb-2" id="quickViewRating" style="display: none;">
                        <div class="reviews-group d-flex">
                            <!-- Stars will be added dynamically -->
                        </div>
                        <span class="reviews-note text-lowercase text-secondary ms-2" id="quickViewReviewsCount"></span>
                    </div>
                    <div class="product-single__short-desc">
                        <p id="quickViewDescription">-</p>
                    </div>
                    <form name="addtocart-form" method="post" id="quickViewAddToCartForm">
                        <input type="hidden" name="product_id" id="quickViewProductId" value="">
                        <div class="product-single__swatches" style="display: none;">
                            <!-- Swatches can be added later if needed -->
                        </div>
                        <div class="product-single__addtocart">
                            <div class="qty-control position-relative">
                                <input type="number" name="quantity" value="1" min="1" class="qty-control__number text-center" id="quickViewQuantity">
                                <div class="qty-control__reduce">-</div>
                                <div class="qty-control__increase">+</div>
                            </div>
                            <button type="button" class="btn btn-primary btn-addtocart js-add-cart-from-quickview js-open-aside" data-aside="cartDrawer">{{ __('buttons.Add to Cart') }}</button>
                        </div>
                    </form>
                    <div class="product-single__addtolinks">
                        <a href="#" class="menu-link menu-link_us-s js-add-wishlist" id="quickViewWishlistBtn">
                            <svg class="js-wishlist-icon" width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_heart" /></svg>
                            <span class="js-wishlist-text">{{ __('wishlist.Add to Wishlist') }}</span>
                        </a>
                        <share-button class="share-button">
                            <button class="menu-link menu-link_us-s to-share border-0 bg-transparent d-flex align-items-center">
                                <svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_sharing" /></svg>
                            </button>
                            <details id="Details-share-template__main" class="m-1 xl:m-1.5" hidden="">
                                <summary class="btn-solid m-1 xl:m-1.5 pt-3.5 pb-3 px-5">+</summary>
                                <div id="Article-share-template__main" class="share-button__fallback flex items-center absolute top-full left-0 w-full px-2 py-4 bg-container shadow-theme border-t z-10">
                                    <div class="field grow mr-4">
                                        <label class="field__label sr-only" for="url">Link</label>
                                        <input type="text" class="field__input w-full" id="url" value="https://uomo-crystal.myshopify.com/blogs/news/go-to-wellness-tips-for-mental-health" placeholder="Link" onclick="this.select();" readonly="">
                                    </div>
                                    <button class="share-button__copy no-js-hidden">
                                        <svg class="icon icon-clipboard inline-block mr-1" width="11" height="13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" viewBox="0 0 11 13">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 1a1 1 0 011-1h7a1 1 0 011 1v9a1 1 0 01-1 1V1H2zM1 2a1 1 0 00-1 1v9a1 1 0 001 1h7a1 1 0 001-1V3a1 1 0 00-1-1H1zm0 10V3h7v9H1z" fill="currentColor"></path>
                                        </svg>
                                        <span class="sr-only">Copy link</span>
                                    </button>
                                </div>
                            </details>
                        </share-button>
                        <script src="{{asset('storefront/js/details-disclosure.js')}}" defer="defer"></script>
                        <script src="{{asset('storefront/js/share.js')}}" defer="defer"></script>
                    </div>
                    <div class="product-single__meta-info mb-0">
                        <div class="meta-item">
                            <label>{{ __('quick_view.SKU') }}:</label>
                            <span id="quickViewSku">-</span>
                        </div>
                        <div class="meta-item" id="quickViewBrandItem" style="display: none;">
                            <label>{{ __('quick_view.Brand') }}:</label>
                            <span id="quickViewBrandLink">-</span>
                        </div>
                        <div class="meta-item" id="quickViewCategoriesItem" style="display: none;">
                            <label>{{ __('quick_view.Categories') }}:</label>
                            <span id="quickViewCategoriesLinks">-</span>
                        </div>
                        <div class="meta-item" id="quickViewTagsItem" style="display: none;">
                            <label>{{ __('quick_view.Tags') }}:</label>
                            <span id="quickViewTags">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
