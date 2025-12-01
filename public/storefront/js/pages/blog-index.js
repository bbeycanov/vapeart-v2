/**
 * Blog Index Page - Load More Functionality
 */
(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreBtn = document.getElementById('load-more-btn');
        const btnLoadingSpinner = document.getElementById('btn-loading-spinner');
        const btnText = loadMoreBtn ? loadMoreBtn.querySelector('.btn-text') : null;
        const blogGrid = document.getElementById('blog-grid');
        const loadMoreContainer = document.getElementById('load-more-container');
        
        let isLoading = false;
        let currentPage = 2;
        let hasMore = true;
        
        if (!loadMoreBtn || !blogGrid) {
            console.warn('Load more button or blog grid not found');
            return;
        }
        
        // Get initial page from button
        if (loadMoreBtn.dataset.page) {
            currentPage = parseInt(loadMoreBtn.dataset.page) || 2;
        }
        
        // Get locale from URL path or data attribute
        let locale = 'en';
        const pathMatch = window.location.pathname.match(/^\/([a-z]{2})\//);
        if (pathMatch) {
            locale = pathMatch[1];
        } else if (loadMoreBtn.dataset.locale) {
            locale = loadMoreBtn.dataset.locale;
        } else {
            locale = document.documentElement.lang || 'en';
        }
        
        // Function to load more blogs
        function loadMoreBlogs() {
            if (isLoading || !hasMore) {
                return;
            }
            
            isLoading = true;
            
            // Show loading state
            if (loadMoreBtn) {
                loadMoreBtn.disabled = true;
                if (btnText) btnText.textContent = 'Loading...';
                if (btnLoadingSpinner) btnLoadingSpinner.classList.remove('d-none');
            }
            
            const url = `/${locale}/blog/load-more?page=${currentPage}`;
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.html && blogGrid) {
                    blogGrid.insertAdjacentHTML('beforeend', data.html);
                }
                
                hasMore = data.hasMore || false;
                
                if (hasMore && data.nextPage) {
                    currentPage = data.nextPage;
                    if (loadMoreBtn) {
                        loadMoreBtn.dataset.page = currentPage;
                    }
                } else {
                    // No more blogs, hide container
                    if (loadMoreContainer) {
                        loadMoreContainer.remove();
                    }
                }
            })
            .catch(error => {
                console.error('Error loading more blogs:', error);
                alert('An error occurred while loading more blogs. Please try again.');
            })
            .finally(() => {
                isLoading = false;
                
                // Hide loading state
                if (loadMoreBtn) {
                    loadMoreBtn.disabled = false;
                    if (btnText) btnText.textContent = 'Load More';
                    if (btnLoadingSpinner) btnLoadingSpinner.classList.add('d-none');
                }
            });
        }
        
        // Click handler for button
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function(e) {
                e.preventDefault();
                loadMoreBlogs();
            });
        }
        
        // Scroll handler for automatic loading
        let scrollTimeout;
        window.addEventListener('scroll', function() {
            clearTimeout(scrollTimeout);
            
            scrollTimeout = setTimeout(function() {
                if (isLoading || !hasMore || !loadMoreContainer) {
                    return;
                }
                
                // Get container position
                const containerRect = loadMoreContainer.getBoundingClientRect();
                const windowHeight = window.innerHeight || document.documentElement.clientHeight;
                
                // Load when container is 300px from bottom of viewport
                const threshold = 300;
                
                if (containerRect.top <= windowHeight + threshold) {
                    loadMoreBlogs();
                }
            }, 100);
        }, { passive: true });
    });
})();

