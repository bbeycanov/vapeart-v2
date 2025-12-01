/**
 * Home Page Product Search Autocomplete
 */
(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('productSearchInput');
        const clearBtn = document.getElementById('productSearchClear');
        const autocomplete = document.getElementById('productSearchAutocomplete');
        const autocompleteResults = document.getElementById('autocompleteResults');
        const autocompleteLoading = autocomplete?.querySelector('.autocomplete-loading');
        const autocompleteNoResults = autocomplete?.querySelector('.autocomplete-no-results');
        const autocompleteFooter = document.getElementById('autocompleteFooter');
        
        if (!searchInput || !clearBtn || !autocomplete) return;
        
        // Get locale from URL path (e.g., /en/... or /az/...)
        let locale = 'en';
        const pathMatch = window.location.pathname.match(/^\/([a-z]{2})\//);
        if (pathMatch) {
            locale = pathMatch[1];
        } else {
            // Fallback to HTML lang attribute
            locale = document.documentElement.lang || 'en';
        }
        
        const searchUrl = window.location.origin + '/' + locale + '/search/autocomplete';
        const viewAllUrl = window.location.origin + '/' + locale + '/search';
        let searchTimeout;
        
        // Show/hide clear button based on input value
        function toggleClearButton() {
            if (searchInput.value.length > 0) {
                clearBtn.classList.remove('d-none');
            } else {
                clearBtn.classList.add('d-none');
            }
        }
        
        // Render products in autocomplete
        function renderProducts(products) {
            if (!autocompleteResults) return;
            
            autocompleteResults.innerHTML = '';
            
            if (products.length === 0) {
                if (autocompleteNoResults) {
                    autocompleteNoResults.classList.remove('d-none');
                }
                if (autocompleteFooter) {
                    autocompleteFooter.classList.add('d-none');
                }
                return;
            }
            
            if (autocompleteNoResults) {
                autocompleteNoResults.classList.add('d-none');
            }
            if (autocompleteFooter) {
                autocompleteFooter.classList.remove('d-none');
                // Update view all link
                const viewAllLink = autocompleteFooter.querySelector('a');
                if (viewAllLink) {
                    viewAllLink.href = viewAllUrl + '?q=' + encodeURIComponent(searchInput.value.trim());
                }
            }
            
            products.forEach(product => {
                const item = document.createElement('div');
                item.className = 'autocomplete-item';
                item.innerHTML = `
                    <img src="${product.image}" alt="${product.name}" class="autocomplete-item-image" onerror="this.src='${window.location.origin}/storefront/images/products/placeholder.jpg'">
                    <div class="autocomplete-item-info">
                        <div class="autocomplete-item-name">${product.name}</div>
                        <div class="autocomplete-item-price">${product.price} ${product.currency}</div>
                    </div>
                `;
                item.style.cursor = 'pointer';
                item.addEventListener('click', function() {
                    window.location.href = product.url;
                });
                autocompleteResults.appendChild(item);
            });
        }
        
        // Fetch products from Elasticsearch API
        async function fetchProducts(query) {
            if (!query || query.length < 1) {
                return [];
            }
            
            try {
                const response = await fetch(searchUrl + '?q=' + encodeURIComponent(query));
                const data = await response.json();
                return data.products || [];
            } catch (error) {
                console.error('Search error:', error);
                return [];
            }
        }
        
        // Show autocomplete with products
        async function showAutocomplete(query) {
            if (!query || query.length < 1) {
                autocomplete.classList.add('d-none');
                return;
            }
            
            // Show loading
            if (autocompleteLoading) {
                autocompleteLoading.classList.remove('d-none');
            }
            autocomplete.classList.remove('d-none');
            
            try {
                const products = await fetchProducts(query);
                
                if (autocompleteLoading) {
                    autocompleteLoading.classList.add('d-none');
                }
                
                renderProducts(products);
            } catch (error) {
                console.error('Error showing autocomplete:', error);
                if (autocompleteLoading) {
                    autocompleteLoading.classList.add('d-none');
                }
            }
        }
        
        // Clear input
        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.focus();
            toggleClearButton();
            autocomplete.classList.add('d-none');
        });
        
        // Handle input changes with debounce
        searchInput.addEventListener('input', function() {
            toggleClearButton();
            const query = searchInput.value.trim();
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            // Debounce search
            searchTimeout = setTimeout(() => {
                showAutocomplete(query);
            }, 300);
        });
        
        // Show autocomplete on focus if there's text
        searchInput.addEventListener('focus', function() {
            const query = searchInput.value.trim();
            if (query.length > 0) {
                showAutocomplete(query);
            }
        });
        
        // Hide autocomplete when clicking outside
        document.addEventListener('click', function(e) {
            if (autocomplete && !autocomplete.contains(e.target) && e.target !== searchInput) {
                autocomplete.classList.add('d-none');
            }
        });
    });
})();

