<?php
include ('config.php');
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Préparer la requête d'insertion
    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

    // Préparer l'instruction
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Lier les variables à la requête préparée
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);

        // Exécuter la requête
        if (mysqli_stmt_execute($stmt)) {
            // Rediriger vers la page de connexion après l'inscription réussie
            header("Location: login.php");
        } else {
            echo "Erreur lors de l'inscription.";
        }

        // Fermer l'instruction préparée
        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur lors de la préparation de la requête : " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="register">S'inscrire</button>
    </form>

    <!-- Lien pour revenir à la page de connexion -->
    <div class="login-link">
        <p>Déjà un compte ?</p>
        <a href="login.php"><button>Se connecter</button></a>
    </div>
</body>

</html>