<?php
session_start(); // Assure que la session est démarrée

include ('config.php');

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_exercise_id']) && isset($_POST['status'])) {
    $user_exercise_id = intval($_POST['user_exercise_id']);
    $status = $_POST['status'];

    // Préparer la requête pour mettre à jour le statut de l'exercice
    $query = "UPDATE user_exercises SET status = ? WHERE id = ?";

    // Préparer l'instruction
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Lier les variables à la requête préparée
        mysqli_stmt_bind_param($stmt, "si", $status, $user_exercise_id);  // "s" pour string (status), "i" pour integer (user_exercise_id)

        // Exécuter la requête
        if (mysqli_stmt_execute($stmt)) {
            // Rediriger vers le tableau de bord après mise à jour
            header("Location: dashboard.php?status=updated");
            exit();
        } else {
            echo "Erreur lors de la mise à jour du statut : " . mysqli_stmt_error($stmt);
        }

        // Fermer l'instruction préparée
        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur lors de la préparation de la requête : " . mysqli_error($conn);
    }
} else {
    echo "Données invalides.";
}

?>