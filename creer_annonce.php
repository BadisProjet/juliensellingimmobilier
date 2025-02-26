<?php
include "header.php"; // Inclusion du header

// Vérifier si l'utilisateur est un vendeur
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'vendeur') {
    header("Location: index.php"); // Rediriger vers l'accueil si ce n'est pas un vendeur
    exit();
}

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

// Variables pour stocker les messages de succès ou d'erreur
$success = "";
$error = "";

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = htmlspecialchars($_POST['description']);
    $prix = intval($_POST['prix']);
    $pieces = intval($_POST['pieces']);
    $date_v = $_POST['date_v']; // Utilisez la colonne `date_v` au lieu de `date_mise_en_vente`
    $id_users = $_SESSION['user_id'];
    $id_cat = intval($_POST['id_cat']); // Récupérer l'ID de la catégorie
    $etat = 0; // Valeur par défaut pour `etat`
    $superficie = floatval($_POST['superficie']); // Récupérer la superficie depuis le formulaire
    $vendu = 0; // Valeur par défaut pour `vendu` (0 = non vendu)

    // Gestion des images (si vous avez une colonne `images` dans la table)
    $images = "";
    if (!empty($_FILES['images']['name'][0])) {
        $images = "uploads/" . basename($_FILES['images']['name'][0]);
        // Déplacer l'image vers le dossier "uploads"
        move_uploaded_file($_FILES['images']['tmp_name'][0], $images);
    }

    // Vérifier si l'ID de la catégorie existe dans la table `categories`
    $stmt_check = $conn->prepare("SELECT id_cat FROM categories WHERE id_cat = ?");
    $stmt_check->bind_param("i", $id_cat);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // L'ID de la catégorie existe, procéder à l'insertion
        $stmt = $conn->prepare("INSERT INTO biens (description, prix, pieces, date_v, id_users, id_cat, etat, superficie, vendu) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siisiiidi", $description, $prix, $pieces, $date_v, $id_users, $id_cat, $etat, $superficie, $vendu);

        if ($stmt->execute()) {
            $success = "Annonce créée avec succès !";
        } else {
            $error = "Erreur lors de la création de l'annonce : " . $stmt->error;
        }

        $stmt->close();
    } else {
        $error = "La catégorie sélectionnée n'existe pas.";
    }

    $stmt_check->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Poster une annonce - JulienSelling</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Ajout d'un calendrier pour la saisie de la date -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body>
    <main class="container mt-5">
        <h1 class="text-center">Poster une annonce</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <!-- Champ Description -->
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
            </div>

            <!-- Champ Prix -->
            <div class="form-group mb-3">
                <label for="prix">Prix (€)</label>
                <input type="number" class="form-control" id="prix" name="prix" required>
            </div>

            <!-- Champ Nombre de pièces -->
            <div class="form-group mb-3">
                <label for="pieces">Nombre de pièces</label>
                <input type="number" class="form-control" id="pieces" name="pieces" required>
            </div>

            <!-- Champ Date de mise en vente -->
            <div class="form-group mb-3">
                <label for="date_v">Date de mise en vente</label>
                <input type="text" class="form-control" id="date_v" name="date_v" required>
            </div>

            <!-- Champ Catégorie -->
            <div class="form-group mb-3">
                <label for="id_cat">Catégorie</label>
                <select class="form-control" id="id_cat" name="id_cat" required>
                    <option value="">Choisissez une catégorie</option>
                    <?php
                    // Récupérer les catégories depuis la base de données
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    $result = $conn->query("SELECT id_cat, nom_cat FROM categories");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_cat'] . "'>" . $row['nom_cat'] . "</option>";
                    }
                    $conn->close();
                    ?>
                </select>
            </div>

            <!-- Champ Superficie -->
            <div class="form-group mb-3">
                <label for="superficie">Superficie (m²)</label>
                <input type="number" class="form-control" id="superficie" name="superficie" step="0.01" required>
            </div>

            <!-- Champ Images -->
            <div class="form-group mb-3">
                <label for="images">Images du bien</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple>
            </div>

            <!-- Bouton de soumission -->
            <button type="submit" class="btn btn-primary">Publier l'annonce</button>
        </form>

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
    </main>

    <!-- Script pour le calendrier -->
    <script>
        flatpickr("#date_v", {
            dateFormat: "Y-m-d", // Format de la date
            minDate: "today", // La date ne peut pas être antérieure à aujourd'hui
        });
    </script>
</body>
</html>

<?php include "footer.php"; ?>