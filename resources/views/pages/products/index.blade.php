@extends('layouts.default')

@section('title', __('Products'))

@php
    $locale = app()->getLocale();
    
    // Prepare categories tree for JavaScript
    $categoriesTree = [];
    foreach ($categories as $category) {
        $categoryName = $category->getTranslation('name', $locale);
        $categoryData = [
            'id' => $category->id,
            'name' => $categoryName,
            'slug' => $category->slug,
            'children' => []
        ];
        
        if ($category->children && $category->children->isNotEmpty()) {
            foreach ($category->children as $child) {
                $childName = $child->getTranslation('name', $locale);
                $childData = [
                    'id' => $child->id,
                    'name' => $childName,
                    'slug' => $child->slug,
                    'children' => []
                ];
                
                if ($child->children && $child->children->isNotEmpty()) {
                    foreach ($child->children as $grandchild) {
                        $grandchildName = $grandchild->getTranslation('name', $locale);
                        $childData['children'][] = [
                            'id' => $grandchild->id,
                            'name' => $grandchildName,
                            'slug' => $grandchild->slug,
                        ];
                    }
                }
                
                $categoryData['children'][] = $childData;
            }
        }
        
        $categoriesTree[] = $categoryData;
    }
    
    // Prepare brands array for JavaScript
    $brandsArray = [];
    foreach ($brands as $brand) {
        $brandsArray[] = [
            'id' => $brand->id,
            'name' => $brand->getTranslation('name', $locale),
            'slug' => $brand->slug,
        ];
    }
@endphp

