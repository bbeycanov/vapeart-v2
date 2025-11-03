@extends('layouts.default')

@section('head')
    {!! $schemaJsonLd !!}
@endsection

@section('title', $category->getTranslation('meta_title', app()->getLocale()) ?? $category->getTranslation('name', app()->getLocale()))

@section('content')
    <section class="container py-8">
        <article class="prose max-w-none">
            <h1>{{ $category->getTranslation('name', app()->getLocale()) }}</h1>

            @if($img = $category->getFirstMediaUrl('featured'))
                <img src="{{ $img }}" alt="{{ $category->getTranslation('name', app()->getLocale()) }}" class="my-6">
            @endif

            {!! $category->getTranslation('description', app()->getLocale()) !!}
        </article>
    </section>
@endsection
