<!DOCTYPE html>
<html>
<head>
    <title>Accueil - Annuaire Téléphonique</title>
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .user-info {
            background-color: #f5f5f5;
            padding: 10px;
            margin-bottom: 20px;
        }
        .contacts {
            margin-bottom: 20px;
        }
        .contact-item {
            margin-bottom: 10px;
        }
        .search-form {
            margin-bottom: 20px;
        }
        .search-input {
            width: 200px;
            padding: 5px;
        }
        .add-form {
            margin-bottom: 20px;
        }
        .add-input {
            width: 200px;
            padding: 5px;
            margin-bottom: 10px;
        }
        .add-submit {
            padding: 5px 10px;
            background-color: #008000;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .edit-link,
        .delete-link {
            text-decoration: none;
            color: #0000ff;
            margin-left: 10px;
        }
        .delete-link {
            color: #ff0000;
        }
    </style>
</head>
<body>

    <?php session_start(); ?>
    
    <div class="container">
        <h2>Bienvenue dans l'annuaire téléphonique</h2>
        <div class="user-info">
            <p>Vous êtes connecté en tant que <?php echo $_SESSION["email"]; ?></p>
            <p>Votre nom : <?php echo $_SESSION["nom"]; ?></p>
            <p>Votre adresse : <?php echo $_SESSION["adresse"]; ?></p>
        </div>

        <div class="search-form">
            <h3>Recherche de contacts</h3>
            <form method="POST" action="recherche.php">
                <input type="text" name="search" class="search-input" placeholder="Rechercher par nom...">
                <input type="submit" value="Rechercher">
            </form>
        </div>

        <div class="contacts">
            <h3>Liste des contacts</h3>
            <?php
            // Connexion à la base de données
            $host = "localhost";
            $username = "root";
            $password = "";
            $database = "annulaire_tel";

            $conn = mysqli_connect($host, $username, $password, $database);

            if (!$conn) {
                die("Erreur de connexion à la base de données : " . mysqli_connect_error());
            }

            // Récupérer la liste des contacts
            $query = "SELECT * FROM contacts WHERE utilisateur_id = " . $_SESSION["utilisateur_id"];
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="contact-item">';
                    echo 'Nom : ' . $row["nom"] . '<br>';
                    echo 'Numéro de téléphone : ' . $row["numero_telephone"] . '<br>';
                    echo 'Adresse : ' . $row["adresse"] . '<br>';
                    echo '<a href="modifier_contact.php?id=' . $row["id"] . '" class="edit-link">Modifier</a>';
                    echo '<a href="supprimer_contact.php?id=' . $row["id"] . '" class="delete-link">Supprimer</a>';
                    echo '</div>';
                }
            } else {
                echo 'Aucun contact trouvé.';
            }

            // Fermeture de la connexion à la base de données
            mysqli_close($conn);
            ?>
        </div>

        <div class="add-form">
            <h3>Ajouter un nouveau contact</h3>
            <form method="POST" action="ajout_contact.php">
                <input type="text" name="utilisateur_id" class="add-input" placeholder="utilisateur_id" required>
                <input type="text" name="nom" class="add-input" placeholder="Nom" required>
                <input type="tel" name="numero_telephone" class="add-input" placeholder="Numéro de téléphone" required>
                <textarea name="adresse" class="add-input" placeholder="Adresse" required></textarea>
                <input type="submit" value="Ajouter" class="add-submit">
            </form>
        </div>

        <p><a href="deconnexion.php">Se déconnecter</a></p>
    </div>
</body>
</html>