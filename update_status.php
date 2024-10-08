<?php
session_start(); // Assure que la session est démarrée

include('config.php');

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_exercise_id']) && isset($_POST['status'])) {
    $user_exercise_id = intval($_POST['user_exercise_id']);
    $status = $_POST['status'];

    // Mettre à jour le statut de l'exercice pour cet utilisateur
    $query = "UPDATE user_exercises SET status = '$status' WHERE id = '$user_exercise_id'";

    if (mysqli_query($conn, $query)) {
        // Redirige vers le tableau de bord après mise à jour
        header("Location: dashboard.php?status=updated");
        exit();
    } else {
        echo "Erreur lors de la mise à jour du statut : " . mysqli_error($conn);
    }
} else {
    echo "Données invalides.";
}
?>
