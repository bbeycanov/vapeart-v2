@extends('layouts.default')

@section('head')
    {!! $schemaJsonLd !!}
@endsection

@section('title', $blog->getTranslation('meta_title', app()->getLocale()) ?? $blog->getTranslation('title', app()->getLocale()))

@section('content')
    <section class="container py-8">
        <article class="prose max-w-none">
            <h1>{{ $blog->getTranslation('title', app()->getLocale()) }}</h1>

            <p class="text-sm text-gray-500">
                @if($blog->author_name) {{ $blog->author_name }} · @endif
                {{ optional($blog->published_at)->format('Y-m-d') }}
                @if($blog->reading_time) · {{ $blog->reading_time }} {{ __('min read') }} @endif
            </p>

            @if($img = $blog->getFirstMediaUrl('featured'))
                <img src="{{ $img }}" alt="{{ $blog->getTranslation('title', app()->getLocale()) }}" class="my-6">
            @endif

            {!! $blog->getTranslation('body', app()->getLocale()) !!}
        </article>
    </section>
@endsection
