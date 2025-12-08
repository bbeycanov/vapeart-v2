(function() {
    'use strict';

    // Get page data
    const pageData = window.searchPageData || {};
    let currentPage = pageData.currentPage || 1;
    let hasMorePages = pageData.hasMorePages || false;
    let isLoading = false;

    // DOM elements
    const productsGrid = document.getElementById('products-grid');
    const loadMoreSection = document.getElementById('load-more-section');
    const infiniteScrollTrigger = document.getElementById('infinite-scroll-trigger');
    const loadingSpinner = document.getElementById('btn-loading-spinner');

    /**
     * Load more products
     */
    async function loadMoreProducts() {
        if (isLoading || !hasMorePages) return;

        isLoading = true;
        if (loadingSpinner) {
            loadingSpinner.classList.remove('d-none');
        }

        try {
            const nextPage = currentPage + 1;
            const params = new URLSearchParams({
                page: nextPage,
                q: pageData.query || ''
            });

            const response = await fetch(`${pageData.loadMoreUrl}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const html = await response.text();

            // Create a temporary container to parse the HTML
            const tempContainer = document.createElement('div');
            tempContainer.innerHTML = html;

            // Get the product cards from the response
            const newProducts = tempContainer.querySelectorAll('.product-card-wrapper, .col');

            if (newProducts.length > 0) {
                newProducts.forEach(product => {
                    productsGrid.appendChild(product);
                });

                currentPage = nextPage;

                // Check if there are more pages by looking at the response
                // If we got fewer products than expected, assume no more pages
                if (newProducts.length < 24) {
                    hasMorePages = false;
                    if (loadMoreSection) {
                        loadMoreSection.style.display = 'none';
                    }
                }

                // Re-initialize any product card functionality
                if (typeof window.initProductCards === 'function') {
                    window.initProductCards();
                }

                // Re-initialize wishlist buttons
                if (typeof window.initWishlistButtons === 'function') {
                    window.initWishlistButtons();
                }

                // Re-initialize quick view buttons
                if (typeof window.initQuickViewButtons === 'function') {
                    window.initQuickViewButtons();
                }
            } else {
                hasMorePages = false;
                if (loadMoreSection) {
                    loadMoreSection.style.display = 'none';
                }
            }
        } catch (error) {
            console.error('Error loading more products:', error);
        } finally {
            isLoading = false;
            if (loadingSpinner) {
                loadingSpinner.classList.add('d-none');
            }
        }
    }

    /**
     * Initialize Intersection Observer for infinite scroll
     */
    function initInfiniteScroll() {
        if (!infiniteScrollTrigger || !hasMorePages) return;

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && hasMorePages && !isLoading) {
                        loadMoreProducts();
                    }
                });
            },
            {
                root: null,
                rootMargin: '200px',
                threshold: 0
            }
        );

        observer.observe(infiniteScrollTrigger);
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initInfiniteScroll);
    } else {
        initInfiniteScroll();
    }
})();
