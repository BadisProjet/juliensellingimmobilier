<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Envoyer un Message - Momo Bilier</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

    </style>
</head>
<body class="d-flex align-items-center py-4">
<main class="form-signin w-100 m-auto">
    <form method="post" action="send_message.php">
        <img class="mb-4" src="votre-logo.svg" alt="Logo" width="100" height="100">
        <h1 class="h3 mb-3 fw-normal">Envoyer un Message</h1>

        <!-- Champ Message -->
        <div class="form-floating mb-3">
            <textarea class="form-control" id="floatingMessage" name="message" placeholder="Votre message" required></textarea>
            <label for="floatingMessage"><i class="fas fa-comment"></i> Votre message</label>
        </div>

        <!-- Bouton d'envoi -->
        <button class="btn btn-primary w-100 py-2" type="submit">Envoyer</button>
        <p class="mt-5 mb-3 text-body-secondary">&copy; 2024 Momo Bilier</p>
    </form>
</main>
<script src="/docs/5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

