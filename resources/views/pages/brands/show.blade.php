@extends('layouts.default')

@section('head')
    {!! $schemaJsonLd !!}
@endsection

@section('title', $brand->getTranslation('meta_title', app()->getLocale()) ?? $brand->getTranslation('name', app()->getLocale()))

@section('content')
    <section class="container py-8">
        <article class="prose max-w-none">
            <h1>{{ $brand->getTranslation('name', app()->getLocale()) }}</h1>

            @if($img = $brand->getFirstMediaUrl('featured'))
                <img src="{{ $img }}" alt="{{ $brand->getTranslation('name', app()->getLocale()) }}" class="my-6">
            @endif

            {!! $brand->getTranslation('description', app()->getLocale()) !!}
        </article>
    </section>
@endsection
