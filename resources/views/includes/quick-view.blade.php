
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
                    <div class="d-flex align-items-center gap-3 flex-wrap mb-2">
                        <div class="product-single__brand mb-3" id="quickViewBrandLogo" style="display: none;">
                            <!-- Brand logo will be added here -->
                        </div>
                        <div class="d-flex align-items-center flex-wrap mb-2">
                            <div class="meta-item w-100 mb-0">
                                <label>{{ __('quick_view.SKU') }}:</label>
                                <span id="quickViewSku">-</span>
                            </div>
                            <div class="meta-item w-100" id="quickViewCategoriesItem" style="display: none;">
                                <label>{{ __('quick_view.Categories') }}:</label>
                                <span id="quickViewCategoriesLinks">-</span>
                            </div>
                        </div>
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
                    <div class="product-single__whatsapp-order mb-3">
                        <button type="button" class="btn btn-whatsapp w-100" id="quickViewWhatsappOrderBtn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="me-2" style="vertical-align: middle;">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            {{ __('product.WhatsApp ilə sifariş et') }}
                        </button>
                    </div>
                    <div class="product-single__addtolinks" style="margin-bottom: 10px; margin-top: 15px">
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
                                        <input type="text" class="field__input w-full" id="product-url" value="" placeholder="Link" onclick="this.select();" readonly="">
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
