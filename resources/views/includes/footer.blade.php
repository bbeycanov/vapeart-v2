<footer class="footer footer_type_1 theme-bg-color-secondary text-white">
    <div class="footer-middle container">
        <div class="row">
            <div class="footer-column footer-store-info col-12 col-lg-4 mb-4 mb-lg-0">
                <div class="logo">
                    <a href="{{ route('home', app()->getLocale()) }}">
                        <img src="{{ asset('storefront/images/logo-white.png') }}" alt="{{ settings('site.name', 'VapeartBaku') }}" class="logo__image d-block">
                    </a>
                </div>
                <p class="footer-address">{{ settings('site.address', __('Address')) }}</p>

                <p class="m-0">
                    <strong class="fw-medium">{{ settings('site.email', __('Email')) }}</strong>
                </p>
                <p>
                    <strong class="fw-medium">{{ settings('site.phone', __('Phone')) }}</strong>
                </p>

                <ul class="social-links list-unstyled d-flex flex-wrap mb-0">
                    @if(settings('facebook'))
                        <li>
                            <a href="{{ settings('facebook') }}" target="_blank" rel="noopener noreferrer" class="footer__social-link d-block text-white">
                                <svg class="svg-icon svg-icon_facebook" width="9" height="15" viewBox="0 0 9 15" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_facebook"/>
                                </svg>
                            </a>
                        </li>
                    @endif
                    @if(settings('twitter'))
                        <li>
                            <a href="{{ settings('twitter') }}" target="_blank" rel="noopener noreferrer" class="footer__social-link d-block text-white">
                                <svg class="svg-icon svg-icon_twitter" width="14" height="13" viewBox="0 0 14 13" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_twitter"/>
                                </svg>
                            </a>
                        </li>
                    @endif
                    @if(settings('instagram'))
                        <li>
                            <a href="{{ settings('instagram') }}" target="_blank" rel="noopener noreferrer" class="footer__social-link d-block text-white">
                                <svg class="svg-icon svg-icon_instagram" width="14" height="13" viewBox="0 0 14 13" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_instagram"/>
                                </svg>
                            </a>
                        </li>
                    @endif
                    @if(settings('youtube'))
                        <li>
                            <a href="{{ settings('youtube') }}" target="_blank" rel="noopener noreferrer" class="footer__social-link d-block text-white">
                                <svg class="svg-icon svg-icon_youtube" width="16" height="11" viewBox="0 0 16 11" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.0117 1.8584C14.8477 1.20215 14.3281 0.682617 13.6992 0.518555C12.5234 0.19043 7.875 0.19043 7.875 0.19043C7.875 0.19043 3.19922 0.19043 2.02344 0.518555C1.39453 0.682617 0.875 1.20215 0.710938 1.8584C0.382812 3.00684 0.382812 5.46777 0.382812 5.46777C0.382812 5.46777 0.382812 7.90137 0.710938 9.07715C0.875 9.7334 1.39453 10.2256 2.02344 10.3896C3.19922 10.6904 7.875 10.6904 7.875 10.6904C7.875 10.6904 12.5234 10.6904 13.6992 10.3896C14.3281 10.2256 14.8477 9.7334 15.0117 9.07715C15.3398 7.90137 15.3398 5.46777 15.3398 5.46777C15.3398 5.46777 15.3398 3.00684 15.0117 1.8584ZM6.34375 7.68262V3.25293L10.2266 5.46777L6.34375 7.68262Z"/>
                                </svg>
                            </a>
                        </li>
                    @endif
                    @if(settings('pinterest'))
                        <li>
                            <a href="{{ settings('pinterest') }}" target="_blank" rel="noopener noreferrer" class="footer__social-link d-block text-white">
                                <svg class="svg-icon svg-icon_pinterest" width="14" height="15" viewBox="0 0 14 15" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_pinterest"/>
                                </svg>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            @if(isset($footerMenus) && $footerMenus->isNotEmpty())
                @php
                    $menuCount = $footerMenus->count();
                    $colClass = $menuCount <= 2 ? 'col-lg-4' : ($menuCount == 3 ? 'col-lg-3' : 'col-lg-2');
                @endphp
                @foreach($footerMenus as $index => $menu)
                    <div class="footer-column footer-menu {{ $colClass }} mb-4 mb-lg-0">
                        <h6 class="sub-menu__title text-uppercase d-flex align-items-center justify-content-between justify-content-lg-start mb-0 mb-lg-2">
                            <span>{{ $menu->getTranslation('title', app()->getLocale()) }}</span>
                            @if($menu->children->isNotEmpty())
                                <button class="footer-menu-toggle d-lg-none btn btn-link text-white p-0 ms-2" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#footer-menu-{{ $index }}" 
                                        aria-expanded="false" 
                                        aria-controls="footer-menu-{{ $index }}">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="footer-menu-toggle-icon">
                                        <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            @endif
                        </h6>
                        @if($menu->children->isNotEmpty())
                            <div class="collapse d-lg-block" id="footer-menu-{{ $index }}">
                                <ul class="sub-menu__list list-unstyled mt-2 mt-lg-0">
                                @foreach($menu->children as $child)
                                    <li class="sub-menu__item">
                                        <a href="{{ $child->getTranslation('url', app()->getLocale()) ?: '#' }}" 
                                           target="{{ $child->target ?? '_self' }}" 
                                           class="menu-link menu-link_us-s text-white">
                                            {{ $child->getTranslation('title', app()->getLocale()) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="footer-bottom container" style="border-top-color: rgba(255,255,255,.1);">
        <div class="footer-bottom-content d-flex flex-column flex-md-row align-items-center justify-content-between py-3 py-md-4 gap-3">
            <div class="footer-copyright text-center text-md-start order-2 order-md-1">
                <span class="text-white-50" style="font-size: 0.875rem;">
                    {{ __('footer.Copyright') }} © {{ date('Y') }} {{ settings('site.name', 'VapeartBaku.com') }}
                </span>
            </div>
            <div class="footer-settings order-1 order-md-2">
                <div class="footer-language-selector d-flex align-items-center justify-content-center justify-content-md-end gap-2">
                    <label for="footerSettingsLanguage" class="text-white mb-0" style="font-size: 0.875rem; font-weight: 500;">
                        {{ __('footer.Language') }}:
                    </label>
                    <div class="footer-language-select-wrapper position-relative">
                    <select id="footerSettingsLanguage"
                                class="footer-language-select"
                            aria-label="{{ __('footer.Select Language') }}" 
                            name="store-language">
                        @foreach($languages as $lang)
                            <option value="{{ $lang['code'] }}" 
                                        {{ app()->getLocale() === $lang['code'] ? 'selected' : '' }}>
                                {{ $lang['native_name'] ?? strtoupper($lang['code']) }}
                            </option>
                        @endforeach
                    </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

@push('styles')
<style>
/* Footer Menu Collapsible Styles */
.footer-menu-toggle {
    border: none;
    background: transparent;
    transition: transform 0.3s ease;
    min-width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.footer-menu-toggle:focus {
    box-shadow: none;
    outline: none;
}

.footer-menu-toggle-icon {
    transition: transform 0.3s ease;
}

.footer-menu-toggle[aria-expanded="true"] .footer-menu-toggle-icon {
    transform: rotate(180deg);
}

/* Footer Menu Collapse Animation */
.footer-menu .collapse {
    transition: height 0.35s ease;
}

.footer-menu .collapse:not(.show) {
    display: none;
}

@media (min-width: 992px) {
    .footer-menu .collapse {
        display: block !important;
    }
}

/* Footer Bottom Styles */
.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
}

.footer-bottom-content {
    min-height: 60px;
}

.footer-copyright {
    flex: 1;
    line-height: 1.5;
}

/* Footer Language Selector */
.footer-language-selector {
    flex-wrap: wrap;
}

.footer-language-select-wrapper {
    position: relative;
}


/* Footer Language Select - White background design */
.footer-language-select,
#footerSettingsLanguage,
.footer-bottom select,
.footer-language-select-wrapper select {
    display: block !important;
    width: 100% !important;
    min-width: 140px !important;
    padding: 0.5rem 2.5rem 0.5rem 0.75rem !important;
    font-size: 0.875rem !important;
    font-weight: 400 !important;
    line-height: 1.5 !important;
    color: #495057 !important;
    background-color: #fff !important;
    background-image: none !important;
    border: 1px solid #dee2e6 !important;
    border-radius: 6px !important;
    appearance: none !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    -ms-appearance: none !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
    box-shadow: none !important;
}

.footer-language-select:hover,
#footerSettingsLanguage:hover {
    background-color: #f8f9fa !important;
    background-image: none !important;
    border-color: #adb5bd !important;
    color: #495057 !important;
}

.footer-language-select:focus,
#footerSettingsLanguage:focus {
    background-color: #fff !important;
    background-image: none !important;
    border-color: #adb5bd !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.05) !important;
    color: #495057 !important;
    outline: none !important;
}

