<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed" dir="ltr"
    data-theme="theme-default" data-assets-path="/assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title[0] . ' - ' . $title[1] }} | {{ config('app.name', 'Laravel') }}</title>

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
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
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
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('espacio') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <svg id="a" data-name="Capa 1" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 71.28 63.71">
                                <rect x="41.22" y="-3.15" width="16.76" height="70" rx="8.38" ry="8.38"
                                    transform="translate(22.57 -20.53) rotate(30)" fill="#696cff" fill-opacity="0.8"
                                    stroke-width="0" />
                                <rect x="11.75" y="-3.15" width="23" height="70" rx="11.5" ry="11.5"
                                    transform="translate(-12.81 15.89) rotate(-30)" fill="#696cff" stroke-width="0" />
                            </svg>
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold ms-2">VenSis</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>
                <x-menu :modulo="$title[1]" />
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
                                , ❤️ <b>SisVen</b>
                            </div>
                            <div class="d-none d-lg-inline-block">
                                <a href="https://www.gmail.com/" target="_blank"
                                    class="footer-link d-none d-sm-inline-block">
                                    <i class="fa-solid fa-file-lines"></i>
                                    Manuales</a>
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
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @livewireScripts

    @stack('scripts')

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

</body>

</html>
