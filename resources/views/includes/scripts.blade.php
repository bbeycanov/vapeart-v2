<div id="scrollTop" class="visually-hidden end-0"></div>

<div class="page-overlay"></div>

<script src="{{asset('storefront/js/plugins/jquery.min.js')}}"></script>
<script src="{{asset('storefront/js/plugins/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('storefront/js/plugins/bootstrap-slider.min.js')}}"></script>
<script src="{{asset('storefront/js/plugins/swiper.min.js')}}"></script>
<script src="{{asset('storefront/js/plugins/countdown.js')}}"></script>
<script src="{{asset('storefront/js/plugins/jquery.fancybox.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{asset('storefront/js/theme.js')}}"></script>
<script src="{{asset('storefront/js/includes/header-search.js')}}" defer></script>

<script>
(function() {
    'use strict';
    
    const locale = '{{ app()->getLocale() }}';
    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
    
    // Update cart item images from API if missing
    async function updateCartItemImages() {
        const promises = cart.map(async (item, index) => {
            // Only fetch if image is truly missing (not just placeholder)
            if (!item.image || (!item.image.includes('/storage/') && !item.image.includes('placeholder'))) {
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
                    // Silent fail for image fetch
                }
            }
        });
        
        await Promise.all(promises);
        localStorage.setItem('cart', JSON.stringify(cart));
    }
    
    // Update cart UI
    async function updateCartUI() {
        const cartItemsList = document.getElementById('cartDrawerItemsList');
        const cartCountElements = document.querySelectorAll('.js-cart-items-count');
        const cartSubtotal = document.getElementById('cartSubtotal');
        const cartEmptyMessage = document.getElementById('cartEmptyMessage');
        const viewCartBtn = document.getElementById('viewCartBtn');
        const checkoutBtn = document.getElementById('checkoutBtn');
        
        if (!cartItemsList) return;
        
        // Update images from API if needed
        await updateCartItemImages();
        
        // Calculate total items count (sum of all quantities)
        const totalItems = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
        
        // Update all cart count elements (header and drawer)
        cartCountElements.forEach(element => {
            element.textContent = totalItems;
        });
        
        // Calculate subtotal and discount
        let subtotal = 0;
        let totalDiscount = 0;
        cart.forEach(item => {
            const itemPrice = parseFloat(item.price) || 0;
            const originalPrice = parseFloat(item.original_price || item.price) || 0;
            const quantity = item.quantity || 1;
            subtotal += (itemPrice * quantity);
            if (item.has_discount && originalPrice > itemPrice) {
                totalDiscount += ((originalPrice - itemPrice) * quantity);
            }
        });
        
        if (cartSubtotal) {
            const currency = cart.length > 0 ? cart[0].currency : 'AZN';
            const finalTotal = subtotal - totalDiscount;
            
            // Show discount if any
            const discountElement = document.getElementById('cartDiscount');
            if (totalDiscount > 0 && discountElement) {
                const discountAmount = discountElement.querySelector('span');
                if (discountAmount) {
                    discountAmount.textContent = `-${totalDiscount.toFixed(2)} ${currency}`;
                }
                discountElement.style.display = 'flex';
            } else if (discountElement) {
                discountElement.style.display = 'none';
            }
            
            // Update subtotal to show final total (after discount)
            cartSubtotal.textContent = finalTotal.toFixed(2) + ' ' + currency;
        }
        
        // Show/hide empty message
        if (cartEmptyMessage) {
            cartEmptyMessage.style.display = cart.length === 0 ? 'block' : 'none';
        }
        
        // Show/hide buttons
        const whatsappBtn = document.getElementById('cartDrawerWhatsappBtn');
        if (viewCartBtn && whatsappBtn) {
            const shouldShow = cart.length > 0;
            viewCartBtn.style.display = shouldShow ? 'block' : 'none';
            whatsappBtn.style.display = shouldShow ? 'block' : 'none';
        }
        
        // Render cart items
        if (cart.length === 0) {
            cartItemsList.innerHTML = '<div class="text-center py-5 text-secondary" id="cartEmptyMessage"><p>{{ __("scripts.Your cart is empty") }}</p></div>';
            return;
        }
        
        let html = '';
        cart.forEach((item, index) => {
            const imageUrl = item.image || '{{ asset("storefront/images/products/placeholder.jpg") }}';
            const itemPrice = parseFloat(item.price) || 0;
            const originalPrice = parseFloat(item.original_price || item.price) || 0;
            const hasDiscount = item.has_discount && originalPrice > itemPrice;
            const itemSubtotal = itemPrice * (item.quantity || 1);
            
            html += `
                <div class="cart-drawer-item d-flex position-relative" data-cart-index="${index}">
                    <div class="position-relative">
                        <a href="${item.url}">
                            <img loading="lazy" class="cart-drawer-item__img" src="${imageUrl}" alt="${item.name}" width="120" height="120" style="object-fit: contain; width: 120px; height: 120px;" onerror="this.src='{{ asset('storefront/images/products/placeholder.jpg') }}'">
                        </a>
                        ${hasDiscount && item.discount_text ? `<span class="badge text-white position-absolute top-0 start-0 m-1 fw-bold" style="font-size: 0.65rem; z-index: 5; background: linear-gradient(135deg, #ff4757 0%, #ff6348 100%); border-radius: 4px; box-shadow: 0 2px 4px rgba(220, 53, 69, 0.4); padding: 2px 6px;">${item.discount_text}</span>` : ''}
                    </div>
                    <div class="cart-drawer-item__info flex-grow-1">
                        <h6 class="cart-drawer-item__title fw-normal"><a href="${item.url}">${item.name}</a></h6>
                        <div class="d-flex align-items-center justify-content-between mt-1">
                            <div class="qty-control position-relative">
                                <input type="number" name="quantity" value="${item.quantity}" min="1" class="qty-control__number border-0 text-center" data-cart-index="${index}">
                                <div class="qty-control__reduce text-start">-</div>
                                <div class="qty-control__increase text-end">+</div>
                            </div>
                            <div class="text-end">
                                ${hasDiscount ? `<span class="text-decoration-line-through d-block" style="font-size: 0.75rem; color: #6c757d !important;">${originalPrice.toFixed(2)} ${item.currency}</span>` : ''}
                                <span class="cart-drawer-item__price money price fw-bold" style="${hasDiscount ? 'color: #28a745 !important;' : ''}">${itemPrice.toFixed(2)} ${item.currency}</span>
                            </div>
                        </div>
                    </div>
                    <button class="btn-close-xs position-absolute top-0 end-0 js-cart-item-remove" data-cart-index="${index}"></button>
                </div>
                ${index < cart.length - 1 ? '<hr class="cart-drawer-divider">' : ''}
            `;
        });
        
        cartItemsList.innerHTML = html;
        
        // Attach event listeners
        attachCartEventListeners();
        
        // Attach WhatsApp button listener
        attachCartDrawerWhatsappListener();
    }
    
    // Unified function to load branches and show modal for single product order
    window.loadBranchesAndShowModalForSingleProduct = function(modalId = 'branchSelectionModal', branchListId = 'branchList') {
        const branchList = document.getElementById(branchListId);
        const modalEl = document.getElementById(modalId);
        if (!modalEl || !branchList) return;
        
        const modal = new bootstrap.Modal(modalEl);
        
        branchList.innerHTML = '<div class="text-center py-4"><div class="spinner-border" role="status"><span class="visually-hidden">{{ __("scripts.Loading...") }}</span></div></div>';
        modal.show();
        
        fetch(`/${locale}/cart/branches`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.branches && data.branches.length > 0) {
                let html = '';
                data.branches.forEach(branch => {
                    const hasWhatsapp = branch.whatsapp || branch.phone;
                    html += `
                        <button type="button" class="branch-item w-100 ${!hasWhatsapp ? 'disabled' : ''}" 
                                data-branch-id="${branch.id}" 
                                data-branch-whatsapp="${branch.whatsapp || branch.phone || ''}"
                                data-order-type="single-product"
                                ${!hasWhatsapp ? 'disabled' : ''}>
                            <div class="d-flex align-items-center">
                                <div class="branch-item-icon me-3">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="${hasWhatsapp ? '#25D366' : '#6c757d'}">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                </div>
                                <div class="flex-grow-1 text-start">
                                    <h6 class="mb-1 fw-bold">${branch.name}</h6>
                                    ${branch.address ? `<p class="mb-1 text-secondary small"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: -2px; margin-right: 4px;"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>${branch.address}</p>` : ''}
                                    ${branch.phone ? `<p class="mb-0 text-muted small"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: -2px; margin-right: 4px;"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>${branch.phone}</p>` : ''}
                                </div>
                                ${hasWhatsapp ? '<div class="ms-2"><svg width="24" height="24" viewBox="0 0 24 24" fill="#25D366"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg></div>' : '<div class="ms-2"><span class="badge bg-secondary">WhatsApp yoxdur</span></div>'}
                            </div>
                        </button>
                    `;
                });
                branchList.innerHTML = html;
                
                // Attach click listeners to branch items for single product
                document.querySelectorAll(`#${branchListId} .branch-item[data-order-type="single-product"]:not(.disabled)`).forEach(item => {
                    item.addEventListener('click', function() {
                        const branchWhatsapp = this.getAttribute('data-branch-whatsapp');
                        selectBranchAndOpenWhatsAppForSingleProduct(branchWhatsapp, modalId);
                    });
                });
            } else {
                branchList.innerHTML = '<div class="alert alert-warning">{{ __("branch.Filial tapılmadı.") }}</div>';
            }
        })
        .catch(error => {
            console.error('Error loading branches:', error);
            branchList.innerHTML = '<div class="alert alert-danger">{{ __("branch.Filiallar yüklənərkən xəta baş verdi.") }}</div>';
        });
    }
    
    // Function to open WhatsApp for single product order
    window.selectBranchAndOpenWhatsAppForSingleProduct = function(branchWhatsapp, modalId = 'branchSelectionModal') {
        if (!branchWhatsapp) {
            alert('{{ __("branch.Bu filialın WhatsApp nömrəsi yoxdur. Lütfən başqa bir filial seçin.") }}');
            return;
        }
        
        if (!window.singleProductOrder) {
            console.error('Single product order data not found');
            return;
        }
        
        const { product, quantity } = window.singleProductOrder;
        const currency = product.currency || 'AZN';
        const itemTotal = product.price * quantity;
        const hasDiscount = product.hasDiscount && product.originalPrice > product.price;
        
        let message = '🛒 *SİFARİŞ*\n\n';
        message += 'Salam! Aşağıdakı məhsulu sifariş etmək istəyirəm:\n\n';
        message += '━━━━━━━━━━━━━━━━━━━━\n\n';
        
        message += `📦 *${product.name}*\n`;
        message += `   └─ Miqdar: ${quantity} ədəd\n`;
        if (hasDiscount) {
            message += `   └─ Orijinal Qiymət: ${product.originalPrice.toFixed(2)} ${currency}\n`;
            if (product.discountText) {
                message += `   └─ Endirim: ${product.discountText}\n`;
            }
            message += `   └─ Endirimli Qiymət: ${product.price.toFixed(2)} ${currency}\n`;
        } else {
            message += `   └─ Qiymət: ${product.price.toFixed(2)} ${currency}\n`;
        }
        message += `   └─ Cəmi: ${itemTotal.toFixed(2)} ${currency}\n`;
        message += `   └─ Link: ${product.url}\n`;
        
        message += '\n━━━━━━━━━━━━━━━━━━━━\n\n';
        if (hasDiscount) {
            const discountAmount = (product.originalPrice - product.price) * quantity;
            message += `💸 *ÜMUMİ ENDİRİM: -${discountAmount.toFixed(2)} ${currency}*\n`;
        }
        message += `💰 *ÜMUMİ MƏBLƏĞ: ${itemTotal.toFixed(2)} ${currency}*\n\n`;
        message += 'Təşəkkürlər! 🙏';
        
        const phoneNumber = branchWhatsapp.replace(/[\s+]/g, '');
        const encodedMessage = encodeURIComponent(message);
        const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
        
        // Close modal
        const modalEl = document.getElementById(modalId);
        if (modalEl) {
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        }
        
        // Clear single product order data
        window.singleProductOrder = null;
        
        window.open(whatsappUrl, '_blank');
    }
    
    // Unified function to load branches and show modal (works for both cart page and cart drawer)
    window.loadBranchesAndShowModal = function(modalId = 'branchSelectionModal', branchListId = 'branchList') {
        const branchList = document.getElementById(branchListId);
        const modalEl = document.getElementById(modalId);
        if (!modalEl || !branchList) return;
        
        const modal = new bootstrap.Modal(modalEl);
        
        branchList.innerHTML = '<div class="text-center py-4"><div class="spinner-border" role="status"><span class="visually-hidden">{{ __("scripts.Loading...") }}</span></div></div>';
        modal.show();
        
        fetch(`/${locale}/cart/branches`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.branches && data.branches.length > 0) {
                let html = '';
                data.branches.forEach(branch => {
                    const hasWhatsapp = branch.whatsapp || branch.phone;
                    html += `
                        <button type="button" class="branch-item w-100 ${!hasWhatsapp ? 'disabled' : ''}" 
                                data-branch-id="${branch.id}" 
                                data-branch-whatsapp="${branch.whatsapp || branch.phone || ''}"
                                ${!hasWhatsapp ? 'disabled' : ''}>
                            <div class="d-flex align-items-center">
                                <div class="branch-item-icon me-3">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="${hasWhatsapp ? '#25D366' : '#6c757d'}">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                </div>
                                <div class="flex-grow-1 text-start">
                                    <h6 class="mb-1 fw-bold">${branch.name}</h6>
                                    ${branch.address ? `<p class="mb-1 text-secondary small"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: -2px; margin-right: 4px;"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>${branch.address}</p>` : ''}
                                    ${branch.phone ? `<p class="mb-0 text-muted small"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: -2px; margin-right: 4px;"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>${branch.phone}</p>` : ''}
                                </div>
                                ${hasWhatsapp ? '<div class="ms-2"><svg width="24" height="24" viewBox="0 0 24 24" fill="#25D366"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg></div>' : '<div class="ms-2"><span class="badge bg-secondary">WhatsApp yoxdur</span></div>'}
                            </div>
                        </button>
                    `;
                });
                branchList.innerHTML = html;
                
                // Attach click listeners to branch items
                document.querySelectorAll(`#${branchListId} .branch-item:not(.disabled)`).forEach(item => {
                    item.addEventListener('click', function() {
                        const branchId = this.getAttribute('data-branch-id');
                        const branchWhatsapp = this.getAttribute('data-branch-whatsapp');
                        selectBranchAndOpenWhatsApp(branchId, branchWhatsapp, modalId);
                    });
                });
            } else {
                branchList.innerHTML = '<div class="alert alert-warning">{{ __("branch.Filial tapılmadı.") }}</div>';
            }
        })
        .catch(error => {
            console.error('Error loading branches:', error);
            branchList.innerHTML = '<div class="alert alert-danger">{{ __("branch.Filiallar yüklənərkən xəta baş verdi.") }}</div>';
        });
    }
    
    // Unified function to select branch and open WhatsApp (works for both cart page and cart drawer)
    window.selectBranchAndOpenWhatsApp = function(branchId, branchWhatsapp, modalId = 'branchSelectionModal') {
        if (!branchWhatsapp) {
            alert('{{ __("branch.Bu filialın WhatsApp nömrəsi yoxdur. Lütfən başqa bir filial seçin.") }}');
            return;
        }
        
        let message = '🛒 *SİFARİŞ SƏBƏTİ*\n\n';
        message += 'Salam! Aşağıdakı məhsulları sifariş etmək istəyirəm:\n\n';
        message += '━━━━━━━━━━━━━━━━━━━━\n\n';
        
        let total = 0;
        let totalDiscount = 0;
        const currency = cart.length > 0 ? (cart[0].currency || 'AZN') : 'AZN';
        
        cart.forEach((item, index) => {
            const quantity = item.quantity || 1;
            const price = parseFloat(item.price) || 0;
            const originalPrice = parseFloat(item.original_price || item.price) || 0;
            const hasDiscount = item.has_discount && originalPrice > price;
            const itemTotal = price * quantity;
            const itemDiscount = hasDiscount ? ((originalPrice - price) * quantity) : 0;
            
            total += itemTotal;
            totalDiscount += itemDiscount;
            
            let productUrl = item.url;
            if (!productUrl && item.slug) {
                productUrl = `${window.location.origin}/${locale}/products/${item.slug}`;
            } else if (!productUrl) {
                productUrl = `${window.location.origin}/${locale}/products/${item.id}`;
            }
            
            message += `📦 *${index + 1}. ${item.name || 'Məhsul'}*\n`;
            message += `   └─ Miqdar: ${quantity} ədəd\n`;
            if (hasDiscount) {
                message += `   └─ Orijinal Qiymət: ${originalPrice.toFixed(2)} ${currency}\n`;
                message += `   └─ Endirim: ${item.discount_text || '-'}\n`;
                message += `   └─ Endirimli Qiymət: ${price.toFixed(2)} ${currency}\n`;
            } else {
                message += `   └─ Qiymət: ${price.toFixed(2)} ${currency}\n`;
            }
            message += `   └─ Cəmi: ${itemTotal.toFixed(2)} ${currency}\n`;
            message += `   └─ Link: ${productUrl}\n`;
            
            if (index < cart.length - 1) {
                message += '\n';
            }
        });
        
        message += '\n━━━━━━━━━━━━━━━━━━━━\n\n';
        if (totalDiscount > 0) {
            message += `💸 *ÜMUMİ ENDİRİM: -${totalDiscount.toFixed(2)} ${currency}*\n`;
        }
        message += `💰 *ÜMUMİ MƏBLƏĞ: ${total.toFixed(2)} ${currency}*\n\n`;
        message += 'Təşəkkürlər! 🙏';
        
        const phoneNumber = branchWhatsapp.replace(/[\s+]/g, '');
        const encodedMessage = encodeURIComponent(message);
        const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
        
        // Close modal
        const modalEl = document.getElementById(modalId);
        if (modalEl) {
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        }
        
        // Close cart drawer if it's open (when called from cart drawer)
        const cartDrawer = document.getElementById('cartDrawer');
        if (cartDrawer && cartDrawer.classList.contains('aside_visible')) {
            cartDrawer.classList.remove('aside_visible');
            if (typeof UomoHelpers !== 'undefined' && UomoHelpers.hidePageBackdrop) {
                UomoHelpers.hidePageBackdrop();
            }
        }
        
        window.open(whatsappUrl, '_blank');
    }
    
    // Attach WhatsApp button listener for cart drawer
    function attachCartDrawerWhatsappListener() {
        const whatsappBtn = document.getElementById('cartDrawerWhatsappBtn');
        if (whatsappBtn) {
            // Remove all existing event listeners by cloning the button
            const newBtn = whatsappBtn.cloneNode(true);
            whatsappBtn.parentNode.replaceChild(newBtn, whatsappBtn);
            
            // Attach click event listener
            newBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Check if cart is not empty
                if (!cart || cart.length === 0) {
                    if (typeof toastr !== 'undefined') {
                        toastr.warning('{{ __("scripts.Səbətiniz boşdur") }}', '{{ __("scripts.Xəbərdarlıq") }}');
                    }
                    return;
                }
                
                // Use the same modal as cart page
                if (typeof window.loadBranchesAndShowModal === 'function') {
                    window.loadBranchesAndShowModal('branchSelectionModal', 'branchList');
                } else {
                    console.error('loadBranchesAndShowModal function not found');
                }
            });
        }
    }
    
    // Attach cart event listeners
    function attachCartEventListeners() {
        // Remove item
        document.querySelectorAll('.js-cart-item-remove').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-cart-index'));
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
            });
        });
        
        // Update quantity
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
                updateCartUI();
            });
        });
        
        // Increase quantity
        document.querySelectorAll('.qty-control__increase').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.qty-control__number');
                const index = parseInt(input.getAttribute('data-cart-index'));
                cart[index].quantity++;
                input.value = cart[index].quantity;
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
            });
        });
        
        // Decrease quantity
        document.querySelectorAll('.qty-control__reduce').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.qty-control__number');
                const index = parseInt(input.getAttribute('data-cart-index'));
                if (cart[index].quantity > 1) {
                    cart[index].quantity--;
                    input.value = cart[index].quantity;
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartUI();
                }
            });
        });
    }
    
    // Add to cart
    function addToCart(productId, quantity = 1) {
        return fetch(`/${locale}/quick-view?product_id=${productId}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.product) {
                const product = data.product;
                const existingIndex = cart.findIndex(item => item.id === product.id);
                
                if (existingIndex >= 0) {
                    cart[existingIndex].quantity += quantity;
                } else {
                    cart.push({
                        id: product.id,
                        name: product.name,
                        price: parseFloat(product.price), // This is already discounted price from API
                        original_price: parseFloat(product.original_price || product.price),
                        discount_text: product.discount_text || null,
                        has_discount: product.has_discount || false,
                        currency: product.currency,
                        image: product.image,
                        url: product.url,
                        quantity: quantity
                    });
                }
                
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
                
                // Show notification
                console.log('Product added to cart');
                return true;
            }
            return false;
        })
        .catch(error => {
            console.error('Error adding to cart:', error);
            return false;
        });
    }
    
    // Quick view handler - load data immediately when button is clicked
    $(document).on('click', '.js-quick-view', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const btn = $(this);
        const productId = btn.data('product-id');
        
        if (!productId) {
            console.error('Product ID not found on button');
            return false;
        }
        
        console.log('Quick view button clicked, product ID:', productId);
        
        // Show loading state immediately
        $('#quickViewName').text('{{ __("quick_view.Loading...") }}');
        $('#quickViewPrice').text('-');
        
        // Load product data
        $.ajax({
            url: `/${locale}/quick-view`,
            method: 'GET',
            data: { product_id: productId },
            dataType: 'json',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(data) {
                console.log('Quick view data loaded:', data);
                if (data.success && data.product) {
                    const product = data.product;
                    
                    // Update modal content
                    const nameEl = document.getElementById('quickViewName');
                    const priceEl = document.getElementById('quickViewPrice');
                    const oldPriceEl = document.getElementById('quickViewOldPrice');
                    const descEl = document.getElementById('quickViewDescription');
                    const skuEl = document.getElementById('quickViewSku');
                    const brandLinkEl = document.getElementById('quickViewBrandLink');
                    const brandItemEl = document.getElementById('quickViewBrandItem');
                    const brandLogoEl = document.getElementById('quickViewBrandLogo');
                    const categoriesLinksEl = document.getElementById('quickViewCategoriesLinks');
                    const categoriesItemEl = document.getElementById('quickViewCategoriesItem');
                    const tagsEl = document.getElementById('quickViewTags');
                    const tagsItemEl = document.getElementById('quickViewTagsItem');
                    const ratingEl = document.getElementById('quickViewRating');
                    const reviewsCountEl = document.getElementById('quickViewReviewsCount');
                    const productIdEl = document.getElementById('quickViewProductId');
                    const imagesWrapper = document.getElementById('quickViewImages');
                    const wishlistBtn = document.getElementById('quickViewWishlistBtn');
                    const discountBadgeEl = document.getElementById('quickViewDiscountBadge');
                    
                    // Basic info
                    if (nameEl) nameEl.textContent = product.name;
                    if (productIdEl) productIdEl.value = product.id;
                    
                    // Price with discount support - Calculate first
                    const productPrice = parseFloat(product.price) || 0;
                    const originalPrice = parseFloat(product.original_price || product.price) || 0;
                    const productSalePrice = product.sale_price ? parseFloat(product.sale_price) : null;
                    const hasDiscount = product.has_discount && originalPrice > productPrice;
                    const discountText = product.discount_text || null;
                    
                    // Discount badge
                    if (discountBadgeEl) {
                        if (hasDiscount && discountText) {
                            discountBadgeEl.innerHTML = `
                                <span class="badge text-white px-3 py-2 fw-bold" style="font-size: 0.875rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.5); background: linear-gradient(135deg, #ff4757 0%, #ff6348 100%); border: 1px solid rgba(255, 255, 255, 0.3);">
                                    ${discountText}
                                </span>
                            `;
                            discountBadgeEl.style.display = 'block';
                        } else {
                            discountBadgeEl.style.display = 'none';
                        }
                    }
                    
                    // Update wishlist button
                    if (wishlistBtn) {
                        wishlistBtn.setAttribute('data-product-id', product.id);
                        updateWishlistUI();
                    }
                    
                    if (hasDiscount) {
                        // Show discount badge and prices
                        if (priceEl) {
                            priceEl.innerHTML = `
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                    <span class="text-decoration-line-through" style="font-size: 1rem; color: #6c757d !important;">${originalPrice.toFixed(2)} ${product.currency}</span>
                                    ${discountText ? `<span class="badge text-white px-2 py-1 fw-bold" style="font-size: 0.75rem; background: linear-gradient(135deg, #ff4757 0%, #ff6348 100%); border-radius: 4px; box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);">${discountText}</span>` : ''}
                                </div>
                                <span class="fw-bold" style="font-size: 1.5rem; color: #28a745 !important;">${productPrice.toFixed(2)} ${product.currency}</span>
                            `;
                        }
                        if (oldPriceEl) oldPriceEl.style.display = 'none';
                    } else if (productSalePrice && productSalePrice < originalPrice) {
                        // Show sale price
                        if (priceEl) priceEl.textContent = productSalePrice.toFixed(2) + ' ' + product.currency;
                        if (oldPriceEl) {
                            oldPriceEl.textContent = originalPrice.toFixed(2) + ' ' + product.currency;
                        oldPriceEl.style.display = 'inline-block';
                        oldPriceEl.style.textDecoration = 'line-through';
                        oldPriceEl.style.marginLeft = '10px';
                        oldPriceEl.style.color = '#999';
                        }
                    } else {
                        // Regular price
                        if (priceEl) priceEl.textContent = productPrice.toFixed(2) + ' ' + product.currency;
                        if (oldPriceEl) oldPriceEl.style.display = 'none';
                    }
                    
                    // Description
                    if (descEl) {
                        const description = product.short_description || product.description || '-';
                        descEl.innerHTML = description;
                    }
                    
                    // SKU
                    if (skuEl) skuEl.textContent = product.sku || 'N/A';
                    
                    // Brand with logo and link
                    if (product.brand && product.brand.name) {
                        // Show brand logo if available
                        if (brandLogoEl && product.brand.logo) {
                            brandLogoEl.innerHTML = `<a href="/${locale}/brands/${product.brand.slug}" target="_blank" class="d-inline-block">
                                <img src="${product.brand.logo}" alt="${product.brand.name}" style="max-height: 60px; max-width: 150px; object-fit: contain;">
                            </a>`;
                            brandLogoEl.style.display = 'block';
                        } else if (brandLogoEl) {
                            brandLogoEl.style.display = 'none';
                        }
                        
                        // Brand link in meta
                        if (brandLinkEl) {
                            brandLinkEl.innerHTML = `<a href="/${locale}/brands/${product.brand.slug}" target="_blank" class="text-decoration-none">${product.brand.name}</a>`;
                        }
                        if (brandItemEl) brandItemEl.style.display = 'block';
                    } else {
                        if (brandLogoEl) brandLogoEl.style.display = 'none';
                        if (brandItemEl) brandItemEl.style.display = 'none';
                    }
                    
                    // Categories with links
                    if (product.categories && Array.isArray(product.categories) && product.categories.length > 0) {
                        const categoryLinks = product.categories.map((cat, index) => {
                            const separator = index > 0 ? ', ' : '';
                            return `${separator}<a href="/${locale}/products?category_id=${cat.id}" target="_blank" class="text-decoration-none">${cat.name}</a>`;
                        }).join('');
                        
                        if (categoriesLinksEl) categoriesLinksEl.innerHTML = categoryLinks;
                        if (categoriesItemEl) categoriesItemEl.style.display = 'block';
                    } else {
                        if (categoriesItemEl) categoriesItemEl.style.display = 'none';
                    }
                    
                    // Tags (no links, just text)
                    if (product.tags && product.tags !== 'N/A') {
                        if (tagsEl) tagsEl.textContent = product.tags;
                        if (tagsItemEl) tagsItemEl.style.display = 'block';
                    } else {
                        if (tagsItemEl) tagsItemEl.style.display = 'none';
                    }
                    
                    // Rating
                    if (product.rating_avg > 0 || product.reviews_count > 0) {
                        if (ratingEl) {
                            ratingEl.style.display = 'flex';
                            const starsGroup = ratingEl.querySelector('.reviews-group');
                            if (starsGroup) {
                                let starsHtml = '';
                                const rating = Math.round(product.rating_avg || 0);
                                for (let i = 0; i < 5; i++) {
                                    starsHtml += `<svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.0172 0.313075L2.91869 2.64013L0.460942 3.0145C0.0201949 3.08129 -0.15644 3.64899 0.163185 3.97415L1.94131 5.78447L1.52075 8.34177C1.44505 8.80402 1.91103 9.15026 2.30131 8.93408L4.5 7.72661L6.69869 8.93408C7.08897 9.14851 7.55495 8.80402 7.47925 8.34177L7.05869 5.78447L8.83682 3.97415C9.15644 3.64899 8.97981 3.08129 8.53906 3.0145L6.08131 2.64013L4.9828 0.313075C4.78598 -0.101718 4.2157 -0.10699 4.0172 0.313075Z" fill="${i < rating ? 'currentColor' : 'none'}" stroke="currentColor" stroke-width="0.5"></path>
                                    </svg>`;
                                }
                                starsGroup.innerHTML = starsHtml;
                            }
                        }
                        if (reviewsCountEl) {
                            reviewsCountEl.textContent = '(' + (product.reviews_count || 0) + ')';
                        }
                    } else {
                        if (ratingEl) ratingEl.style.display = 'none';
                    }
                    
                    // Update images
                    if (imagesWrapper) {
                        let imagesHtml = '';
                        const images = product.images && product.images.length > 0 ? product.images : (product.image ? [product.image] : []);
                        
                        if (images.length === 0 || !images[0]) {
                            // If no images, show a simple placeholder div instead of trying to load a missing image
                            imagesHtml = `<div class="swiper-slide product-single__image-item d-flex align-items-center justify-content-center bg-light" style="min-height: 400px;">
                                <span class="text-muted">{{ __("quick_view.No image available") }}</span>
                            </div>`;
                        } else {
                            images.forEach(img => {
                                if (img) {
                                    imagesHtml += `<div class="swiper-slide product-single__image-item">
                                        <img loading="lazy" src="${img}" alt="${product.name}" style="object-fit: contain; width: 100%; height: 512px; max-width: 512px; max-height: 512px;" onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\\'d-flex align-items-center justify-content-center bg-light\\' style=\\'min-height: 400px;\\'><span class=\\'text-muted\\'>{{ __("quick_view.Image not found") }}</span></div>';">
                                    </div>`;
                                }
                            });
                        }
                        imagesWrapper.innerHTML = imagesHtml;
                        
                        // Initialize swiper immediately to prevent theme.js error
                        const swiperContainer = imagesWrapper.closest('.swiper-container');
                        if (swiperContainer && typeof Swiper !== 'undefined') {
                            // Destroy existing swiper if any
                            if (swiperContainer.swiper) {
                                try {
                                    swiperContainer.swiper.destroy(true, true);
                                } catch (e) {
                                    // Ignore destroy errors
                                }
                            }
                            
                            // Initialize new swiper immediately
                            try {
                                const settingsAttr = swiperContainer.getAttribute('data-settings');
                                const settings = settingsAttr ? JSON.parse(settingsAttr) : {};
                                const newSwiper = new Swiper(swiperContainer, settings);
                                // Store reference so theme.js can find it
                                swiperContainer.swiper = newSwiper;
                            } catch (err) {
                                console.error('Error initializing swiper:', err);
                            }
                        }
                    }
                    
                    // Show modal after content is loaded
                    const quickViewModalEl = document.getElementById('quickView');
                    if (quickViewModalEl) {
                        // Fix aria-hidden issue - remove aria-hidden before showing
                        quickViewModalEl.removeAttribute('aria-hidden');
                        quickViewModalEl.setAttribute('aria-modal', 'true');
                        
                        // Use Bootstrap 5 modal API
                        let quickViewModal = bootstrap.Modal.getInstance(quickViewModalEl);
                        if (!quickViewModal) {
                            quickViewModal = new bootstrap.Modal(quickViewModalEl, {
                                backdrop: true,
                                keyboard: true,
                                focus: true
                            });
                        }
                        
                        // Fix aria-hidden when modal is shown
                        const fixAriaHidden = function() {
                            quickViewModalEl.removeAttribute('aria-hidden');
                            quickViewModalEl.setAttribute('aria-modal', 'true');
                        };
                        
                        quickViewModalEl.addEventListener('shown.bs.modal', fixAriaHidden, { once: true });
                        
                        quickViewModal.show();
                    }
                    
                    // Setup WhatsApp button for Quick View
                    const quickViewWhatsappBtn = document.getElementById('quickViewWhatsappOrderBtn');
                    if (quickViewWhatsappBtn) {
                        // Store product data for WhatsApp order
                        quickViewWhatsappBtn.setAttribute('data-product-id', product.id);
                        quickViewWhatsappBtn.setAttribute('data-product-name', product.name);
                        quickViewWhatsappBtn.setAttribute('data-product-price', productPrice);
                        quickViewWhatsappBtn.setAttribute('data-product-original-price', originalPrice);
                        quickViewWhatsappBtn.setAttribute('data-product-currency', product.currency || 'AZN');
                        quickViewWhatsappBtn.setAttribute('data-product-url', product.url || `${window.location.origin}/${locale}/products/${product.slug || product.id}`);
                        quickViewWhatsappBtn.setAttribute('data-product-has-discount', hasDiscount ? 'true' : 'false');
                        quickViewWhatsappBtn.setAttribute('data-product-discount-text', discountText || '');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading quick view:', error);
                $('#quickViewName').text('{{ __("quick_view.Error loading product") }}');
                $('#quickViewPrice').text('-');
            }
        });
        
        return false;
    });
    
    // Add to cart from product card
    $(document).on('click', '.js-add-cart:not(.js-add-cart-from-quickview)', function(e) {
        e.preventDefault();
        const btn = $(this);
        const productId = btn.data('product-id');
        
        if (productId) {
            addToCart(productId, 1).then(success => {
                if (success) {
                    // Open cart drawer if it has the class, using theme's method
                    if (btn.hasClass('js-open-aside')) {
                        const aside = btn.data('aside');
                        if (aside) {
                            const asideEl = document.getElementById(aside);
                            if (asideEl) {
                                // Use theme's helpers and classes
                                if (typeof UomoHelpers !== 'undefined' && UomoHelpers.showPageBackdrop) {
                                    UomoHelpers.showPageBackdrop();
                                }
                                asideEl.classList.add('aside_visible');
                            }
                        }
                    }
                }
            });
        }
        
        return false;
    });
    
    // Add to cart from quick view
    $(document).on('click', '.js-add-cart-from-quickview', function(e) {
        e.preventDefault();
        const btn = $(this);
        const productIdEl = document.getElementById('quickViewProductId');
        const quantityEl = document.getElementById('quickViewQuantity');
        
        if (productIdEl && quantityEl) {
            const productId = productIdEl.value;
            const quantity = parseInt(quantityEl.value) || 1;
            
            if (!productId) {
                console.error('Product ID not found in quick view');
                return false;
            }
            
            // Disable button to prevent double clicks
            btn.prop('disabled', true).text('{{ __("scripts.Adding...") }}');
            
            addToCart(productId, quantity).then(success => {
                // Re-enable button
                btn.prop('disabled', false).text('{{ __("buttons.Add to Cart") }}');
                
                if (success) {
                    // Get aside ID before closing modal
                    const aside = btn.data('aside') || 'cartDrawer';
                    
                    // Close quick view modal first
                    const quickViewModalEl = document.getElementById('quickView');
                    if (quickViewModalEl) {
                        // Listen for modal close event, then open cart drawer using theme's method
                        $(quickViewModalEl).one('hidden.bs.modal', function() {
                            // Open cart drawer using theme's original method
                            const asideEl = document.getElementById(aside);
                            if (asideEl) {
                                // Use theme's helpers and classes
                                if (typeof UomoHelpers !== 'undefined' && UomoHelpers.showPageBackdrop) {
                                    UomoHelpers.showPageBackdrop();
                                }
                                asideEl.classList.add('aside_visible');
                            } else {
                                console.error('Cart drawer element not found:', aside);
                            }
                        });
                        
                        // Try Bootstrap 5 modal instance
                        const quickViewModal = bootstrap.Modal.getInstance(quickViewModalEl);
                        if (quickViewModal) {
                            quickViewModal.hide();
                        } else {
                            // Fallback: hide manually
                            $(quickViewModalEl).modal('hide');
                        }
                    } else {
                        // If modal element not found, just open cart drawer using theme's method
                        const asideEl = document.getElementById(aside);
                        if (asideEl) {
                            if (typeof UomoHelpers !== 'undefined' && UomoHelpers.showPageBackdrop) {
                                UomoHelpers.showPageBackdrop();
                            }
                            asideEl.classList.add('aside_visible');
                        }
                    }
                } else {
                    alert('Ürün sepete eklenirken bir hata oluştu. Lütfen tekrar deneyin.');
                }
            });
        }
        
        return false;
    });
    
    // Quantity control in quick view - increase
    $(document).on('click', '#quickView .qty-control__increase', function(e) {
        e.preventDefault();
        const input = document.getElementById('quickViewQuantity');
        if (input) {
            const currentValue = parseInt(input.value) || 1;
            input.value = currentValue + 1;
        }
        return false;
    });
    
    // Quantity control in quick view - decrease
    $(document).on('click', '#quickView .qty-control__reduce', function(e) {
        e.preventDefault();
        const input = document.getElementById('quickViewQuantity');
        if (input) {
            const currentValue = parseInt(input.value) || 1;
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
        return false;
    });
    
    // Override theme.js quick view swiper handler to prevent errors
    // Run after DOM and theme.js are loaded
    $(document).ready(function() {
        // Remove existing handler
        $('#quickView.modal').off('shown.bs.modal');
        
        // Add safe handler
        $('#quickView.modal').on('shown.bs.modal', function(e) {
            // Fix aria-hidden issue
            const modalEl = document.getElementById('quickView');
            if (modalEl) {
                modalEl.removeAttribute('aria-hidden');
                modalEl.setAttribute('aria-modal', 'true');
            }
            
            var paneTarget = "#quickView";
            var $thePane = $('.modal' + paneTarget);
            if ($thePane.find('.swiper-container').length > 0) {
                document.querySelectorAll('.modal' + paneTarget + ' .swiper-container').forEach(function(item) {
                    if (item.swiper && typeof item.swiper.update === 'function') {
                        try {
                            item.swiper.update();
                            if (typeof item.swiper.lazy !== 'undefined' && typeof item.swiper.lazy.load === 'function') {
                                item.swiper.lazy.load();
                            }
                        } catch (err) {
                            // Silently ignore errors
                        }
                    }
                });
            }
        });
    });
    
    // Wishlist functions
    function getWishlist() {
        return JSON.parse(localStorage.getItem('wishlist') || '[]');
    }
    
    function saveWishlist(wishlist) {
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
        updateWishlistUI();
        // Trigger custom event for same-tab updates
        document.dispatchEvent(new CustomEvent('wishlistUpdated'));
    }
    
    function addToWishlist(productId) {
        const wishlist = getWishlist();
        if (!wishlist.includes(productId)) {
            wishlist.push(productId);
            saveWishlist(wishlist);
            return true;
        }
        return false;
    }
    
    function removeFromWishlist(productId) {
        const wishlist = getWishlist();
        const index = wishlist.indexOf(productId);
        if (index > -1) {
            wishlist.splice(index, 1);
            saveWishlist(wishlist);
            return true;
        }
        return false;
    }
    
    function isInWishlist(productId) {
        const wishlist = getWishlist();
        return wishlist.includes(productId);
    }
    
    function updateWishlistUI() {
        const wishlist = getWishlist();
        const count = wishlist.length;
        
        // Update header count
        const countElements = document.querySelectorAll('.js-wishlist-items-count');
        countElements.forEach(el => {
            if (count > 0) {
                el.textContent = count;
                el.style.display = 'block';
            } else {
                el.textContent = '0';
                el.style.display = 'none';
            }
        });
        
        // Update wishlist buttons
        document.querySelectorAll('.js-add-wishlist').forEach(btn => {
            const productId = parseInt(btn.getAttribute('data-product-id'));
            if (productId) {
                const icon = btn.querySelector('.js-wishlist-icon');
                const text = btn.querySelector('.js-wishlist-text');
                
                if (isInWishlist(productId)) {
                    if (icon) {
                        icon.style.fill = '#d6001c';
                        const useEl = icon.querySelector('use');
                        if (useEl) {
                            icon.setAttribute('fill', '#d6001c');
                        }
                    }
                    if (text) text.textContent = '{{ __("wishlist.Remove from Wishlist") }}';
                    btn.classList.add('wishlist-active');
                } else {
                    if (icon) {
                        icon.style.fill = '';
                        icon.removeAttribute('fill');
                    }
                    if (text) text.textContent = '{{ __("wishlist.Add to Wishlist") }}';
                    btn.classList.remove('wishlist-active');
                }
            }
        });
    }
    
    // Wishlist button handlers
    document.addEventListener('click', function(e) {
        const wishlistBtn = e.target.closest('.js-add-wishlist');
        if (wishlistBtn) {
            e.preventDefault();
            const productId = parseInt(wishlistBtn.getAttribute('data-product-id'));
            if (productId) {
                if (isInWishlist(productId)) {
                    removeFromWishlist(productId);
                    if (typeof toastr !== 'undefined') {
                        toastr.success('{{ __("scripts.Removed from wishlist") }}', '{{ __("scripts.Wishlist") }}');
                    }
                } else {
                    addToWishlist(productId);
                    if (typeof toastr !== 'undefined') {
                        toastr.success('{{ __("scripts.Added to wishlist") }}', '{{ __("scripts.Wishlist") }}');
                    }
                }
            }
        }
    });
    
    // Quick View WhatsApp button handler
    document.addEventListener('click', function(e) {
        const whatsappBtn = e.target.closest('#quickViewWhatsappOrderBtn');
        if (whatsappBtn) {
            e.preventDefault();
            
            // Get product data from button attributes
            const productData = {
                id: whatsappBtn.getAttribute('data-product-id'),
                name: whatsappBtn.getAttribute('data-product-name'),
                price: parseFloat(whatsappBtn.getAttribute('data-product-price')) || 0,
                originalPrice: parseFloat(whatsappBtn.getAttribute('data-product-original-price')) || 0,
                currency: whatsappBtn.getAttribute('data-product-currency') || 'AZN',
                url: whatsappBtn.getAttribute('data-product-url'),
                hasDiscount: whatsappBtn.getAttribute('data-product-has-discount') === 'true',
                discountText: whatsappBtn.getAttribute('data-product-discount-text')
            };
            
            // Get quantity from quick view
            const qtyInput = document.getElementById('quickViewQuantity');
            const quantity = qtyInput ? parseInt(qtyInput.value) || 1 : 1;
            
            // Store product data in window for use by branch selection
            window.singleProductOrder = {
                product: productData,
                quantity: quantity
            };
            
            // Close quick view modal first
            const quickViewModalEl = document.getElementById('quickView');
            if (quickViewModalEl) {
                const quickViewModal = bootstrap.Modal.getInstance(quickViewModalEl);
                if (quickViewModal) {
                    quickViewModal.hide();
                }
            }
            
            // Open branch selection modal after quick view closes
            setTimeout(function() {
                if (typeof window.loadBranchesAndShowModalForSingleProduct === 'function') {
                    window.loadBranchesAndShowModalForSingleProduct('branchSelectionModal', 'branchList');
                } else {
                    console.error('loadBranchesAndShowModalForSingleProduct function not found');
                }
            }, 300);
        }
    });
    
    // Initialize cart UI on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartUI();
        updateWishlistUI();
        initAgeVerification();
        
        // Attach WhatsApp listener initially
        attachCartDrawerWhatsappListener();
        
        // Attach WhatsApp listener when cart drawer is opened
        const cartDrawer = document.getElementById('cartDrawer');
        if (cartDrawer) {
            // Use MutationObserver to detect when cart drawer is opened
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        if (cartDrawer.classList.contains('aside_visible')) {
                            // Cart drawer is now visible, attach WhatsApp listener
                            setTimeout(function() {
                                attachCartDrawerWhatsappListener();
                            }, 100);
                        }
                    }
                });
            });
            
            observer.observe(cartDrawer, {
                attributes: true,
                attributeFilter: ['class']
            });
        }
    });
    
    // Override theme.js newsletter popup to prevent it from showing
    window.onload = function() {
        // Prevent theme.js from showing newsletter popup
        // Age verification will be handled by initAgeVerification()
    };
    
    // Age Verification
    function initAgeVerification() {
        const ageVerificationKey = 'age_verification_accepted';
        const ageVerificationPopup = document.getElementById('ageVerificationPopup');
        
        // Check if age verification is enabled via Settings
        const ageVerificationEnabled = @json(settings('age_verification_enabled', true));
        
        if (!ageVerificationEnabled || !ageVerificationPopup) return;
        
        // Check if age verification was already accepted (check both cookie and localStorage)
        const cookieAccepted = getCookie(ageVerificationKey) === 'true';
        const localStorageAccepted = localStorage.getItem(ageVerificationKey) === 'true';
        
        if (!cookieAccepted && !localStorageAccepted) {
            // Show popup if not accepted
            const modal = new bootstrap.Modal(ageVerificationPopup, {
                backdrop: 'static',
                keyboard: false
            });

            // Remove aria-hidden when modal is shown to prevent accessibility warning
            ageVerificationPopup.addEventListener('shown.bs.modal', function() {
                this.removeAttribute('aria-hidden');
            });

            modal.show();
        }
        
        // Handle "Yes" button click
        const yesButton = document.querySelector('.js-age-verify-yes');
        if (yesButton) {
            yesButton.addEventListener('click', function() {
                // Save to cookie (expires in 1 year)
                setCookie(ageVerificationKey, 'true', 365);
                // Save to localStorage
                localStorage.setItem(ageVerificationKey, 'true');

                // Blur focused element to prevent aria-hidden warning
                if (document.activeElement) {
                    document.activeElement.blur();
                }

                // Hide modal
                const modal = bootstrap.Modal.getInstance(ageVerificationPopup);
                if (modal) {
                    modal.hide();
                }
            });
        }
        
        // Handle "No" button click
        const noButton = document.querySelector('.js-age-verify-no');
        if (noButton) {
            noButton.addEventListener('click', function() {
                // Redirect to Google
                window.location.href = 'https://www.google.com';
            });
        }
    }
    
    // Cookie helper functions
    function setCookie(name, value, days) {
        const expires = new Date();
        expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = name + '=' + value + ';expires=' + expires.toUTCString() + ';path=/';
    }
    
    function getCookie(name) {
        const nameEQ = name + '=';
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }
})();
</script>

<!-- Branch Phone Slider Script -->
@if(isset($headerBranches) && $headerBranches->isNotEmpty())
<script>
(function() {
    'use strict';
    
    function initBranchPhoneSlider() {
        const desktopWrapper = document.getElementById('desktopPhoneSliderWrapper');
        const mobileWrapper = document.getElementById('mobilePhoneSliderWrapper');
        
        function createSlider(wrapper) {
            if (!wrapper) return;
            
            const items = wrapper.querySelectorAll('.header-phone-item');
            if (items.length <= 1) return;
            
            let currentIndex = 0;
            const itemHeight = 40; // height of each item in pixels (matches CSS)
            const slideInterval = 3000; // 3 seconds
            
            // Set initial position
            wrapper.style.transition = 'transform 0.5s ease-in-out';
            wrapper.style.transform = `translateY(0)`;
            
            // Auto-slide function
            function slideNext() {
                currentIndex = (currentIndex + 1) % items.length;
                const translateY = -currentIndex * itemHeight;
                wrapper.style.transform = `translateY(${translateY}px)`;
            }
            
            // Start auto-sliding
            let intervalId = setInterval(slideNext, slideInterval);
            
            // Pause on hover
            const sliderContainer = wrapper.closest('.header-phone-slider');
            if (sliderContainer) {
                sliderContainer.addEventListener('mouseenter', function() {
                    if (intervalId) {
                        clearInterval(intervalId);
                        intervalId = null;
                    }
                });
                
                sliderContainer.addEventListener('mouseleave', function() {
                    if (!intervalId) {
                        intervalId = setInterval(slideNext, slideInterval);
                    }
                });
            }
        }
        
        // Initialize only desktop slider (mobile doesn't have slider anymore)
        createSlider(desktopWrapper);
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBranchPhoneSlider);
    } else {
        initBranchPhoneSlider();
    }
})();
</script>
@endif

<!-- Mobile Search Trigger Script -->
<script>
(function() {
    'use strict';

    // Mobile search trigger from bottom menu
    document.addEventListener('DOMContentLoaded', function() {
        const mobileSearchTrigger = document.querySelector('.js-mobile-search-trigger');
        const mobileNavActivator = document.querySelector('.mobile-nav-activator');
        const mobileSearchInput = document.getElementById('mobileSearchInput');
        const body = document.body;
        const headerMobile = document.querySelector('.header-mobile');
        const mobileDropdown = headerMobile ? headerMobile.querySelector('.header-mobile__navigation') : null;

        if (mobileSearchTrigger && mobileNavActivator && mobileSearchInput) {
            mobileSearchTrigger.addEventListener('click', function(e) {
                e.preventDefault();

                // Check if menu is already open
                const isMenuOpen = body.classList.contains('mobile-menu-opened');

                // If menu is not open, open it first
                if (!isMenuOpen) {
                    // Open mobile menu (same logic as theme.js)
                    body.classList.add('mobile-menu-opened');
                    if (headerMobile) {
                        const scrollWidth = window.innerWidth - document.documentElement.clientWidth;
                        headerMobile.style.paddingRight = scrollWidth + 'px';
                        if (mobileDropdown) {
                            mobileDropdown.style.paddingRight = scrollWidth + 'px';
                        }
                    }

                    // Wait for menu animation to complete, then focus input
                    setTimeout(function() {
                        if (mobileSearchInput) {
                            mobileSearchInput.focus();
                            // Scroll to input smoothly
                            mobileSearchInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }, 400); // Wait for menu animation (0.35s + small buffer)
                } else {
                    // Menu is already open, just focus the input
                    mobileSearchInput.focus();
                    mobileSearchInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        }
    });
})();
</script>

<!-- Service Worker Registration (PWA) -->
<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('[PWA] Service Worker registered with scope:', registration.scope);
            })
            .catch(function(error) {
                console.log('[PWA] Service Worker registration failed:', error);
            });
    });
}
</script>
