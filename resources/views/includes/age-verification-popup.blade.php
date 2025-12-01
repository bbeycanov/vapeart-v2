@php
    $ageVerificationEnabled = settings('age_verification_enabled', true);
@endphp

@if($ageVerificationEnabled)
<div class="modal fade" id="ageVerificationPopup" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog age-verification-popup modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="age-verification-wrapper text-center">
                    <h2 class="age-verification-brand mb-4">VAPEART</h2>
                    
                    <div class="age-verification-icon mb-4">
                        <div class="age-icon-circle">
                            <span class="age-icon-text">+18</span>
                        </div>
                    </div>
                    
                    <div class="age-verification-message mb-4">
                        <p class="mb-2">Bu səhifə tanıtım məqsədi daşıyır.</p>
                        <p class="mb-2">Səhifədə tütün məmulatları nümayiş olunub.</p>
                        <p class="mb-2">Nikotin sizin sağlamlığınız üçün zərərlidir.</p>
                        <p class="mb-2">18 yaşı tamam olmamış şəxslərə heç bir məhsul satılmır.</p>
                        <p class="mb-0 fw-bold">18 yaşı tamam olmamış şəxslərə səhifəyə daxil olması qadağandır!</p>
                    </div>
                    
                    <div class="age-verification-actions">
                        <button type="button" class="btn btn-primary mb-2 js-age-verify-yes">
                            Bəli, 18 yaşım tamam olub
                        </button>
                        <button type="button" class="btn btn-outline-primary js-age-verify-no">
                            Xeyr, 18 yaşım tamam olmayıb
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('storefront/css/includes/age-verification-popup.css') }}">
@endpush
@endif
