@extends('layouts.default')

@section('content')
    <section class="swiper-container js-swiper-slider slideshow type3 slideshow-navigation-white-sm"
             data-settings='{
                    "autoplay": {
                      "delay": 5000
                    },
                    "navigation": {
                      "nextEl": ".slideshow__next",
                      "prevEl": ".slideshow__prev"
                    },
                    "pagination": {
                      "el": ".slideshow-pagination",
                      "type": "bullets",
                      "clickable": true
                    },
                    "slidesPerView": 1,
                    "effect": "fade",
                    "loop": true
                  }'>
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="overflow-hidden position-relative h-100">
                    <div class="slideshow-bg" style="background-color: #f5e6e0;">
                        <img loading="lazy"
                             src="{{asset('storefront/images/home/demo12/slider1.jpg')}}" width="1920"
                             height="560" alt="Pattern" class="slideshow-bg__img object-fit-cover">
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="overflow-hidden position-relative h-100">
                    <div class="slideshow-bg" style="background-color: #f5e6e0;">
                        <img loading="lazy"
                             src="{{asset('storefront/images/home/demo12/slider2.jpg')}}" width="1920"
                             height="560" alt="Pattern" class="slideshow-bg__img object-fit-cover">
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="overflow-hidden position-relative h-100">
                    <div class="slideshow-bg" style="background-color: #f5e6e0;">
                        <img loading="lazy"
                             src="{{asset('storefront/images/home/demo12/slider3.jpg')}}" width="1920"
                             height="560" alt="Pattern" class="slideshow-bg__img object-fit-cover">
                    </div>
                </div>
            </div>
        </div>

        <div class="slideshow__prev position-absolute top-50 d-flex align-items-center justify-content-center">
            <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_prev_sm"/>
            </svg>
        </div>
        <div class="slideshow__next position-absolute top-50 d-flex align-items-center justify-content-center">
            <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_next_sm"/>
            </svg>
        </div>

        <div class="container">
            <div class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-5"></div>
        </div>
    </section>

    <section class="service-promotion horizontal bg-grey-f7f5ee">
        <div class="container">
            <div class="pb-2"></div>
            <div class="row">
                <form action="" method="POST">
                    <div class="form-group">
                        <div class="col-12">
                            <!-- Search input -->
                            <input type="text" class="form-control form-control-lg" placeholder="Search for products...">
                        </div>
                    </div>
                </form>
            </div>
            <div class="pb-2"></div>
        </div>
    </section>

    <div class="mb-3 mb-xl-5 pb-3 pt-1 pb-xl-5"></div>

    <section class="products-grid">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 pb-xl-2 mb-xl-4 gap-md-4">
                <h2 class="section-title fw-normal">Featured Products</h2>

                <ul class="nav nav-tabs justify-content-center" id="collections-1-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore active" id="collections-tab-1-trigger"
                           data-bs-toggle="tab" href="#collections-tab-1" role="tab" aria-controls="collections-tab-1"
                           aria-selected="true">Best Sellers</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore" id="collections-tab-2-trigger" data-bs-toggle="tab"
                           href="#collections-tab-2" role="tab" aria-controls="collections-tab-2" aria-selected="true">Most
                            Popular</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore" id="collections-tab-3-trigger" data-bs-toggle="tab"
                           href="#collections-tab-3" role="tab" aria-controls="collections-tab-3" aria-selected="true">Top
                            20</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore" id="collections-tab-4-trigger" data-bs-toggle="tab"
                           href="#collections-tab-4" role="tab" aria-controls="collections-tab-4" aria-selected="true">Best
                            Rated</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content pt-2" id="collections-2-tab-content">
                <div class="tab-pane fade show active" id="collections-tab-1" role="tabpanel"
                     aria-labelledby="collections-tab-1-trigger">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-5">
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-1.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Bartlett Pear</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$35.90</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-2.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Strawberries, 1 lb</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$79.99</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-3.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Blueberry Organic, 6 Ounce</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$929.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-4.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Kiwi Organic, 1 Each</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$729.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-5.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Banana</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$399.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-6.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">McCormick Gourmet Orange</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$35.90</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-7.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Strawberries, 1 lb</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$79.99</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-8.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Blueberry Organic, 6 Ounce</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$929.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-9.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Dried Pineapple Fruit Bar</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$729.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-10.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Holiday Nuts Gift Basket</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$399.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="collections-tab-2" role="tabpanel"
                     aria-labelledby="collections-tab-2-trigger">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-5">
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-2.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Strawberries, 1 lb</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$79.99</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-3.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Blueberry Organic, 6 Ounce</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$929.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-4.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Kiwi Organic, 1 Each</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$729.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-5.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Banana</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$399.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-6.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">McCormick Gourmet Orange</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$35.90</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-7.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Strawberries, 1 lb</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$79.99</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-8.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Blueberry Organic, 6 Ounce</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$929.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-9.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Dried Pineapple Fruit Bar</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$729.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-10.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Holiday Nuts Gift Basket</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$399.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-1.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Bartlett Pear</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$35.90</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="collections-tab-3" role="tabpanel"
                     aria-labelledby="collections-tab-3-trigger">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-5">
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-3.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Blueberry Organic, 6 Ounce</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$929.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-4.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Kiwi Organic, 1 Each</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$729.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-5.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Banana</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$399.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-6.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">McCormick Gourmet Orange</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$35.90</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-7.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Strawberries, 1 lb</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$79.99</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-8.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Blueberry Organic, 6 Ounce</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$929.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-9.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Dried Pineapple Fruit Bar</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$729.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-10.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Holiday Nuts Gift Basket</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$399.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-1.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Bartlett Pear</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$35.90</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-2.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Strawberries, 1 lb</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$79.99</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="collections-tab-4" role="tabpanel"
                     aria-labelledby="collections-tab-4-trigger">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-5">
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-4.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Kiwi Organic, 1 Each</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$729.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-5.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Banana</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$399.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-6.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">McCormick Gourmet Orange</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$35.90</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-7.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Strawberries, 1 lb</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$79.99</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-8.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Blueberry Organic, 6 Ounce</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$929.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-9.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Dried Pineapple Fruit Bar</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$729.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-10.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Holiday Nuts Gift Basket</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$399.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-1.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Bartlett Pear</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$35.90</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-2.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Strawberries, 1 lb</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$79.99</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-wrapper mb-2">
                            <div class="product-card product-card_style9 border rounded-3 mb-3 mb-md-4 ">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-3.jpg')}}"
                                                 width="256" height="201" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Blueberry Organic, 6 Ounce</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$929.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="mb-3 mb-xl-4 pb-3 pt-1 pb-xl-5"></div>


    <section class="discount-carousel container">
        <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 pb-xl-2 mb-xl-4 gap-md-4">
            <h2 class="section-title fw-normal">Discount</h2>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-20per">
                <div class="position-relative w-100 h-sm-100 border-radius-4 overflow-hidden minh-240 mb-4 mb-sm-0">
                    <div class="background-img"
                         style="background-image: url('{{asset('storefront/images/home/demo12/deal-bg.jpg')}}');"></div>
                    <div class="position-absolute position-center text-white text-center w-100">
                        <h2 class="section-title fw-bold text-white">$20</h2>
                        <h3 class="text-white fw-normal">Under Products</h3>
                        <p>Limited Time Only</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-8 col-lg-9 col-xl-80per">
                <div id="deals_carousel" class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                         data-settings='{
                "autoplay": {
                  "delay": 5000
                },
                "slidesPerView": 4,
                "slidesPerGroup": 1,
                "effect": "none",
                "loop": false,
                "breakpoints": {
                  "320": {
                    "slidesPerView": 1,
                    "slidesPerGroup": 1,
                    "spaceBetween": 16
                  },
                  "768": {
                    "slidesPerView": 2,
                    "slidesPerGroup": 1,
                    "spaceBetween": 22
                  },
                  "992": {
                    "slidesPerView": 3,
                    "slidesPerGroup": 1,
                    "spaceBetween": 28
                  },
                  "1200": {
                    "slidesPerView": 4,
                    "slidesPerGroup": 1,
                    "spaceBetween": 34
                  }
                }
              }'>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide product-card product-card_style9 border rounded-3">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-16.jpg')}}"
                                                 width="253" height="198" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Bartlett Pear</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$35.90</span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide product-card product-card_style9 border rounded-3">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-17.jpg')}}"
                                                 width="253" height="198" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Strawberries, 1 lb</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$79.99</span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide product-card product-card_style9 border rounded-3">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-18.jpg')}}"
                                                 width="253" height="198" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Blueberry Organic, 6 Ounce</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$929.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide product-card product-card_style9 border rounded-3">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-19.jpg')}}"
                                                 width="253" height="198" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Kiwi Organic, 1 Each</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$729.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide product-card product-card_style9 border rounded-3">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-16.jpg')}}"
                                                 width="253" height="198" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Bartlett Pear</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$35.90</span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide product-card product-card_style9 border rounded-3">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-17.jpg')}}"
                                                 width="253" height="198" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Organic Strawberries, 1 lb</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$79.99</span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide product-card product-card_style9 border rounded-3">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-18.jpg')}}"
                                                 width="253" height="198" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Blueberry Organic, 6 Ounce</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$929.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide product-card product-card_style9 border rounded-3">
                                <div class="position-relative pb-3">
                                    <div class="pc__img-wrapper pc__img-wrapper_wide3">
                                        <a href="#">
                                            <img loading="lazy"
                                                 src="{{asset('storefront/images/home/demo12/product-19.jpg')}}"
                                                 width="253" height="198" alt="Cropped Faux leather Jacket"
                                                 class="pc__img">
                                        </a>
                                    </div>
                                    <div class="anim_appear-bottom position-absolute w-100 text-center">
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">
                                            <svg class="d-inline-block" width="14" height="14" viewBox="0 0 20 20"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_cart"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase me-2 js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <svg class="d-inline-block" width="18" height="18" viewBox="0 0 18 18"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_view"/>
                                            </svg>
                                        </button>
                                        <button
                                            class="btn btn-round btn-hover-red border-0 text-uppercase js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">Fruits</p>
                                    <h6 class="pc__title"><a href="#">Kiwi Organic, 1 Each</a></h6>
                                    <div class="product-card__review d-sm-flex align-items-center">
                                        <div class="reviews-group d-flex">
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                            <svg class="review-star" viewBox="0 0 9 9"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z"></path>
                                            </svg>
                                        </div>
                                        <span class="reviews-note text-lowercase text-secondary ms-sm-1">321,975</span>
                                    </div>
                                    <div class="product-card__price d-flex">
                                        <span class="money price fs-5">$729.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="mb-3 mb-xl-5 pb-3 pt-1 pb-xl-5"></div>

    <section class="category-carousel bg-grey-f7f5ee">
        <div class="container">
            <div class="mb-3 mb-xl-5 pb-3 pt-1 pb-xl-5"></div>

            <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 pb-xl-2 mb-xl-4 gap-md-4">
                <h2 class="section-title fw-normal">Latest in Blog</h2>
                <a class="btn-link btn-link_md default-underline text-uppercase fw-medium" href="#">See All Blog</a>
            </div>

            <div class="position-relative">
                <div class="swiper-container js-swiper-slider"
                     data-settings='{
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": 3,
              "slidesPerGroup": 3,
              "effect": "none",
              "loop": true,
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "slidesPerGroup": 1,
                  "spaceBetween": 14
                },
                "768": {
                  "slidesPerView": 2,
                  "slidesPerGroup": 2,
                  "spaceBetween": 24
                },
                "992": {
                  "slidesPerView": 3,
                  "slidesPerGroup": 1,
                  "spaceBetween": 30
                },
                "1200": {
                  "slidesPerView": 4,
                  "slidesPerGroup": 1,
                  "spaceBetween": 30
                }
              }
            }'>
                    <div class="swiper-wrapper blog-grid row-cols-xl-3">
                        <div class="swiper-slide blog-grid__item mb-0 bg-white">
                            <div class="blog-grid__item-image mb-0">
                                <img loading="lazy" class="h-auto"
                                     src="{{asset('storefront/images/home/demo12/post-1.jpg')}}" width="330"
                                     height="220" alt="">
                            </div>
                            <div class="blog-grid__item-detail px-4 py-4">
                                <div class="blog-grid__item-meta">
                                    <span class="blog-grid__item-meta__author">By Admin</span>
                                    <span class="blog-grid__item-meta__date">Aprial 05, 2023</span>
                                </div>
                                <div class="blog-grid__item-title mb-0 me-3 me-xxl-5">
                                    <a href="#">Woman with good shoes is never be ugly place</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide blog-grid__item mb-0 bg-white">
                            <div class="blog-grid__item-image mb-0">
                                <img loading="lazy" class="h-auto"
                                     src="{{asset('storefront/images/home/demo12/post-2.jpg')}}" width="330"
                                     height="220" alt="">
                            </div>
                            <div class="blog-grid__item-detail px-4 py-4">
                                <div class="blog-grid__item-meta">
                                    <span class="blog-grid__item-meta__author">By Admin</span>
                                    <span class="blog-grid__item-meta__date">Aprial 05, 2023</span>
                                </div>
                                <div class="blog-grid__item-title mb-0 me-3 me-xxl-5">
                                    <a href="#">What Freud Can Teach Us About Furniture</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide blog-grid__item mb-0 bg-white">
                            <div class="blog-grid__item-image mb-0">
                                <img loading="lazy" class="h-auto"
                                     src="{{asset('storefront/images/home/demo12/post-3.jpg')}}" width="330"
                                     height="220" alt="">
                            </div>
                            <div class="blog-grid__item-detail px-4 py-4">
                                <div class="blog-grid__item-meta">
                                    <span class="blog-grid__item-meta__author">By Admin</span>
                                    <span class="blog-grid__item-meta__date">Aprial 05, 2023</span>
                                </div>
                                <div class="blog-grid__item-title mb-0 me-3 me-xxl-5">
                                    <a href="#">Habitant morbi tristique senectus</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide blog-grid__item mb-0 bg-white">
                            <div class="blog-grid__item-image mb-0">
                                <img loading="lazy" class="h-auto"
                                     src="{{asset('storefront/images/home/demo12/post-4.jpg')}}" width="330"
                                     height="220" alt="">
                            </div>
                            <div class="blog-grid__item-detail px-4 py-4">
                                <div class="blog-grid__item-meta">
                                    <span class="blog-grid__item-meta__author">By Admin</span>
                                    <span class="blog-grid__item-meta__date">Aprial 05, 2023</span>
                                </div>
                                <div class="blog-grid__item-title mb-0 me-3 me-xxl-5">
                                    <a href="#">Woman with good shoes is never be ugly place</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 mt-xl-5 pb-3 pt-1 pb-xl-5"></div>
        </div>
    </section>

@endsection
