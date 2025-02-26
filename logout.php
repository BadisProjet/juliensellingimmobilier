<?php
session_start(); // Démarrer la session

// Détruire toutes les données de la session
session_unset(); // Supprime toutes les variables de session
session_destroy(); // Détruit la session

// Rediriger l'utilisateur vers la page principale
header("Location: index.php"); // Remplace "index.php" par la page de ton choix
exit(); // Arrêter l'exécution du script
?>