
<div class="header-mobile header_sticky">
    <div class="container d-flex align-items-center h-100">
        <a class="mobile-nav-activator d-block position-relative" href="#">
            <svg class="nav-icon" width="25" height="18" viewBox="0 0 25 18" xmlns="http://www.w3.org/2000/svg"><use href="#icon_nav" /></svg>
            <span class="btn-close-lg position-absolute top-0 start-0 w-100"></span>
        </a>

        <div class="logo">
            <a href="#">
                <img src="{{ asset('storefront/images/logo.png') }}" alt="Uomo" class="logo__image d-block">
            </a>
        </div>

        <a href="#" class="header-tools__item header-tools__cart js-open-aside" data-aside="cartDrawer">
            <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_cart" /></svg>
            <span class="cart-amount d-block position-absolute js-cart-items-count">3</span>
        </a>
    </div>

    <nav class="header-mobile__navigation navigation d-flex flex-column w-100 position-absolute top-100 bg-body overflow-auto">
        <div class="container">
            <form action="#" method="GET" class="search-field position-relative mt-4 mb-3">
                <div class="position-relative">
                    <input class="search-field__input w-100 border rounded-1" type="text" name="search-keyword" placeholder="Search products">
                    <button class="btn-icon search-popup__submit pb-0 me-2" type="submit">
                        <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_search" /></svg>
                    </button>
                    <button class="btn-icon btn-close-lg search-popup__reset pb-0 me-2" type="reset"></button>
                </div>

                <div class="position-absolute start-0 top-100 m-0 w-100">
                    <div class="search-result"></div>
                </div>
            </form>
        </div>

        <div class="container">
            <div class="overflow-hidden">
                <ul class="navigation__list list-unstyled position-relative">
                    <li class="navigation__item">
                        <a href="#" class="navigation__link js-nav-right d-flex align-items-center">Home<svg class="ms-auto" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_sm" /></svg></a>
                        <div class="sub-menu position-absolute top-0 start-100 w-100 d-none">
                            <a href="#" class="navigation__link js-nav-left d-flex align-items-center border-bottom mb-2"><svg class="me-2" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_sm" /></svg>Home</a>
                            <ul class="list-unstyled">
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 1</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 2</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 3</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 4</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 5</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 6</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 7</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 8</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 9</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 10</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 11</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 12</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 13</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 14</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 15</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 16</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 17</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 18</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 19</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 20</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 21</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 22</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 23</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="navigation__item">
                        <a href="#" class="navigation__link js-nav-right d-flex align-items-center">Shop<svg class="ms-auto" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_sm" /></svg></a>
                        <div class="sub-menu position-absolute top-0 start-100 w-100 d-none">
                            <a href="#" class="navigation__link js-nav-left d-flex align-items-center border-bottom mb-3"><svg class="me-2" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_sm" /></svg>Shop</a>
                            <div class="sub-menu__wrapper">
                                <a href="#" class="navigation__link js-nav-right d-flex align-items-center">Shop List<svg class="ms-auto" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_sm" /></svg></a>
                                <div class="sub-menu__wrapper position-absolute top-0 start-100 w-100 d-none">
                                    <a href="#" class="navigation__link js-nav-left d-flex align-items-center border-bottom mb-2"><svg class="me-2" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_sm" /></svg>Shop List</a>
                                    <ul class="sub-menu__list list-unstyled">
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V1</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V2</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V3</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V4</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V5</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V6</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V7</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V8</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V9</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Item Style</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Horizontal Scroll</a></li>
                                    </ul>
                                </div>

                                <a href="#" class="navigation__link js-nav-right d-flex align-items-center">Shop Detail<svg class="ms-auto" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_sm" /></svg></a>
                                <div class="sub-menu__wrapper position-absolute top-0 start-100 w-100 d-none">
                                    <a href="#" class="navigation__link js-nav-left d-flex align-items-center border-bottom mb-2"><svg class="me-2" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_sm" /></svg>Shop Detail</a>
                                    <ul class="sub-menu__list list-unstyled">
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V1</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V2</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V3</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V4</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V5</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V6</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V7</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V8</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V9</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V10</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V11</a></li>
                                    </ul>
                                </div>

                                <a href="#" class="navigation__link js-nav-right d-flex align-items-center">Other Pages<svg class="ms-auto" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_sm" /></svg></a>
                                <div class="sub-menu__wrapper position-absolute top-0 start-100 w-100 d-none">
                                    <a href="#" class="navigation__link js-nav-left d-flex align-items-center border-bottom mb-2"><svg class="me-2" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_sm" /></svg>Other Pages</a>
                                    <ul class="sub-menu__list list-unstyled">
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Collection Grid</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Simple Product</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Variable Product</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">External Product</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Grouped Product</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">On Sale</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Out of Stock</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shopping Cart</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Checkout</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Order Complete</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Order Tracking</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="navigation__item">
                        <a href="#" class="navigation__link js-nav-right d-flex align-items-center">Blog<svg class="ms-auto" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_sm" /></svg></a>
                        <div class="sub-menu position-absolute top-0 start-100 w-100 d-none">
                            <a href="#" class="navigation__link js-nav-left d-flex align-items-center border-bottom mb-2"><svg class="me-2" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_sm" /></svg>Blog</a>
                            <ul class="list-unstyled">
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Blog V1</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Blog V2</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Blog V3</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Blog Detail</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="navigation__item">
                        <a href="#" class="navigation__link js-nav-right d-flex align-items-center">Pages<svg class="ms-auto" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_next_sm" /></svg></a>
                        <div class="sub-menu position-absolute top-0 start-100 w-100 d-none">
                            <a href="#" class="navigation__link js-nav-left d-flex align-items-center border-bottom mb-2"><svg class="me-2" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg"><use href="#icon_prev_sm" /></svg>Pages</a>
                            <ul class="list-unstyled">
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">My Account</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Login / Register</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Store Locator</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Lookbook</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Faq</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Terms</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">404 Error</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Coming Soon</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="navigation__item">
                        <a href="#" class="navigation__link">About</a>
                    </li>

                    <li class="navigation__item">
                        <a href="#" class="navigation__link">Contact</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-top mt-auto pb-2">
            <div class="container d-flex align-items-center">
                <label for="footerSettingsLanguage_mobile" class="me-2 text-secondary">Language</label>
                <select id="footerSettingsLanguage_mobile" class="form-select form-select-sm bg-transparent border-0" aria-label="Default select example" name="store-language">
                    @foreach($languages as $lang)
                        <option class="footer-select__option" selected>
                            <a href="{{ localized_url($lang['code']) }}">
                                {{ $lang['native_name'] ?? strtoupper($lang['code']) }}
                            </a>
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
                    <a href="#">
                        <img src="{{ asset('storefront/images/logo-white.png') }}" alt="Uomo" class="logo__image">
                    </a>
                </div>

                <form action="./" method="GET" class="header-search search-field">
                    <input class="header-search__input w-100" type="text" name="search-keyword" placeholder="Search products...">

                    <button class="btn header-search__btn" type="submit">
                        <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><use href="#icon_search" /></svg>
                    </button>
                </form>

                <div class="header-tools d-flex align-items-center">


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
                        <li class="navigation__item">
                            <a href="#" class="navigation__link">Home</a>
                            <div class="box-menu" style="width: 800px;">
                                <div class="col pe-4">
                                    <ul class="sub-menu__list list-unstyled">
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 1</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 2</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 3</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 4</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 5</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 6</a></li>
                                    </ul>
                                </div>

                                <div class="col pe-4">
                                    <ul class="sub-menu__list list-unstyled">
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 7</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 8</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 9</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 10</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 11</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 12</a></li>
                                    </ul>
                                </div>

                                <div class="col pe-4">
                                    <ul class="sub-menu__list list-unstyled">
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 13</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 14</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 15</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 16</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 17</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 18</a></li>
                                    </ul>
                                </div>

                                <div class="col">
                                    <ul class="sub-menu__list list-unstyled">
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 19</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 20</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 21</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 22</a></li>
                                        <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Home 23</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="navigation__item">
                            <a href="#" class="navigation__link">Shop</a>
                            <div class="mega-menu">
                                <div class="container d-flex">
                                    <div class="col pe-4">
                                        <a href="#" class="sub-menu__title">Shop List</a>
                                        <ul class="sub-menu__list list-unstyled">
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V1</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V2</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V3</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V4</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V5</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V6</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V7</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V8</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop List V9</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Item Style</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Horizontal Scroll</a></li>
                                        </ul>
                                    </div>

                                    <div class="col pe-4">
                                        <a href="#" class="sub-menu__title">Shop Detail</a>
                                        <ul class="sub-menu__list list-unstyled">
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V1</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V2</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V3</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V4</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V5</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V6</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V7</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V8</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V9</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V10</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop Detail V11</a></li>
                                        </ul>
                                    </div>

                                    <div class="col pe-4">
                                        <a href="#" class="sub-menu__title">Other Pages</a>
                                        <ul class="sub-menu__list list-unstyled">
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Collection Grid</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Simple Product</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Variable Product</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">External Product</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Grouped Product</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">On Sale</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Out of Stock</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shopping Cart</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Checkout</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Order Complete</a></li>
                                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Order Tracking</a></li>
                                        </ul>
                                    </div>

                                    <div class="mega-menu__media col">
                                        <div class="position-relative">
                                            <img loading="lazy" class="mega-menu__img" src="{{ asset('storefront/images/mega-menu-item.jpg') }}" alt="New Horizons">
                                            <div class="mega-menu__media-content content_abs content_left content_bottom">
                                                <h3>NEW</h3>
                                                <h3 class="mb-0">HORIZONS</h3>
                                                <a href="#" class="btn-link default-underline fw-medium">SHOP NOW</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="navigation__item">
                            <a href="#" class="navigation__link">Blog</a>
                            <ul class="default-menu list-unstyled">
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Blog V1</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Blog V2</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Blog V3</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Blog Detail</a></li>
                            </ul>
                        </li>
                        <li class="navigation__item">
                            <a href="#" class="navigation__link">Pages</a>
                            <ul class="default-menu list-unstyled">
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">My Account</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Login / Register</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Store Locator</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Lookbook</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Faq</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Terms</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">404 Error</a></li>
                                <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Coming Soon</a></li>
                            </ul>
                        </li>
                        <li class="navigation__item">
                            <a href="#" class="navigation__link">About</a>
                        </li>
                        <li class="navigation__item">
                            <a href="#" class="navigation__link">Contact</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>

