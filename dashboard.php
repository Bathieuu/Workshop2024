<?php
include ('header.php');
include ('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupère les exercices attribués à l'utilisateur avec toutes les informations nécessaires
$query = "SELECT user_exercises.id AS user_exercise_id, 
                 exercises.name, 
                 exercises.description, 
                 exercises.sets, 
                 exercises.reps, 
                 exercises.equipment_needed, 
                 muscle_groups.name AS muscle_group_name, 
                 user_exercises.status, 
                 user_exercises.assigned_date
          FROM user_exercises 
          JOIN exercises ON user_exercises.exercise_id = exercises.id 
          JOIN muscle_groups ON exercises.muscle_group_id = muscle_groups.id 
          WHERE user_exercises.user_id = '$user_id'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Bienvenue sur votre tableau de bord</h1>
    <h2>Vos exercices à réaliser</h2>
    <ul class="exercise-list">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <li class="exercise-card">
                <strong><?php echo $row['name']; ?></strong><br>
                Description : <?php echo $row['description']; ?><br>
                Séries : <?php echo $row['sets'] ?: 'Non défini'; ?><br>
                Répétitions : <?php echo $row['reps'] ?: 'Non défini'; ?><br>
                Groupe musculaire : <?php echo $row['muscle_group_name']; ?><br>
                Équipement nécessaire : <?php echo $row['equipment_needed'] ?: 'Aucun'; ?><br>
                Date assignée : <?php echo $row['assigned_date']; ?><br>
                Statut :
                <span class="<?php echo $row['status']; ?>">
                    <?php
                    switch ($row['status']) {
                        case 'not_started':
                            echo 'Non commencé';
                            break;
                        case 'in_progress':
                            echo 'En cours';
                            break;
                        case 'completed':
                            echo 'Terminé';
                            break;
                    }
                    ?>
                </span>
                <form method="POST" action="update_status.php">
                    <input type="hidden" name="user_exercise_id" value="<?php echo $row['user_exercise_id']; ?>">
                    <label for="status">Changer le statut :</label>
                    <select name="status" id="status">
                        <option value="not_started" <?php echo $row['status'] == 'not_started' ? 'selected' : ''; ?>>Non
                            commencé</option>
                        <option value="in_progress" <?php echo $row['status'] == 'in_progress' ? 'selected' : ''; ?>>En cours
                        </option>
                        <option value="completed" <?php echo $row['status'] == 'completed' ? 'selected' : ''; ?>>Terminé
                        </option>
                    </select>
                    <button type="submit">Mettre à jour</button>
                </form>

            </li>
        <?php endwhile; ?>
    </ul>

    <a href="logout.php">Déconnexion</a>
</body>

</html>