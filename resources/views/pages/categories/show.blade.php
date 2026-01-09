@extends('layouts.default')

@section('title', $category->getTranslation('meta_title', app()->getLocale()) ?? $category->getTranslation('name', app()->getLocale()))

@section('og_image'){{ $category->getFirstMediaUrl('banner') ?: $category->getFirstMediaUrl('icon') ?: $category->getFirstMediaUrl('gallery') ?: asset('storefront/images/placeholder-og.jpg') }}@endsection

@section('head')
    {!! $schemaJsonLd !!}
@endsection

@php
    $locale = app()->getLocale();
    $categoryName = $category->getTranslation('name', $locale);
    $categoryDescription = $category->getTranslation('description', $locale);
    $categoryBannerImages = $category->getBannerImageUrls();
    $selectedBrandId = request()->get('brand_id');
    $selectedBrand = $selectedBrandId ? $brands->firstWhere('id', $selectedBrandId) : null;

    // Prepare brands array for JavaScript
    $brandsArray = [];
    if ($brands) {
        foreach ($brands as $brand) {
            $brandsArray[$brand->id] = [
                'id' => $brand->id,
                'name' => $brand->getTranslation('name', $locale),
                'slug' => $brand->slug,
                'logo' => $brand->getFirstMediaUrl('logo')
            ];
        }
    }
@endphp

