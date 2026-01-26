(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const brandPills = document.querySelectorAll('.brand-pill');
        const productsGrid = document.getElementById('products-grid');
        const productsContainer = document.getElementById('products-container');
        const brandActionArea = document.getElementById('brand-action-area');
        const productsCountBadge = document.getElementById('products-count');

        // Get data from window object (set by blade)
        const locale = window.categoryShowPageData?.locale || 'en';
        const categorySlug = window.categoryShowPageData?.categorySlug || '';
        const brands = window.categoryShowPageData?.brands || {};
        let currentBrandId = window.categoryShowPageData?.currentBrandId || null;

        let isLoading = false;
        let currentPage = 1;
        let infiniteScrollObserver = null;

        // Scroll active pill into view on load
        const activePill = document.querySelector('.brand-pill.btn-dark');
        if (activePill) {
            setTimeout(() => {
                activePill.scrollIntoView({ behavior: 'auto', block: 'nearest', inline: 'center' });
            }, 100);
        }

        // Brand scroll arrows functionality
        initBrandScrollArrows();

        // Initialize Infinite Scroll
        initInfiniteScroll();

        function initBrandScrollArrows() {
            const scrollWrapper = document.getElementById('brandScrollWrapper');
            const leftArrow = document.querySelector('.brand-scroll-left');
            const rightArrow = document.querySelector('.brand-scroll-right');

            if (!scrollWrapper) return;

            const scrollAmount = 200;

            // Update arrows visibility based on scroll position
            function updateArrowsVisibility() {
                const { scrollLeft, scrollWidth, clientWidth } = scrollWrapper;
                const maxScroll = scrollWidth - clientWidth;

                if (leftArrow) {
                    leftArrow.style.opacity = scrollLeft > 10 ? '1' : '0.3';
                    leftArrow.style.pointerEvents = scrollLeft > 10 ? 'auto' : 'none';
                }

                if (rightArrow) {
                    rightArrow.style.opacity = scrollLeft < maxScroll - 10 ? '1' : '0.3';
                    rightArrow.style.pointerEvents = scrollLeft < maxScroll - 10 ? 'auto' : 'none';
                }
            }

            // Arrow click/touch handlers
            function scrollLeft() {
                scrollWrapper.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            }

            function scrollRight() {
                scrollWrapper.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }

            if (leftArrow) {
                leftArrow.addEventListener('click', scrollLeft);
                leftArrow.addEventListener('touchend', function(e) {
                    e.preventDefault();
                    scrollLeft();
                });
            }

            if (rightArrow) {
                rightArrow.addEventListener('click', scrollRight);
                rightArrow.addEventListener('touchend', function(e) {
                    e.preventDefault();
                    scrollRight();
                });
            }

            // Listen for scroll events
            scrollWrapper.addEventListener('scroll', updateArrowsVisibility);

            // Initial check
            setTimeout(updateArrowsVisibility, 200);

            // Update on resize
            window.addEventListener('resize', updateArrowsVisibility);
        }

        // Brand Pill Click Handler
        brandPills.forEach(pill => {
            pill.addEventListener('click', function() {
                if (isLoading) return;
                if (this.classList.contains('btn-dark') && this.dataset.brandId !== '') return; // Already active

                const brandId = this.dataset.brandId ? parseInt(this.dataset.brandId) : null;

                // UI Updates for Pills
                brandPills.forEach(p => {
                    p.classList.remove('btn-dark');
                    p.classList.add('btn-outline-light', 'text-dark', 'border-secondary-subtle');
                });
                this.classList.remove('btn-outline-light', 'text-dark', 'border-secondary-subtle');
                this.classList.add('btn-dark');

                // Center the active pill
                this.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });

                // Update State
                currentBrandId = brandId;
                currentPage = 1;

                // Logic
                loadProducts(true);
                updateBrandActionArea(brandId);
            });
        });

        function initInfiniteScroll() {
            // Disconnect existing observer if any
            if (infiniteScrollObserver) {
                infiniteScrollObserver.disconnect();
            }

            const trigger = document.getElementById('infinite-scroll-trigger');
            const loadMoreBtn = document.getElementById('load-more-btn');

            // Only initialize if we have a trigger and a button with a next page
            if (trigger && loadMoreBtn && loadMoreBtn.dataset.page) {
                const options = {
                    root: null,
                    rootMargin: '200px', // Load 200px before reaching bottom
                    threshold: 0.1
                };

                infiniteScrollObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && !isLoading) {
                            const btn = document.getElementById('load-more-btn');
                            if (btn && btn.dataset.page) {
                                currentPage = parseInt(btn.dataset.page);
                                loadProducts(false);
                            }
                        }
                    });
                }, options);

                infiniteScrollObserver.observe(trigger);
            }
        }

        function updateBrandActionArea(brandId) {
            if (brandId && brands[brandId]) {
                const brand = brands[brandId];
                const brandUrl = `/${locale}/brand/${brand.slug}`;
                const visitText = window.categoryShowPageData?.visitText || 'Visit';
                const pageText = window.categoryShowPageData?.pageText || 'Page';

                brandActionArea.innerHTML = `
                    <a href="${brandUrl}" class="btn btn-sm btn-link text-decoration-none d-flex align-items-center text-dark fw-medium px-0 animate__animated animate__fadeIn">
                        ${visitText} ${brand.name} ${pageText}
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="ms-1">
                            <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                `;
                brandActionArea.classList.remove('d-none');
            } else {
                brandActionArea.classList.add('d-none');
                brandActionArea.innerHTML = '';
            }
        }

        function loadProducts(reset = false) {
            if (isLoading) return;
            isLoading = true;

            // Loading UI
            if (reset) {
                if (productsGrid) productsGrid.classList.add('loading');
                if (productsContainer) productsContainer.style.opacity = '0.5';
            } else {
                // Show spinner for infinite scroll
                const spinner = document.getElementById('btn-loading-spinner');
                if (spinner) spinner.classList.remove('d-none');
            }

            // URL Params
            const params = new URLSearchParams();
            params.set('page', currentPage);
            if (currentBrandId) params.set('brand_id', currentBrandId);
            params.set('_t', new Date().getTime());

            const url = `/${locale}/category/${categorySlug}?${params.toString()}`;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(res => {
                if(!res.ok) throw new Error('Network error');
                return res.text();
            })
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const newGrid = doc.getElementById('products-grid');
                const newPagination = doc.querySelector('.load-more-section');
                const newCount = doc.getElementById('products-count');

                // Update Count
                if (productsCountBadge && newCount) {
                    productsCountBadge.textContent = newCount.textContent;
                }

                if (reset) {
                    // Full Replace
                    if (productsContainer) {
                        if(newGrid) {
                            productsContainer.innerHTML = '';
                            productsContainer.appendChild(newGrid);

                            if (newPagination) {
                                productsContainer.appendChild(newPagination);
                            }
                        } else {
                             const emptyState = doc.querySelector('.empty-state');
                             if(emptyState) {
                                 productsContainer.innerHTML = '';
                                 productsContainer.appendChild(emptyState);
                             }
                        }
                    }

                    // URL History Update
                    const newUrl = new URL(window.location);
                    if (currentBrandId) newUrl.searchParams.set('brand_id', currentBrandId);
                    else newUrl.searchParams.delete('brand_id');
                    newUrl.searchParams.delete('page');
                    window.history.pushState({}, '', newUrl);

                } else {
                    // Append - get fresh reference since grid may have been replaced
                    const currentProductsGrid = document.getElementById('products-grid');
                    if (newGrid && currentProductsGrid) {
                        currentProductsGrid.insertAdjacentHTML('beforeend', newGrid.innerHTML);
                    }

                    // Update Pagination Section
                    const currentPagination = document.querySelector('.load-more-section');
                    if (currentPagination) currentPagination.remove();

                    if (newPagination && productsContainer) {
                        productsContainer.appendChild(newPagination);
                    }
                }

                // Re-initialize infinite scroll observer for the new content/trigger
                setTimeout(initInfiniteScroll, 100);
            })
            .catch(err => console.error(err))
            .finally(() => {
                isLoading = false;
                if (reset) {
                    if (productsGrid) productsGrid.classList.remove('loading');
                    if (productsContainer) productsContainer.style.opacity = '1';
                } else {
                     // Hide spinner
                     const spinner = document.getElementById('btn-loading-spinner');
                     if (spinner) spinner.classList.add('d-none');
                }
            });
        }
    });
})();