@section('content')
    <section class="shop-main container d-flex pt-4 pt-xl-5">
        <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
            <div class="aside-header d-flex d-lg-none align-items-center">
                <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
                <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
            </div>

            <div class="pt-4 pt-lg-0"></div>

            <!-- Categories Filter -->
            <div class="accordion" id="categories-list">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-category">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-category" aria-expanded="true" aria-controls="accordion-filter-category">
                            Product Categories
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                    <path d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z"/>
                                </g>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-category" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-category" data-bs-parent="#categories-list">
                        <div class="search-field multi-select accordion-body px-0 pb-0">
                            <select class="d-none" multiple name="category_ids" id="categoryFilterSelect">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" data-parent="0">{{ $category->getTranslation('name', $locale) }}</option>
                                    @if($category->children && $category->children->isNotEmpty())
                                        @foreach($category->children as $child)
                                            <option value="{{ $child->id }}" data-parent="{{ $category->id }}">{{ $child->getTranslation('name', $locale) }}</option>
                                            @if($child->children && $child->children->isNotEmpty())
                                                @foreach($child->children as $grandchild)
                                                    <option value="{{ $grandchild->id }}" data-parent="{{ $child->id }}">{{ $grandchild->getTranslation('name', $locale) }}</option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                            <div class="search-field__input-wrapper mb-3">
                                <input type="text" name="category_search" id="categorySearchInput" class="search-field__input form-control form-control-sm border-light border-2" placeholder="SEARCH">
                            </div>
                            <ul class="multi-select__list list-unstyled category-filter-list" id="categoryFilterList">
                                @foreach($categories as $category)
                                    @php
                                        $categoryName = $category->getTranslation('name', $locale);
                                        $productCount = $category->products()->where('is_active', true)->count();
                                    @endphp
                                    <li class="category-filter-item" data-category-id="{{ $category->id }}" data-parent-id="0">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="category-checkbox me-2" id="cat-{{ $category->id }}" data-category-id="{{ $category->id }}">
                                            <label for="cat-{{ $category->id }}" class="d-flex align-items-center w-100 mb-0">
                                                <span class="me-auto category-name">{{ $categoryName }}</span>
                                                <span class="text-secondary category-count">{{ $productCount }}</span>
                                            </label>
                                        </div>
                                    </li>
                                    @if($category->children && $category->children->isNotEmpty())
                                        @foreach($category->children as $child)
                                            @php
                                                $childName = $child->getTranslation('name', $locale);
                                                $childProductCount = $child->products()->where('is_active', true)->count();
                                            @endphp
                                            <li class="category-filter-item ms-3" data-category-id="{{ $child->id }}" data-parent-id="{{ $category->id }}">
                                                <div class="d-flex align-items-center">
                                                    <input type="checkbox" class="category-checkbox me-2" id="cat-{{ $child->id }}" data-category-id="{{ $child->id }}">
                                                    <label for="cat-{{ $child->id }}" class="d-flex align-items-center w-100 mb-0">
                                                        <span class="me-auto category-name">{{ $childName }}</span>
                                                        <span class="text-secondary category-count">{{ $childProductCount }}</span>
                                                    </label>
                                                </div>
                                            </li>
                                            @if($child->children && $child->children->isNotEmpty())
                                                @foreach($child->children as $grandchild)
                                                    @php
                                                        $grandchildName = $grandchild->getTranslation('name', $locale);
                                                        $grandchildProductCount = $grandchild->products()->where('is_active', true)->count();
                                                    @endphp
                                                    <li class="category-filter-item ms-5" data-category-id="{{ $grandchild->id }}" data-parent-id="{{ $child->id }}">
                                                        <div class="d-flex align-items-center">
                                                            <input type="checkbox" class="category-checkbox me-2" id="cat-{{ $grandchild->id }}" data-category-id="{{ $grandchild->id }}">
                                                            <label for="cat-{{ $grandchild->id }}" class="d-flex align-items-center w-100 mb-0">
                                                                <span class="me-auto category-name">{{ $grandchildName }}</span>
                                                                <span class="text-secondary category-count">{{ $grandchildProductCount }}</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Brands Filter -->
            <div class="accordion" id="brand-filters">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-brand">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-brand" aria-expanded="true" aria-controls="accordion-filter-brand">
                            Brands
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                    <path d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z"/>
                                </g>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
                        <div class="search-field multi-select accordion-body px-0 pb-0">
                            <select class="d-none" multiple name="brand_ids" id="brandFilterSelect">
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->getTranslation('name', $locale) }}</option>
                                @endforeach
                            </select>
                            <div class="search-field__input-wrapper mb-3">
                                <input type="text" name="brand_search" id="brandSearchInput" class="search-field__input form-control form-control-sm border-light border-2" placeholder="SEARCH">
                            </div>
                            <ul class="multi-select__list list-unstyled brand-filter-list" id="brandFilterList">
                                @foreach($brands as $brand)
                                    @php
                                        $brandName = $brand->getTranslation('name', $locale);
                                        $brandProductCount = $brand->products()->where('is_active', true)->count();
                                    @endphp
                                    <li class="brand-filter-item" data-brand-id="{{ $brand->id }}">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="brand-checkbox me-2" id="brand-{{ $brand->id }}" data-brand-id="{{ $brand->id }}">
                                            <label for="brand-{{ $brand->id }}" class="d-flex align-items-center w-100 mb-0">
                                                <span class="me-auto brand-name">{{ $brandName }}</span>
                                                <span class="text-secondary brand-count">{{ $brandProductCount }}</span>
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Price Filter -->
            <div class="accordion" id="price-filters">
                <div class="accordion-item mb-4">
                    <h5 class="accordion-header mb-2" id="accordion-heading-price">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-price" aria-expanded="true" aria-controls="accordion-filter-price">
                            Price
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                    <path d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z"/>
                                </g>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-price" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
                        <div class="price-filter-wrapper accordion-body px-0 pb-0">
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-label text-secondary small">Min Price</label>
                                    <input type="number" class="form-control form-control-sm" id="priceMinInput" 
                                           min="{{ $priceMin }}" max="{{ $priceMax }}" step="5"
                                           value="{{ $filters['price_min'] ?? $priceMin }}" placeholder="{{ $priceMin }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-secondary small">Max Price</label>
                                    <input type="number" class="form-control form-control-sm" id="priceMaxInput" 
                                           min="{{ $priceMin }}" max="{{ $priceMax }}" step="5"
                                           value="{{ $filters['price_max'] ?? $priceMax }}" placeholder="{{ $priceMax }}">
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary w-100 mt-3" id="applyPriceFilter">
                                Apply
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="shop-list flex-grow-1">
            <div class="mb-3 pb-2 pb-xl-3"></div>

            <div class="d-flex justify-content-between mb-4 pb-md-2">
                <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                    <a href="{{ route('home', $locale) }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                    <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                    <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Products</a>
                </div>

                <div class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                    <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0" aria-label="Sort Items" name="sort" id="sortSelect">
                        <option value="default" {{ ($filters['sort'] ?? 'default') === 'default' ? 'selected' : '' }}>Default Sorting</option>
                        <option value="price_asc" {{ ($filters['sort'] ?? '') === 'price_asc' ? 'selected' : '' }}>Price, low to high</option>
                        <option value="price_desc" {{ ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : '' }}>Price, high to low</option>
                        <option value="name_asc" {{ ($filters['sort'] ?? '') === 'name_asc' ? 'selected' : '' }}>Alphabetically, A-Z</option>
                        <option value="name_desc" {{ ($filters['sort'] ?? '') === 'name_desc' ? 'selected' : '' }}>Alphabetically, Z-A</option>
                        <option value="created_desc" {{ ($filters['sort'] ?? '') === 'created_desc' ? 'selected' : '' }}>Date, new to old</option>
                        <option value="created_asc" {{ ($filters['sort'] ?? '') === 'created_asc' ? 'selected' : '' }}>Date, old to new</option>
                    </select>
                    <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
                        <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside" data-aside="shopFilter">
                            <svg class="d-inline-block align-middle me-2" width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_filter" /></svg>
                            <span class="text-uppercase fw-medium d-inline-block align-middle">Filter</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                @if($products->count() > 0)
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="empty-products-state text-center py-5">
                            <div class="empty-icon mb-4">
                                <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="60" cy="60" r="60" fill="#F8F9FA"/>
                                    <path d="M45 50L55 60L45 70" stroke="#ADB5BD" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M65 50L75 60L65 70" stroke="#ADB5BD" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                    <rect x="30" y="35" width="60" height="50" rx="4" stroke="#DEE2E6" stroke-width="2" fill="none"/>
                                </svg>
                            </div>
                            <h3 class="fs-4 fw-semibold mb-3">{{ __('No Products Found') }}</h3>
                            <p class="text-secondary mb-4">{{ __('We couldn\'t find any products matching your filters.') }}<br>{{ __('Try adjusting your search criteria.') }}</p>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="clearAllFilters">
                                <svg class="me-2" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                </svg>
                                {{ __('Clear All Filters') }}
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            @if($products->hasMorePages())
                <div class="load-more-section mt-4 mt-md-5 pt-3" id="load-more-section">
                    <div id="infinite-scroll-trigger" style="height: 1px;"></div>
                    <div class="text-center">
                        <div id="btn-loading-spinner" class="spinner-border text-primary d-none" role="status" style="width: 2.5rem; height: 2.5rem;">
                            <span class="visually-hidden">{{ __('Loading...') }}</span>
                        </div>
                    </div>
                </div>
            @elseif($products->count() > 0)
                <div class="load-more-section mt-4 mt-md-5 pt-3" id="load-more-section" style="display: none;">
                    <div id="infinite-scroll-trigger" style="height: 1px;"></div>
                </div>
            @endif
        </div>
    </section>
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

