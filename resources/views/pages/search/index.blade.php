@extends('layouts.default')

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
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-5">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <p class="text-secondary mb-4">{{ __('common.No products found') }}</p>
                    <a href="{{ route('home', app()->getLocale()) }}" class="btn btn-primary">
                        {{ __('common.Back to Home') }}
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

