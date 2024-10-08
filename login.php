<?php
include('config.php');
session_start();

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['isKine'] = $user['isKine']; // Ajoute isKine à la session
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Erreur de connexion. Vérifiez votre email et votre mot de passe.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="login">Se connecter</button>
    </form>
    
    <!-- Bouton pour rediriger vers la page de création de compte -->
    <div class="register-link">
        <p>Pas encore inscrit ?</p>
        <a href="register.php"><button>S'enregistrer</button></a>
    </div>
</body>
</html>
