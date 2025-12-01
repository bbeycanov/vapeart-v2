<!DOCTYPE html>
<html dir="ltr" lang="{{ app()->getLocale() }}">
    <head>
        <title>VapeartBaku.com</title>

        @include('includes.head')

        @yield('head')
        
        @stack('styles')
    </head>
    <body>

    @include('includes.svg')

    @include('includes.header')

    <main>
        @yield('content')
    </main>

    @include('includes.footer')

    @include('includes.customer-forms')

    @include('includes.cart-drawer')

    @include('includes.branch-selection-modal')

    @include('includes.site-map')

    @include('includes.quick-view')

    @include('includes.age-verification-popup')

    @include('includes.scripts')

    @stack('scripts')

    </body>
</html>
