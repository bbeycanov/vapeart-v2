<!-- Universal Branch Selection Modal -->
<div class="modal fade" id="branchSelectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable branch-modal-dialog">
        <div class="modal-content branch-modal-content">
            <div class="modal-header branch-modal-header">
                <div class="d-flex align-items-center">
                    <div class="branch-modal-icon me-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="branchModalTitle">{{ __('branch.Select Branch') }}</h5>
                        <p class="modal-subtitle mb-0">{{ __('branch.Sifariş üçün filial seçin') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body branch-modal-body">
                <div id="branchList" class="branch-grid">
                    <!-- Branches will be loaded dynamically or statically -->
                    @if(isset($headerBranches) && $headerBranches->isNotEmpty())
                        @foreach($headerBranches as $branch)
                            <div class="branch-card" data-branch-id="{{ $branch['id'] ?? '' }}" data-branch-phone="{{ $branch['phone'] ?? '' }}" data-branch-whatsapp="{{ $branch['whatsapp'] ?? $branch['phone'] ?? '' }}">
                                <div class="branch-card-header">
                                    <div class="branch-card-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <h6 class="branch-card-name">{{ $branch['name'] }}</h6>
                                </div>

                                @if(!empty($branch['address']))
                                <div class="branch-card-info">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                    <span>{{ $branch['address'] }}</span>
                                </div>
                                @endif

                                @if(!empty($branch['phone']))
                                <div class="branch-card-info">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                    </svg>
                                    <span>{{ $branch['phone'] }}</span>
                                </div>
                                @endif

                                <div class="branch-card-actions">
                                    @if(!empty($branch['phone']))
                                    <a href="tel:{{ $branch['phone'] }}" class="branch-action-btn branch-action-call">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.384 17.752a2.108 2.108 0 0 1-.522 3.359 7.674 7.674 0 0 1-5.478.642C4.933 20.428 1.48 7.378 4.268 3.384a2.108 2.108 0 0 1 3.359-.522l2.409 2.409a2.108 2.108 0 0 1 .396 2.396l-.923 1.846a.316.316 0 0 0 .063.396c1.429 1.114 3.312 2.997 4.426 4.426a.316.316 0 0 0 .396.063l1.846-.923a2.108 2.108 0 0 1 2.396.396l2.409 2.409z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>{{ __('common.Call') }}</span>
                                    </a>
                                    @endif

                                    @if(!empty($branch['whatsapp']) || !empty($branch['phone']))
                                    <button type="button" class="branch-action-btn branch-action-whatsapp" data-branch-whatsapp="{{ $branch['whatsapp'] ?? $branch['phone'] }}">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                        </svg>
                                        <span>WhatsApp</span>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle static WhatsApp buttons in branch modal (for simple contact, not orders)
    const branchModal = document.getElementById('branchSelectionModal');
    if (branchModal) {
        branchModal.addEventListener('shown.bs.modal', function() {
            // Check if this is a static modal (has static branch cards without order-type)
            const staticWhatsappBtns = branchModal.querySelectorAll('.branch-action-whatsapp:not([data-order-type])');

            staticWhatsappBtns.forEach(btn => {
                // Remove existing listeners by cloning
                const newBtn = btn.cloneNode(true);
                btn.parentNode.replaceChild(newBtn, btn);

                // Add click handler for simple WhatsApp contact
                const handleClick = function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const whatsappNumber = this.getAttribute('data-branch-whatsapp');
                    if (!whatsappNumber) return;

                    const phoneNumber = whatsappNumber.replace(/[\s+]/g, '');
                    const message = encodeURIComponent('Salam! Sizinlə əlaqə saxlamaq istəyirəm.');
                    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${message}`;

                    // Close modal
                    const modal = bootstrap.Modal.getInstance(branchModal);
                    if (modal) {
                        modal.hide();
                    }

                    window.open(whatsappUrl, '_blank');
                };

                newBtn.addEventListener('click', handleClick);
                newBtn.addEventListener('touchend', handleClick);
            });
        });
    }
});
</script>
@endpush
