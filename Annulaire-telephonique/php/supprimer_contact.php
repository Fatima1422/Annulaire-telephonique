<!DOCTYPE html>
<html>
<head>
    <title>Supprimer un contact - Annuaire Téléphonique</title>
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
        <h2>Supprimer un contact</h2>
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

            // Récupérer les informations du contact à supprimer
            $query = "SELECT * FROM contacts WHERE id = '$contact_id'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);

                // Afficher les informations du contact à supprimer avec un message de confirmation
                echo '<p>Voulez-vous vraiment supprimer le contact suivant :</p>';
                echo '<p><strong>Nom :</strong> ' . $row['nom'] . '</p>';
                echo '<p><strong>Numéro de téléphone :</strong> ' . $row['numero_telephone'] . '</p>';
                echo '<p><strong>Adresse :</strong> ' . $row['adresse'] . '</p>';
                // Afficher d'autres informations du contact si nécessaire

                // Afficher le formulaire de confirmation de suppression
                echo '<form method="POST" action="supprimer_contact.php">';
                echo '<input type="hidden" name="contact_id" value="' . $contact_id . '">'; // Champ caché pour stocker l'identifiant du contact
                echo '<input type="submit" value="Supprimer">';
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