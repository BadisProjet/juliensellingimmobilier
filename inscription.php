<?php
include "header.php"; // Inclusion du header

// Inclure le fichier de configuration de la base de données
$servername = "185.142.53.211";
$username = "admin";
$password = "admin";
$dbname = "juliensellingimmo";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash du mot de passe
    $user_type = htmlspecialchars($_POST['user_type']); // Type d'utilisateur (vendeur ou acheteur)
    $ip = $_SERVER['REMOTE_ADDR']; // Adresse IP de l'utilisateur

    // Vérifier si l'email est déjà utilisé
    $stmt = $conn->prepare("SELECT id_users FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Cet email est déjà utilisé.";
    } else {
        // Insérer l'utilisateur dans la base de données
        $stmt = $conn->prepare("INSERT INTO users (nom, prenom, email, mdp, user_type, ip) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nom, $prenom, $email, $password, $user_type, $ip);

        if ($stmt->execute()) {
            $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        } else {
            $error = "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">

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

    <title>Inscription - JulienSelling</title>

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
        <!-- Formulaire d'inscription -->
        <main class="form-signin">
            <form method="post" action="">
                <img class="mb-4" src="votre-logo.svg" alt="Logo" width="100" height="100">
                <h1 class="h3 mb-3 fw-normal text-center">Inscription à JulienSelling</h1>

                <!-- Champ Nom -->
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingNom" name="nom" placeholder="Votre nom" required>
                    <label for="floatingNom"><i class="fas fa-user"></i> Nom</label>
                </div>

                <!-- Champ Prénom -->
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingPrenom" name="prenom" placeholder="Votre prénom" required>
                    <label for="floatingPrenom"><i class="fas fa-user"></i> Prénom</label>
                </div>

                <!-- Champ Email -->
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingEmail" name="email" placeholder="name@example.com" required>
                    <label for="floatingEmail"><i class="fas fa-envelope"></i> Adresse email</label>
                </div>

                <!-- Champ Mot de passe -->
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                    <label for="floatingPassword"><i class="fas fa-lock"></i> Mot de passe</label>
                </div>

                <!-- Champ Type d'utilisateur -->
                <div class="form-floating mb-3">
                    <select class="form-control" id="floatingUserType" name="user_type" required>
                        <option value="">Choisissez un type</option>
                        <option value="acheteur">Acheteur</option>
                        <option value="vendeur">Vendeur</option>
                    </select>
                    <label for="floatingUserType"><i class="fas fa-users"></i> Type d'utilisateur</label>
                </div>

                <!-- Bouton d'inscription -->
                <button class="btn btn-primary w-100 py-2" type="submit">S'INSCRIRE</button>
                <button class="btn btn-secondary w-100 py-2 mt-2" type="button" onclick="window.location.href='connexion.php';">SE CONNECTER</button>
                <p class="mt-5 mb-3 text-body-secondary text-center">&copy; 2024 JulienSelling</p>

                <!-- Afficher le message de succès ou d'erreur -->
                <?php if (isset($success)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
            </form>
        </main>
    </div>

    <!-- Scripts JavaScript -->
    <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php include "footer.php"; ?>