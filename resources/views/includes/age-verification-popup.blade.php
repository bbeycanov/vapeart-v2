@php
    $ageVerificationEnabled = settings('age_verification_enabled', true);
@endphp

@if($ageVerificationEnabled)
<div class="modal fade" id="ageVerificationPopup" tabindex="-1" aria-labelledby="ageVerificationTitle" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog age-verification-popup modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="age-verification-wrapper text-center">
                    <h2 class="age-verification-brand mb-4" id="ageVerificationTitle">VAPEART</h2>
                    
                    <div class="age-verification-icon mb-4">
                        <div class="age-icon-circle">
                            <span class="age-icon-text">+18</span>
                        </div>
                    </div>
                    
                    <div class="age-verification-message mb-4">
                        <p class="mb-2">{{ __('age_verification.Bu səhifə tanıtım məqsədi daşıyır.') }}</p>
                        <p class="mb-2">{{ __('age_verification.Səhifədə tütün məmulatları nümayiş olunub.') }}</p>
                        <p class="mb-2">{{ __('age_verification.Nikotin sizin sağlamlığınız üçün zərərlidir.') }}</p>
                        <p class="mb-2">{{ __('age_verification.18 yaşı tamam olmamış şəxslərə heç bir məhsul satılmır.') }}</p>
                        <p class="mb-0 fw-bold">{{ __('age_verification.18 yaşı tamam olmamış şəxslərə səhifəyə daxil olması qadağandır!') }}</p>
                    </div>
                    
                    <div class="age-verification-actions">
                        <button type="button" class="btn btn-primary mb-2 js-age-verify-yes">
                            {{ __('age_verification.Bəli, 18 yaşım tamam olub') }}
                        </button>
                        <button type="button" class="btn btn-outline-primary js-age-verify-no">
                            {{ __('age_verification.Xeyr, 18 yaşım tamam olmayıb') }}
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
