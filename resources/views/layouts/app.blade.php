<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed" dir="ltr"
    data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $modulo }} {{ $pagina ? '- ' . $pagina : '' }} | {{ config('app.name', 'Laravel') }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />

    <style>
        .overlay {
            display: flex;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 1900;
            justify-content: center;
            align-items: center;
            background-color: rgba(0,0,0,0.6);
        }
    </style>

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>

    @livewireStyles
</head>

<body>
    <div class="overlay hide" wire:loading>
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('espacio') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <svg width="25" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 67.7">
                                <g>
                                    <path fill="#696cff"
                                        d="M29.9,14c-2.2,2.2-3.9,4.1-4.9,5.5c-1,1.4-2.1,3.5-3.3,6.2c-0.9,2-1.5,4-1.9,6.2c-0.5,1.9-0.7,4.4-0.7,7.4c0,4.3,0.4,7.8,1.2,10.7 c0.8,2.8,2,5,3.6,6.4c1.6,1.4,3.5,2.2,5.8,2.2c1.8,0,3.7-0.7,5.6-2c1.9-1.3,3.6-3.1,5.2-5.2c1.5-2.2,2.8-4.6,3.7-7.3 c0.9-2.7,1.4-5.2,1.4-7.7c0-4.5-1.5-9.1-4.6-14c-1.1-2-1.7-3.3-1.7-4c0-1.3,0.7-2.7,2.2-4c1.7-1.6,3.6-3,5.7-4.2 c2.1-1.2,3.8-1.9,5.1-1.9c0.7,0,1.5,0.2,2.3,0.5c0.8,0.3,1.4,0.8,1.8,1.3c1,1.1,1.9,3.1,2.6,5.9s1,5.9,1,9.2 c0,7.7-1.6,14.8-4.7,21.3c-3.1,6.5-7.4,11.6-12.8,15.4c-5.4,3.8-11.2,5.7-17.5,5.7c-3.6,0-7.2-0.7-10.7-2c-3.5-1.3-6.4-3.1-8.6-5.4 C1.9,56.6,0,51.7,0,45.6c0-3.5,0.7-7.2,2.1-11.2c1.4-3.9,3.2-7.8,5.6-11.5c2.4-3.7,5.2-7.1,8.3-10.2c3.1-3.1,6.4-5.5,9.7-7.3 c3-1.6,6.3-2.9,9.8-3.9C38.9,0.5,42,0,44.6,0c3.7,0,5.6,0.6,5.6,1.7c0,0.5-0.4,1.2-1.2,2.1c-1.4,1.3-2.7,2.3-3.7,2.8 c-1.1,0.6-2.8,1.2-5.2,1.9c-2.6,0.8-4.5,1.5-5.7,2.1S31.8,12.4,29.9,14z" />
                                </g>
                                <path fill="#696cff" fill-opacity="0.8" d="M41.1,35.8l16.7,16.7c3,3,3,7.8,0,10.8l-3.6,3.6c-1,1-2.7,1-3.7,0L30.2,46.7c-3-3-3-7.8,0-10.8l0,0
                                  C33.2,32.8,38.1,32.8,41.1,35.8z" />
                            </svg>
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold ms-2">Quipu</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>
                <x-menu :modulo="$modulo" />
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item navbar-search-wrapper mb-0">
                                <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                                    <i class="bx bx-search bx-sm"></i>
                                    <span class="d-none d-md-inline-block text-muted">Buscar (Ctrl+/)</span>
                                </a>
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Style Switcher -->
                            <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-sm"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                            <span class="align-middle"><i class="bx bx-sun me-2"></i>Light</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                            <span class="align-middle"><i class="bx bx-moon me-2"></i>Dark</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                            <span class="align-middle"><i class="bx bx-desktop me-2"></i>System</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- / Style Switcher-->
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/img/avatars/sinfoto.png') }}"
                                            alt class="w-px-40 h-auto rounded-circle">
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/img/avatars/sinfoto.png') }}"
                                                            alt class="w-px-40 h-auto rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <small class="text-muted">Bienvenido</small>
                                                    <span class="fw-medium d-block">
                                                        @if (Auth::check())
                                                            {{ Auth::user()->name }}
                                                        @else
                                                            No identificado
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('espacio') }}">
                                            <i class="fa-solid fa-house-user me-2"></i>
                                            <span class="align-middle">Mi espacio</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    @if (Auth::check())
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="bx bx-power-off me-2"></i>
                                                <span class="align-middle">Log Out</span>
                                            </a>
                                        </li>
                                        <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                            @csrf
                                        </form>
                                    @endif
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>

                    <!-- Search Small Screens -->
                    <div class="navbar-search-wrapper search-input-wrapper d-none">
                        <input type="text" class="form-control search-input container-xxl border-0"
                            placeholder="Buscar..." aria-label="Buscar..." />
                        <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">

                        {{ $slot }}

                    </div>
                    <!-- / Content -->
                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                , ❤️ <b>Informática</b> | Administración | Distrito Fiscal de Cajamarca
                            </div>
                            <div class="d-none d-lg-inline-block">
                                <a href="/" target="_blank" class="footer-link me-4"><i
                                        class="fa-solid fa-globe"></i> Intranet Local</a>
                                <a href="http://intranet.mpfn.gob.pe/" target="_blank" class="footer-link me-4"><i
                                        class="fa-solid fa-globe"></i> Intranet Nacional</a>
                                <a href="https://www.gmail.com/" target="_blank"
                                    class="footer-link d-none d-sm-inline-block"><i class="fa-solid fa-envelope"></i>
                                    Correo</a>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @livewireScripts

    <script>
        function noti(msg, tipo = 'success') {
            toastr.options.progressBar = true;
            toastr[tipo](msg)
        }
        @if (session('error'))
            noti('{{ session('error') }}', 'error');
        @endif
        @if (session('success'))
            noti('{{ session('success') }}');
        @endif
    </script>

    <!-- Page JS -->
    @stack('scripts')

</body>
</html>
