@extends('layouts.default')

@section('head')
    {!! $schemaJsonLd !!}
@endsection

@section('content')
    <h1>{{ $product->getTranslation('name', app()->getLocale()) }}</h1>

    @if($img = $product->getFirstMediaUrl('featured'))
        <img src="{{ $img }}" alt="{{ $product->getTranslation('name', app()->getLocale()) }}">
    @endif

    <p>{!! $product->getTranslation('short_description', app()->getLocale()) !!}</p>
    <p>
        {{ number_format($product->sale_price ?? $product->price, 2) }}
        {{ $product->currency }}
    </p>

    {{-- Review form --}}
    <form method="POST" action="{{ route('products.reviews.store', [app()->getLocale(), $product]) }}">
        @csrf
        <input type="number" name="rating" min="1" max="5" required>
        <input type="text" name="title" placeholder="{{ __('Title') }}">
        <textarea name="body" placeholder="{{ __('Your Review') }}"></textarea>
        <button type="submit">{{ __('Submit') }}</button>
    </form>

    {{-- Related products --}}
    <h3>{{ __('Related Products') }}</h3>
    <div class="grid">
        @foreach($related as $item)
            <a href="{{ route('products.show',[app()->getLocale(), $item]) }}">
                {{ $item->getTranslation('name', app()->getLocale()) }}
            </a>
        @endforeach
    </div>
@endsection
