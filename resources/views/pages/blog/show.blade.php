@extends('layouts.default')

@section('title', $blog->getTranslation('meta_title', app()->getLocale()) ?? $blog->getTranslation('title', app()->getLocale()))

@section('og_image'){{ $blog->getFirstMediaUrl('featured') ?: $blog->getFirstMediaUrl('gallery') ?: asset('storefront/images/placeholder-og.jpg') }}@endsection

@section('og_type', 'article')

@section('head')
    {!! $schemaJsonLd !!}
@endsection

@section('content')
    @php
        $blogTitle = $blog->getTranslation('title', app()->getLocale());
        $blogBody = $blog->getTranslation('body', app()->getLocale());
        $blogDate = $blog->published_at ? $blog->published_at->format('F d, Y') : $blog->created_at->format('F d, Y');
        $authorName = $blog->author_name ?: 'Admin';
        $blogImage = $blog->getFirstMediaUrl('featured');
        $galleryImages = $blog->getMedia('gallery');
        $blogUrl = route('blog.show', [app()->getLocale(), $blog->slug]);
    @endphp

    <x-breadcrumb :items="[
        ['label' => __('navigation.Home'), 'url' => route('home', app()->getLocale())],
        ['label' => __('page.The Blog'), 'url' => route('blog.index', app()->getLocale())],
        ['label' => $blogTitle]
    ]" />

    <section class="blog-page blog-single container py-4 py-md-2">
        <div class="row">
            <div class="col-12">
                <h2 class="page-title">{{ $blogTitle }}</h2>
                <div class="blog-single__item-meta">
                    <span class="blog-single__item-meta__author">By {{ $authorName }}</span>
                    <span class="blog-single__item-meta__date">{{ $blogDate }}</span>
                    @if($blog->reading_time)
                        <span class="blog-single__item-meta__reading-time">{{ $blog->reading_time }} {{ __('min read') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="blog-single__item-content">
            @if($blogImage)
                <div class="row">
                    <div class="col-12">
                        <p>
                            <img loading="lazy" class="w-100 h-auto d-block" src="{{ $blogImage }}" width="1410" height="550" alt="{{ $blogTitle }}">
                        </p>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    {!! $blogBody !!}
                </div>
            </div>
            @if($galleryImages->isNotEmpty())
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            @foreach($galleryImages->chunk(2) as $chunk)
                                @foreach($chunk as $index => $image)
                                    <div class="col-md-6">
                                        <p><img loading="lazy" class="w-100 h-auto d-block" src="{{ $image->getUrl() }}" alt="{{ $blogTitle }} - Gallery {{ $index + 1 }}"></p>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @if(isset($previousBlog) || isset($nextBlog))
            <div class="row">
                <div class="col-12">
                    <div class="blog-single__item-pagination">
                        <div class="row">
                            @if(isset($previousBlog))
                                @php
                                    $prevTitle = $previousBlog->getTranslation('title', app()->getLocale());
                                    $prevUrl = route('blog.show', [app()->getLocale(), $previousBlog->slug]);
                                @endphp
                                <div class="col-lg-6">
                                    <a href="{{ $prevUrl }}" class="btn-link d-inline-flex align-items-center">
                                        <svg class="me-1" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_sm" /></svg>
                                        <span class="fw-medium">{{ __('page.PREVIOUS POST') }}</span>
                                    </a>
                                    <p>{{ $prevTitle }}</p>
                                </div>
                            @endif
                            @if(isset($nextBlog))
                                @php
                                    $nextTitle = $nextBlog->getTranslation('title', app()->getLocale());
                                    $nextUrl = route('blog.show', [app()->getLocale(), $nextBlog->slug]);
                                @endphp
                                <div class="col-lg-6 {{ isset($previousBlog) ? 'text-lg-end' : '' }}">
                                    <a href="{{ $nextUrl }}" class="btn-link d-inline-flex align-items-center">
                                        <span class="fw-medium me-1">{{ __('page.NEXT POST') }}</span>
                                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_md" /></svg>
                                    </a>
                                    <p>{{ $nextTitle }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="blog-single__reviews py-4">
            <h2 class="blog-single__reviews-title">{{ __('product.Reviews') }}</h2>
            <div class="blog-single__reviews-list" id="reviews-list">
                @if($reviews->count() > 0)
                    @foreach($reviews as $review)
                        @include('pages.blog.partials.review-item', ['review' => $review])
                    @endforeach
                @else
                    <p class="text-muted">{{ __('common.No reviews yet. Be the first to review!') }}</p>
                @endif
            </div>
            <div class="blog-single__review-form mt-4">
                <form id="blog-review-form" name="customer-review-form" class="needs-validation" novalidate>
                    <h5>{{ __('product.Be the first to review') }} "{{ $blogTitle }}"</h5>
                    <p>{{ __('product.Your email address will not be published. Required fields are marked *') }}</p>
                    <div class="select-star-rating mb-4">
                        <label>{{ __('product.Your rating') }} *</label>
                        <span class="star-rating" id="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="star-rating__star-icon" data-rating="{{ $i }}" width="12" height="12" fill="#ccc" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg" style="cursor: pointer;">
                                    <path d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z"/>
                                </svg>
                            @endfor
                        </span>
                        <input type="hidden" id="form-input-rating" name="rating" value="" required>
                    </div>
                    <div class="mb-4">
                        <textarea id="form-input-review" name="body" class="form-control form-control_gray" placeholder="{{ __('product.Your Review') }}" cols="30" rows="8"></textarea>
                    </div>
                    <div class="form-label-fixed mb-4">
                        <label for="form-input-name" class="form-label">{{ __('product.Name') }} *</label>
                        <input id="form-input-name" name="author_name" class="form-control form-control-md form-control_gray" required>
                    </div>
                    <div class="form-label-fixed mb-4">
                        <label for="form-input-email" class="form-label">{{ __('product.Email address') }} *</label>
                        <input id="form-input-email" name="author_email" type="email" class="form-control form-control-md form-control_gray" required>
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input form-check-input_fill" type="checkbox" value="1" id="remember_checkbox" name="remember">
                        <label class="form-check-label" for="remember_checkbox">
                            {{ __('product.Save my name, email, and website in this browser for the next time I comment.') }}
                        </label>
                    </div>
                    <div class="form-action">
                        <button type="submit" class="btn btn-primary">{{ __('product.Submit') }}</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('storefront/css/pages/blog-show.css') }}">
@endpush

@push('scripts')
    <script>
    // Set form data for JS
        document.addEventListener('DOMContentLoaded', function() {
            const reviewForm = document.getElementById('blog-review-form');
            if (reviewForm) {
            reviewForm.dataset.submitUrl = '{{ route("blog.reviews.store", [app()->getLocale(), $blog->slug]) }}';
            }
        });
    </script>
<script src="{{ asset('storefront/js/pages/blog-show.js') }}" defer></script>
@endpush

