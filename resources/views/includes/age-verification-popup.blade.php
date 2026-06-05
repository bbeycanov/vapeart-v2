@php
    $ageVerificationEnabled = settings('age_verification_enabled', true);
@endphp

@if($ageVerificationEnabled)
<div class="modal fade" id="ageVerificationPopup" tabindex="-1" aria-labelledby="ageVerificationTitle" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog age-verification-popup modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="age-verification-wrapper text-center">
                    <div class="age-verification-brand" id="ageVerificationTitle">
                        <span class="age-brand-main">ALCO ART</span>
                        <span class="age-brand-sub">WINE &amp; TOBACCO</span>
                    </div>

                    <div class="age-verification-icon">
                        <div class="age-icon-circle">
                            <span class="age-icon-text">+18</span>
                        </div>
                    </div>

                    <div class="age-verification-message">
                        <p>{{ __('age_verification.Bu sayt məlumatlandırma və tanıtım məqsədi daşıyır.') }}</p>
                        <p>{{ __('age_verification.Saytda alkoqollu içkilər və tütün məmulatları nümayiş olunur.') }}</p>
                        <p>{{ __('age_verification.Alkoqoldan həddindən artıq istifadə və nikotin sağlamlığınız üçün zərərlidir.') }}</p>
                        <p>{{ __('age_verification.18 yaşı tamam olmamış şəxslərə heç bir məhsul satılmır.') }}</p>
                    </div>

                    <p class="age-verification-warning">{{ __('age_verification.18 yaşı tamam olmamış şəxslərin sayta daxil olması qadağandır!') }}</p>

                    <div class="age-verification-actions">
                        <button type="button" class="btn age-btn age-btn-yes js-age-verify-yes">
                            {{ __('age_verification.Bəli, 18 yaşım tamam olub') }}
                        </button>
                        <button type="button" class="btn age-btn age-btn-no js-age-verify-no">
                            {{ __('age_verification.Xeyr, 18 yaşım tamam olmayıb') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
