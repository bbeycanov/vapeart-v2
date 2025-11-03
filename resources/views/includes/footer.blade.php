<footer class="footer footer_type_1 theme-bg-color-secondary text-white">
    <div class="footer-middle container">
        <div class="row row-cols-lg-5 row-cols-2">
            <div class="footer-column footer-store-info col-12 mb-4 mb-lg-0">
                <div class="logo">
                    <a href="#">
                        <img src="{{ asset('storefront/images/logo-white.png') }}" alt="Uomo" class="logo__image d-block">
                    </a>
                </div>
                <p class="footer-address">{{settings('site.address')}}</p>

                <p class="m-0">
                    <strong class="fw-medium">{{settings('site.email')}}</strong>
                </p>
                <p>
                    <strong class="fw-medium">{{settings('site.phone')}}</strong>
                </p>

                <ul class="social-links list-unstyled d-flex flex-wrap mb-0">
                    <li>
                        <a href="{{settings('facebook')}}" class="footer__social-link d-block text-white">
                            <svg class="svg-icon svg-icon_facebook" width="9" height="15" viewBox="0 0 9 15"
                                 xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_facebook"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="{{settings('twitter')}}" class="footer__social-link d-block text-white">
                            <svg class="svg-icon svg-icon_twitter" width="14" height="13" viewBox="0 0 14 13"
                                 xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_twitter"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="{{settings('instagram')}}" class="footer__social-link d-block text-white">
                            <svg class="svg-icon svg-icon_instagram" width="14" height="13" viewBox="0 0 14 13"
                                 xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_instagram"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="{{settings('youtube')}}" class="footer__social-link d-block text-white">
                            <svg class="svg-icon svg-icon_youtube" width="16" height="11" viewBox="0 0 16 11"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.0117 1.8584C14.8477 1.20215 14.3281 0.682617 13.6992 0.518555C12.5234 0.19043 7.875 0.19043 7.875 0.19043C7.875 0.19043 3.19922 0.19043 2.02344 0.518555C1.39453 0.682617 0.875 1.20215 0.710938 1.8584C0.382812 3.00684 0.382812 5.46777 0.382812 5.46777C0.382812 5.46777 0.382812 7.90137 0.710938 9.07715C0.875 9.7334 1.39453 10.2256 2.02344 10.3896C3.19922 10.6904 7.875 10.6904 7.875 10.6904C7.875 10.6904 12.5234 10.6904 13.6992 10.3896C14.3281 10.2256 14.8477 9.7334 15.0117 9.07715C15.3398 7.90137 15.3398 5.46777 15.3398 5.46777C15.3398 5.46777 15.3398 3.00684 15.0117 1.8584ZM6.34375 7.68262V3.25293L10.2266 5.46777L6.34375 7.68262Z"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="{{settings('pinterest')}}" class="footer__social-link d-block text-white">
                            <svg class="svg-icon svg-icon_pinterest" width="14" height="15" viewBox="0 0 14 15"
                                 xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_pinterest"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="footer-column footer-menu mb-4 mb-lg-0">
                <h6 class="sub-menu__title text-uppercase">Company</h6>
                <ul class="sub-menu__list list-unstyled">
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">About Us</a></li>
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">Careers</a></li>
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">Affiliates</a>
                    </li>
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">Blog</a></li>
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">Contact Us</a>
                    </li>
                </ul>
            </div>

            <div class="footer-column footer-menu mb-4 mb-lg-0">
                <h6 class="sub-menu__title text-uppercase">Shop</h6>
                <ul class="sub-menu__list list-unstyled">
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">New Arrivals</a>
                    </li>
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">Accessories</a>
                    </li>
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">Men</a></li>
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">Women</a></li>
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">Shop All</a></li>
                </ul>
            </div>

            <div class="footer-column footer-menu mb-4 mb-lg-0">
                <h6 class="sub-menu__title text-uppercase">Help</h6>
                <ul class="sub-menu__list list-unstyled">
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">Customer
                            Service</a></li>
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">My Account</a>
                    </li>
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">Find a Store</a>
                    </li>
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">Legal &
                            Privacy</a></li>
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">Contact</a></li>
                    <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s text-white">Gift Card</a>
                    </li>
                </ul>
            </div>

            <div class="footer-column footer-newsletter col-12 mb-4 mb-lg-0">
                <h6 class="sub-menu__title text-uppercase">Subscribe</h6>
                <p>Be the first to get the latest news about trends, promotions, and much more!</p>
                <form action="#" class="footer-newsletter__form position-relative bg-body">
                    <input class="form-control border-white" type="email" name="email" placeholder="Your email address">
                    <input class="btn-link fw-medium bg-white position-absolute top-0 end-0 h-100" type="submit"
                           value="JOIN">
                </form>

                <div class="mt-4 pt-3 d-flex align-items-center justify-content-around gap-3 flex-wrap">
                    <a href="https://www.apple.com/app-store/" target="_blank"
                       class="app-download-link no-bg text-white">
                        <svg width="28" height="33" viewBox="0 0 28 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M27.207 23.7305C26.0547 23.3789 25.0195 22.5586 24.1211 21.2695C23.2227 19.9805 22.7734 18.5156 22.7734 16.9141C22.7734 15.4297 23.2031 14.082 24.043 12.8711C24.5117 12.1875 25.2539 11.4258 26.2695 10.5664C25.6055 9.74609 24.9219 9.08203 24.2383 8.61328C23.0273 7.77344 21.6406 7.34375 20.0781 7.34375C19.1211 7.34375 17.9883 7.57812 16.6992 8.00781C15.4102 8.45703 14.4727 8.67188 13.9063 8.67188C13.457 8.67188 12.5586 8.47656 11.2109 8.08594C9.84375 7.69531 8.71094 7.5 7.75391 7.5C5.50781 7.5 3.67188 8.4375 2.20703 10.3125C0.742188 12.207 0 14.6289 0 17.6172C0 20.8203 0.976563 24.082 2.87109 27.4414C4.80469 30.8008 6.73828 32.5 8.75 32.5C9.39453 32.5 10.2539 32.2852 11.3281 31.8359C12.3828 31.4063 13.3203 31.1914 14.1016 31.1914C14.9023 31.1914 15.8984 31.3867 17.0508 31.8164C18.2227 32.2266 19.1211 32.4414 19.7852 32.4414C21.4453 32.4414 23.125 31.1719 24.8047 28.6133C25.9375 26.9141 26.7188 25.2734 27.207 23.7305ZM19.8633 0.820312C19.8633 0.683593 19.8438 0.566405 19.8438 0.429687C19.8242 0.312499 19.7852 0.17578 19.7461 -2.38419e-06C17.4805 0.527342 15.8398 1.48437 14.8633 2.89062C13.8867 4.29687 13.3789 5.97656 13.3398 7.91015C14.2578 7.83203 14.9219 7.71484 15.3711 7.57812C16.0742 7.34375 16.7773 6.875 17.4805 6.17187C18.3008 5.35156 18.9063 4.45312 19.2969 3.47656C19.668 2.51953 19.8633 1.62109 19.8633 0.820312Z"
                                fill="#fff"/>
                        </svg>
                        <span class="app-download-text">
                <span>Download on the</span>
                <strong>Apple Store</strong>
              </span>
                    </a>
                    <a href="https://play.google.com/store/apps" target="_blank"
                       class="app-download-link no-bg text-white">
                        <svg width="28" height="31" viewBox="0 0 28 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M18.043 14.5195L5.09375 1.51172L21.5586 11.0039L18.043 14.5195ZM1.75391 0.75L16.7539 15.75L1.75391 30.75C0.992188 30.3984 0.464844 29.6367 0.464844 28.6992V2.85938C0.464844 1.92188 0.992188 1.16016 1.75391 0.75ZM26.6562 13.9922C27.7695 14.8125 27.7695 16.7461 26.7148 17.5664L23.1992 19.5586L19.332 15.75L23.1992 12L26.6562 13.9922ZM5.09375 29.9883L18.043 17.0391L21.5586 20.5547L5.09375 29.9883Z"
                                fill="#fff"/>
                        </svg>
                        <span class="app-download-text">
                <span>Get it on</span>
                <strong>Google Play</strong>
              </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom container" style="border-top-color: rgba(255,255,255,.1);">
        <div class="d-block d-md-flex align-items-center">
            <span class="footer-copyright me-auto">©2025 VapeartBaku.com</span>
            <div class="footer-settings d-block d-md-flex align-items-center">
                <div class="d-flex align-items-center">
                    <label for="footerSettingsLanguage" class="me-2 text-white">Language</label>
                    <select id="footerSettingsLanguage"
                            class="form-select form-select-sm bg-transparent border-0 color-white"
                            aria-label="Default select example" name="store-language">
                        @foreach($languages as $lang)
                            <option class="footer-select__option" selected>
                                <a href="{{ localized_url($lang['code']) }}">
                                    {{ $lang['native_name'] ?? strtoupper($lang['code']) }}
                                </a>
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</footer>


