<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Codescandy" />

    <!-- Favicon icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon/favicon.ico') }}" />

    <!-- Darkmode JS -->
    <script src="{{ asset('assets/js/vendors/darkMode.js') }}"></script>

    <!-- Libs CSS -->
    <link href="{{ asset('assets/fonts/feather/feather.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/bootstrap-icons/font/bootstrap-icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/simplebar/dist/simplebar.min.css') }}" rel="stylesheet" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/libs/tiny-slider/dist/tiny-slider.css') }}" />
    <title>@yield('title', 'Homepage | Geeks - Bootstrap 5 Template')</title>
</head>

<body class="bg-white">
    <!-- Page Content -->
<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container px-0">
        <a class="navbar-brand" href="">
         <strong>   AFRICA TRAVEL CAR</strong>
            <!--img src="{{ asset('assets/_ALLO-SERVICES-LOGO-BLANC 1.png') }}" alt="Geeks" width="100"/--></a>
        <div class="ms-auto d-flex align-items-center order-lg-3">
            <div class="d-flex gap-2 align-items-center">
            <a href="" class="btn btn-dark d-none d-md-block">Commencer</a>

                <!-- <a href="" class="btn btn-dark d-none d-md-block">Telecharger l'application</a> -->

            </div>
      
        </div>
      
        <div>
            <button class="navbar-toggler collapsed ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar top-bar mt-0"></span>
                <span class="icon-bar middle-bar"></span>
                <span class="icon-bar bottom-bar"></span>
            </button>
        </div>
        <!-- <div class="collapse navbar-collapse" id="navbar-default">
            <ul class="navbar-nav mt-3 mt-lg-0 mx-xxl-auto">
                <li><a href="" class="dropdown-item">Comment ca marche </a></li>
                <li><a href="" class="dropdown-item">Annuaire</a></li>
            </ul>
        </div> -->
    </div>
</nav>


    <main>
        <!-- Hero Section -->
        @yield('content')
        <!-- Trusted -->
    </main>
<!-- Footer -->
<!-- Footer 
<footer class="footer bg-dark-stable py-8" style="background:#023252">
    <div class="container">
        <div class="row gy-6 gy-xl-0 pb-8">
            <div class="col-xl-6 col-lg-12 col-md-7 col-12">
                <div class="d-flex flex-column gap-4">
                    <div>
                        <img src="{{ asset('assets/_ALLO-SERVICES-LOGO-BLANC 1.png') }}" alt="Geeks logo"  width="100"/>
                    </div>
                    <p class="mb-0">Découvrez et connectez-vous avec les entreprises et professionnels de la Côte d'Ivoire sur notre plateforme dédiée.
                    Notre objectif est construit sur la base du jobbing, un modèle économique entre particuliers. C'est avant tout une mise en relation entre les besoins d'une personne ou une entreprise et la compétence d'une autre.Nous proposons des jobbers aux compétences confirmées aux personnes ou aux entreprises dans le besoin.</p>
                  
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="d-flex flex-column gap-4">
                    <span class="text-white-stable">Pages</span>
                    <ul class="list-unstyled mb-0 d-flex flex-column nav nav-footer nav-x-0">
                        <li><a href="#" class="nav-link">Accueil</a></li>
                        <li><a href="#" class="nav-link">Creation de compte</a></li>
                        <li><a href="#" class="nav-link">Connexion</a></li>
                        <li><a href="" class="nav-link">Annuaire</a></li>

                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 col-6">
                <div class="d-flex flex-column gap-3">
                    <span class="text-white-stable"></span>
                    <ul class="list-unstyled mb-0 d-flex flex-column nav nav-footer nav-x-0">
                        <li><a href="" class="nav-link">Professionel</a></li>
                        <li><a href="" class="nav-link">Entreprise </a></li>
                    </ul>
                        <a href="#"><img src="{{ asset('assets/images/svg/appstore.svg') }}" alt="" class="img-fluid" /></a>
                        <a href="#"><img src="{{ asset('assets/images/svg/playstore.svg') }}" alt="" class="img-fluid" /></a>
                </div>
            </div>
         
           
        </div>
        <div class="py-4" style="background:#023252">
            <div class="container text-center">
                <span class="text-white">© 2024 Allo services Tous droits réservés.</span>
            </div>
        </div>
    </div>
</footer>-->



    <!-- Scroll top -->
    <div class="btn-scroll-top">
        <svg class="progress-square svg-content" width="100%" height="100%" viewBox="0 0 40 40">
            <path d="M8 1H32C35.866 1 39 4.13401 39 8V32C39 35.866 35.866 39 32 39H8C4.13401 39 1 35.866 1 32V8C1 4.13401 4.13401 1 8 1Z" />
        </svg>
    </div>

    <!-- Scripts -->
    <!-- Libs JS -->
    <script src="{{ asset('assets/libs/%40popperjs/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>

    <!-- Theme JS -->
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>
    <script src="{{ asset('assets/libs/tiny-slider/dist/min/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/tnsSlider.js') }}"></script>
</body>
</html>
