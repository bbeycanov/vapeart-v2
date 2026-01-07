@extends('layouts.default')

@section('title', $query ? __('page.Search Results for') . ': ' . $query : __('page.Search'))

@section('head')
    {!! $schemaJsonLd ?? '' !!}
@endsection

@php
    $locale = app()->getLocale();
@endphp

@section('content')
    <section class="products-search-page py-4 py-md-5">
        <div class="container">
            <div class="mb-4">
                <h1 class="page-title mb-3">
                    @if($query)
                        {{ __('product.Search Results') }}: "{{ $query }}"
                    @else
                        {{ __('product.All Products') }}
                    @endif
                </h1>

                @if($query)
                    <p class="text-secondary">
                        {{ trans('common.found_products', ['count' => $products->total()]) }}
                    </p>
                @endif
            </div>

            @if($products->count() > 0)
                <div class="products-grid row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-5" id="products-grid">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                @if($products->hasMorePages())
                    <div class="load-more-section mt-4 mt-md-5 pt-3" id="load-more-section">
                        <div id="infinite-scroll-trigger" style="height: 1px;"></div>
                        <div class="text-center">
                            <div id="btn-loading-spinner" class="spinner-border text-primary d-none" role="status" style="width: 2.5rem; height: 2.5rem;">
                                <span class="visually-hidden">{{ __('common.Loading...') }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <p class="text-secondary mb-4">{{ __('common.No products found') }}</p>
                    <a href="{{ route('home', $locale) }}" class="btn btn-primary">
                        {{ __('common.Back to Home') }}
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
    window.searchPageData = {
        locale: '{{ $locale }}',
        query: '{{ $query }}',
        currentPage: {{ $products->currentPage() }},
        hasMorePages: {{ $products->hasMorePages() ? 'true' : 'false' }},
        loadMoreUrl: '{{ route('search.load-more', $locale) }}'
    };
</script>
<script src="{{ asset('storefront/js/pages/search-index.js') }}"></script>
@endpush

