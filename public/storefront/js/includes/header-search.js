/**
 * Header Search Autocomplete (Mobile & Desktop)
 */
(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
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
        
        // Helper function to initialize search
        function initSearch(config) {
            const {
                searchInput,
                clearBtn,
                autocomplete,
                autocompleteResults,
                autocompleteLoading,
                autocompleteNoResults,
                autocompleteFooter
            } = config;
            
            if (!searchInput || !autocomplete) return;
            
            let searchTimeout;
            
            // Show/hide clear button
            function toggleClearButton() {
                if (clearBtn) {
                    if (searchInput.value.length > 0) {
                        clearBtn.classList.remove('d-none');
                    } else {
                        clearBtn.classList.add('d-none');
                    }
                }
            }
            
            // Render products
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
                    const viewAllLink = autocompleteFooter.querySelector('a');
                    if (viewAllLink) {
                        viewAllLink.href = viewAllUrl + '?q=' + encodeURIComponent(searchInput.value.trim());
                    }
                }
                
                products.forEach(product => {
                    const item = document.createElement('div');
                    item.className = 'autocomplete-item';
                    item.style.cssText = 'padding: 1rem 1.5rem; border-bottom: 1px solid #f0f0f0; cursor: pointer; transition: background-color 0.2s ease; display: flex; align-items: center; gap: 1rem;';
                    item.innerHTML = `
                        <img src="${product.image}" alt="${product.name}" style="width: 60px; height: 60px; object-fit: contain; border-radius: 8px; background-color: #f5f5f5; flex-shrink: 0;" onerror="this.src='${window.location.origin}/storefront/images/products/placeholder.jpg'">
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-size: 0.95rem; font-weight: 500; color: #222222; margin-bottom: 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${product.name}</div>
                            <div style="font-size: 0.875rem; color: #767676;">${product.price} ${product.currency}</div>
                        </div>
                    `;
                    item.addEventListener('mouseenter', function() {
                        this.style.backgroundColor = '#f8f8f8';
                    });
                    item.addEventListener('mouseleave', function() {
                        this.style.backgroundColor = '';
                    });
                    item.addEventListener('click', function() {
                        window.location.href = product.url;
                    });
                    autocompleteResults.appendChild(item);
                });
            }
            
            // Fetch products
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
            
            // Show autocomplete
            async function showAutocomplete(query) {
                if (!query || query.length < 1) {
                    autocomplete.classList.add('d-none');
                    return;
                }
                
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
            
            // Clear button handler
            if (clearBtn) {
                clearBtn.addEventListener('click', function() {
                    searchInput.value = '';
                    searchInput.focus();
                    toggleClearButton();
                    autocomplete.classList.add('d-none');
                });
            }
            
            // Input handler with debounce
            searchInput.addEventListener('input', function() {
                toggleClearButton();
                const query = searchInput.value.trim();
                
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    showAutocomplete(query);
                }, 300);
            });
            
            // Focus handler
            searchInput.addEventListener('focus', function() {
                const query = searchInput.value.trim();
                if (query.length > 0) {
                    showAutocomplete(query);
                }
            });
            
            // Hide on outside click
            document.addEventListener('click', function(e) {
                if (autocomplete && !autocomplete.contains(e.target) && e.target !== searchInput && e.target !== clearBtn) {
                    autocomplete.classList.add('d-none');
                }
            });
            
            // Initial state
            toggleClearButton();
        }
        
        // Initialize mobile search
        initSearch({
            searchInput: document.getElementById('mobileSearchInput'),
            clearBtn: document.getElementById('mobileSearchClear'),
            autocomplete: document.getElementById('mobileSearchAutocomplete'),
            autocompleteResults: document.getElementById('mobileAutocompleteResults'),
            autocompleteLoading: document.getElementById('mobileAutocompleteLoading'),
            autocompleteNoResults: document.getElementById('mobileAutocompleteNoResults'),
            autocompleteFooter: document.getElementById('mobileAutocompleteFooter')
        });
        
        // Initialize desktop search
        initSearch({
            searchInput: document.getElementById('desktopSearchInput'),
            clearBtn: document.getElementById('desktopSearchClear'),
            autocomplete: document.getElementById('desktopSearchAutocomplete'),
            autocompleteResults: document.getElementById('desktopAutocompleteResults'),
            autocompleteLoading: document.getElementById('desktopAutocompleteLoading'),
            autocompleteNoResults: document.getElementById('desktopAutocompleteNoResults'),
            autocompleteFooter: document.getElementById('desktopAutocompleteFooter')
        });
    });
})();

