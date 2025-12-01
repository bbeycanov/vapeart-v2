<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="author" content="flexkit">

<link rel="shortcut icon" href="{{asset('storefront/images/favicon.ico')}}" type="image/x-icon">
<link rel="preconnect" href="https://fonts.gstatic.com">


<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Inter%3A300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&#038;subset=latin&#038;display=swap&#038;ver=6.8.3' type='text/css' media='all' />

<link rel="stylesheet" href="{{asset('storefront/css/plugins/swiper.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('storefront/css/plugins/jquery.fancybox.css')}}" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" type="text/css">
<link rel="stylesheet" href="{{asset('storefront/css/style.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('storefront/css/pages/cart-index.css')}}" type="text/css">

<!-- Toastr Custom Styles -->
<style>
    * {
        font-family: "Inter", Arial, Helvetica, sans-serif!important;
    }
    /* Toastr Success - Green */
    .toast-success {
        background-color: #51A351 !important;
        color: #ffffff !important;
    }
    
    /* Toastr Error - Red */
    .toast-error {
        background-color: #BD362F !important;
        color: #ffffff !important;
    }
    
    /* Toastr Warning - Orange */
    .toast-warning {
        background-color: #F89406 !important;
        color: #ffffff !important;
    }
    
    /* Toastr Info - Blue */
    .toast-info {
        background-color: #2F96B4 !important;
        color: #ffffff !important;
    }
    
    /* Toastr Title */
    #toast-container > div .toast-title {
        color: #ffffff !important;
        font-weight: bold;
    }
    
    /* Toastr Message */
    #toast-container > div .toast-message {
        color: #ffffff !important;
    }
    
    /* Toastr Close Button */
    #toast-container > div .toast-close-button {
        color: #ffffff !important;
        opacity: 0.8;
    }
    
    #toast-container > div .toast-close-button:hover {
        opacity: 1;
    }
</style>


<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

