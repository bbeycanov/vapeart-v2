@extends('layouts.default')

@section('title', $menu->getTranslation('title', app()->getLocale()) . ' - ' . __('Brands'))

@php
    $locale = app()->getLocale();
    $menuTitle = $menu->getTranslation('title', $locale);
    $menuUrl = $menu->getTranslation('url', $locale);
@endphp

@section('content')
    <div class="mb-md-1 pb-md-3"></div>
    
    <section class="catalog-brands-page container py-4 py-md-5">
        <!-- Breadcrumb -->
        <div class="mb-4 pb-md-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home', $locale) }}" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="menu-link menu-link_us-s text-uppercase fw-medium">{{ $menuTitle }}</span>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <span class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('Brands') }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Page Header -->
        <div class="mb-4 mb-md-5">
            <h1 class="page-title mb-2 mb-md-3">{{ $menuTitle }} - {{ __('Brands') }}</h1>
            <p class="text-secondary">{{ __('Browse brands available in this category') }}</p>
        </div>

        <!-- Brands Grid -->
        @if($brands && $brands->count() > 0)
            <div class="brands-grid row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3 g-md-4">
                @foreach($brands as $item)
                    @php
                        $brand = $item['brand'];
                        $productCount = $item['product_count'];
                        $brandName = $brand->getTranslation('name', $locale);
                        $brandSlug = $brand->slug;
                        $brandLogo = $brand->getFirstMediaUrl('logo');
                        $brandUrl = route('brands.show', [$locale, $brandSlug, 'menu_id' => $menu->id]);
                    @endphp
                    <div class="col">
                        <a href="{{ $brandUrl }}" class="brand-card d-flex flex-column border rounded-3 p-3 p-md-4 text-decoration-none h-100" style="transition: all 0.2s ease;" onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='none'; this.style.transform='translateY(0)';">
                            <div class="brand-card__logo d-flex align-items-center justify-content-center mb-3" style="height: 120px; background-color: #f8f9fa; border-radius: 8px;">
                                @if($brandLogo)
                                    <img src="{{ $brandLogo }}" alt="{{ $brandName }}" style="max-width: 100%; max-height: 100%; object-fit: contain; padding: 12px;">
                                @else
                                    <div class="text-muted text-center">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.3;">
                                            <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="brand-card__content text-center">
                                <h3 class="brand-card__name h6 fw-bold text-dark mb-2">{{ $brandName }}</h3>
                                <p class="brand-card__count text-muted mb-0 small">{{ $productCount }} {{ __('products') }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state text-center py-5">
                <div class="mb-4">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-muted opacity-50">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="h5 fw-bold text-dark mb-2">{{ __('No brands found') }}</h3>
                <p class="text-muted mb-4">{{ __('No brands available for this category.') }}</p>
            </div>
        @endif
    </section>
@endsection

