@extends('layouts.default')

@section('head')
    {!! $schemaJsonLdScripts !!}
@endsection

@section('title', $page->getTranslation('meta_title', app()->getLocale()) ?? $page->getTranslation('title', app()->getLocale()))

@section('content')
    <article class="container py-6">
        <h1>{{ $page->getTranslation('title', app()->getLocale()) }}</h1>

        @if($img = $page->getFirstMediaUrl('featured'))
            <img src="{{ $img }}" alt="{{ $page->getTranslation('title', app()->getLocale()) }}" class="my-4">
        @endif

        {!! $page->getTranslation('body', app()->getLocale()) !!}
    </article>
@endsection
