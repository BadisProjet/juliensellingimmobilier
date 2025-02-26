<?php
include "header.php"; // Inclusion du header

// Connexion à la base de données
$servername = "185.142.53.211";
$username = "admin";
$password = "admin";
$dbname = "juliensellingimmo";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer toutes les annonces
$sql = "SELECT b.*, u.email AS vendeur_email, u.nom AS vendeur_nom, u.prenom AS vendeur_prenom 
        FROM biens b 
        JOIN users u ON b.id_users = u.id_users";
$result = $conn->query($sql);

// Variable pour stocker les messages de succès ou d'erreur
$success = "";
$error = "";

// Traitement du formulaire de contact
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $id_bien = intval($_POST['id_bien']);
    $message = htmlspecialchars($_POST['message']);
    $id_exp = $_SESSION['user_id']; // ID de l'acheteur

    // Récupérer l'e-mail du vendeur
    $sql_vendeur = "SELECT u.email FROM biens b JOIN users u ON b.id_users = u.id_users WHERE b.id_bien = ?";
    $stmt_vendeur = $conn->prepare($sql_vendeur);
    $stmt_vendeur->bind_param("i", $id_bien);
    $stmt_vendeur->execute();
    $stmt_vendeur->bind_result($vendeur_email);
    $stmt_vendeur->fetch();
    $stmt_vendeur->close();

    // Envoyer un e-mail au vendeur
    if (!empty($vendeur_email)) {
        $sujet = "Nouveau message concernant votre annonce";
        $contenu = "Vous avez reçu un nouveau message de la part de " . $_SESSION['prenom'] . " " . $_SESSION['nom'] . ":\n\n";
        $contenu .= $message . "\n\n";
        $contenu .= "Vous pouvez répondre à cet e-mail pour contacter l'acheteur.";

        // En-têtes de l'e-mail
        $headers = "From: no-reply@julienselling.com\r\n";
        $headers .= "Reply-To: " . $_SESSION['email'] . "\r\n";

        // Envoyer l'e-mail
        if (mail($vendeur_email, $sujet, $contenu, $headers)) {
            $success = "Votre message a été envoyé avec succès !";
        } else {
            $error = "Erreur lors de l'envoi du message.";
        }
    } else {
        $error = "Impossible de trouver l'e-mail du vendeur.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Annonces - JulienSelling</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main class="container mt-5">
        <h1 class="text-center">Annonces disponibles</h1>

        <!-- Afficher les messages de succès ou d'erreur -->
        <?php if (!empty($success)): ?>
            <div class="alert alert-success mt-3" role="alert">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Liste des annonces -->
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <!-- Affichage de la première image -->
                            <?php if (!empty($row['images'])): ?>
                                <?php $images = explode(",", $row['images']); ?>
                                <img src="<?php echo $images[0]; ?>" class="card-img-top" alt="Image du bien">
                            <?php endif; ?>

                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['titre']; ?> </h5>
                                <p class="card-text"><?php echo $row['description']; ?></p>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Prix : <?php echo $row['prix']; ?> €</li>
                                    <li class="list-group-item">Ville : <?php echo $row['ville']; ?> </li>
                                    <li class="list-group-item">Pièces : <?php echo $row['pieces']; ?></li>
                                    <li class="list-group-item">Vendeur : <?php echo $row['vendeur_prenom'] . " " . $row['vendeur_nom']; ?></li>
                                </ul>
                                <!-- Bouton pour contacter le vendeur -->
                                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#contactModal<?php echo $row['id_bien']; ?>">
                                    Contacter le vendeur
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal pour contacter le vendeur -->
                    <div class="modal fade" id="contactModal<?php echo $row['id_bien']; ?>" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="contactModalLabel">Contacter le vendeur</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="">
                                        <input type="hidden" name="id_bien" value="<?php echo $row['id_bien']; ?>">
                                        <div class="form-group mb-3">
                                            <label for="message">Votre message</label>
                                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Envoyer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">Aucune annonce disponible pour le moment.</p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Scripts JavaScript -->
    <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include "footer.php"; ?>