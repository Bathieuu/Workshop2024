<?php
session_start();
include('config.php');

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Vérifie si l'ID de l'exercice utilisateur a été envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_exercise_id'])) {
    $user_exercise_id = intval($_POST['user_exercise_id']);
    $user_id = $_SESSION['user_id'];

    // Supprimer l'exercice de la table user_exercises
    $delete_query = "DELETE FROM user_exercises WHERE id = '$user_exercise_id' AND user_id = '$user_id'";
    if (mysqli_query($conn, $delete_query)) {
        header("Location: dashboard.php?message=Exercice retiré avec succès");
        exit();
    } else {
        echo "Erreur lors de la suppression de l'exercice : " . mysqli_error($conn);
    }
} else {
    echo "Données invalides.";
}
?>
