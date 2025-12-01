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
            <h3 class="fs-4 fw-semibold mb-3">{{ __('product.No Products Found') }}</h3>
            <p class="text-secondary mb-4">{{ __('common.We couldn\'t find any products matching your filters.') }}<br>{{ __('common.Try adjusting your search criteria.') }}</p>
            <button type="button" class="btn btn-outline-primary btn-sm" id="clearAllFilters">
                <svg class="me-2" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                </svg>
                {{ __('product.Clear All Filters') }}
            </button>
        </div>
    </div>
@endif

