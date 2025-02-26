<?php
session_start(); // Démarrage de la session
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <link rel="icon" href="images/a-1.jpg" type="image/gif" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>JulienSelling - Immobilier</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="bootstrap.css" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

    <!-- font awesome style -->
    <link href="font-awesome.min.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="responsive.css" rel="stylesheet" />
</head>

<body>
    <div class="hero_area">
        <!-- header section strats -->
        <header class="header_section">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container">
                    <a class="navbar-brand" href="index.php">
                        <span>JulienSelling - Immobilier</span>
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class=""></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about.php">À propos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="annonces.php">Produits</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="testimonial.html">Classement</a>
                            </li>
                            <li class="nav-item active">
                                <?php
                                if (isset($_SESSION['user_id'])) {
                                    // Utilisateur connecté
                                    echo '<a class="nav-link">Bienvenue, ' . htmlspecialchars($_SESSION['prenom']) . ' ' . htmlspecialchars($_SESSION['nom']) . '</a>';
                                    echo '<a class="nav-link" href="logout.php">Déconnexion</a>';

                                    // Si l'utilisateur est un vendeur, afficher le lien "Poster une annonce"
                                    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'vendeur') {
                                        echo '<li class="nav-item"><a class="nav-link" href="creer_annonce.php">Poster une annonce</a></li>';
                                    }
                                } else {
                                    // Utilisateur non connecté
                                    echo '<a class="nav-link" href="connexion.php">Connexion</a>';
                                }
                                ?>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!-- end header section -->