<footer class="footer-mobile container w-100 px-5 d-md-none bg-body">
    <div class="row text-center">
        <div class="col-3">
            <a href="/" class="footer-mobile__link d-flex flex-column align-items-center">
                <svg class="d-block" width="18" height="18" viewBox="0 0 18 18" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_home"/>
                </svg>
                <span>Home</span>
            </a>
        </div>

        <div class="col-3">
            <a href="/" class="footer-mobile__link d-flex flex-column align-items-center">
                <svg class="d-block" width="18" height="18" viewBox="0 0 18 18" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_hanger"/>
                </svg>
                <span>Categories</span>
            </a>
        </div>

        <div class="col-3">
            <a href="/" class="footer-mobile__link d-flex flex-column align-items-center">
                <div class="position-relative">
                    <svg class="d-block" width="18" height="18" viewBox="0 0 20 20" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_headphone"/>
                    </svg>
                </div>
                <span>Phone</span>
            </a>
        </div>
        <div class="col-3">
            <a href="/" class="footer-mobile__link d-flex flex-column align-items-center">
                <div class="position-relative">
                    <svg class="d-block" width="18" height="18" viewBox="0 0 20 20" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_search"/>
                    </svg>
                </div>
                <span>Search</span>
            </a>
        </div>
    </div>
</footer>
