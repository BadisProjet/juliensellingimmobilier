<?php
session_start();

// Vérifier si l'utilisateur est connecté et est un administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin' || $_SESSION['user_lvl'] != 3) {
    header("Location: index.php"); // Rediriger vers l'accueil si ce n'est pas un admin
    exit();
}

// Connexion à la base de données
$servername = "185.142.53.211";
$username = "admin";
$password = "admin";
$dbname = "juliensellingimmo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variables pour les messages de succès ou d'erreur
$success = "";
$error = "";

// Suppression d'un utilisateur
if (isset($_GET['delete_user']) && is_numeric($_GET['delete_user'])) {
    $id_users = intval($_GET['delete_user']);

    $stmt = $conn->prepare("DELETE FROM users WHERE id_users = ?");
    $stmt->bind_param("i", $id_users);

    if ($stmt->execute()) {
        $success = "Utilisateur supprimé avec succès !";
    } else {
        $error = "Erreur lors de la suppression de l'utilisateur : " . $stmt->error;
    }

    $stmt->close();
}

// Récupérer tous les utilisateurs
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$result_users = $stmt->get_result();
$users = $result_users->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - JulienSelling</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table {
            margin-top: 20px;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Administration</h1>

        <!-- Afficher les messages de succès ou d'erreur -->
        <?php if (!empty($success)): ?>
            <div class="alert alert-success" role="alert">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- Section des utilisateurs -->
        <h2>Gestion des utilisateurs</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id_users']) ?></td>
                        <td><?= htmlspecialchars($user['nom']) ?></td>
                        <td><?= htmlspecialchars($user['prenom']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['user_type']) ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= $user['id_users'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="?delete_user=<?= $user['id_users'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>