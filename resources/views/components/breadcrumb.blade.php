@props(['items' => []])

@php
    $locale = app()->getLocale();
@endphp

<div class="breadcrumb-wrapper d-none d-md-block">
    <div class="container">
        <nav class="breadcrumb py-2 py-md-3 mb-0" aria-label="breadcrumb">
            @if(empty($items))
                {{-- Default: Home only --}}
                <a href="{{ route('home', $locale) }}" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('navigation.Home') }}</a>
            @else
                @foreach($items as $index => $item)
                    @if($loop->last)
                        {{-- Last item - no link --}}
                        <span class="menu-link menu-link_us-s text-uppercase fw-medium" aria-current="page">{{ $item['label'] ?? $item }}</span>
                    @else
                        {{-- Link item --}}
                        <a href="{{ $item['url'] ?? '#' }}" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ $item['label'] ?? $item }}</a>
                        <span class="breadcrumb-separator menu-link fw-medium px-2">/</span>
                    @endif
                @endforeach
            @endif
        </nav>
    </div>
</div>

