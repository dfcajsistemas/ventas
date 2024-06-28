<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-navbar-fixed layout-wide"
    dir="ltr" data-theme="theme-default" data-assets-path="{{asset('assets')}}/" data-template="front-pages">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Intranet | SisCaj</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/front-page.css') }}" />
    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/nouislider/nouislider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />

    <!-- Page CSS -->

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/front-page-landing.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/front-config.js') }}"></script>

    <!-- Page CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/ui-carousel.css') }}" /> --}}
</head>

<body>


    <!-- Navbar: Start -->
    <nav class="layout-navbar shadow-none py-0">
        <div class="container">
            <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-4">
                <!-- Menu logo wrapper: Start -->
                <div class="navbar-brand app-brand demo d-flex py-0 me-4">
                    <!-- Mobile menu toggle: Start-->
                    <button class="navbar-toggler border-0 px-0 me-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="tf-icons bx bx-menu bx-sm align-middle"></i>
                    </button>
                    <!-- Mobile menu toggle: End-->
                    <a href="{{ route('intranet') }}" class="app-brand-link">
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
                        <span class="app-brand-text demo menu-text fw-bold ms-2 ps-1">quipu</span>
                    </a>
                </div>
                <!-- Menu logo wrapper: End -->
                <!-- Menu wrapper: Start -->
                <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
                    <button class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl"
                        type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="tf-icons bx bx-x bx-sm"></i>
                    </button>
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link fw-medium" aria-current="page"
                                href="{{ route('intranet') }}#inicio">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('intranet') }}#noticias">Noticias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('intranet') }}#directorio">Directorio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('intranet') }}#enlaces">Enlaces</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('intranet') }}#documentos">Documentos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('intranet') }}#boletines">Boletines</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('intranet') }}#cumpleaneros">Cumpleñeros</a>
                        </li>
                    </ul>
                </div>
                <div class="landing-menu-overlay d-lg-none"></div>
                <!-- Menu wrapper: End -->
                <!-- Toolbar: Start -->
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

                    <!-- navbar button: Start -->
                    @if (Route::has('login'))
                        <li>
                            @auth
                                <a href="{{ route('espacio') }}" class="btn btn-primary" target="_blank">
                                    <span class="tf-icons bx bx-user me-md-1"></span>
                                    <span class="d-none d-md-block">Mi Espacio</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary" target="_blank">
                                    <span class="tf-icons bx bx-user me-md-1"></span>
                                    <span class="d-none d-md-block">Ingresar</span>
                                </a>
                            @endauth
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary" target="_blank">
                                    <span class="tf-icons bx bx-user me-md-1"></span>
                                    <span class="d-none d-md-block">Registro</span>
                                </a>
                            @endif
                        @else
                        </li>
                    @endif
                    <!-- navbar button: End -->
                </ul>
                <!-- Toolbar: End -->
            </div>
        </div>
    </nav>
    <!-- Navbar: End -->

    <!-- Sections:Start -->

    <div data-bs-spy="scroll" class="scrollspy-example">
        <!--Inicio: Inicio -->
        <section class="section-py bg-body first-section-pt">
          <div class="container">
            <div class="card px-3">
              <div class="row">
                <div class="col-lg-9 card-body border-end">
                    <div id="carouselIntranet" class="carousel slide col-md-12" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                          <button type="button" data-bs-target="#carouselIntranet" data-bs-slide-to="0" class="active"></button>
                          <button type="button" data-bs-target="#carouselIntranet" data-bs-slide-to="1"></button>
                          <button type="button" data-bs-target="#carouselIntranet" data-bs-slide-to="2"></button>
                        </div>
                        <div class="carousel-inner">
                          <div class="carousel-item active">
                            <img class="d-block w-100" src="{{asset('assets/img/elements/13_c.jpg')}}" alt="First slide" />
                            <div class="carousel-caption d-none d-md-block">
                              <h3>First slide</h3>
                              <p>Eos mutat malis maluisset et, agam ancillae quo te, in vim congue pertinacia.</p>
                            </div>
                          </div>
                          <div class="carousel-item">
                            <img class="d-block w-100" src="{{asset('assets/img/elements/2_c.jpg')}}" alt="Second slide" />
                            <div class="carousel-caption d-none d-md-block">
                              <h3>Second slide</h3>
                              <p>In numquam omittam sea.</p>
                            </div>
                          </div>
                          <div class="carousel-item">
                            <img class="d-block w-100" src="{{asset('assets/img/elements/18_c.jpg')}}" alt="Third slide" />
                            <div class="carousel-caption d-none d-md-block">
                              <h3>Third slide</h3>
                              <p>Lorem ipsum dolor sit amet, virtute consequat ea qui, minim graeco mel no.</p>
                            </div>
                          </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExample" role="button" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExample" role="button" data-bs-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Next</span>
                        </a>
                      </div>
                </div>
                <div class="col-lg-3 card-body">
                  <h4 class="mb-2">Anuncios</h4>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!--Inicio: Fin -->
      </div>

    <!-- / Sections:End -->

    <!-- Footer: Start -->
    <footer class="landing-footer bg-body footer-text">
        <div class="footer-bottom py-3">
            <div
                class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
                <div class="mb-2 mb-md-0">
                    <span class="footer-text">©
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                    </span>
                    <a href="https://themeselection.com" target="_blank"
                        class="fw-medium text-white footer-link">ThemeSelection,</a>
                    <span class="footer-text"> Made with ❤️ for a better web.</span>
                </div>
                <div>
                    <a href="https://www.facebook.com/ThemeSelections/" class="footer-link me-3" target="_blank">
                        <img src="../../assets/img/front-pages/icons/facebook-light.png" alt="facebook icon"
                            data-app-light-img="front-pages/icons/facebook-light.png"
                            data-app-dark-img="front-pages/icons/facebook-dark.png" />
                    </a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer: End -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/js/dropdown-hover.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/mega-dropdown.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/nouislider/nouislider.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/front-main.js') }}"></script>

    <!-- Page JS -->
    {{-- <script src="{{ asset('assets/js/front-page-landing.js') }}"></script> --}}

    <!-- Carousel -->
    <script src="{{ asset('assets/js/ui-carousel.js') }}"></script>
</body>

</html>
