@php
    $locale = app()->getLocale();
@endphp

<style>
#siteMap .modal-body {
    max-height: calc(100vh - 60px);
    overflow-y: auto;
    background: #ffffff;
    padding: 2rem 1rem !important;
}

/* Menu Card - Individual Cards */
.menu-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: #2d3748;
    transition: all 0.3s ease;
    padding: 2rem 1rem;
    border-radius: 16px;
    position: relative;
    background: #fff;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.menu-card:hover {
    border-color: #cbd5e0;
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    transform: translateY(-5px);
}

.menu-card__icon {
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 18px;
    margin-bottom: 0.75rem;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.menu-card:hover .menu-card__icon {
    transform: scale(1.1);
    box-shadow: 0 12px 30px rgba(0,0,0,0.25);
}

.menu-card__icon svg {
    transition: all 0.3s ease;
}

.menu-card__title {
    font-size: 13px;
    font-weight: 600;
    text-align: center;
    margin-top: 0.25rem;
    color: #2d3748;
}

.menu-card__badge {
    position: absolute;
    top: 8px;
    right: 8px;
    color: #fff;
    font-size: 9px;
    font-weight: 800;
    padding: 4px 10px;
    border-radius: 12px;
    letter-spacing: 0.5px;
    z-index: 2;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.badge-new {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    animation: bounce 2s ease-in-out infinite;
}

.badge-sale {
    background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
    animation: pulse 2s ease-in-out infinite;
}

/* Color Variants - Vibrant & Modern */
.menu-card--blue .menu-card__icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
}

.menu-card--purple .menu-card__icon {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: #fff;
}

.menu-card--orange .menu-card__icon {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    color: #fff;
}

.menu-card--pink .menu-card__icon {
    background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
    color: #fff;
}

.menu-card--green .menu-card__icon {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: #fff;
}

.menu-card--red .menu-card__icon {
    background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
    color: #fff;
}

.menu-card--teal .menu-card__icon {
    background: linear-gradient(135deg, #0ba360 0%, #3cba92 100%);
    color: #fff;
}

.menu-card--indigo .menu-card__icon {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: #fff;
}

.menu-card--rose .menu-card__icon {
    background: linear-gradient(135deg, #f857a6 0%, #ff5858 100%);
    color: #fff;
}

.menu-card--cyan .menu-card__icon {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: #fff;
}

.menu-card--yellow .menu-card__icon {
    background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
    color: #fff;
}

/* Animations */
@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.08);
    }
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-4px);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .menu-card {
        padding: 1.5rem 0.8rem;
    }
    
    .menu-card__icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
    }
    
    .menu-card__icon svg {
        width: 28px;
        height: 28px;
    }
    
    .menu-card__title {
        font-size: 12px;
    }
}

@media (max-width: 576px) {
    #siteMap .modal-body {
        padding: 1rem !important;
    }
    
    .menu-card {
        padding: 1.2rem 0.6rem;
    }
    
    .menu-card__icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
    }
    
    .menu-card__icon svg {
        width: 24px;
        height: 24px;
    }
    
    .menu-card__title {
        font-size: 11px;
    }
    
    .menu-card__badge {
        font-size: 8px;
        padding: 3px 8px;
    }
}
</style>

<div class="modal fade" id="siteMap" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-uppercase fw-bold">{{ __('common.Menu') }}</h5>
                <button type="button" class="btn-close-lg" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <div class="container">
                    <div class="row g-4">
                        {{-- 1. Ana Sayfa --}}
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ route('home', $locale) }}" class="menu-card menu-card--blue">
                                <div class="menu-card__icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <polyline points="9 22 9 12 15 12 15 22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="menu-card__title">{{ __('navigation.Home') }}</div>
                            </a>
                        </div>
                        
                        {{-- 2. Ürünler --}}
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ route('products.index', $locale) }}" class="menu-card menu-card--purple">
                                <div class="menu-card__icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="3" y="3" width="7" height="7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <rect x="14" y="3" width="7" height="7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <rect x="14" y="14" width="7" height="7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <rect x="3" y="14" width="7" height="7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="menu-card__title">{{ __('navigation.Products') }}</div>
                            </a>
                        </div>
                        
                        {{-- 3. Kategoriler --}}
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ route('categories.index', $locale) }}" class="menu-card menu-card--orange">
                                <div class="menu-card__icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 4h7v7H4zM13 4h7v7h-7zM4 13h7v7H4zM13 13h7v7h-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="menu-card__title">{{ __('navigation.Categories') }}</div>
                            </a>
                    </div>

                        {{-- 4. Markalar --}}
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ route('brands.index', $locale) }}" class="menu-card menu-card--pink">
                                <div class="menu-card__icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2L2 7l10 5 10-5-10-5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="menu-card__title">{{ __('navigation.Brands') }}</div>
                            </a>
                        </div>
                        
                        {{-- 5. Yeni Məhsullar --}}
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ route('new-products.index', $locale) }}" class="menu-card menu-card--green">
                                <div class="menu-card__icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                        <path d="M12 8v8m-4-4h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                        </div>
                                <div class="menu-card__title">{{ __('page.New Products') }}</div>
                                <span class="menu-card__badge badge-new">NEW</span>
                            </a>
                                        </div>
                        
                        {{-- 6. Endirimli Məhsullar --}}
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ route('discounts.index', $locale) }}" class="menu-card menu-card--red">
                                <div class="menu-card__icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="7" cy="7" r="1.5" fill="currentColor"/>
                                    </svg>
                                        </div>
                                <div class="menu-card__title">{{ __('page.Discounted Products') }}</div>
                                <span class="menu-card__badge badge-sale">SALE</span>
                            </a>
                                    </div>
                        
                        {{-- 7. Blog --}}
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ route('blog.index', $locale) }}" class="menu-card menu-card--teal">
                                <div class="menu-card__icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <polyline points="14 2 14 8 20 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <line x1="16" y1="13" x2="8" y2="13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <line x1="16" y1="17" x2="8" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="menu-card__title">{{ __('navigation.Blog') }}</div>
                            </a>
                            </div>
                        
                        {{-- 8. Əlaqə --}}
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ route('contacts.index', $locale) }}" class="menu-card menu-card--indigo">
                                <div class="menu-card__icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="menu-card__title">{{ __('navigation.Contact') }}</div>
                            </a>
                        </div>
                        
                        {{-- 9. Wishlist --}}
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ route('wishlist.index', $locale) }}" class="menu-card menu-card--rose">
                                <div class="menu-card__icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="menu-card__title">{{ __('navigation.Wishlist') }}</div>
                            </a>
                        </div>
                        
                        {{-- 10. Cart --}}
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ route('cart.index', $locale) }}" class="menu-card menu-card--cyan">
                                <div class="menu-card__icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="9" cy="21" r="1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="20" cy="21" r="1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="menu-card__title">{{ __('navigation.Cart') }}</div>
                            </a>
                        </div>
                        
                        {{-- 11. Search --}}
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ route('search.index', $locale) }}" class="menu-card menu-card--yellow">
                                <div class="menu-card__icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="menu-card__title">{{ __('common.Search') }}</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

