@extends('layouts.public')

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

<style>
/* Styles de base */
body {
    font-family: 'Poppins', sans-serif;
    color: #333;
}

/* Hero section avec animation améliorée */
.hero-section {
    background: linear-gradient(to right, rgba(1, 30, 49, 0.8), rgba(10, 145, 234, 0.7)), url('{{ asset('assets/hombg.jpg') }}') no-repeat center;
    background-size: cover;
    height: 700px;
    position: relative;
    overflow: hidden;
    animation: fadeInDown 1.5s ease-in-out;
}

.hero-content {
    position: relative;
    z-index: 2;
}

/* Animation améliorée */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Effet de vague en bas du hero */
.wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100px;
    background: url('{{ asset('assets/wave.svg') }}') repeat-x;
    background-size: 1000px 100px;
}

/* Cartes de services avec effets avancés */
.service-card {
    background-color: white;
    border-radius: 10px;
    padding: 30px 20px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    min-height: 320px;
    position: relative;
    overflow: hidden;
    border-bottom: 4px solid transparent;
    margin-bottom: 25px;
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    border-bottom: 4px solid #F7A600;
}

.service-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 0;
    background-color: rgba(247, 166, 0, 0.05);
    transition: height 0.4s ease;
    z-index: 0;
}

.service-card:hover::before {
    height: 100%;
}

.service-card * {
    position: relative;
    z-index: 1;
}

/* Icônes dans des cercles avec effet de pulsation */
.icon-circle {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background-color: #F7A600;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: white;
    box-shadow: 0 5px 15px rgba(247, 166, 0, 0.3);
    position: relative;
}

.icon-circle::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 2px solid #F7A600;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    100% {
        transform: scale(1.5);
        opacity: 0;
    }
}

.custom-icon {
    font-size: 2.5rem;
}

/* Boutons stylisés */
.btn-custom {
    background-color: #F7A600;
    color: white;
    border: none;
    border-radius: 30px;
    padding: 12px 30px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.btn-custom::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.7s ease;
    z-index: -1;
}

.btn-custom:hover {
    background-color: #E59500;
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(247, 166, 0, 0.2);
}

.btn-custom:hover::before {
    left: 100%;
}

.btn-custom:active {
    transform: translateY(0);
}

/* Section de réservation avec style moderne */
.booking-section {
    background: linear-gradient(135deg, #0A91EA, #011E31);
    color: white;
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.booking-section::before, .booking-section::after {
    content: '';
    position: absolute;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
}

.booking-section::before {
    top: -100px;
    left: -100px;
}

.booking-section::after {
    bottom: -100px;
    right: -100px;
}

/* Formulaire de recherche rapide */
.search-form {
    background-color: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    margin-top: 30px;
}

.search-form label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.search-form .form-control {
    border-radius: 5px;
    padding: 12px 15px;
    font-size: 16px;
    border: 1px solid #ddd;
    transition: all 0.3s ease;
}

.search-form .form-control:focus {
    border-color: #F7A600;
    box-shadow: 0 0 0 3px rgba(247, 166, 0, 0.1);
}

/* Section des destinations populaires */
.destination-card {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    position: relative;
    transition: all 0.3s ease;
}

.destination-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
}

.destination-img {
    height: 200px;
    overflow: hidden;
}

.destination-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.destination-card:hover .destination-img img {
    transform: scale(1.1);
}

.destination-info {
    padding: 20px;
    background-color: white;
}

.destination-price {
    position: absolute;
    top: 15px;
    right: 15px;
    background-color: #F7A600;
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-weight: 600;
}

/* Témoignages */
.testimonial-card {
    background-color: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
    position: relative;
}

.testimonial-card::before {
    content: '\f10d';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    top: 20px;
    left: 20px;
    font-size: 24px;
    color: rgba(247, 166, 0, 0.1);
}

.client-info {
    display: flex;
    align-items: center;
    margin-top: 20px;
}

.client-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 15px;
}

.client-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.client-details h5 {
    margin-bottom: 0;
    color: #333;
}

.client-details span {
    color: #777;
    font-size: 14px;
}

