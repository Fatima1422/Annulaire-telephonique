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

        <label for="motdepasse">Mot de passe :</label>
        <input type="password" name="motdepasse" required><br>

        <input type="submit" value="Se connecter">
    </form>
    <?php if (isset($erreur)) { ?>
        <p class="error"><?php echo $erreur; ?></p>
    <?php } ?>
</body>
</html>
<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté, le rediriger vers la page d'accueil
if (isset($_SESSION["email"])) {
    header("Location: accueil.php");
    exit();
}

// Traitement des données de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $motdepasse = $_POST["motdepasse"];

    // Vérifier les informations de connexion
    // Connexion à la base de données
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "annulaire_tel";

    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Erreur de connexion à la base de données : " . mysqli_connect_error());
    }

    // Requête de vérification des informations de connexion
    $query = "SELECT * FROM utilisateurs WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($motdepasse, $user["motdepasse"])) {
            // Informations de connexion correctes
            $_SESSION["email"] = $email;
            header("Location: accueil.php"); // Rediriger vers la page d'accueil après la connexion
            exit();
        }
    }

    // Informations de connexion incorrectes
    $erreur = "Email ou mot de passe incorrect.";
}

// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>