<!DOCTYPE html>
<html>
<head>
    <title>Connexion - Annuaire Téléphonique</title>
</head>
<body>
    <h2>Connexion</h2>
    <form method="POST" action="connexion.php">
        <label for="email">Email :</label>
        <input type="email" name="email" required><br>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" required><br>

        <input type="submit" value="Se connecter">
    </form>
    <?php if (isset($erreur)) { ?>
    <p class="error"><?php echo $erreur; ?></p>
<?php } ?>

</body>
</html>
<?php
session_start();


$host = "localhost";
$username = "root";
$password = "";
$database = "annulaire_tel";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Vérifier si l'utilisateur est déjà connecté, le rediriger vers la page d'accueil
if (isset($_SESSION["email"])) {
    header("Location: acceuil.php");
    exit();
}

// Traitement des données de connexion
$email = $_POST["email"];
$mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);

// Requête de vérification des informations de connexion
$query = "SELECT * FROM utilisateurs WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);

    if (password_verify($_POST["mot_de_passe"], $user["mot_de_passe"])) {
        // Informations de connexion correctes
        $_SESSION["email"] = $email;
        $_SESSION["utilisateur_id"] = $user["id"]; // Attribuer l'ID de l'utilisateur à la variable de session

        // Définir les clés "nom" et "adresse" dans $_SESSION
        $_SESSION["nom"] = $user["nom"];
        $_SESSION["adresse"] = $user["adresse"];

        header("Location: acceuil.php"); // Rediriger vers la page d'accueil après la connexion
        exit();
    } else {
        // Mot de passe incorrect
        $erreur = "Mot de passe incorrect.";
    }
} else {
    // Aucun utilisateur correspondant trouvé
    $erreur = "Email ou mot de passe incorrect.";
}

// ...


// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>