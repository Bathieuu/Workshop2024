<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Vérifie si l'utilisateur est un kiné (isKine)
$isKine = isset($_SESSION['isKine']) && $_SESSION['isKine'] == 1;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>HomeKiné</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="dashboard.php">HomeKiné</a>
            </div>
            <ul class="nav-links">
                <li><a href="dashboard.php">Tableau de bord</a></li>
                <li><a href="exercices.php">Exercices</a></li>
                <li><a href="voir_progres.php">Voir Progrès</a></li>
                <li><a href="profil.php">Profil</a></li>
                <?php if ($isKine): ?>
                    <li><a href="kine_panel.php">Panel Kiné</a></li> <!-- Lien pour les kinés -->
                <?php endif; ?>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
