
<div class="aside aside_right overflow-hidden customer-forms" id="customerForms">
    <div class="customer-forms__wrapper d-flex position-relative">
        <div class="customer__login">
            <div class="aside-header d-flex align-items-center">
                <h3 class="text-uppercase fs-6 mb-0">{{ __('auth.Login') }}</h3>
                <button class="btn-close-lg js-close-aside ms-auto"></button>
            </div>

            <form action="./login_register.html" method="POST" class="aside-content">
                <div class="form-floating mb-3">
                    <input name="email" type="email" class="form-control form-control_gray" id="customerNameEmailInput" placeholder="name@example.com">
                    <label for="customerNameEmailInput">{{ __('auth.Username or email address *') }}</label>
                </div>

                <div class="pb-3"></div>

                <div class="form-label-fixed mb-3">
                    <label for="customerPasswordInput" class="form-label">{{ __('auth.Password *') }}</label>
                    <input name="password" id="customerPasswordInput" class="form-control form-control_gray" type="password" placeholder="********">
                </div>

                <div class="d-flex align-items-center mb-3 pb-2">
                    <div class="form-check mb-0">
                        <input name="remember" class="form-check-input form-check-input_fill" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label text-secondary" for="flexCheckDefault">{{ __('auth.Remember me') }}</label>
                    </div>
                    <a href="#" class="btn-text ms-auto">{{ __('auth.Lost password?') }}</a>
                </div>

                <button class="btn btn-primary w-100 text-uppercase" type="submit">{{ __('auth.Log In') }}</button>

                <div class="customer-option mt-4 text-center">
                    <span class="text-secondary">{{ __('auth.No account yet?') }}</span>
                    <a href="#" class="btn-text js-show-register">{{ __('auth.Create Account') }}</a>
                </div>
            </form>
        </div>

        <div class="customer__register">
            <div class="aside-header d-flex align-items-center">
                <h3 class="text-uppercase fs-6 mb-0">{{ __('auth.Create an account') }}</h3>
                <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
            </div>

            <form action="./login_register.html" method="POST" class="aside-content">
                <div class="form-floating mb-4">
                    <input name="username" type="text" class="form-control form-control_gray" id="registerUserNameInput" placeholder="Username">
                    <label for="registerUserNameInput">{{ __('auth.Username') }}</label>
                </div>

                <div class="pb-1"></div>

                <div class="form-floating mb-4">
                    <input name="email" type="email" class="form-control form-control_gray" id="registerUserEmailInput" placeholder="user@company.com">
                    <label for="registerUserEmailInput">{{ __('auth.Email address *') }}</label>
                </div>

                <div class="pb-1"></div>

                <div class="form-label-fixed mb-4">
                    <label for="registerPasswordInput" class="form-label">{{ __('auth.Password *') }}</label>
                    <input name="password" id="registerPasswordInput" class="form-control form-control_gray" type="password" placeholder="*******">
                </div>

                <p class="text-secondary mb-4">{{ __('auth.Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy.') }}</p>

                <button class="btn btn-primary w-100 text-uppercase" type="submit">{{ __('auth.Register') }}</button>

                <div class="customer-option mt-4 text-center">
                    <span class="text-secondary">{{ __('auth.Already have account?') }}</span>
                    <a href="#" class="btn-text js-show-login">{{ __('auth.Login') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
