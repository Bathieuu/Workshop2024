<?php
include('header.php'); // Inclure le header
include('config.php');


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupère la liste des exercices attribués à l'utilisateur
$query = "SELECT user_exercises.exercise_id, exercises.name 
          FROM user_exercises 
          JOIN exercises ON user_exercises.exercise_id = exercises.id 
          WHERE user_exercises.user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if (isset($_POST['submit_progress'])) {
    $exercise_id = $_POST['exercise_id'];
    $score = $_POST['score'];
    $comment = $_POST['comment'];
    $progress_date = date('Y-m-d');
    
    // Insère la progression dans la table 'progress'
    $insert_query = "INSERT INTO progress (user_id, exercise_id, progress_date, score, comment) 
                     VALUES ('$user_id', '$exercise_id', '$progress_date', '$score', '$comment')";
    
    if (mysqli_query($conn, $insert_query)) {
        echo "Progression ajoutée avec succès!";
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Saisir Progression</title>
</head>
<body>
    <h1>Saisir votre progression</h1>
    <form method="POST" action="">
        <label for="exercise_id">Exercice :</label>
        <select name="exercise_id" required>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <option value="<?php echo $row['exercise_id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="score">Score (sur 10) :</label>
        <input type="number" name="score" min="1" max="10" required><br>

        <label for="comment">Commentaire :</label>
        <textarea name="comment" rows="4" cols="50"></textarea><br>

        <button type="submit" name="submit_progress">Soumettre la progression</button>
    </form>
</body>
</html>

<?php
include('footer.php');
?>