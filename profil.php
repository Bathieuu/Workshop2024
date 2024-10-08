<?php
include('header.php'); // Inclure le header
include('config.php');

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupère les informations de l'utilisateur connecté
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Met à jour les informations de l'utilisateur si le formulaire est soumis
if (isset($_POST['update_profile'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $update_query = "UPDATE users SET username = '$username', email = '$email' WHERE id = '$user_id'";
    if (mysqli_query($conn, $update_query)) {
        echo "Profil mis à jour avec succès !";

    } else {
        echo "Erreur lors de la mise à jour du profil.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil utilisateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Votre profil</h1>
    <form method="POST" action="">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
        
        <label for="email">Email :</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        
        <button type="submit" name="update_profile">Mettre à jour le profil</button>
    </form>

    <a href="dashboard.php">Retour au tableau de bord</a>
</body>
</html>

<?php
include('footer.php');
?>