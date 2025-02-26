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

$error = ""; // Variable pour stocker les messages d'erreur

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparer et exécuter la requête
    $stmt = $conn->prepare("SELECT id_users, nom, prenom, mdp, user_type FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_users, $nom, $prenom, $hashed_password, $user_type);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Mot de passe correct, démarrer la session
            $_SESSION['user_id'] = $id_users;
            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['user_type'] = $user_type;

            // Rediriger vers la page principale (index.php)
            header("Location: index.php");
            exit();
        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Aucun compte trouvé avec cet email.";
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

    <title>Connexion - JulienSelling</title>

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
        <!-- Formulaire de connexion -->
        <main class="form-signin">
            <form method="post" action="">
                <img class="mb-4" src="votre-logo.svg" alt="Logo" width="100" height="100">
                <h1 class="h3 mb-3 fw-normal text-center">Connexion à JulienSelling</h1>

                <!-- Champ Email -->
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
                    <label for="floatingInput"><i class="fas fa-envelope"></i> Adresse email</label>
                </div>

                <!-- Champ Mot de passe -->
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                    <label for="floatingPassword"><i class="fas fa-lock"></i> Mot de passe</label>
                </div>

                <!-- Bouton de connexion -->
                <button class="btn btn-primary w-100 py-2" type="submit">SE CONNECTER</button>
                <button class="btn btn-secondary w-100 py-2 mt-2" type="button" onclick="window.location.href='inscription.php';">S'INSCRIRE</button>
                <p class="mt-5 mb-3 text-body-secondary text-center">&copy; 2024 JulienSelling</p>

                <!-- Afficher le message d'erreur si nécessaire -->
                <?php if (!empty($error)): ?>
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