<!DOCTYPE html>
<!--
* this admin panel developed by Obaida Attaee
* @twitter obaida_attaee
* @github obaidaattaee
-->
<!-- Breadcrumb-->
<html lang="{{ app()->getLocale() }}" dir="{{ \LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="{{ config()->get('settings.app_name', config()->get('app.app_name')) }}">
    <meta name="author" content="Obaida Attaee">
    {{-- <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard"> --}}
    <title>{{ config()->get('settings.app_name', config()->get('app.app_name')) }} @yield('title')</title>
    <link rel="manifest" src="{{ asset('admin_assets/assets/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">

    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{ asset('admin_assets/vendors/simplebar/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/vendors/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/icons/coreui-icons-master/css/all.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="shortcut icon" href="{{ asset('admin_assets/assets/img/default_logo.png') }}" type="image/x-icon">
    <!-- Main styles for this application-->
    <link href="{{ asset('admin_assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_assets/css/examples.css') }}" rel="stylesheet">

    @yield('css')
</head>

<body>
    @include('admin.layouts.sidebar')
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
        <!-- start header section -->
        <header class="header header-sticky mb-4">
            <div class="container-fluid">
                <button class="header-toggler px-md-0 me-md-3" type="button"
                    onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                    <svg class="icon icon-lg">
                        <use xlink:href="{{ asset('admin_assets/vendors/@coreui/icons/svg/free.svg#cil-menu') }}">
                        </use>
                    </svg>
                </button>
                <a class="header-brand d-md-none" href="#">
                    <img src="{{ config()->get('settings.app_logo') }}" class="sidebar-brand-narrow" width="118" height="46"
            alt="">
                    {{-- <svg width="118" height="46" alt="CoreUI Logo">
                        <use xlink:src="{{ asset('admin_assets/assets/brand/coreui.svg#full') }}"></use>
                    </svg> --}}
                </a>
                <ul class="header-nav ms-auto">
                    <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#"
                            role="button" aria-haspopup="true" aria-expanded="false">
                            <div class=""><img class=""
                                    src="{{ asset('admin_assets/assets/icons/language.svg') }}"
                                    alt="{{ t('language') }}"></div>
                        </a>
                        {{-- {{ dd(LaravelLocalization::getSupportedLocales()) }} --}}
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                            @foreach (LaravelLocalization::getSupportedLocales() as $local => $language)
                                <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($local) }}">
                                    {{ $language['native'] }}
                                </a>
                            @endforeach
                        </div>
                    </li>
                </ul>

                <ul class="header-nav ms-3">
                    <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#"
                            role="button" aria-haspopup="true" aria-expanded="false">
                            <div class="avatar avatar-md"><img class="avatar-img" src="admin_assets/assets/img/default_logo.png"
                                    alt="{{ auth()->user()->name }}"></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                            <a class="dropdown-item" href="#">
                                <svg class="icon me-2">
                                    <use
                                        xlink:href="{{ asset('admin_assets/vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}">
                                    </use>

                                </svg>

                                <span
                                    onclick="event.preventDefault(); document.getElementById('logout_form').submit();">
                                    {{ __('Log Out') }}
                                </span>
                            </a>
                            <form method="POST" id="logout_form" action="{{ route('logout') }}">
                                @csrf
                            </form>

                        </div>
                    </li>
                </ul>
            </div>
            <div class="header-divider"></div>
            @yield('breadcrumb')
        </header>
        <!-- end header section -->

        <!-- start content section -->
        <div class="body flex-grow-1 px-3">
            <div class="container-lg">
                @yield('content')

            </div>
        </div>
        <!-- end content section -->

        <!-- start footer section -->
        @include('admin.layouts.footer')
        <!-- end footer section -->

    </div>

    <div class="loader">
        <div class="loadingio-eclipse">
            <div class="ldio-rpinwye8j0b">
                <div>
                </div>
            </div>
        </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('admin_assets/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendors/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin_assets/icons/coreui-icons-master/js/index.js') }}"></script>
    <script src="{{ asset('admin_assets/js/jquery.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        toastr.options.timeOut = 6000;
        toastr.options.extendedTimeOut = 0;
    </script>

    <script>
        $('.search-button').on('click' , function(event){
            event.preventDefault()

            $('.search-section').toggleClass('d-none')
        })
    </script>
    @yield('javascript')
</body>

</html>
