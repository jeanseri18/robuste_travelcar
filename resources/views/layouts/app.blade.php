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
    /* Modern Sidebar Styles */
    .modern-sidebar {
        background: linear-gradient(30deg, #013481FF 0%, #162359 100%);
        width: 280px;
        min-height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 0 0 0 0;
        overflow-y: auto;
        transition: all 0.3s ease;
    }

    /* Brand Section */
    .sidebar-brand {
        padding: 1.5rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.05);
    }

    .brand-container {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .brand-logo {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .brand-text {
        color: white;
    }

    . text-white {
         text-whitefont-size: 1.2rem;
        font-weight: 700;
        line-height: 1.2;
        margin: 0;
    }

    .brand-subtitle {
        font-size: 0.75rem;
        opacity: 0.8;
        font-weight: 400;
        margin: 0;
    }

    /* Navigation */
    .sidebar-nav {
        padding: 1rem 0;
    }

    .nav-section {
        margin-bottom: 1.5rem;
    }

    .nav-section-title {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0 1.5rem 0.5rem;
        margin-bottom: 0.5rem;
    }

    .nav-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-item {
        margin-bottom: 2px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        transition: all 0.3s ease;
        border-radius: 0;
        position: relative;
        overflow: hidden;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        transform: translateX(5px);
    }

    .nav-link.active {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border-left: 4px solid #ffffff;
    }

    .nav-link.active::before {
        content: '';
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: #ffffff;
    }

    .nav-icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        margin-right: 12px;
        font-size: 1rem;
    }

    .nav-text {
        font-size: 0.9rem;
        font-weight: 500;
        flex: 1;
    }

    /* Scrollbar Styling */
    .modern-sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .modern-sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    .modern-sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .modern-sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    /* Animation for nav items */
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .nav-item {
        animation: slideInLeft 0.3s ease forwards;
    }

    .nav-item:nth-child(1) { animation-delay: 0.1s; }
    .nav-item:nth-child(2) { animation-delay: 0.2s; }
    .nav-item:nth-child(3) { animation-delay: 0.3s; }
    .nav-item:nth-child(4) { animation-delay: 0.4s; }
    .nav-item:nth-child(5) { animation-delay: 0.5s; }

    /* Submenu Styles */
    .nav-item.has-submenu .submenu-arrow {
        margin-left: auto;
        transition: transform 0.3s ease;
        font-size: 0.8rem;
    }

    .nav-item.has-submenu .nav-link[aria-expanded="true"] .submenu-arrow {
        transform: rotate(180deg);
    }

    .nav-submenu {
        list-style: none;
        margin: 0;
        padding: 0;
        background: rgba(0, 0, 0, 0.2);
        border-left: 2px solid rgba(255, 255, 255, 0.1);
        margin-left: 1rem;
    }

    .nav-submenu .nav-item {
        margin-bottom: 1px;
    }

    .nav-submenu .nav-link {
        padding: 0.6rem 1rem 0.6rem 2rem;
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.8);
        border-radius: 0;
    }

    .nav-submenu .nav-link:hover {
        background: rgba(255, 255, 255, 0.08);
        color: white;
        transform: translateX(3px);
    }

    .nav-submenu .nav-link.active {
        background: rgba(255, 255, 255, 0.12);
        color: white;
        border-left: 3px solid #ffffff;
    }

    .nav-submenu .nav-link i {
        margin-right: 8px;
        font-size: 0.8rem;
        width: 16px;
        text-align: center;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .modern-sidebar {
            width: 260px;
            transform: translateX(-100%);
        }
        
        .modern-sidebar.show {
            transform: translateX(0);
        }
    }

    /* Header/Navbar adjustments */
    .app-header {
        margin-left: 2%;
        z-index: 999;
        position: fixed;
        top: 0;
        right: 0;
        left: 280px;
        transition: all 0.3s ease;
    }

    /* Main content adjustment */
    .app-main {
        margin-left: 280px;
        margin-top: 60px;
        transition: margin-left 0.3s ease;
    }

    @media (max-width: 768px) {
        .app-header {
            margin-left: 0;
            left: 0;
        }
        
        .app-main {
            margin-left: 0;
        }
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
        <aside class="modern-sidebar">
            <!-- Brand Section -->
            <div class="sidebar-brand">
                <div class="brand-container">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="brand-logo">
                    <div class="brand-text">
                        <div class="brand-title text-white">TravelCar</div>
                        <div class="brand-subtitle text-white">Admin Panel</div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav">
                <!-- Gestion Transport -->
                <div class="nav-section">
                    <div class="nav-section-title">Gestion Transport</div>
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                                <div class="nav-icon-wrapper">
                                    <i class="bi bi-speedometer2"></i>
                                </div>
                                <span class="nav-text">Tableau de bord</span>
                            </a>
                        </li>
                        <li class="nav-item has-submenu">
                            <a href="#" class="nav-link {{ request()->routeIs('societes.*') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#societesSubmenu" aria-expanded="{{ request()->routeIs('societes.*') ? 'true' : 'false' }}">
                                <div class="nav-icon-wrapper">
                                    <i class="bi bi-building"></i>
                                </div>
                                <span class="nav-text">Sociétés de transport</span>
                                <i class="bi bi-chevron-down submenu-arrow"></i>
                            </a>
                            <div class="collapse {{ request()->routeIs('societes.*') ? 'show' : '' }}" id="societesSubmenu">
                                <ul class="nav-submenu">
                                    <li class="nav-item">
                                        <a href="{{ route('societes.index') }}" class="nav-link {{ request()->routeIs('societes.index') ? 'active' : '' }}">
                                            <i class="bi bi-list-ul"></i>
                                            <span class="nav-text">Toutes les sociétés</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('societes.national') }}" class="nav-link {{ request()->routeIs('societes.national') ? 'active' : '' }}">
                                            <i class="bi bi-flag text-success"></i>
                                            <span class="nav-text">Sociétés nationales</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('societes.sousregional') }}" class="nav-link {{ request()->routeIs('societes.sousregional') ? 'active' : '' }}">
                                            <i class="bi bi-globe text-primary"></i>
                                            <span class="nav-text">Sociétés sous-régionales</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('societes.garesAll') }}" class="nav-link {{ request()->routeIs('societes.garesAll') ? 'active' : '' }}">
                                <div class="nav-icon-wrapper">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <span class="nav-text">Gares</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Destinations -->
                <div class="nav-section">
                    <div class="nav-section-title">Destinations</div>
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="{{ route('lieux.index') }}" class="nav-link {{ request()->routeIs('lieux.*') ? 'active' : '' }}">
                                <div class="nav-icon-wrapper">
                                    <i class="bi bi-pin-map"></i>
                                </div>
                                <span class="nav-text">Lieux</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('destinations_national.index') }}" class="nav-link {{ request()->routeIs('destinations_national.*') ? 'active' : '' }}">
                                <div class="nav-icon-wrapper">
                                    <i class="bi bi-map"></i>
                                </div>
                                <span class="nav-text">Destinations nationales</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('destinations_sousregion.index') }}" class="nav-link {{ request()->routeIs('destinations_sousregion.*') ? 'active' : '' }}">
                                <div class="nav-icon-wrapper">
                                    <i class="bi bi-globe-americas"></i>
                                </div>
                                <span class="nav-text">Destinations sous-région</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Opérations -->
                <div class="nav-section">
                    <div class="nav-section-title">Opérations</div>
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="{{ route('reservations.index') }}" class="nav-link {{ request()->routeIs('reservations.*') ? 'active' : '' }}">
                                <div class="nav-icon-wrapper">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <span class="nav-text">Réservations</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('paiements.index') }}" class="nav-link {{ request()->routeIs('paiements.*') ? 'active' : '' }}">
                                <div class="nav-icon-wrapper">
                                    <i class="bi bi-credit-card"></i>
                                </div>
                                <span class="nav-text">Paiements</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Administration -->
                <div class="nav-section">
                    <div class="nav-section-title">Administration</div>
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <div class="nav-icon-wrapper">
                                    <i class="bi bi-people"></i>
                                </div>
                                <span class="nav-text">Utilisateurs</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
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