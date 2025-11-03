<!DOCTYPE html>
<html dir="ltr" lang="zxx">
    <head>
        <title>VapeartBaku.com</title>

        @include('includes.head')

        @yield('head')
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

    @include('includes.site-map')

    @include('includes.quick-view')

{{--    @include('includes.newsletter-popup')--}}

    @include('includes.scripts')

    </body>
</html>