/* Footer amélioré */
.footer {
    background-color: #011E31;
    color: white;
    padding: 80px 0 30px;
}

.footer-title {
    color: white;
    font-weight: 600;
    margin-bottom: 25px;
    position: relative;
    padding-bottom: 10px;
}

.footer-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 2px;
    background-color: #F7A600;
}

.footer-links {
    list-style: none;
    padding-left: 0;
}

.footer-links li {
    margin-bottom: 10px;
}

.footer-links a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    padding-left: 15px;
}

.footer-links a:hover {
    color: white;
    padding-left: 20px;
}

.footer-links a::before {
    content: '\f105';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    left: 0;
    top: 2px;
    color: #F7A600;
}

.social-links {
    list-style: none;
    padding-left: 0;
    display: flex;
}

.social-links li {
    margin-right: 15px;
}

.social-links a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.1);
    color: white;
    transition: all 0.3s ease;
}

.social-links a:hover {
    background-color: #F7A600;
    transform: translateY(-3px);
}

.copyright {
    padding-top: 30px;
    margin-top: 30px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    text-align: center;
    color: rgba(255, 255, 255, 0.7);
    font-size: 14px;
}

/* Media queries pour responsive */
@media (max-width: 991px) {
    .hero-section {
        height: 600px;
    }
    
    .hero-section h1 {
        font-size: 3rem !important;
    }
}

@media (max-width: 768px) {
    .hero-section {
        height: 500px;
    }
    
    .hero-section h1 {
        font-size: 2.5rem !important;
    }
    
    .search-form {
        margin-bottom: 30px;
    }
}

@media (max-width: 576px) {
    .hero-section h1 {
        font-size: 2rem !important;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
}

/* Animation de chargement de page */
.page-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: opacity 0.5s ease, visibility 0.5s ease;
}

.loader {
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #F7A600;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.fade-out {
    opacity: 0;
    visibility: hidden;
}

/* Style spécial du logo */
.logo-container {
    display: flex;
    align-items: center;
}

.logo-text {
    color: white;
    font-weight: 700;
    font-size: 1.8rem;
    margin-left: 10px;
}

.slogan {
    font-style: italic;
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
}
</style>

@section('content')

@section('title', 'Réservez vos tickets de voyage | AFRICA TRAVEL CAR')

<!-- Animation de chargement -->
<div class="page-loader">
    <div class="loader"></div>
</div>

<!-- Navigation -->


<!-- Hero Section améliorée -->


<!-- Section de réservation améliorée -->
<section class="booking-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="mb-4">Réservez vos tickets de voyage en 3 étapes simples</h2>
                <div class="d-flex align-items-center mb-4">
                    <div class="me-3 bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-search"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Recherchez votre trajet</h5>
                        <p class="mb-0">Entrez votre lieu de départ, d'arrivée et la date souhaitée.</p>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <div class="me-3 bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-bus"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Choisissez votre transport</h5>
                        <p class="mb-0">Comparez les prix, horaires et services des différents transporteurs.</p>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="me-3 bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Payez et recevez votre e-ticket</h5>
                        <p class="mb-0">Payez en ligne et recevez instantanément votre ticket par SMS et email.</p>
                    </div>
                </div>
                <div class="mt-5 d-flex gap-3">
                    <a href="#" class="btn btn-light px-4 py-3 rounded-pill"><i class="fab fa-google-play me-2"></i>Google Play</a>
                    <a href="#" class="btn btn-light px-4 py-3 rounded-pill"><i class="fab fa-apple me-2"></i>App Store</a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block">
                <img src="{{ asset('assets/FlightDetails.png') }}" style="width: 300px;" alt="Application mobile" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>


