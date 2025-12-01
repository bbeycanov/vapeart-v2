@foreach($items as $brand)
    <div class="brand-grid__item mb-4">
        <div class="brand-card border rounded-3 p-4 h-100 d-flex flex-column align-items-center justify-content-center text-center">
            <div class="brand-card__logo mb-3">
                <a href="{{ route('brands.show', [app()->getLocale(), $brand->slug]) }}" class="d-block">
                    @if($logo = $brand->getFirstMediaUrl('logo'))
                        <img loading="lazy" 
                             src="{{ $logo }}" 
                             alt="{{ $brand->getTranslation('name', app()->getLocale()) }}"
                             class="brand-logo"
                             style="max-width: 100%; max-height: 120px; object-fit: contain; width: auto; height: auto;">
                    @else
                        <div class="brand-logo-placeholder d-flex align-items-center justify-content-center" style="width: 150px; height: 120px; background-color: #f5f5f5; border-radius: 8px;">
                            <span class="text-muted">{{ $brand->getTranslation('name', app()->getLocale()) }}</span>
                        </div>
                    @endif
                </a>
            </div>
            <div class="brand-card__name">
                <a href="{{ route('brands.show', [app()->getLocale(), $brand->slug]) }}" class="text-decoration-none">
                    <h5 class="mb-0 fw-medium">{{ $brand->getTranslation('name', app()->getLocale()) }}</h5>
                </a>
            </div>
            <div class="brand-card__count mt-2">
                <small class="text-muted">{{ $brand->products_count ?? 0 }} {{ __('Products') }}</small>
            </div>
        </div>
    </div>
@endforeach