/* Category Filter */
.category-filter-list {
    max-height: 400px;
    overflow-y: auto;
}

.category-filter-item {
    padding: 0.5rem 0;
    transition: background-color 0.2s;
}

.category-filter-item label {
    cursor: pointer;
}

.category-filter-item:hover {
    background-color: #f8f9fa;
}

.category-checkbox {
    cursor: pointer;
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

/* Brand Filter */
.brand-filter-list {
    max-height: 300px;
    overflow-y: auto;
}

.brand-filter-item {
    padding: 0.5rem 0;
    transition: background-color 0.2s;
}

.brand-filter-item label {
    cursor: pointer;
}

.brand-filter-item:hover {
    background-color: #f8f9fa;
}

.brand-checkbox {
    cursor: pointer;
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

/* Price Filter */
.price-filter-wrapper input[type="number"] {
    border: 1px solid #dee2e6;
}

.price-filter-wrapper input[type="number"]:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.price-filter-wrapper .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.price-filter-wrapper .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
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

.products-grid:has(.empty-products-state) {
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
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

.empty-products-state button {
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

/* Scrollbar Styling */
.category-filter-list::-webkit-scrollbar,
.brand-filter-list::-webkit-scrollbar {
    width: 6px;
}

.category-filter-list::-webkit-scrollbar-track,
.brand-filter-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.category-filter-list::-webkit-scrollbar-thumb,
.brand-filter-list::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.category-filter-list::-webkit-scrollbar-thumb:hover,
.brand-filter-list::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
@endpush

@push('scripts')
<script>
    // Pass data to JavaScript - MUST be before the script file
    window.productsPageData = {
        locale: '{{ $locale }}',
        categoriesTree: @json($categoriesTree),
        brands: @json($brandsArray),
        currentFilters: @json($filters),
        priceMin: {{ $priceMin }},
        priceMax: {{ $priceMax }},
        currentPage: {{ $products->currentPage() }},
        hasMorePages: {{ $products->hasMorePages() ? 'true' : 'false' }}
    };
</script>
<script src="{{ asset('storefront/js/pages/products-index.js') }}"></script>
@endpush
