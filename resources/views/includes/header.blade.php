
<div class="header-mobile header_sticky">
    <div class="container d-flex align-items-center h-100 position-relative">
        <div class="d-flex align-items-center">
            <a class="mobile-nav-activator d-block position-relative me-3" href="#" role="button" aria-label="{{ __('common.Open navigation menu') }}" aria-expanded="false">
                <svg class="nav-icon" width="25" height="18" viewBox="0 0 25 18" xmlns="http://www.w3.org/2000/svg"><use href="#icon_nav" /></svg>
                <span class="btn-close-lg position-absolute top-0 start-0 w-100"></span>
            </a>

            @if(isset($headerBranches) && $headerBranches->isNotEmpty())
                <a href="#" class="header-tools__item" data-bs-toggle="modal" data-bs-target="#branchSelectionModal">
                    <svg class="d-block" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                </a>
            @endif
        </div>

        <div class="logo position-absolute start-50 translate-middle-x">
            <a href="{{ route('home', app()->getLocale()) }}">
                @php
                    $defaultLogo = asset('storefront/images/vapeart-logo.svg');
                @endphp
                <img src="{{ $defaultLogo }}" alt="{{ settings('site.name', 'VapeartBaku') }}" class="logo__image d-block">
            </a>
        </div>

        <div class="d-flex align-items-center ms-auto">
            <a href="{{ route('wishlist.index', app()->getLocale()) }}" class="header-tools__item header-tools__wishlist me-3">
                <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_heart" /></svg>
                <span class="wishlist-amount d-block position-absolute js-wishlist-items-count theme-bg-color">0</span>
            </a>
            <a href="#" class="header-tools__item header-tools__cart js-open-aside" data-aside="cartDrawer">
                <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_cart" /></svg>
                <span class="cart-amount d-block position-absolute js-cart-items-count">3</span>
            </a>
        </div>
    </div>

    <nav class="header-mobile__navigation navigation d-flex flex-column w-100 position-absolute top-100 bg-body overflow-auto">
        <div class="container">
            <form action="{{ route('search.index', app()->getLocale()) }}" method="GET" class="search-field position-relative mt-4 mb-3" id="mobileSearchForm">
                <div class="position-relative">
                    <input
                        class="search-field__input w-100 border rounded-1"
                        type="text"
                        name="q"
                        id="mobileSearchInput"
                        placeholder="{{ __('product.Search products...') }}"
                        autocomplete="off"
                    >
                    <button class="btn-icon search-popup__submit pb-0 me-2" type="submit">
                        <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_search" /></svg>
                    </button>
                    <button class="btn-icon btn-close-lg search-popup__reset pb-0 me-2 d-none" type="button" id="mobileSearchClear"></button>
                </div>

                <!-- Mobile Autocomplete Dropdown -->
                <div class="position-absolute start-0 top-100 m-0 w-100 d-none" id="mobileSearchAutocomplete" style="z-index: 1000;">
                    <div class="bg-white border rounded-3 shadow-lg mt-2 overflow-hidden">
                        <!-- Loading State -->
                        <div class="autocomplete-loading p-4 text-center d-none" id="mobileAutocompleteLoading">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">{{ __('common.Loading...') }}</span>
                            </div>
                        </div>

                        <!-- Results Container -->
                        <div class="autocomplete-results" id="mobileAutocompleteResults" style="max-height: 400px; overflow-y: auto;">
                            <!-- Product suggestions will appear here -->
                        </div>

                        <!-- No Results -->
                        <div class="autocomplete-no-results p-4 text-center text-secondary d-none" id="mobileAutocompleteNoResults">
                            <p class="mb-0">{{ __('common.No products found') }}</p>
                        </div>

                        <!-- View All Results -->
                        <div class="autocomplete-footer border-top p-3 text-center d-none" id="mobileAutocompleteFooter">
                            <a href="{{ route('search.index', app()->getLocale()) }}" class="btn btn-link text-decoration-none">
                                {{ __('common.View all results') }}
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="ms-1">
                                    <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="container">
            <div class="overflow-hidden">
                <ul class="navigation__list list-unstyled position-relative">
                    @php
                        $locale = app()->getLocale();
                    @endphp

                    {{-- 1. Ana Sayfa - Static --}}
                    <li class="navigation__item">
                        <a href="{{ route('home', $locale) }}" class="navigation__link">{{ __('navigation.Home') }}</a>
                    </li>

                    {{-- 2. Categories - Static (goes to categories index page) --}}
                    <li class="navigation__item">
                        <a href="{{ route('categories.index', $locale) }}" class="navigation__link js-nav-right d-flex align-items-center">
                            {{ __('navigation.Categories') }}
                            <svg class="ms-auto" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_sm" /></svg>
                        </a>
                    </li>

                    {{-- 3. Dynamic Menu Items from MobileMenu position --}}
                    @if(isset($mobileMenus) && $mobileMenus->isNotEmpty())
                        @foreach($mobileMenus as $menu)
                            @php
                                $menuTitle = $menu->getTranslation('title', $locale);
                                $menuUrl = $menu->getTranslation('url', $locale) ?: '#';
                                $hasChildren = $menu->children->isNotEmpty();
                                $target = $menu->target ?: '_self';
                            @endphp
                            <li class="navigation__item">
                                @if($hasChildren)
                                    <a href="{{ $menuUrl }}" class="navigation__link js-nav-right d-flex align-items-center" target="{{ $target }}">
                                        {{ $menuTitle }}
                                        <svg class="ms-auto" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_sm" /></svg>
                                    </a>
                                    <div class="sub-menu position-absolute top-0 start-100 w-100 d-none">
                                        <a href="{{ $menuUrl }}" class="navigation__link js-nav-left d-flex align-items-center border-bottom mb-2" target="{{ $target }}">
                                            <svg class="me-2" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_sm" /></svg>
                                            {{ $menuTitle }}
                                        </a>
                                        <ul class="list-unstyled">
                                            @foreach($menu->children as $child)
                                                @php
                                                    $childTitle = $child->getTranslation('title', $locale);
                                                    $childUrl = $child->getTranslation('url', $locale) ?: '#';
                                                    $childTarget = $child->target ?: '_self';
                                                @endphp
                                                <li class="sub-menu__item">
                                                    <a href="{{ $childUrl }}" class="menu-link menu-link_us-s" target="{{ $childTarget }}">{{ $childTitle }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <a href="{{ $menuUrl }}" class="navigation__link" target="{{ $target }}">{{ $menuTitle }}</a>
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="border-top mt-auto pb-2">
            <div class="container d-flex align-items-center">
                <label for="footerSettingsLanguage_mobile" class="me-2 text-secondary">{{ __('footer.Language') }}</label>
                <select id="footerSettingsLanguage_mobile" class="form-select form-select-sm bg-transparent border-0" aria-label="Default select example" name="store-language">
                    @foreach($languages as $lang)
                        <option value="{{ $lang['code'] }}" {{ app()->getLocale() === $lang['code'] ? 'selected' : '' }}>
                            {{ $lang['native_name'] ?? strtoupper($lang['code']) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <ul class="container social-links list-unstyled d-flex flex-wrap mb-0">
                <li>
                    <a href="{{settings('facebook')}}" class="footer__social-link d-block ps-0">
                        <svg class="svg-icon svg-icon_facebook" width="9" height="15" viewBox="0 0 9 15" xmlns="http://www.w3.org/2000/svg"><use href="#icon_facebook" /></svg>
                    </a>
                </li>
                <li>
                    <a href="{{settings('twitter')}}" class="footer__social-link d-block">
                        <svg class="svg-icon svg-icon_twitter" width="14" height="13" viewBox="0 0 14 13" xmlns="http://www.w3.org/2000/svg"><use href="#icon_twitter" /></svg>
                    </a>
                </li>
                <li>
                    <a href="{{settings('instagram')}}" class="footer__social-link d-block">
                        <svg class="svg-icon svg-icon_instagram" width="14" height="13" viewBox="0 0 14 13" xmlns="http://www.w3.org/2000/svg"><use href="#icon_instagram" /></svg>
                    </a>
                </li>
                <li>
                    <a href="{{settings('youtube')}}" class="footer__social-link d-block">
                        <svg class="svg-icon svg-icon_youtube" width="16" height="11" viewBox="0 0 16 11" xmlns="http://www.w3.org/2000/svg"><path d="M15.0117 1.8584C14.8477 1.20215 14.3281 0.682617 13.6992 0.518555C12.5234 0.19043 7.875 0.19043 7.875 0.19043C7.875 0.19043 3.19922 0.19043 2.02344 0.518555C1.39453 0.682617 0.875 1.20215 0.710938 1.8584C0.382812 3.00684 0.382812 5.46777 0.382812 5.46777C0.382812 5.46777 0.382812 7.90137 0.710938 9.07715C0.875 9.7334 1.39453 10.2256 2.02344 10.3896C3.19922 10.6904 7.875 10.6904 7.875 10.6904C7.875 10.6904 12.5234 10.6904 13.6992 10.3896C14.3281 10.2256 14.8477 9.7334 15.0117 9.07715C15.3398 7.90137 15.3398 5.46777 15.3398 5.46777C15.3398 5.46777 15.3398 3.00684 15.0117 1.8584ZM6.34375 7.68262V3.25293L10.2266 5.46777L6.34375 7.68262Z"/></svg>
                    </a>
                </li>
                <li>
                    <a href="{{settings('pinterest')}}" class="footer__social-link d-block">
                        <svg class="svg-icon svg-icon_pinterest" width="14" height="15" viewBox="0 0 14 15" xmlns="http://www.w3.org/2000/svg"><use href="#icon_pinterest" /></svg>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<header id="header" class="header header_sticky">
    <div class="header-desk_type_7">
        <div class="header-top theme-bg-color-secondary">
            <div class="container d-flex align-items-center">
                <div class="logo">
                    <a href="{{ route('home', app()->getLocale()) }}">
                        @php
                            $defaultLogo = asset('storefront/images/vapeart-logo.svg');
                        @endphp
                        <img src="{{   $defaultLogo }}" alt="{{ settings('site.name', 'VapeartBaku') }}" class="logo__image">
                    </a>
                </div>



                <form action="{{ route('search.index', app()->getLocale()) }}" method="GET" class="header-search search-field position-relative" id="desktopSearchForm">
                    <input
                        class="header-search__input w-100"
                        type="text"
                        name="q"
                        id="desktopSearchInput"
                        placeholder="{{ __('product.Search products...') }}"
                        autocomplete="off"
                    >

                    <button class="btn header-search__btn" type="submit">
                        <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_search" /></svg>
                    </button>

                    <button class="btn-icon btn-close-lg d-none" type="button" id="desktopSearchClear" style="position: absolute; right: 3rem; top: 50%; transform: translateY(-50%); padding: 0.25rem;"></button>

                    <!-- Desktop Autocomplete Dropdown -->
                    <div class="position-absolute start-0 top-100 w-100 d-none" id="desktopSearchAutocomplete" style="z-index: 1000; margin-top: 0.5rem;">
                        <div class="bg-white border rounded-3 shadow-lg overflow-hidden">
                            <!-- Loading State -->
                            <div class="autocomplete-loading p-4 text-center d-none" id="desktopAutocompleteLoading">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">{{ __('common.Loading...') }}</span>
                                </div>
                            </div>

                            <!-- Results Container -->
                            <div class="autocomplete-results" id="desktopAutocompleteResults" style="max-height: 400px; overflow-y: auto;">
                                <!-- Product suggestions will appear here -->
                            </div>

                            <!-- No Results -->
                            <div class="autocomplete-no-results p-4 text-center text-secondary d-none" id="desktopAutocompleteNoResults">
                                <p class="mb-0">{{ __('common.No products found') }}</p>
                            </div>

                            <!-- View All Results -->
                            <div class="autocomplete-footer border-top p-3 text-center d-none" id="desktopAutocompleteFooter">
                                <a href="{{ route('search.index', app()->getLocale()) }}" class="btn btn-link text-decoration-none">
                                    {{ __('common.View all results') }}
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="ms-1">
                                        <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="header-tools d-flex align-items-center">
                    @if(isset($headerBranches) && $headerBranches->isNotEmpty())
                        <div class="header-phone-slider position-relative me-3" id="desktopHeaderPhoneSlider">
                            <a href="#" class="header-phone-link text-white text-decoration-none d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#branchSelectionModal">
                                <svg class="header-phone-icon me-2" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21.384 17.752a2.108 2.108 0 0 1-.522 3.359 7.674 7.674 0 0 1-5.478.642C4.933 20.428 1.48 7.378 4.268 3.384a2.108 2.108 0 0 1 3.359-.522l2.409 2.409a2.108 2.108 0 0 1 .396 2.396l-.923 1.846a.316.316 0 0 0 .063.396c1.429 1.114 3.312 2.997 4.426 4.426a.316.316 0 0 0 .396.063l1.846-.923a2.108 2.108 0 0 1 2.396.396l2.409 2.409a2.108 2.108 0 0 1 .099 2.837z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                </svg>
                                <div class="header-phone-content position-relative">
                                    <div class="header-phone-slider-wrapper" id="desktopPhoneSliderWrapper">
                                        @foreach($headerBranches as $branch)
                                            <div class="header-phone-item d-flex flex-column">
                                                <span class="header-phone-name">{{ $branch['name'] }}</span>
                                                <span class="header-phone-number">{{ $branch['phone'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif

                    <a href="{{ route('wishlist.index', app()->getLocale()) }}" class="header-tools__item header-tools__wishlist">
                        <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_heart" /></svg>
                        <span class="wishlist-amount d-block position-absolute js-wishlist-items-count theme-bg-color">0</span>
                    </a>
                    <a href="#" class="header-tools__item header-tools__cart js-open-aside" data-aside="cartDrawer">
                        <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_cart" /></svg>
                        <span class="cart-amount d-block position-absolute js-cart-items-count theme-bg-color">3</span>
                    </a>

                    <a class="header-tools__item" href="#" data-bs-toggle="modal" data-bs-target="#siteMap">
                        <svg class="nav-icon" width="25" height="18" viewBox="0 0 25 18" xmlns="http://www.w3.org/2000/svg">
                            <rect width="25" height="2"/><rect y="8" width="20" height="2"/><rect y="16" width="25" height="2"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="header-bottom theme-bg-color">
            <div class="container d-flex align-items-center">
                <nav class="navigation">
                    <ul class="navigation__list list-unstyled d-flex">
                        @if(isset($headerMenus) && $headerMenus->isNotEmpty())
                            @foreach($headerMenus as $menu)
                                @php
                                    $menuTitle = $menu->getTranslation('title', app()->getLocale());
                                    $menuUrl = $menu->getTranslation('url', app()->getLocale()) ?: '#';
                                    $hasChildren = $menu->children->isNotEmpty();
                                    $target = $menu->target ?: '_self';
                                    $menuType = $menu->type;
                                @endphp
                                <li class="navigation__item">
                                    @if($menuType === 'mega' && $hasChildren)
                                        {{-- MEGA MENU --}}
                                        <a href="{{ $menuUrl }}" class="navigation__link" target="{{ $target }}">{{ $menuTitle }}</a>
                                        <div class="mega-menu">
                                            <div class="container d-flex">
                                                @foreach($menu->children as $groupMenu)
                                                    @php
                                                        $groupTitle = $groupMenu->getTranslation('title', app()->getLocale());
                                                        $groupUrl = $groupMenu->getTranslation('url', app()->getLocale()) ?: '#';
                                                        $groupChildren = $groupMenu->children;
                                                    @endphp
                                                    <div class="col pe-4">
                                                        <a href="{{ $groupUrl }}" class="sub-menu__title">{{ $groupTitle }}</a>
                                                        @if($groupChildren->isNotEmpty())
                                                            <ul class="sub-menu__list list-unstyled">
                                                                @foreach($groupChildren as $child)
                                                                    @php
                                                                        $childTitle = $child->getTranslation('title', app()->getLocale());
                                                                        $childUrl = $child->getTranslation('url', app()->getLocale()) ?: '#';
                                                                        $childTarget = $child->target ?: '_self';
                                                                    @endphp
                                                                    <li class="sub-menu__item">
                                                                        <a href="{{ $childUrl }}" class="menu-link menu-link_us-s" target="{{ $childTarget }}">{{ $childTitle }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                @endforeach

                                                {{-- Widget Area --}}
                                                @if($menu->widgets->isNotEmpty())
                                                    @foreach($menu->widgets->where('is_active', true)->sortBy('sort_order') as $widget)
                                                        @php
                                                            $widgetTitle = $widget->getTranslation('title', app()->getLocale());
                                                            $widgetContent = $widget->getTranslation('content', app()->getLocale());
                                                            $widgetButtonText = $widget->getTranslation('button_text', app()->getLocale());
                                                            $widgetButtonUrl = $widget->getTranslation('button_url', app()->getLocale()) ?: '#';
                                                            $widgetImage = $widget->getFirstMediaUrl('image');
                                                        @endphp
                                                        <div class="mega-menu__media col">
                                                            <div class="position-relative">
                                                                @if($widgetImage)
                                                                    <img loading="lazy" class="mega-menu__img" src="{{ $widgetImage }}" alt="{{ $widgetTitle ?: 'Widget Image' }}">
                                                                @endif
                                                                <div class="mega-menu__media-content content_abs content_left content_bottom">
                                                                    @if($widgetTitle)
                                                                        @php
                                                                            $titleWords = explode(' ', $widgetTitle);
                                                                            $firstWord = $titleWords[0] ?? '';
                                                                            $remainingWords = implode(' ', array_slice($titleWords, 1));
                                                                        @endphp
                                                                        <h3>{{ strtoupper($firstWord) }}</h3>
                                                                        @if($remainingWords)
                                                                            <h3 class="mb-0">{{ strtoupper($remainingWords) }}</h3>
                                                                        @endif
                                                                    @endif
                                                                    @if($widgetContent)
                                                                        <p class="mega-menu__content mb-2"> {!! $widgetContent !!} </p>
                                                                    @endif
                                                                    @if($widgetButtonText && $widgetButtonUrl)
                                                                        <a href="{{ $widgetButtonUrl }}" class="btn-link default-underline fw-medium">{{ strtoupper($widgetButtonText) }}</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @elseif($menuType === 'dropdown' && $hasChildren)
                                        {{-- DROPDOWN MENU --}}
                                        <a href="{{ $menuUrl }}" class="navigation__link" target="{{ $target }}">{{ $menuTitle }}</a>
                                        <ul class="default-menu list-unstyled">
                                            @foreach($menu->children as $child)
                                                @php
                                                    $childTitle = $child->getTranslation('title', app()->getLocale());
                                                    $childUrl = $child->getTranslation('url', app()->getLocale()) ?: '#';
                                                    $childTarget = $child->target ?: '_self';
                                                @endphp
                                                <li class="sub-menu__item">
                                                    <a href="{{ $childUrl }}" class="menu-link menu-link_us-s" target="{{ $childTarget }}">{{ $childTitle }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{-- NORMAL LINK --}}
                                        <a href="{{ $menuUrl }}" class="navigation__link" target="{{ $target }}">{{ $menuTitle }}</a>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>


