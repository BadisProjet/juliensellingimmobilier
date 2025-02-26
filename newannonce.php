<?php include "header.php"; ?>

<style>
    /* Styles personnalisés pour la section d'ajout d'annonce */
    .add_announcement_section {
        background-color: #f9f9f9;
        padding: 50px 0;
    }

    .heading_container h2 {
        color: #333;
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .heading_container p {
        color: #666;
        font-size: 1.1rem;
        margin-bottom: 40px;
    }

    .form_container {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .form-group label {
        font-weight: 600;
        color: #444;
        margin-bottom: 8px;
    }

    .form-control {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .form-control-file {
        border: 1px dashed #ddd;
        padding: 15px;
        border-radius: 5px;
        text-align: center;
        background: #fafafa;
        cursor: pointer;
    }

    .form-control-file:hover {
        background: #f1f1f1;
    }

    .btn_box {
        text-align: center;
        margin-top: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 10px 30px;
        font-size: 1rem;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Effet de survol pour les champs du formulaire */
    .form-group:hover label {
        color: #007bff;
    }
</style>

<section class="add_announcement_section layout_padding">
    <div class="container">
        <div class="heading_container text-center">
            <h2>
                Ajouter une annonce
            </h2>
            <p>
                Vous avez un logement à vendre ? Ajoutez votre annonce ici et faites-en profiter la communauté !
            </p>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="form_container">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Titre de l'annonce</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Ex: Appartement F4 au bord de mer à Marseille" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Décrivez votre logement en détail..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Prix (€)</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Ex: 146000" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Catégorie</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="">Choisissez une catégorie</option>
                                <option value="maison">Maison</option>
                                <option value="appartement">Appartement</option>
                                <option value="autres">Autres</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Image de l'annonce</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="contact">Contact (email ou téléphone)</label>
                            <input type="text" class="form-control" id="contact" name="contact" placeholder="Ex: contact@julienselling.com ou 06 12 34 56 78" required>
                        </div>
                        <div class="btn_box">
                            <button type="submit" class="btn btn-primary">
                                Publier l'annonce
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>