@section('content')
    <div class="mb-md-1 pb-md-3"></div>

    <div class="container">

        <!-- Category Banner & Hero Section -->
        <section class="mb-4 mb-md-5">
            <div class="shop-banner position-relative rounded-3 overflow-hidden" style="min-height: 320px; display: flex; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div class="background-img background-img_overlay" style="background-color: #f5f5f5;">
                    @if($categoryBannerImages['banner_desktop'])
                        <picture>
                            {{-- Mobile fallback --}}
                            @if($categoryBannerImages['banner_mobile'])
                                <source media="(max-width: 768px)" srcset="{{ $categoryBannerImages['banner_mobile'] }}">
                            @endif
                            {{-- Tablet fallback --}}
                            @if($categoryBannerImages['banner_tablet'])
                                <source media="(max-width: 1024px)" srcset="{{ $categoryBannerImages['banner_tablet'] }}">
                            @endif
                            {{-- Desktop fallback --}}
                            <img loading="lazy" src="{{ $categoryBannerImages['banner_desktop'] }}" width="1920" height="400" alt="{{ $categoryName }}" class="slideshow-bg__img object-fit-cover" style="opacity: 0.9;">
                        </picture>
                        <!-- Dark overlay for better text readability on image -->
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.35);"></div>
                    @endif
                </div>

                <div class="shop-banner__content position-relative z-2 text-center py-4 py-md-5 px-3 px-md-4 w-100">
                    <h1 class="h1 text-uppercase fw-bold mb-3 mb-md-4 {{ $categoryBannerImages['banner_desktop'] ? 'text-white' : 'text-dark' }}" style="font-size: clamp(1.75rem, 4vw, 2.5rem);">
                        {{ $categoryName }}
                    </h1>

                    @if($categoryDescription)
                        <div class="category-description mx-auto {{ $categoryBannerImages['banner_desktop'] ? 'text-white' : 'text-secondary' }}" style="max-width: 800px; font-size: 1.05rem; line-height: 1.6;">
                            {!! $categoryDescription !!}
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Breadcrumb -->
        <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4 pb-2 pb-md-3">
            <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                <a href="{{ route('home', $locale) }}" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('navigation.Home') }}</a>
                <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                <a href="{{ route('categories.index', $locale) }}" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('navigation.Categories') }}</a>
                @if($category->parent && $category->parent->slug)
                    <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                    <a href="{{ route('categories.show', [$locale, 'category' => $category->parent->slug]) }}" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ $category->parent->getTranslation('name', $locale) }}</a>
                @endif
                <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                <span class="menu-link menu-link_us-s text-uppercase fw-medium">{{ $categoryName }}</span>
            </div>
        </div>

        <!-- Child Categories -->
        @if($childCategoriesWithCounts && $childCategoriesWithCounts->count() > 0)
            <section class="mb-4 mb-md-5">
                <h2 class="h5 fw-bold mb-3 mb-md-4">{{ __('common.Subcategories') }}</h2>
                <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
                    @foreach($childCategoriesWithCounts as $item)
                        @php
                            $childCategory = $item['category'];
                            $childProductCount = $item['product_count'];
                            $childCategoryName = $childCategory->getTranslation('name', $locale);
                            $childCategoryImage = $childCategory->getFirstMediaUrl('icon');
                        @endphp
                        <div class="col">
                            <a href="{{ route('categories.show', [$locale, 'category' => $childCategory->slug]) }}"
                               class="category-card category-card--small d-block h-100 text-decoration-none">
                                <div class="category-card__image-wrapper category-card__image-wrapper--small">
                                    @if($childCategoryImage)
                                        <img src="{{ $childCategoryImage }}"
                                             alt="{{ $childCategoryName }}"
                                             class="category-card__image"
                                             loading="lazy">
                                    @else
                                        <div class="category-card__placeholder">
                                            <svg width="32" height="32" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/>
                                                <path d="M10 6v4M10 14h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="category-card__content category-card__content--small">
                                    <h3 class="category-card__title category-card__title--small">{{ $childCategoryName }}</h3>
                                    <p class="category-card__count category-card__count--small">{{ $childProductCount }} {{ __('common.products') }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <div class="category-page-wrapper">
            <!-- Sticky Brand Navigation -->
            @if($brands && $brands->count() > 0)
                <div class="sticky-brand-nav bg-white border rounded-3 mb-4 mb-md-5" style="position: sticky; top: 60px; z-index: 99; transition: top 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <div class="brand-scroll-container py-3 py-md-3.5 d-flex align-items-center px-3 px-md-4 position-relative">
                        <div class="brand-scroll-wrapper d-flex gap-2 gap-md-3 overflow-auto no-scrollbar w-100" style="scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
                            <!-- All Brands Button -->
                            <button type="button"
                                    class="brand-pill btn btn-sm {{ !$selectedBrandId ? 'btn-dark' : 'btn-outline-light text-dark border-secondary-subtle' }} rounded-pill px-3 px-md-4 py-2 py-md-2.5 flex-shrink-0 fw-medium d-flex align-items-center gap-2 transition-all"
                                    data-brand-id="">
                                <span>{{ __('product.All Brands') }}</span>
                            </button>

                            <!-- Brand List -->
                            @foreach($brands as $brand)
                                @php
                                    $isActive = $selectedBrandId == $brand->id;
                                    $brandLogo = $brand->getFirstMediaUrl('logo');
                                @endphp
                                <button type="button"
                                        class="brand-pill btn btn-sm {{ $isActive ? 'btn-dark' : 'btn-outline-light text-dark border-secondary-subtle' }} rounded-pill px-3 px-md-4 py-2 py-md-2.5 flex-shrink-0 fw-medium d-flex align-items-center gap-2 transition-all"
                                        data-brand-id="{{ $brand->id }}">
                                    @if($brandLogo)
                                        <img src="{{ $brandLogo }}" alt="{{ $brand->getTranslation('name', $locale) }}" class="rounded-circle bg-white p-0.5" style="width: 22px; height: 22px; object-fit: contain;">
                                    @endif
                                    <span>{{ $brand->getTranslation('name', $locale) }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Content -->
            <section class="pb-4 pb-md-5">
                <!-- Products Header / Active Filter Info -->
                <div class="d-flex justify-content-between align-items-center mb-4 mb-md-5 flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <h2 class="h5 mb-0 fw-bold">{{ __('common.Products') }}</h2>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2" id="products-count" style="font-size: 0.875rem; font-weight: 600;">
                            {{ $list->total() }}
                        </span>
                    </div>

                    <div id="brand-action-area" class="{{ $selectedBrand ? '' : 'd-none' }}">
                        @if($selectedBrand)
                            <a href="{{ route('brands.show', [$locale, $selectedBrand->slug]) }}" class="btn btn-sm btn-link text-decoration-none d-flex align-items-center text-dark fw-medium px-0">
                                {{ __('page.Visit') }} {{ $selectedBrand->getTranslation('name', $locale) }} {{ __('page.Page') }}
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="ms-1">
                                    <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Products Grid -->
                <div id="products-container" style="min-height: 400px;">
                    @if($list && $list->count() > 0)
                        <div class="products-grid row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-5 g-3 g-md-4 mb-4" id="products-grid">
                            @foreach($list->items() as $product)
                                <div class="col">
                                    <x-product-card :product="$product" />
                                </div>
                            @endforeach
                        </div>

                        <!-- Infinite Scroll Trigger / Loading State -->
                        @if($list->hasMorePages() || $list->currentPage() > 1)
                            <div class="load-more-section text-center mt-4 mt-md-5 pt-3">
                                <!-- Progress Bar -->
                                <div class="progress mb-4 mx-auto" style="height: 4px; width: 200px; max-width: 100%; background-color: #f0f0f0; border-radius: 2px;">
                                    <div class="progress-bar bg-dark"
                                         role="progressbar"
                                         style="width: {{ $list->total() > 0 ? ($list->lastItem() / $list->total() * 100) : 0 }}%; border-radius: 2px; transition: width 0.3s ease;"
                                         aria-valuenow="{{ $list->lastItem() ?? 0 }}"
                                         aria-valuemin="0"
                                         aria-valuemax="{{ $list->total() }}">
                                    </div>
                                </div>

                                <!-- Status Text -->
                                <p class="text-muted small mb-3 d-none">
                                    {{ __('Showing') }} <span class="fw-bold text-dark">{{ $list->firstItem() ?? 0 }} - {{ $list->lastItem() ?? 0 }}</span> {{ __('of') }} {{ $list->total() }} {{ __('products') }}
                                </p>

                                <!-- Infinite Scroll Trigger Element -->
                                <div id="infinite-scroll-trigger" class="py-3 py-md-4">
                                    @if($list->hasMorePages())
                                        <div class="spinner-border text-dark" role="status" id="btn-loading-spinner" style="width: 2.5rem; height: 2.5rem;">
                                            <span class="visually-hidden">{{ __('common.Loading...') }}</span>
                                        </div>
                                        <!-- Hidden button for fallback/JS data storage -->
                                        <button type="button" class="d-none" id="load-more-btn"
                                                data-page="{{ $list->currentPage() + 1 }}"
                                                data-category-slug="{{ $category->slug }}"
                                                data-locale="{{ $locale }}">
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="empty-state text-center py-5 py-md-6">
                            <div class="mb-4">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-muted opacity-50">
                                    <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h3 class="h5 fw-bold text-dark mb-2">{{ __('common.No products found') }}</h3>
                            <p class="text-muted mb-4">{{ __('common.Try selecting a different brand or browse all categories.') }}</p>
                            <a href="{{ route('products.index', $locale) }}" class="btn btn-dark rounded-pill px-4">
                                {{ __('common.Browse All Products') }}
                            </a>
                        </div>
                    @endif
                </div>
    </section>
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('storefront/css/pages/categories-show.css') }}">
@endpush

@push('scripts')
<script>
// Pass data to JavaScript
window.categoryShowPageData = {
    locale: '{{ $locale }}',
    categorySlug: '{{ $category->slug }}',
    brands: @json($brandsArray),
    currentBrandId: {{ $selectedBrandId ?: 'null' }},
    visitText: '{{ __('page.Visit') }}',
    pageText: '{{ __('page.Page') }}'
};
</script>
<script src="{{ asset('storefront/js/pages/categories-show.js') }}" defer></script>
@endpush
