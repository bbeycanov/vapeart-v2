/**
 * Cart Index Page - Cart Management and WhatsApp Order
 */
(function() {
    'use strict';
    
    // Get locale from URL path
    let locale = 'en';
    const pathMatch = window.location.pathname.match(/^\/([a-z]{2})\//);
    if (pathMatch) {
        locale = pathMatch[1];
    } else {
        locale = document.documentElement.lang || 'en';
    }
    
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    
    // Update cart item images from API if missing
    async function updateCartItemImages() {
        const promises = cart.map(async (item, index) => {
            if (!item.image || item.image.includes('placeholder')) {
                try {
                    const response = await fetch(`/${locale}/quick-view?product_id=${item.id}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = await response.json();
                    if (data.success && data.product && data.product.image) {
                        cart[index].image = data.product.image;
                    }
                } catch (error) {
                    console.error('Error fetching product image:', error);
                }
            }
        });
        
        await Promise.all(promises);
        localStorage.setItem('cart', JSON.stringify(cart));
    }
    
    // Update cart page
    async function updateCartPage() {
        const cartTable = document.getElementById('cartTable');
        const cartTableBody = document.getElementById('cartTableBody');
        const cartEmptyMessage = document.getElementById('cartEmptyMessage');
        const whatsappOrderBtn = document.getElementById('whatsappOrderBtn');
        
        if (cart.length === 0) {
            cartTable.style.display = 'none';
            cartEmptyMessage.style.display = 'block';
            whatsappOrderBtn.style.display = 'none';
            return;
        }
        
        await updateCartItemImages();
        
        cartTable.style.display = 'table';
        cartEmptyMessage.style.display = 'none';
        whatsappOrderBtn.style.display = 'block';
        
        let html = '';
        let subtotal = 0;
        let totalDiscount = 0;
        const placeholderImage = window.location.origin + '/storefront/images/products/placeholder.jpg';
        
        cart.forEach((item, index) => {
            const itemPrice = parseFloat(item.price) || 0;
            const originalPrice = parseFloat(item.original_price || item.price) || 0;
            const quantity = item.quantity || 1;
            const itemSubtotal = itemPrice * quantity;
            const hasDiscount = item.has_discount && originalPrice > itemPrice;
            
            subtotal += itemSubtotal;
            if (hasDiscount) {
                totalDiscount += ((originalPrice - itemPrice) * quantity);
            }
            
            const imageUrl = item.image || placeholderImage;
            
            html += `
                <tr data-cart-index="${index}">
                    <td>
                        <div class="shopping-cart__product-item position-relative">
                            <a href="${item.url}">
                                <img loading="lazy" src="${imageUrl}" width="120" height="120" alt="${item.name}" style="object-fit: contain; width: 120px; height: 120px;" onerror="this.src='${placeholderImage}'">
                            </a>
                            ${hasDiscount && item.discount_text ? `<span class="badge text-white position-absolute top-0 start-0 m-1 fw-bold" style="font-size: 0.65rem; z-index: 5; background: linear-gradient(135deg, #ff4757 0%, #ff6348 100%); border-radius: 4px; box-shadow: 0 2px 4px rgba(220, 53, 69, 0.4); padding: 2px 6px;">${item.discount_text}</span>` : ''}
                        </div>
                    </td>
                    <td>
                        <div class="shopping-cart__product-item__detail">
                            <h4><a href="${item.url}">${item.name}</a></h4>
                        </div>
                    </td>
                    <td>
                        ${hasDiscount ? `<span class="text-decoration-line-through d-block" style="font-size: 0.875rem; color: #6c757d !important;">${originalPrice.toFixed(2)} ${item.currency}</span>` : ''}
                        <span class="shopping-cart__product-price fw-bold" style="${hasDiscount ? 'color: #28a745 !important;' : ''}">${itemPrice.toFixed(2)} ${item.currency}</span>
                    </td>
                    <td>
                        <div class="qty-control position-relative">
                            <input type="number" name="quantity" value="${quantity}" min="1" class="qty-control__number text-center" data-cart-index="${index}">
                            <div class="qty-control__reduce js-cart-qty-reduce" data-cart-index="${index}">-</div>
                            <div class="qty-control__increase js-cart-qty-increase" data-cart-index="${index}">+</div>
                        </div>
                    </td>
                    <td>
                        <span class="shopping-cart__subtotal fw-bold" style="${hasDiscount ? 'color: #28a745 !important;' : ''}">${itemSubtotal.toFixed(2)} ${item.currency}</span>
                    </td>
                    <td>
                        <a href="#" class="remove-cart js-cart-item-remove" data-cart-index="${index}">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z"/>
                                <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
            `;
        });
        
        cartTableBody.innerHTML = html;
        
        const currency = cart.length > 0 ? cart[0].currency : 'AZN';
        const finalTotal = subtotal - totalDiscount;
        
        // Update subtotal
        document.getElementById('cartPageSubtotal').textContent = subtotal.toFixed(2) + ' ' + currency;
        
        // Show/hide discount row
        let discountRow = document.getElementById('cartPageDiscountRow');
        if (totalDiscount > 0) {
            if (!discountRow) {
                const subtotalRow = document.getElementById('cartPageSubtotalRow');
                if (subtotalRow) {
                    const discountHtml = `
                        <tr id="cartPageDiscountRow">
                            <th>Endirim:</th>
                            <td><span class="fw-bold">-${totalDiscount.toFixed(2)} ${currency}</span></td>
                        </tr>
                    `;
                    subtotalRow.insertAdjacentHTML('afterend', discountHtml);
                }
            } else {
                const discountAmount = discountRow.querySelector('span');
                if (discountAmount) {
                    discountAmount.textContent = `-${totalDiscount.toFixed(2)} ${currency}`;
                }
                discountRow.style.display = '';
            }
        } else if (discountRow) {
            discountRow.style.display = 'none';
        }
        
        document.getElementById('cartPageTotal').textContent = finalTotal.toFixed(2) + ' ' + currency;
        
        attachCartPageListeners();
    }
    
    // Use unified function from scripts.blade.php
    // This file now just calls the unified function with cart page modal IDs
    function loadBranchesAndShowModal() {
        if (typeof window.loadBranchesAndShowModal === 'function') {
            window.loadBranchesAndShowModal('branchSelectionModal', 'branchList');
            } else {
            console.error('Unified loadBranchesAndShowModal function not found');
            }
    }
    
    // Use unified function from scripts.blade.php
    function selectBranch(branchId, branchWhatsapp) {
        if (typeof window.selectBranchAndOpenWhatsApp === 'function') {
            window.selectBranchAndOpenWhatsApp(branchId, branchWhatsapp, 'branchSelectionModal');
        } else {
            console.error('Unified selectBranchAndOpenWhatsApp function not found');
        }
    }
    
    // Attach cart page event listeners
    function attachCartPageListeners() {
        document.querySelectorAll('.js-cart-item-remove').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const index = parseInt(this.getAttribute('data-cart-index'));
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartPage();
                if (typeof updateCartUI === 'function') {
                    updateCartUI();
                }
            });
        });
        
        document.querySelectorAll('.qty-control__number').forEach(input => {
            input.addEventListener('change', function() {
                const index = parseInt(this.getAttribute('data-cart-index'));
                const quantity = parseInt(this.value) || 1;
                if (quantity < 1) {
                    this.value = 1;
                    return;
                }
                cart[index].quantity = quantity;
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartPage();
                if (typeof updateCartUI === 'function') {
                    updateCartUI();
                }
            });
        });
        
        document.querySelectorAll('.js-cart-qty-increase').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-cart-index'));
                cart[index].quantity = (cart[index].quantity || 1) + 1;
                const input = document.querySelector(`.qty-control__number[data-cart-index="${index}"]`);
                if (input) {
                    input.value = cart[index].quantity;
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartPage();
                if (typeof updateCartUI === 'function') {
                    updateCartUI();
                }
            });
        });
        
        document.querySelectorAll('.js-cart-qty-reduce').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-cart-index'));
                if (cart[index].quantity > 1) {
                    cart[index].quantity--;
                    const input = document.querySelector(`.qty-control__number[data-cart-index="${index}"]`);
                    if (input) {
                        input.value = cart[index].quantity;
                    }
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartPage();
                    if (typeof updateCartUI === 'function') {
                        updateCartUI();
                    }
                }
            });
        });
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartPage();
        
        const whatsappOrderBtn = document.getElementById('whatsappOrderBtn');
        if (whatsappOrderBtn) {
            whatsappOrderBtn.addEventListener('click', function(e) {
                e.preventDefault();
                loadBranchesAndShowModal();
            });
        }
    });
})();

