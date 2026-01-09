<footer class="footer footer_type_1 theme-bg-color-secondary text-white">
    <div class="footer-middle container">
        <div class="row">
            <div class="footer-column footer-store-info col-12 col-lg-4 mb-4 mb-lg-0">
                <div class="logo">
                    <a href="{{ route('home', app()->getLocale()) }}">
                        <img src="{{ asset('storefront/images/vapeart-logo.svg') }}" alt="{{ settings('site.name', 'VapeartBaku') }}" class="logo__image d-block">
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
                            <a href="{{ settings('facebook') }}" target="_blank" rel="noopener noreferrer" class="footer__social-link d-block text-white" aria-label="{{ __('footer.Follow us on Facebook') }}" title="Facebook">
                                <svg class="svg-icon svg-icon_facebook" width="9" height="15" viewBox="0 0 9 15" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <use href="#icon_facebook"/>
                                </svg>
                            </a>
                        </li>
                    @endif
                    @if(settings('twitter'))
                        <li>
                            <a href="{{ settings('twitter') }}" target="_blank" rel="noopener noreferrer" class="footer__social-link d-block text-white" aria-label="{{ __('footer.Follow us on X (Twitter)') }}" title="X (Twitter)">
                                <svg class="svg-icon svg-icon_twitter" width="14" height="13" viewBox="0 0 14 13" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <use href="#icon_twitter"/>
                                </svg>
                            </a>
                        </li>
                    @endif
                    @if(settings('instagram'))
                        <li>
                            <a href="{{ settings('instagram') }}" target="_blank" rel="noopener noreferrer" class="footer__social-link d-block text-white" aria-label="{{ __('footer.Follow us on Instagram') }}" title="Instagram">
                                <svg class="svg-icon svg-icon_instagram" width="14" height="13" viewBox="0 0 14 13" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <use href="#icon_instagram"/>
                                </svg>
                            </a>
                        </li>
                    @endif
                    @if(settings('youtube'))
                        <li>
                            <a href="{{ settings('youtube') }}" target="_blank" rel="noopener noreferrer" class="footer__social-link d-block text-white" aria-label="{{ __('footer.Subscribe on YouTube') }}" title="YouTube">
                                <svg class="svg-icon svg-icon_youtube" width="16" height="11" viewBox="0 0 16 11" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M15.0117 1.8584C14.8477 1.20215 14.3281 0.682617 13.6992 0.518555C12.5234 0.19043 7.875 0.19043 7.875 0.19043C7.875 0.19043 3.19922 0.19043 2.02344 0.518555C1.39453 0.682617 0.875 1.20215 0.710938 1.8584C0.382812 3.00684 0.382812 5.46777 0.382812 5.46777C0.382812 5.46777 0.382812 7.90137 0.710938 9.07715C0.875 9.7334 1.39453 10.2256 2.02344 10.3896C3.19922 10.6904 7.875 10.6904 7.875 10.6904C7.875 10.6904 12.5234 10.6904 13.6992 10.3896C14.3281 10.2256 14.8477 9.7334 15.0117 9.07715C15.3398 7.90137 15.3398 5.46777 15.3398 5.46777C15.3398 5.46777 15.3398 3.00684 15.0117 1.8584ZM6.34375 7.68262V3.25293L10.2266 5.46777L6.34375 7.68262Z"/>
                                </svg>
                            </a>
                        </li>
                    @endif
                    @if(settings('pinterest'))
                        <li>
                            <a href="{{ settings('pinterest') }}" target="_blank" rel="noopener noreferrer" class="footer__social-link d-block text-white" aria-label="{{ __('footer.Follow us on Pinterest') }}" title="Pinterest">
                                <svg class="svg-icon svg-icon_pinterest" width="14" height="15" viewBox="0 0 14 15" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
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
                            @if($menu->children->isNotEmpty())
                                <span class="d-lg-none"
                                      data-bs-toggle="collapse"
                                      data-bs-target="#footer-menu-{{ $index }}"
                                      aria-expanded="false"
                                      aria-controls="footer-menu-{{ $index }}"
                                      role="button">{{ $menu->getTranslation('title', app()->getLocale()) }}</span>
                                <span class="d-none d-lg-block">{{ $menu->getTranslation('title', app()->getLocale()) }}</span>
                            @else
                                <span>{{ $menu->getTranslation('title', app()->getLocale()) }}</span>
                            @endif

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

@push('scripts')
<script src="{{ asset('storefront/js/includes/footer.js') }}" defer></script>
@endpush

<footer class="footer-mobile w-100 px-4 d-md-none theme-bg-color-secondary text-white">
    <div class="d-flex justify-content-between align-items-center w-100">
        <a href="{{ route('home', app()->getLocale()) }}" class="footer-mobile__link d-flex flex-column align-items-center text-white">
            <svg class="d-block" width="18" height="18" viewBox="0 0 18 18" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_home"/>
            </svg>
            <span>{{ __('footer.Home') }}</span>
        </a>

        <a href="{{ route('categories.index', app()->getLocale()) }}" class="footer-mobile__link d-flex flex-column align-items-center text-white">
            <svg class="d-block" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="3" y="3" width="8" height="8" rx="2" stroke="currentColor" stroke-width="1.5"/>
                <rect x="13" y="3" width="8" height="8" rx="2" stroke="currentColor" stroke-width="1.5"/>
                <rect x="3" y="13" width="8" height="8" rx="2" stroke="currentColor" stroke-width="1.5"/>
                <rect x="13" y="13" width="8" height="8" rx="2" stroke="currentColor" stroke-width="1.5"/>
            </svg>
            <span>{{ __('footer.Categories') }}</span>
        </a>

        @if(isset($headerBranches) && $headerBranches->isNotEmpty())
            <a href="#" class="footer-mobile__link d-flex flex-column align-items-center text-white" data-bs-toggle="modal" data-bs-target="#branchPhoneModal">
                <div class="position-relative">
                    <svg class="d-block" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.384 17.752a2.108 2.108 0 0 1-.522 3.359 7.674 7.674 0 0 1-5.478.642C4.933 20.428 1.48 7.378 4.268 3.384a2.108 2.108 0 0 1 3.359-.522l2.409 2.409a2.108 2.108 0 0 1 .396 2.396l-.923 1.846a.316.316 0 0 0 .063.396c1.429 1.114 3.312 2.997 4.426 4.426a.316.316 0 0 0 .396.063l1.846-.923a2.108 2.108 0 0 1 2.396.396l2.409 2.409a2.108 2.108 0 0 1 .099 2.837z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
                <span>{{ __('footer.Phone') }}</span>
            </a>
        @else
            <a href="{{ route('contacts.index', app()->getLocale()) }}" class="footer-mobile__link d-flex flex-column align-items-center text-white">
                <div class="position-relative">
                    <svg class="d-block" width="18" height="18" viewBox="0 0 20 20" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_headphone"/>
                    </svg>
                </div>
                <span>{{ __('footer.Phone') }}</span>
            </a>
        @endif

        <a href="#" class="footer-mobile__link d-flex flex-column align-items-center js-mobile-search-trigger text-white">
            <div class="position-relative">
                <svg class="d-block" width="18" height="18" viewBox="0 0 20 20" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_search"/>
                </svg>
            </div>
            <span>{{ __('footer.Search') }}</span>
        </a>
    </div>
</footer>