<!-- Section Nos Services -->
<section class="py-5 bg-light" id="services">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title">Pourquoi choisir AFRICA TRAVEL CAR?</h2>
                <p class="lead">Nous vous offrons la meilleure expérience de voyage en Afrique de l'Ouest grâce à des services uniques et pratiques.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="service-card text-center">
                    <div class="icon-circle">
                        <i class="fas fa-ticket-alt custom-icon"></i>
                    </div>
                    <h4>Réservation 24/7</h4>
                    <p>Réservez vos billets de transport en quelques clics, à tout moment sans vous déplacer, 24h/24 et 7j/7.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card text-center">
                    <div class="icon-circle">
                        <i class="fas fa-money-bill-wave custom-icon"></i>
                    </div>
                    <h4>Paiement Mobile</h4>
                    <p>Payez via Orange Money, MTN Money, Moov Money, Wave, ou par carte bancaire en toute sécurité.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card text-center">
                    <div class="icon-circle">
                        <i class="fas fa-map-marked-alt custom-icon"></i>
                    </div>
                    <h4>Large Couverture</h4>
                    <p>Plus de 50 destinations en Côte d'Ivoire et dans les pays limitrophes de la sous-région.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card text-center">
                    <div class="icon-circle">
                        <i class="fas fa-bus custom-icon"></i>
                    </div>
                    <h4>Multiples Transporteurs</h4>
                    <p>Comparez les tarifs et services de nombreux transporteurs partenaires dans toute la sous-région.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card text-center">
                    <div class="icon-circle">
                        <i class="fas fa-clock custom-icon"></i>
                    </div>
                    <h4>Horaires Flexibles</h4>
                    <p>Trouvez des départs à toute heure de la journée selon vos besoins et votre emploi du temps.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card text-center">
                    <div class="icon-circle">
                        <i class="fas fa-headset custom-icon"></i>
                    </div>
                    <h4>Support Client</h4>
                    <p>Notre équipe client est disponible à tout moment pour vous assister via WhatsApp et téléphone.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Section Destinations Populaires -->
<section class="py-5" id="destinations">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title">Destinations Populaires</h2>
                <p class="lead">Découvrez nos trajets les plus prisés en Côte d'Ivoire et dans la sous-région.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="destination-card">
                    <div class="destination-img">
                        <img src="{{ asset('assets/vue-de-face-jeune-femme-avec-sac-rouge-se-preparant-au-voyage-sur-fond-blanc-couleur-avion-repos-vacances-soleil-vol-voyage-voyage.jpg') }}" alt="Abidjan">
                    </div>
                    <div class="destination-info">
                        <h5>Abidjan - Yamoussoukro</h5>
                        <p class="mb-2"><i class="fas fa-clock me-2"></i> 2h30 de trajet</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">10+ départs quotidiens</span>
                            <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                        </div>
                    </div>
                    <div class="destination-price">
                        À partir de 5 000 FCFA
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="destination-card">
                    <div class="destination-img">
                        <img src="{{ asset('assets/belle-fille-en-jeans-saute-sur-fond-orange-portrait-en-pied-de-femme-avec-des-billets-et-une-valise.jpg') }}" alt="Bouaké">
                    </div>
                    <div class="destination-info">
                        <h5>Abidjan - Bouaké</h5>
                        <p class="mb-2"><i class="fas fa-clock me-2"></i> 4h de trajet</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">8+ départs quotidiens</span>
                            <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                        </div>
                    </div>
                    <div class="destination-price">
                        À partir de 7 000 FCFA
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="destination-card">
                    <div class="destination-img">
                        <img src="{{ asset('assets/femme-ennuyee-en-pantalon-rose-tenant-des-billets-d-avion-studio-photo-d-une-fille-a-la-mode-assise-sur-une-valise.jpg') }}" alt="Korhogo">
                    </div>
                    <div class="destination-info">
                        <h5>Abidjan - Korhogo</h5>
                        <p class="mb-2"><i class="fas fa-clock me-2"></i> 9h de trajet</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">5+ départs quotidiens</span>
                            <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                        </div>
                    </div>
                    <div class="destination-price">
                        À partir de 12 000 FCFA
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="destination-card">
                    <div class="destination-img">
                        <img src="{{ asset('assets/full-shot-smiley-partners-walking-together.jpg') }}" alt="San Pedro">
                    </div>
                    <div class="destination-info">
                        <h5>Abidjan - San Pedro</h5>
                        <p class="mb-2"><i class="fas fa-clock me-2"></i> 6h de trajet</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">4+ départs quotidiens</span>
                            <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                        </div>
                    </div>
                    <div class="destination-price">
                        À partir de 8 000 FCFA
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="destination-card">
                    <div class="destination-img">
                        <img src="{{ asset('assets/homme-en-vacances-avec-valise-rouge-et-appareil-photo-prenant-des-photos-sur-bleu.jpg') }}" alt="Accra">
                    </div>
                    <div class="destination-info">
                        <h5>Abidjan - Accra (Ghana)</h5>
                        <p class="mb-2"><i class="fas fa-clock me-2"></i> 8h de trajet</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">3+ départs quotidiens</span>
                            <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                        </div>
                    </div>
                    <div class="destination-price">
                        À partir de 15 000 FCFA
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="destination-card">
                    <div class="destination-img">
                        <img src="{{ asset('assets/homme-en-vacances-tenant-des-billets-sur-le-mur-bleu.jpg') }}" alt="Bamako">
                    </div>
                    <div class="destination-info">
                        <h5>Abidjan - Bamako (Mali)</h5>
                        <p class="mb-2"><i class="fas fa-clock me-2"></i> 15h de trajet</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">2+ départs quotidiens</span>
                            <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                        </div>
                    </div>
                    <div class="destination-price">
                        À partir de 20 000 FCFA
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="#" class="btn btn-custom">Voir toutes les destinations</a>
        </div>
    </div>
