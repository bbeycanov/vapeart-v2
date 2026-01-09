@extends('layouts.default')

@section('title', __('page.home_title'))

@section('meta_description', __('page.home_meta_description'))

@section('head')
    @if(isset($organizationSchema))
        {!! $organizationSchema !!}
    @endif
@endsection

@section('content')
    {{-- Single H1 for SEO - visually hidden but accessible --}}
    <h1 class="visually-hidden">{{ __('page.home_title') }} - VapeArt Baku</h1>

    @if(isset($heroBanners) && $heroBanners && $heroBanners->isNotEmpty())
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
                @foreach($heroBanners as $banner)
                    @php
                        $locale = app()->getLocale();
                        $bannerImages = $banner->getBannerImageUrls();
                        $originalImage = $banner->getFirstMediaUrl('image'); // Original for desktop
                        $videoUrl = $banner->getFirstMediaUrl('video');
                        $title = $banner->getTranslation('title', $locale);
                        $subtitle = $banner->getTranslation('subtitle', $locale);
                        $content = $banner->getTranslation('content', $locale);
                        $linkUrl = $banner->getTranslation('link_url', $locale);
                        $linkText = $banner->getTranslation('link_text', $locale);
                        $target = $banner->target;
                    @endphp
                    <div class="swiper-slide">
                        <div class="overflow-hidden position-relative h-100">
                            <div class="slideshow-bg">
                                @if($videoUrl)
                                    <video autoplay muted loop playsinline class="slideshow-bg__video object-fit-cover w-100 h-100">
                                        <source src="{{ $videoUrl }}" type="video/mp4">
                                    </video>
                                @elseif($originalImage || $bannerImages['desktop'])
                                    <picture>
                                        {{-- Mobile WebP --}}
                                        @if($bannerImages['mobile_webp'])
                                            <source media="(max-width: 768px)" srcset="{{ $bannerImages['mobile_webp'] }}" type="image/webp">
                                        @endif
                                        {{-- Mobile fallback --}}
                                        @if($bannerImages['mobile'])
                                            <source media="(max-width: 768px)" srcset="{{ $bannerImages['mobile'] }}">
                                        @endif
                                        {{-- Tablet WebP --}}
                                        @if($bannerImages['tablet_webp'])
                                            <source media="(max-width: 1024px)" srcset="{{ $bannerImages['tablet_webp'] }}" type="image/webp">
                                        @endif
                                        {{-- Tablet fallback --}}
                                        @if($bannerImages['tablet'])
                                            <source media="(max-width: 1024px)" srcset="{{ $bannerImages['tablet'] }}">
                                        @endif
                                        {{-- Desktop: Original image for best quality --}}
                                        <img loading="eager"
                                             src="{{ $originalImage ?: $bannerImages['desktop'] }}"
                                             alt="{{ $title ?? __('common.Banner') }}"
                                             class="slideshow-bg__img object-fit-cover w-100 h-100">
                                    </picture>
                                @endif
                            </div>
                            @if($title || $subtitle || $content || $linkUrl)
                                <div class="container position-absolute top-50 start-50 translate-middle">
                                    <div class="slideshow-content text-center text-white">
                                        @if($subtitle)
                                            <p class="slideshow-subtitle mb-2">{{ $subtitle }}</p>
                                        @endif
                                        @if($title)
                                            <h2 class="slideshow-title mb-3">{{ $title }}</h2>
                                        @endif
                                        @if($content)
                                            <div class="slideshow-text mb-4">{{ $content }}</div>
                                        @endif
                                        @if($linkUrl && $linkText)
                                            <a href="{{ $linkUrl }}"
                                               class="btn btn-primary"
                                               @if($target) target="{{ $target }}" @endif>
                                                {{ $linkText }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
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
    @endif

    <section class="product-search-section py-4 py-md-5 bg-grey-f7f5ee">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8">
                    <div class="product-search-wrapper position-relative">
                        <form action="{{ route('search.index', app()->getLocale()) }}" method="GET" class="product-search-form" id="productSearchForm">
                            <div class="product-search-input-wrapper position-relative">
                                <input
                                    type="text"
                                    class="product-search-input form-control form-control-lg"
                                    id="productSearchInput"
                                    name="q"
                                    placeholder="{{ __('product.Search for products...') }}"
                                    autocomplete="off"
                                    aria-label="{{ __('product.Search products') }}"
                                >
                                <button
                                    type="submit"
                                    class="product-search-submit-btn position-absolute"
                                    aria-label="{{ __('common.Search') }}"
                                >
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19 19L13.8571 13.8571M13.8571 13.8571C15.9167 11.7975 15.9167 8.60254 13.8571 6.54286C11.7975 4.48318 8.60254 4.48318 6.54286 6.54286C4.48318 8.60254 4.48318 11.7975 6.54286 13.8571C8.60254 15.9167 11.7975 15.9167 13.8571 13.8571Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                                <button
                                    type="button"
                                    class="product-search-clear-btn position-absolute d-none"
                                    id="productSearchClear"
                                    aria-label="{{ __('product.Clear search') }}"
                                >
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 4L4 12M4 4L12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Autocomplete Dropdown -->
                            <div class="product-search-autocomplete position-absolute w-100 d-none" id="productSearchAutocomplete">
                                <div class="autocomplete-content bg-white border rounded-3 shadow-lg mt-2 overflow-hidden">
                                    <!-- Loading State -->
                                    <div class="autocomplete-loading p-4 text-center d-none">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">{{ __('common.Loading...') }}</span>
                                        </div>
                                    </div>

                                    <!-- Results Container -->
                                    <div class="autocomplete-results" id="autocompleteResults">
                                        <!-- Product suggestions will appear here -->
                                    </div>

                                    <!-- No Results -->
                                    <div class="autocomplete-no-results p-4 text-center text-secondary d-none">
                                        <p class="mb-0">{{ __('common.No products found') }}</p>
                                    </div>

                                    <!-- View All Results -->
                                    <div class="autocomplete-footer border-top p-3 text-center d-none" id="autocompleteFooter">
                                        <a href="{{ route('search.index', app()->getLocale()) }}" class="btn btn-link text-decoration-none" id="viewAllLink">
                                            {{ __('common.View all results') }}
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="ms-1">
                                                <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="mb-3 mb-xl-5 pb-3 pt-1 pb-xl-5"></div>

    @if(isset($sidebarMenus) && $sidebarMenus && $sidebarMenus->isNotEmpty())
        <section class="categories-section">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 pb-xl-2 mb-xl-4 gap-md-4">
                    <h2 class="section-title fw-normal">{{ __('home.Kateqoriyalar') }}</h2>
                </div>

                <ul class="nav nav-tabs justify-content-start mb-4" id="categories-tab" role="tablist">
                    @foreach($sidebarMenus as $index => $menu)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link nav-link_underscore {{ $index === 0 ? 'active' : '' }}"
                               id="category-tab-{{ $menu->id }}-trigger"
                               data-bs-toggle="tab"
                               href="#category-tab-{{ $menu->id }}"
                               role="tab"
                               aria-controls="category-tab-{{ $menu->id }}"
                               aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                {{ $menu->getTranslation('title', app()->getLocale()) }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content pt-2" id="categories-tab-content">
                    @foreach($sidebarMenus as $index => $menu)
                        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                             id="category-tab-{{ $menu->id }}"
                             role="tabpanel"
                             aria-labelledby="category-tab-{{ $menu->id }}-trigger">
                            @if($menu->children && $menu->children->isNotEmpty())
                                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 g-3">
                                    @foreach($menu->children as $child)
                                        @php
                                            // Get icon from media library
                                            $iconMedia = $child->getFirstMedia('icon');
                                            $iconUrl = $iconMedia ? $iconMedia->getUrl() : null;
                                            $menuUrl = $child->getTranslation('url', app()->getLocale());
                                            $menuTitle = $child->getTranslation('title', app()->getLocale());
                                        @endphp
                                        <div class="col">
                                            <a href="{{ $menuUrl }}"
                                               class="category-mini-card d-flex border rounded-3 p-3 text-decoration-none h-100"
                                               @if($child->target) target="{{ $child->target }}" @endif>
                                                <div class="category-mini-card__icon d-flex align-items-center justify-content-center bg-light me-3">
                                                    @if($iconUrl)
                                                        <img src="{{ $iconUrl }}" alt="{{ $menuTitle }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                        <svg class="fallback-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/>
                                                            <path d="M10 6v4M10 14h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                        </svg>
                                                    @elseif($child->icon_class)
                                                        <i class="{{ $child->icon_class }}" aria-hidden="true"></i>
                                                    @else
                                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/>
                                                            <path d="M10 6v4M10 14h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="category-mini-card__content d-flex flex-column justify-content-center flex-grow-1">
                                                    <span class="category-mini-card__name text-dark fw-medium">{{ $menuTitle }}</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center text-secondary py-5">
                                    <p>{{ __('common.No subcategories available') }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <div class="mb-3 mb-xl-5 pb-3 pt-1 pb-xl-5"></div>

    @if(isset($featuredMenus) && $featuredMenus && $featuredMenus->isNotEmpty())
    <section class="products-grid">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 pb-xl-2 mb-xl-4 gap-md-4">
                <h2 class="section-title fw-normal">{{ __('home.Featured Products') }}</h2>
                <ul class="nav nav-tabs justify-content-center" id="collections-1-tab" role="tablist">
                    @foreach($featuredMenus as $index => $menu)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore {{ $index === 0 ? 'active' : '' }}"
                           id="collections-tab-{{ $menu->id }}-trigger"
                           data-bs-toggle="tab"
                           href="#collections-tab-{{ $menu->id }}"
                           role="tab"
                           aria-controls="collections-tab-{{ $menu->id }}"
                           aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                            {{ $menu->getTranslation('title', app()->getLocale()) }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="tab-content pt-2" id="collections-2-tab-content">
                    @foreach($featuredMenus as $index => $menu)
                        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                             id="collections-tab-{{ $menu->id }}"
                             role="tabpanel"
                             aria-labelledby="collections-tab-{{ $menu->id }}-trigger">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-5">
                                @if($menu->products && $menu->products->isNotEmpty())
                                    @foreach($menu->products as $product)
                                        <x-product-card :product="$product" />
                                    @endforeach
                                @else
                                    <div class="col-12 d-flex flex-column align-items-center justify-content-center text-secondary" style="min-height: 300px;">
                                        <p>{{ __('product.No products available') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <div class="mb-3 mb-xl-4 pb-3 pt-1 pb-xl-5"></div>


    <div class="mb-3 mb-xl-4 pb-3 pt-1 pb-xl-5"></div>
    @if(isset($discountProducts) && $discountProducts->isNotEmpty() && $activeDiscount)
    <section class="discount-carousel container">
        <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 pb-xl-2 mb-xl-4 gap-md-4">
            <h2 class="section-title fw-normal">{{ __('product.Discount') }}</h2>
            <a href="{{ route('discounts.index', app()->getLocale()) }}" class="btn btn-link text-decoration-none">
                {{ __('common.View All') }}
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="ms-1">
                    <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-20per">
                <div class="position-relative w-100 h-sm-100 border-radius-4 overflow-hidden minh-240 mb-4 mb-sm-0">
                    @php
                        $discountBanner = $activeDiscount->getFirstMediaUrl('banner');
                        $discountName = $activeDiscount->getTranslation('name', app()->getLocale());
                        $discountAmount = $activeDiscount->amount;
                        $discountType = $activeDiscount->type; // 'percentage' or 'fixed'
                        $discountText = $discountType === 'percentage' ? $discountAmount . '%' : $discountAmount . ' ' . ($activeDiscount->products()->first()->currency ?? 'AZN');
                    @endphp
                    <div class="background-img"
                         style="background-image: url('{{ $discountBanner ?: asset('storefront/images/home/demo12/deal-bg.jpg') }}');"></div>
                    <div class="position-absolute position-center text-white text-center w-100 px-3">
                        <h2 class="section-title fw-bold text-white">{{ $discountText }}</h2>
                        <h3 class="text-white fw-normal">{{ $discountName }}</h3>
                        <p>{{ __('product.Limited Time Only') }}</p>
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
                            @foreach($discountProducts as $product)
                                <div class="swiper-slide">
                                    <x-product-card :product="$product" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <div class="mb-3 mb-xl-5 pb-3 pt-1 pb-xl-5"></div>

    <section class="category-carousel bg-grey-f7f5ee">
        <div class="container">
            <div class="mb-3 mb-xl-5 pb-3 pt-1 pb-xl-5"></div>

            <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 pb-xl-2 mb-xl-4 gap-md-4">
                <h2 class="section-title fw-normal">{{ __('page.Latest in Blog') }}</h2>
                <a class="btn-link btn-link_md default-underline text-uppercase fw-medium" href="{{ route('blog.index', app()->getLocale()) }}">{{ __('page.See All Blog') }}</a>
            </div>

            @if(isset($latestBlogs) && count($latestBlogs) > 0)
                <div class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                         data-settings='{
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": 3,
                  "slidesPerGroup": 3,
                  "effect": "none",
                  "loop": false,
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
                            @foreach($latestBlogs as $blog)
                                <x-blog-card :blog="$blog" variant="home" />
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-3 mt-xl-5 pb-3 pt-1 pb-xl-5"></div>
        </div>
    </section>

    {{-- SEO Content Section --}}
    <section class="seo-content-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="seo-content bg-light rounded-3 p-4 p-md-5">
                        <h2 class="h4 mb-4">{{ __('home.seo_title') }}</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-secondary mb-3">{{ __('home.seo_paragraph_1') }}</p>
                                <p class="text-secondary mb-3">{{ __('home.seo_paragraph_2') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-secondary mb-3">{{ __('home.seo_paragraph_3') }}</p>
                                <h3 class="h6 mb-2">{{ __('home.seo_features_title') }}</h3>
                                <ul class="text-secondary mb-0">
                                    <li>{{ __('home.seo_feature_1') }}</li>
                                    <li>{{ __('home.seo_feature_2') }}</li>
                                    <li>{{ __('home.seo_feature_3') }}</li>
                                    <li>{{ __('home.seo_feature_4') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('storefront/css/pages/home.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('storefront/js/pages/home.js') }}" defer></script>
@endpush
