<!DOCTYPE html>
<html>
<head>
    <title>Modifier un contact - Annuaire Téléphonique</title>
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Modifier un contact</h2>
        <?php
        // Vérifier si l'identifiant du contact est présent dans l'URL
        if (isset($_GET['id'])) {
            $contact_id = $_GET['id'];

            // Connexion à la base de données
            $host = "localhost";
            $username = "root";
            $password = "";
            $database = "annulaire_tel";

            $conn = mysqli_connect($host, $username, $password, $database);

            if (!$conn) {
                die("Erreur de connexion à la base de données : " . mysqli_connect_error());
            }

            // Récupérer les informations du contact à modifier
            $query = "SELECT * FROM contacts WHERE id = '$contact_id'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);

                // Afficher le formulaire de modification avec les informations actuelles du contact
                echo '<form method="POST" action="modifier_contact.php">';
                echo '<input type="hidden" name="contact_id" value="' . $contact_id . '">'; // Champ caché pour stocker l'identifiant du contact
                echo '<label for="nom">Nom :</label>';
                echo '<input type="text" name="nom" value="' . $row['nom'] . '" required><br>';

                echo '<label for="numero_telephone">Numéro de téléphone :</label>';
                echo '<input type="tel" name="numero_telephone" value="' . $row['numero_telephone'] . '" required><br>';

                echo '<label for="adresse">Adresse :</label>';
                echo '<textarea name="adresse" required>' . $row['adresse'] . '</textarea><br>';

                // Afficher d'autres champs pour les autres informations du contact

                echo '<input type="submit" value="Enregistrer">';
                echo '</form>';
            } else {
                echo '<p class="error">Le contact spécifié n\'existe pas.</p>';
            }

            // Fermeture de la connexion à la base de données
            mysqli_close($conn);
        } else {
            echo '<p class="error">Aucun identifiant de contact spécifié.</p>';
        }
        ?>
    </div>
</body>
</html>