@extends('layouts.default')

@section('title', $parentCategory ? $parentCategory->getTranslation('name', app()->getLocale()) . ' - ' . __('page.Categories') : __('page.Categories'))

@php
    $locale = app()->getLocale();
@endphp

@section('content')
    <div class="mb-md-1 pb-md-3"></div>

    <div class="container">
        <!-- Breadcrumb Section -->
        <div class="mb-3 mb-md-4 pb-2 pb-md-3">
            <nav aria-label="breadcrumb" class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home', $locale) }}" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('navigation.Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('categories.index', $locale) }}" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('navigation.Categories') }}</a>
                    </li>
                    @if($parentCategory)
                        <li class="breadcrumb-item active menu-link menu-link_us-s text-uppercase fw-medium" aria-current="page">
                            {{ $parentCategory->getTranslation('name', $locale) }}
                        </li>
                    @endif
                </ol>
                @if($parentCategory)
                    <a href="{{ route('categories.index', $locale) }}" class="btn-link btn-link_md default-underline text-uppercase fw-medium d-flex align-items-center">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-1">
                            <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        {{ __('common.Back') }}
                    </a>
                @endif
            </nav>
        </div>

        <!-- Page Title -->
        <div class="mb-4 mb-md-5">
            <h1 class="page-title mb-0">
                {{ $parentCategory ? $parentCategory->getTranslation('name', $locale) : __('page.Categories') }}
            </h1>
            @if($parentCategory && $parentCategory->getTranslation('description', $locale))
                <p class="text-muted mt-2 mb-0" style="font-size: 1rem;">
                    {{ $parentCategory->getTranslation('description', $locale) }}
                </p>
            @endif
        </div>

        @if($categoriesWithCounts->isNotEmpty())
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4 mb-5">
                @foreach($categoriesWithCounts as $item)
                    @php
                        $category = $item['category'];
                        $productCount = $item['product_count'];
                        $categoryName = $category->getTranslation('name', $locale);
                        $categoryImage = $category->getFirstMediaUrl('icon');
                        $hasChildren = $category->children()->where('is_active', true)->exists();
                        
                        // If has children, go to categories index with parent_id, otherwise go to category show page
                        if ($hasChildren) {
                            $categoryUrl = route('categories.index', [$locale, 'parent_id' => $category->id]);
                        } else {
                            $categoryUrl = route('categories.show', [$locale, $category->slug]);
                        }
                    @endphp
                    <div class="col">
                        <a href="{{ $categoryUrl }}" 
                           class="category-card d-block h-100 text-decoration-none">
                            <div class="category-card__image-wrapper">
                                @if($categoryImage)
                                    <img src="{{ $categoryImage }}" 
                                         alt="{{ $categoryName }}" 
                                         class="category-card__image"
                                         loading="lazy">
                                @else
                                    <div class="category-card__placeholder">
                                        <svg width="48" height="48" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/>
                                            <path d="M10 6v4M10 14h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="category-card__content">
                                <h3 class="category-card__title">{{ $categoryName }}</h3>
                                <p class="category-card__count">{{ $productCount }} {{ __('products') }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 py-md-6">
                <div class="mb-4">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-muted mx-auto">
                        <path d="M9 11H15M9 15H15M17 21H7C5.89543 21 5 20.1046 5 19V5C5 3.89543 5.89543 3 7 3H12.5858C12.851 3 13.1054 3.10536 13.2929 3.29289L18.7071 8.70711C18.8946 8.89464 19 9.149 19 9.41421V19C19 20.1046 18.1046 21 17 21Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="h5 mb-3 text-dark">{{ __('common.No categories found') }}</h3>
                <p class="text-secondary mb-4">{{ __('common.There are no categories available at the moment.') }}</p>
                <a href="{{ route('home', $locale) }}" class="btn btn-primary">
                    {{ __('common.Back to Home') }}
                </a>
            </div>
        @endif
    </div>

    @push('styles')
    <style>
        .category-card {
            background-color: #fff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 1.5rem 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 200px;
            height: 100%;
        }

        .category-card:hover {
            text-decoration: none;
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            border-color: #dee2e6;
        }

        .category-card__image-wrapper {
            width: 100%;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            flex-shrink: 0;
        }

        .category-card__image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .category-card:hover .category-card__image {
            transform: scale(1.05);
        }

        .category-card__placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 8px;
            color: #6c757d;
        }

        .category-card__content {
            text-align: center;
            width: 100%;
        }

        .category-card__title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.8em;
        }

        .category-card__count {
            font-size: 0.875rem;
            color: #6c757d;
            margin: 0;
            font-weight: 500;
        }

        /* Responsive adjustments */
        @media (min-width: 768px) {
            .category-card {
                padding: 2rem 1.5rem;
                min-height: 220px;
            }

            .category-card__image-wrapper {
                height: 110px;
                margin-bottom: 1.25rem;
            }

            .category-card__title {
                font-size: 1rem;
            }
        }

        @media (min-width: 992px) {
            .category-card {
                padding: 2.25rem 1.75rem;
                min-height: 240px;
            }

            .category-card__image-wrapper {
                height: 120px;
                margin-bottom: 1.5rem;
            }
        }

        /* Empty state styling */
        .text-center.py-5.py-md-6 {
            padding-top: 3rem !important;
            padding-bottom: 3rem !important;
        }

        @media (min-width: 768px) {
            .text-center.py-5.py-md-6 {
                padding-top: 4rem !important;
                padding-bottom: 4rem !important;
            }
        }
    </style>
    @endpush
@endsection
