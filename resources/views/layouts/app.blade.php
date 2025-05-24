<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Test">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard.">
    <meta name="keywords" content="bootstrap 5, admin dashboard, etc.">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Global styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../../dist/css/adminlte.css">

    @stack('styles') {{-- Inclure les styles spécifiques à une page --}}
    <style>
    .sidebar-brand {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 3.5rem;
        padding: 0.8125rem 0.5rem;
        overflow: hidden;
        font-size: 1.25rem;
        white-space: nowrap;
        transition: width 0.3s ease-in-out;
    }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary" style="background-color:WHITE">
    <div class="app-wrapper" style="background-color:white">
        <nav class="app-header navbar navbar-expand bg-body" style="background-color:white">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Start Navbar Links-->

                <ul class="navbar-nav ms-auto">
                    <!--begin::Navbar Search-->

                    <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i
                                data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i
                                data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a>
                    </li>
                    <!--end::Fullscreen Toggle-->
                    <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <!-- Utilisation de l'icône Font Awesome pour l'utilisateur -->
                            <i class="bi bi-person-circle text-black" style="font-size: 1.5rem;color:black"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <!--begin::User Header-->
                            <li class="user-header bg-secondary">
                                <!-- Utilisation de l'icône Font Awesome pour l'utilisateur -->
                                <i class="bi bi-person-circle " style="font-size: 3rem;color:white"></i>
                                <p>
                                    {{ auth()->user()->nom }}

                                    <small> {{ auth()->user()->role }}</small>
                                </p>
                            </li>
                            <!--end::User Header-->
                            <!--begin::Menu Footer-->
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                <form id="logout-form" action="" method="POST" style="display: none;">
                                    @csrf
                                </form>

                                <a href="#" class="btn btn-default btn-flat float-end"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Déconnexion
                                </a>
                            </li>
                            <!--end::Menu Footer-->
                        </ul>
                    </li>

                    <!--end::User Menu Dropdown-->
                </ul>
                <!--end::End Navbar Links-->
            </div>
            <!--end::Container-->
        </nav>
        <!--end::Header-->
        <!--begin::Sidebar-->
        <aside class="app-sidebar" data-bs-theme="dark" style="background-color:#012545FF;color:white">
            <div style="background-color:#012545FF">
                <center>
                    <img src=" {{ asset('logo.png')}}" alt="AdminLTE Logo" width="150px" class="brand-image opacity-75">
                </center>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                        data-accordion="false">

                        <!-- Tableau de bord -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard.index') }}" class="nav-link" style="color:white">
                                <i class="nav-icon bi bi-house-door-fill text-white"></i>
                                <p>Tableau de board</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('societes.index') }}" class="nav-link" style="color:white">
                                <i class="nav-icon bi bi-house-door-fill text-white"></i>
                                <p>Societé de transport</p>
                            </a>
                        </li>
                        <!-- Gares -->
                        <li class="nav-item">
                            <a href="{{ route('societes.garesAll') }}" class="nav-link" style="color:white">
                                <i class="nav-icon bi bi-geo-alt-fill text-white"></i>
                                <p>Gare</p>
                            </a>
                        </li>
                        <!-- Lieux -->
                        <li class="nav-item">
                            <a href="{{ route('lieux.index') }}" class="nav-link" style="color:white">
                                <i class="nav-icon bi bi-geo-fill text-white"></i>
                                <p>Lieux</p>
                            </a>
                        </li>
                        <!-- Destination local -->
                        <li class="nav-item">
                            <a href="{{ route('destinations_national.index') }}" class="nav-link" style="color:white">
                                <i class="nav-icon bi bi-map text-white"></i>
                                <p>Destination local</p>
                            </a>
                        </li>
                        <!-- Destination Sous région -->
                        <li class="nav-item">
                            <a href="{{ route('destinations_sousregion.index') }}" class="nav-link" style="color:white">
                                <i class="nav-icon bi bi-globe text-white"></i>
                                <p>Destination Sous région</p>
                            </a>
                        </li>
                        <!-- Réservations -->
                        <li class="nav-item">
                            <a href="{{ route('reservations.index') }}" class="nav-link" style="color:white">
                                <i class="nav-icon bi bi-calendar-check text-white"></i>
                                <p>Reservations</p>
                            </a>
                        </li>
                        <!-- Paiements -->
                        <li class="nav-item">
                            <a href="{{ route('paiements.index') }}" class="nav-link" style="color:white">
                                <i class="nav-icon bi bi-credit-card-fill text-white"></i>
                                <p>Paiements</p>
                            </a>
                        </li>
                        <!-- Utilisateurs -->
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link" style="color:white">
                                <i class="nav-icon bi bi-person-circle text-white"></i>
                                <p>Utilisateurs</p>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <main class="app-main" style="background-color:white">
            <div class="app-content-header">
                <!--
                <div class="container-fluid"> 
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Dashboard</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Dashboard
                                </li>
                            </ol>
                        </div>
                    </div>
                </div> end::Row-->
            </div>
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    @yield('content') {{-- Section pour le contenu principal --}}

                </div>
                <!--end::Container-->
            </div>
        </main>
    </div>

    <!-- Global scripts -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" crossorigin="anonymous">
    </script>
    <script src="../../dist/js/adminlte.js"></script>

    @stack('scripts') {{-- Inclure les scripts spécifiques à une page --}}
</body>

</html>