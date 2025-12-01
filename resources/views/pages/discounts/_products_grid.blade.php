@php
    $locale = app()->getLocale();
@endphp

<div id="products-grid" class="products-grid row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
    @foreach($list as $product)
        <div class="product-grid-item col">
            <x-product-card :product="$product" />
        </div>
    @endforeach
</div>

@if($list->hasMorePages())
    <div class="load-more-section mt-4 mt-md-5 pt-3" id="load-more-section">
        <div id="infinite-scroll-trigger" style="height: 1px;"></div>
        <div class="text-center">
            <div id="btn-loading-spinner" class="spinner-border text-primary d-none" role="status" style="width: 2.5rem; height: 2.5rem;">
                <span class="visually-hidden">{{ __('Loading...') }}</span>
            </div>
            <button id="load-more-btn" 
                    class="btn btn-outline-primary d-none" 
                    data-page="{{ $list->currentPage() + 1 }}"
                    style="display: none;">
                {{ __('Load More') }}
            </button>
        </div>
    </div>
@else
    <div class="load-more-section mt-4 mt-md-5 pt-3" id="load-more-section" style="display: none;"></div>
@endif

