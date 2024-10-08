<?php
session_start();
include ('config.php');

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die('Non autorisé');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exercise_id'])) {
    $user_id = $_SESSION['user_id'];
    $exercise_id = intval($_POST['exercise_id']);

    // Vérifie si cet exercice est déjà ajouté pour cet utilisateur avec une requête préparée
    $check_query = "SELECT * FROM user_exercises WHERE user_id = ? AND exercise_id = ?";

    if ($stmt_check = mysqli_prepare($conn, $check_query)) {
        // Lier les variables aux marqueurs de la requête préparée
        mysqli_stmt_bind_param($stmt_check, "ii", $user_id, $exercise_id);

        // Exécuter la requête
        mysqli_stmt_execute($stmt_check);

        // Obtenir les résultats
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            // Exercice déjà ajouté, renvoie une erreur
            echo json_encode(['status' => 'error', 'message' => 'Cet exercice est déjà dans votre programme.']);
        } else {
            // Sinon, insère l'exercice avec une date d'assignation
            $insert_query = "INSERT INTO user_exercises (user_id, exercise_id, assigned_date, status) 
                             VALUES (?, ?, NOW(), 'not_started')";

            // Préparer la requête
            if ($stmt_insert = mysqli_prepare($conn, $insert_query)) {
                // Lier les variables aux marqueurs de la requête préparée
                mysqli_stmt_bind_param($stmt_insert, "ii", $user_id, $exercise_id);

                // Exécuter la requête
                if (mysqli_stmt_execute($stmt_insert)) {
                    echo json_encode(['status' => 'success', 'message' => 'Exercice ajouté avec succès']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de l\'exercice.']);
                }

                // Fermer l'instruction préparée
                mysqli_stmt_close($stmt_insert);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la préparation de la requête d\'insertion.']);
            }
        }

        // Fermer l'instruction préparée de vérification
        mysqli_stmt_close($stmt_check);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la préparation de la requête de vérification.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Données invalides.']);
}

?>