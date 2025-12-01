/**
 * Products Index Page - Filtering and Infinite Scroll
 */
(function() {
    'use strict';
    
    // Wait for DOM and data to be ready
    function init() {
        // Get data from window
        const data = window.productsPageData || {};
        const locale = data.locale || 'en';
        
        // State
        let selectedCategoryIds = [];
        let selectedBrandIds = [];
        let priceMin = null;
        let priceMax = null;
        let currentSort = null;
        let currentPage = 1;
        let isLoading = false;
        let infiniteScrollObserver = null;
        
        console.log('Products page initialized', data);
        
        // Initialize from URL on page load
        initFiltersFromURL();
        
        // Initialize all features
        initCategoryFilter();
        initCategorySearch();
        initBrandFilter();
        initBrandSearch();
        initPriceFilter();
        initSortSelect();
        initInfiniteScroll();
        initClearFilters();
        
        /**
         * Initialize filters from URL parameters
         */
        function initFiltersFromURL() {
            const params = new URLSearchParams(window.location.search);
            
            // Get category IDs
            const categoryIds = params.getAll('category_ids[]');
            if (categoryIds.length > 0) {
                selectedCategoryIds = categoryIds.map(id => parseInt(id));
            }
            
            // Get brand IDs
            const brandIds = params.getAll('brand_ids[]');
            if (brandIds.length > 0) {
                selectedBrandIds = brandIds.map(id => parseInt(id));
            }
            
            // Get price range
            if (params.has('price_min')) {
                priceMin = parseFloat(params.get('price_min'));
            }
            if (params.has('price_max')) {
                priceMax = parseFloat(params.get('price_max'));
            }
            
            // Get sort
            if (params.has('sort')) {
                currentSort = params.get('sort');
            }
            
            console.log('Initialized filters from URL:', {
                categories: selectedCategoryIds,
                brands: selectedBrandIds,
                priceMin,
                priceMax,
                sort: currentSort
            });
        }
        
        /**
         * Initialize category filter
         */
        function initCategoryFilter() {
            const checkboxes = document.querySelectorAll('.category-checkbox');
            console.log('Category checkboxes found:', checkboxes.length);
            
            checkboxes.forEach(checkbox => {
                const categoryId = parseInt(checkbox.getAttribute('data-category-id'));
                
                // Set initial state from URL
                if (selectedCategoryIds.includes(categoryId)) {
                    checkbox.checked = true;
                }
                
                // Add change listener
                checkbox.addEventListener('change', function() {
                    const id = parseInt(this.getAttribute('data-category-id'));
                    
                    if (this.checked) {
                        if (!selectedCategoryIds.includes(id)) {
                            selectedCategoryIds.push(id);
                        }
                    } else {
                        selectedCategoryIds = selectedCategoryIds.filter(cid => cid !== id);
                    }
                    
                    console.log('Categories selected:', selectedCategoryIds);
                    applyFilters();
                });
            });
        }
        
        /**
         * Initialize category search
         */
        function initCategorySearch() {
            const searchInput = document.getElementById('categorySearchInput');
            if (!searchInput) return;
            
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                const categoryItems = document.querySelectorAll('.category-filter-item');
                
                categoryItems.forEach(item => {
                    const categoryName = item.querySelector('.category-name')?.textContent.toLowerCase() || '';
                    item.style.display = (searchTerm === '' || categoryName.includes(searchTerm)) ? '' : 'none';
                });
            });
        }
        
        /**
         * Initialize brand filter
         */
        function initBrandFilter() {
            const checkboxes = document.querySelectorAll('.brand-checkbox');
            console.log('Brand checkboxes found:', checkboxes.length);
            
            checkboxes.forEach(checkbox => {
                const brandId = parseInt(checkbox.getAttribute('data-brand-id'));
                
                // Set initial state from URL
                if (selectedBrandIds.includes(brandId)) {
                    checkbox.checked = true;
                }
                
                // Add change listener
                checkbox.addEventListener('change', function() {
                    const id = parseInt(this.getAttribute('data-brand-id'));
                    
                    if (this.checked) {
                        if (!selectedBrandIds.includes(id)) {
                            selectedBrandIds.push(id);
                        }
                    } else {
                        selectedBrandIds = selectedBrandIds.filter(bid => bid !== id);
                    }
                    
                    console.log('Brands selected:', selectedBrandIds);
                    applyFilters();
                });
            });
        }
        
        /**
         * Initialize brand search
         */
        function initBrandSearch() {
            const searchInput = document.getElementById('brandSearchInput');
            if (!searchInput) return;
            
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                const brandItems = document.querySelectorAll('.brand-filter-item');
                
                brandItems.forEach(item => {
                    const brandName = item.querySelector('.brand-name')?.textContent.toLowerCase() || '';
                    item.style.display = (searchTerm === '' || brandName.includes(searchTerm)) ? '' : 'none';
                });
            });
        }
        
        /**
         * Initialize price filter
         */
        function initPriceFilter() {
            const minInput = document.getElementById('priceMinInput');
            const maxInput = document.getElementById('priceMaxInput');
            const applyBtn = document.getElementById('applyPriceFilter');
            
            if (!minInput || !maxInput || !applyBtn) return;
            
            // Set initial values from URL
            if (priceMin !== null) minInput.value = priceMin;
            if (priceMax !== null) maxInput.value = priceMax;
            
            // Apply on button click
            applyBtn.addEventListener('click', function() {
                priceMin = parseFloat(minInput.value) || null;
                priceMax = parseFloat(maxInput.value) || null;
                
                console.log('Price filter applied:', priceMin, '-', priceMax);
                applyFilters();
            });
            
            // Apply on Enter key
            [minInput, maxInput].forEach(input => {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        applyBtn.click();
                    }
                });
            });
        }
        
        /**
         * Initialize sort select
         */
        function initSortSelect() {
            const sortSelect = document.getElementById('sortSelect');
            if (!sortSelect) return;
            
            // Set initial value from URL
            if (currentSort) {
                sortSelect.value = currentSort;
            }
            
            sortSelect.addEventListener('change', function() {
                currentSort = this.value === 'default' ? null : this.value;
                console.log('Sort changed:', currentSort);
                applyFilters();
            });
        }
        
        /**
         * Apply filters and reload products
         */
        function applyFilters() {
            if (isLoading) {
                console.log('Already loading, skipping...');
                return;
            }
            
            isLoading = true;
            currentPage = 1;
            
            const productsGrid = document.getElementById('products-grid');
            if (!productsGrid) {
                console.error('Products grid not found');
                isLoading = false;
                return;
            }
            
            // Show loading state
            productsGrid.classList.add('loading');
            
            // Build URL with filters
            const params = new URLSearchParams();
            
            selectedCategoryIds.forEach(id => params.append('category_ids[]', id));
            selectedBrandIds.forEach(id => params.append('brand_ids[]', id));
            
            if (priceMin !== null) params.set('price_min', priceMin);
            if (priceMax !== null) params.set('price_max', priceMax);
            if (currentSort) params.set('sort', currentSort);
            
            params.set('page', 1);
            
            const url = `/${locale}/products?${params.toString()}`;
            console.log('Fetching:', url);
            
            // Fetch products
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network error');
                return response.text();
            })
            .then(html => {
                console.log('Response HTML length:', html.length);
                console.log('First 500 chars:', html.substring(0, 500));
                
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newGrid = doc.getElementById('products-grid');
                
                console.log('Parsed document title:', doc.title);
                console.log('Products grid found:', !!newGrid);
                
                if (newGrid) {
                    console.log('Grid has', newGrid.children.length, 'children');
                    productsGrid.innerHTML = newGrid.innerHTML;
                    
                    // Update pagination
                    const newPagination = doc.querySelector('.load-more-section');
                    const currentPagination = document.querySelector('.load-more-section');
                    if (currentPagination) currentPagination.remove();
                    
                    if (newPagination) {
                        productsGrid.parentElement.appendChild(newPagination.cloneNode(true));
                    }
                    
                    // Update URL
                    const newUrl = `/${locale}/products${params.toString() ? '?' + params.toString() : ''}`;
                    window.history.pushState({}, '', newUrl);
                    
                    // Scroll to products with offset
                    const gridTop = productsGrid.getBoundingClientRect().top + window.pageYOffset;
                    const offset = 148; // Header offset
                    window.scrollTo({
                        top: gridTop - offset,
                        behavior: 'smooth'
                    });
                    
                    console.log('Products updated successfully');
                } else {
                    console.error('Could not find products grid in response');
                }
                
                // Re-init infinite scroll
                setTimeout(initInfiniteScroll, 100);
            })
            .catch(error => {
                console.error('Error loading products:', error);
                alert('Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin.');
            })
            .finally(() => {
                isLoading = false;
                productsGrid.classList.remove('loading');
            });
        }
        
        /**
         * Initialize clear all filters button (with event delegation)
         */
        function initClearFilters() {
            // Use event delegation since button might be loaded dynamically
            document.addEventListener('click', function(e) {
                const clearBtn = e.target.closest('#clearAllFilters');
                if (clearBtn) {
                    e.preventDefault();
                    
                    // Clear all filters
                    selectedCategoryIds = [];
                    selectedBrandIds = [];
                    priceMin = null;
                    priceMax = null;
                    currentSort = null;
                    
                    // Uncheck all checkboxes
                    document.querySelectorAll('.category-checkbox, .brand-checkbox').forEach(cb => {
                        cb.checked = false;
                    });
                    
                    // Reset price inputs
                    const minInput = document.getElementById('priceMinInput');
                    const maxInput = document.getElementById('priceMaxInput');
                    if (minInput) minInput.value = '';
                    if (maxInput) maxInput.value = '';
                    
                    // Reset sort
                    const sortSelect = document.getElementById('sortSelect');
                    if (sortSelect) sortSelect.value = 'default';
                    
                    console.log('All filters cleared');
                    
                    // Reload products
                    applyFilters();
                }
            });
        }
        
        /**
         * Initialize infinite scroll
         */
        function initInfiniteScroll() {
            if (infiniteScrollObserver) {
                infiniteScrollObserver.disconnect();
            }
            
            const trigger = document.getElementById('infinite-scroll-trigger');
            if (!trigger) return;
            
            infiniteScrollObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !isLoading) {
                        loadMore();
                    }
                });
            }, {
                root: null,
                rootMargin: '200px',
                threshold: 0.1
            });
            
            infiniteScrollObserver.observe(trigger);
        }
        
        /**
         * Load more products
         */
        function loadMore() {
            const loadMoreSection = document.querySelector('.load-more-section');
            if (!loadMoreSection || loadMoreSection.style.display === 'none') return;
            
            isLoading = true;
            currentPage++;
            
            const spinner = document.getElementById('btn-loading-spinner');
            if (spinner) spinner.classList.remove('d-none');
            
            // Build URL
            const params = new URLSearchParams();
            
            selectedCategoryIds.forEach(id => params.append('category_ids[]', id));
            selectedBrandIds.forEach(id => params.append('brand_ids[]', id));
            
            if (priceMin !== null) params.set('price_min', priceMin);
            if (priceMax !== null) params.set('price_max', priceMax);
            if (currentSort) params.set('sort', currentSort);
            
            params.set('page', currentPage);
            
            const url = `/${locale}/products?${params.toString()}`;
            
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newGrid = doc.getElementById('products-grid');
                const productsGrid = document.getElementById('products-grid');
                
                if (newGrid && productsGrid) {
                    Array.from(newGrid.children).forEach(item => {
                        productsGrid.appendChild(item.cloneNode(true));
                    });
                    
                    // Update pagination
                    const newPagination = doc.querySelector('.load-more-section');
                    const currentPagination = document.querySelector('.load-more-section');
                    if (currentPagination) currentPagination.remove();
                    
                    if (newPagination) {
                        productsGrid.parentElement.appendChild(newPagination.cloneNode(true));
                    }
                }
                
                setTimeout(initInfiniteScroll, 100);
            })
            .catch(error => {
                console.error('Error loading more:', error);
            })
            .finally(() => {
                isLoading = false;
                if (spinner) spinner.classList.add('d-none');
            });
        }
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
