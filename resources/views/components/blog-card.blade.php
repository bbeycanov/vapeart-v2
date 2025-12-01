@props(['blog', 'variant' => 'index'])

@php
    $blogTitle = $blog->getTranslation('title', app()->getLocale());
    $blogExcerpt = $blog->getTranslation('excerpt', app()->getLocale());
    $blogUrl = route('blog.show', [app()->getLocale(), $blog->slug]);
    $blogDate = $blog->published_at ? $blog->published_at->format('F d, Y') : $blog->created_at->format('F d, Y');
    $authorName = $blog->author_name ?: 'Admin';
    
    if ($variant === 'home') {
        $blogImage = $blog->getFirstMediaUrl('featured') ?: asset('storefront/images/products/placeholder.jpg');
        $imageWidth = 330;
        $imageHeight = 220;
    } else {
        $blogImage = $blog->getFirstMediaUrl('featured', 'thumb') ?: asset('storefront/images/products/placeholder.jpg');
        $imageWidth = 450;
        $imageHeight = 400;
    }
@endphp

@if($variant === 'home')
    <div class="swiper-slide blog-grid__item mb-0 bg-white">
        <div class="blog-grid__item-image mb-0" style="height: 220px; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #f5f5f5;">
            <a href="{{ $blogUrl }}" class="w-100 h-100 d-flex align-items-center justify-content-center">
                <img loading="lazy" src="{{ $blogImage }}" width="{{ $imageWidth }}" height="{{ $imageHeight }}" alt="{{ $blogTitle }}" style="object-fit: contain; width: 100%; height: 100%; max-width: 100%; max-height: 100%;">
            </a>
        </div>
        <div class="blog-grid__item-detail px-4 py-4">
            <div class="blog-grid__item-meta">
                <span class="blog-grid__item-meta__author">By {{ $authorName }}</span>
                <span class="blog-grid__item-meta__date">{{ $blogDate }}</span>
            </div>
            <div class="blog-grid__item-title mb-0 me-3 me-xxl-5">
                <a href="{{ $blogUrl }}">{{ $blogTitle }}</a>
            </div>
        </div>
    </div>
@else
    <div class="blog-grid__item">
        <div class="blog-grid__item-image">
            <a href="{{ $blogUrl }}">
                <img loading="lazy" class="h-auto" src="{{ $blogImage }}" width="{{ $imageWidth }}" height="{{ $imageHeight }}" alt="{{ $blogTitle }}">
            </a>
        </div>
        <div class="blog-grid__item-detail">
            <div class="blog-grid__item-meta">
                <span class="blog-grid__item-meta__author">By {{ $authorName }}</span>
                <span class="blog-grid__item-meta__date">{{ $blogDate }}</span>
            </div>
            <div class="blog-grid__item-title">
                <a href="{{ $blogUrl }}">{{ $blogTitle }}</a>
            </div>
            @if($blogExcerpt)
                <div class="blog-grid__item-content">
                    <p>{{ strip_tags($blogExcerpt) }}</p>
                    <a href="{{ $blogUrl }}" class="readmore-link">{{ __('Continue Reading') }}</a>
                </div>
            @endif
        </div>
    </div>
@endif