.footer-language-select option,
#footerSettingsLanguage option {
    background-color: #fff !important;
    color: #495057 !important;
    padding: 0.5rem !important;
}

/* Remove all default arrows */
.footer-language-select::-ms-expand,
#footerSettingsLanguage::-ms-expand {
    display: none !important;
}

.footer-language-select::-webkit-select-arrow,
#footerSettingsLanguage::-webkit-select-arrow {
    display: none !important;
}

/* Custom dropdown arrow - dark gray */
.footer-language-select-wrapper::after {
    content: '';
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 6px solid #6c757d;
    pointer-events: none;
    z-index: 10;
}

/* Mobile Responsive Adjustments */
@media (max-width: 767.98px) {
    .footer-bottom-content {
        padding: 1rem 0 !important;
    }

    .footer-copyright {
        font-size: 0.8125rem;
        line-height: 1.6;
    }

    .footer-language-selector {
        width: 100%;
        justify-content: center;
    }

    .footer-language-select {
        flex: 1;
        max-width: 200px;
    }

    .footer-menu .sub-menu__title {
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 0 !important;
    }

    .footer-menu .sub-menu__list {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }

    .footer-menu .sub-menu__item {
        padding: 0.5rem 0;
    }

    .footer-menu .sub-menu__item:not(:last-child) {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
}

@media (min-width: 768px) {
    .footer-bottom-content {
        padding: 1.25rem 0 !important;
    }
}

/* Smooth transitions */
.footer-menu .sub-menu__list {
    transition: opacity 0.3s ease;
}

.footer-menu .collapse.show .sub-menu__list {
    opacity: 1;
}
</style>
@endpush

@push('scripts')
<script>
// Language Selector - Change URL locale while preserving slug
(function() {
    'use strict';
    
    function initLanguageSelector(selectId) {
        const select = document.getElementById(selectId);
        if (!select) return;
        
        select.addEventListener('change', function() {
            const newLocale = this.value;
            const currentPath = window.location.pathname;
            
            // Get supported locales from config
            const supportedLocales = ['en', 'az', 'ru'];
            
            // Split path into segments
            const segments = currentPath.split('/').filter(s => s);
            
            // Check if first segment is a locale
            if (segments.length > 0 && supportedLocales.includes(segments[0])) {
                // Replace locale (keep slug and other params)
                segments[0] = newLocale;
            } else {
                // Add locale at beginning
                segments.unshift(newLocale);
            }
            
            // Rebuild URL
            const newPath = '/' + segments.join('/');
            const queryString = window.location.search;
            const hash = window.location.hash;
            
            window.location.href = newPath + queryString + hash;
        });
    }
    
    // Initialize both language selectors
    document.addEventListener('DOMContentLoaded', function() {
        initLanguageSelector('footerSettingsLanguage');
        initLanguageSelector('footerSettingsLanguage_mobile');
    });
})();
</script>
@endpush

<footer class="footer-mobile container w-100 px-5 d-md-none bg-body">
    <div class="row text-center">
        <div class="col-3">
            <a href="{{ route('home', app()->getLocale()) }}" class="footer-mobile__link d-flex flex-column align-items-center">
                <svg class="d-block" width="18" height="18" viewBox="0 0 18 18" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_home"/>
                </svg>
                <span>{{ __('footer.Home') }}</span>
            </a>
        </div>

        <div class="col-3">
            <a href="{{ route('categories.index', app()->getLocale()) }}" class="footer-mobile__link d-flex flex-column align-items-center">
                <svg class="d-block" width="18" height="18" viewBox="0 0 18 18" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_hanger"/>
                </svg>
                <span>{{ __('footer.Categories') }}</span>
            </a>
        </div>

        @if(isset($headerBranches) && $headerBranches->isNotEmpty())
        <div class="col-3">
            <a href="#" class="footer-mobile__link d-flex flex-column align-items-center" data-bs-toggle="modal" data-bs-target="#branchPhoneModal">
                <div class="position-relative">
                    <svg class="d-block" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.384 17.752a2.108 2.108 0 0 1-.522 3.359 7.674 7.674 0 0 1-5.478.642C4.933 20.428 1.48 7.378 4.268 3.384a2.108 2.108 0 0 1 3.359-.522l2.409 2.409a2.108 2.108 0 0 1 .396 2.396l-.923 1.846a.316.316 0 0 0 .063.396c1.429 1.114 3.312 2.997 4.426 4.426a.316.316 0 0 0 .396.063l1.846-.923a2.108 2.108 0 0 1 2.396.396l2.409 2.409a2.108 2.108 0 0 1 .099 2.837z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
                <span>{{ __('footer.Phone') }}</span>
            </a>
        </div>
        @else
        <div class="col-3">
            <a href="{{ route('contacts.index', app()->getLocale()) }}" class="footer-mobile__link d-flex flex-column align-items-center">
                <div class="position-relative">
                    <svg class="d-block" width="18" height="18" viewBox="0 0 20 20" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_headphone"/>
                    </svg>
                </div>
                <span>{{ __('footer.Phone') }}</span>
            </a>
        </div>
        @endif
        <div class="col-3">
            <a href="#" class="footer-mobile__link d-flex flex-column align-items-center js-mobile-search-trigger">
                <div class="position-relative">
                    <svg class="d-block" width="18" height="18" viewBox="0 0 20 20" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_search"/>
                    </svg>
                </div>
                <span>{{ __('footer.Search') }}</span>
            </a>
        </div>
    </div>
</footer>
