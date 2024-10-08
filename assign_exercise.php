<?php
include('config.php');

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die('Non autorisé');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exercise_id'])) {
    $user_id = $_SESSION['user_id'];
    $exercise_id = intval($_POST['exercise_id']);

    // Vérifie si cet exercice est déjà ajouté pour cet utilisateur
    $check_query = "SELECT * FROM user_exercises WHERE user_id = '$user_id' AND exercise_id = '$exercise_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Exercice déjà ajouté, renvoie une erreur
        echo json_encode(['status' => 'error', 'message' => 'Cet exercice est déjà dans votre programme.']);
    } else {
        // Sinon, insère l'exercice dans le programme de l'utilisateur
        $insert_query = "INSERT INTO user_exercises (user_id, exercise_id) VALUES ('$user_id', '$exercise_id')";

        if (mysqli_query($conn, $insert_query)) {
            echo json_encode(['status' => 'success', 'message' => 'Exercice ajouté avec succès']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de l\'exercice.']);
        }
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Données invalides.']);
}
?>
