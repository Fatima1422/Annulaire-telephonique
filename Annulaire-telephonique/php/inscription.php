<!DOCTYPE html>
<html>
<head>
    <title>Inscription - Annuaire Téléphonique</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Inscription</h2>
    <form method="POST" action="inscription.php">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" required><br>

        <label for="email">Email :</label>
        <input type="email" name="email" required><br>

        <label for="motdepasse">Mot de passe :</label>
        <input type="password" name="motdepasse" required><br>

        <label for="telephone">Numéro de téléphone :</label>
        <input type="tel" name="telephone" pattern="[0-9]{10}" required><br>

        <label for="adresse">Adresse :</label>
        <textarea name="adresse" required></textarea><br>

        <label for="date_naissance">Date de naissance :</label>
        <input type="date" name="date_naissance" required><br>

        <label for="profession">Profession :</label>
        <input type="text" name="profession" required><br>

        <label for="genre">Genre :</label>
        <select name="genre">
            <option value="homme">Homme</option>
            <option value="femme">Femme</option>
            <option value="autre">Autre</option>
        </select><br>

        <input type="submit" value="S'inscrire">
    </form>
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

// Traitement des données d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $motdepasse = $_POST["motdepasse"];
    $telephone = $_POST["telephone"];
    $adresse = $_POST["adresse"];
    $date_naissance = $_POST["date_naissance"];
    $profession = $_POST["profession"];
    $genre = $_POST["genre"];

    // Effectuer des vérifications et validations supplémentaires ici

    // Insérer les données dans la base de données
    $query = "INSERT INTO utilisateurs (nom, email, motdepasse, telephone, adresse, date_naissance, profession, genre) VALUES ('$nom', '$email', '$motdepasse', '$telephone', '$adresse', '$date_naissance', '$profession', '$genre')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Inscription réussie !";
    } else {
        echo "Erreur lors de l'inscription : " . mysqli_error($conn);
    }
}

// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>
</body>
</html>