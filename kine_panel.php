<?php
include ('header.php');
include ('config.php');

// Vérifie si l'utilisateur est connecté et s'il est kiné
if (!isset($_SESSION['user_id']) || !isset($_SESSION['isKine']) || $_SESSION['isKine'] != 1) {
    header("Location: login.php");
    exit();
}

// Récupérer la liste des utilisateurs (à qui le kiné pourra assigner des exercices)
$user_query = "SELECT id, username FROM users WHERE isKine = 0";
$user_result = mysqli_query($conn, $user_query);

// Récupérer la liste des exercices existants
$exercise_query = "SELECT id, name FROM exercises";
$exercise_result = mysqli_query($conn, $exercise_query);

// Si un exercice est assigné à un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['exercise_id'])) {
    $user_id = intval($_POST['user_id']);
    $exercise_id = intval($_POST['exercise_id']);
    
    // Vérifier si cet exercice a déjà été attribué à l'utilisateur
    $check_query = "SELECT * FROM user_exercises WHERE user_id = '$user_id' AND exercise_id = '$exercise_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $message = "Cet exercice a déjà été attribué à cet utilisateur.";
    } else {
        // Attribuer l'exercice à l'utilisateur
        $assign_query = "INSERT INTO user_exercises (user_id, exercise_id, assigned_date, status) 
                         VALUES ('$user_id', '$exercise_id', NOW(), 'not_started')";
        if (mysqli_query($conn, $assign_query)) {
            $message = "Exercice attribué avec succès.";
        } else {
            $message = "Erreur lors de l'attribution de l'exercice.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panel Kiné</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Panel Kiné - Ajouter des exercices aux utilisateurs</h1>
    
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="kine_panel.php">
        <label for="user_id">Sélectionner l'utilisateur :</label>
        <select name="user_id" id="user_id" required>
            <?php while ($user_row = mysqli_fetch_assoc($user_result)): ?>
                <option value="<?php echo $user_row['id']; ?>"><?php echo $user_row['username']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="exercise_id">Sélectionner l'exercice :</label>
        <select name="exercise_id" id="exercise_id" required>
            <?php while ($exercise_row = mysqli_fetch_assoc($exercise_result)): ?>
                <option value="<?php echo $exercise_row['id']; ?>"><?php echo $exercise_row['name']; ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Attribuer l'exercice</button>
    </form>

    <a href="dashboard.php">Retour au tableau de bord</a>
</body>
</html>