</section>

<!-- Section Options de paiement -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title">Options de Paiement Flexibles</h2>
                <p class="lead">Plusieurs méthodes de paiement disponibles pour votre convenance</p>
            </div>
        </div>
        <div class="row justify-content-center text-center">
            <div class="col-md-2 col-sm-4 col-6 mb-4">
                <div class="bg-white p-3 rounded shadow-sm">
                    <i class="fas fa-mobile-alt mb-3" style="font-size: 2.5rem; color: #F7A600;"></i>
                    <h5 class="mb-0">Orange Money</h5>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6 mb-4">
                <div class="bg-white p-3 rounded shadow-sm">
                    <i class="fas fa-mobile-alt mb-3" style="font-size: 2.5rem; color: #F7A600;"></i>
                    <h5 class="mb-0">MTN Money</h5>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6 mb-4">
                <div class="bg-white p-3 rounded shadow-sm">
                    <i class="fas fa-mobile-alt mb-3" style="font-size: 2.5rem; color: #F7A600;"></i>
                    <h5 class="mb-0">Moov Money</h5>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6 mb-4">
                <div class="bg-white p-3 rounded shadow-sm">
                    <i class="fas fa-mobile-alt mb-3" style="font-size: 2.5rem; color: #F7A600;"></i>
                    <h5 class="mb-0">Wave</h5>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6 mb-4">
                <div class="bg-white p-3 rounded shadow-sm">
                    <i class="fas fa-credit-card mb-3" style="font-size: 2.5rem; color: #F7A600;"></i>
                    <h5 class="mb-0">Carte Bancaire</h5>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Application Mobile -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 order-lg-2">
                <h2 class="mb-4">Téléchargez notre application pour une expérience optimale</h2>
                <p class="mb-4">Avec l'application AFRICA TRAVEL CAR, réservez vos billets encore plus facilement, suivez vos voyages en temps réel et bénéficiez d'offres exclusives.</p>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Interface intuitive et conviviale</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Notifications de départ et d'arrivée</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Billets stockés hors ligne</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Programme de fidélité exclusif</li>
                </ul>
                <div class="d-flex gap-3">
                    <a href="#" class="btn btn-dark d-inline-flex align-items-center">
                        <i class="fab fa-google-play me-2 fs-4"></i>
                        <div>
                            <small class="d-block">Télécharger sur</small>
                            Google Play
                        </div>
                    </a>
                    <a href="#" class="btn btn-dark d-inline-flex align-items-center">
                        <i class="fab fa-apple me-2 fs-4"></i>
                        <div>
                            <small class="d-block">Télécharger sur</small>
                            App Store
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 order-lg-1 mt-5 mt-lg-0">
                <img src="{{ asset('assets/Splash.png') }}" style="width: 300px;" alt="Application mobile AFRICA TRAVEL CAR" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Section Témoignages -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title">Ce que disent nos voyageurs</h2>
                <p class="lead">Découvrez les expériences de nos clients qui ont utilisé AFRICA TRAVEL CAR pour leurs déplacements.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <p>"Je voyage régulièrement entre Abidjan et Bouaké pour visiter ma famille. Grâce à AFRICA TRAVEL CAR, je n'ai plus besoin de me déplacer à la gare pour acheter mon ticket. Tout se fait depuis mon téléphone!"</p>
                    <div class="client-info">
                        <div class="client-avatar">
                            <img src="{{ asset('assets/vue-de-face-jeune-femme-se-preparant-pour-les-vacances-tenant-la-camera-et-prenant-la-photo-sur-l-espace-bleu.jpg') }}" alt="Client">
                        </div>
                        <div class="client-details">
                            <h5>Kouamé Aya</h5>
                            <span>Abidjan</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <p>"En tant que commerçant, je voyage souvent dans la sous-région. Cette application m'a simplifié la vie en me permettant de comparer les prix et les horaires de différents transporteurs en un seul endroit."</p>
                    <div class="client-info">
                        <div class="client-avatar">
                            <img src="{{ asset('assets/vue-de-face-jeune-femme-se-preparant-pour-les-vacances-tenant-la-camera-et-prenant-la-photo-sur-l-espace-bleu.jpg') }}" alt="Client">
                        </div>
                        <div class="client-details">
                            <h5>Ibrahim Touré</h5>
                            <span>Korhogo</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <p>"J'apprécie particulièrement la fonctionnalité qui me permet de suivre mon bus en temps réel. Je sais exactement quand il arrivera à destination, ce qui me permet de mieux organiser mon voyage."</p>
                    <div class="client-info">
                        <div class="client-avatar">
                            <img src="{{ asset('assets/vue-de-face-jeune-femme-se-preparant-pour-les-vacances-tenant-la-camera-et-prenant-la-photo-sur-l-espace-bleu.jpg') }}" alt="Client">
                        </div>
                        <div class="client-details">
                            <h5>Sophie Mensah</h5>
                            <span>Yamoussoukro</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-5">
                <h3 class="text-white mb-4">AFRICA TRAVEL CAR</h3>
                <p class="text-white-50 mb-4">Votre partenaire de confiance pour voyager partout en Côte d'Ivoire et dans la sous-région ouest-africaine. Réservez vos tickets en ligne, facilement et en toute sécurité.</p>
                <ul class="social-links">
                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6 mb-5">
                <h5 class="footer-title">Liens rapides</h5>
                <ul class="footer-links">
                    <li><a href="#">Accueil</a></li>
                    <li><a href="#">À propos</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Destinations</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="footer-title">Services</h5>
                <ul class="footer-links">
                    <li><a href="#">Réservation de billets</a></li>
                    <li><a href="#">Voyages internationaux</a></li>
                    <li><a href="#">Transport VIP</a></li>
                    <li><a href="#">Transport de colis</a></li>
                    <li><a href="#">Programmes de fidélité</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="footer-title">Contact</h5>
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-map-marker-alt me-2"></i> Abidjan-Anyama, quartier résidentiel 28 BP 1496 Abidjan 28</a></li>
                    <li><a href="#"><i class="fas fa-phone me-2"></i> +225 07 0833 9194</a></li>
                    <li><a href="#"><i class="fas fa-envelope me-2"></i> contact@AFRICA TRAVEL CAR.ci</a></li>
                </ul>
                <div class="mt-4">
                    <h6 class="text-white mb-3">Inscrivez-vous à notre newsletter</h6>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Votre email">
                        <button class="btn btn-custom" type="button">S'inscrire</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 AFRICA TRAVEL CAR Côte d'Ivoire S.A.R.L. Tous droits réservés. | RCCM N°CI-ABJ-2019-B-11613</p>
        </div>
    </div>
</footer>

<!-- Script pour animation de chargement -->
<script>
    window.addEventListener('load', function() {
        const loader = document.querySelector('.page-loader');
        setTimeout(() => {
            loader.classList.add('fade-out');
        }, 1000);
    });
</script>

@endsection