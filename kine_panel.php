<?php
include('header.php');
include('config.php');

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
    $check_query = "SELECT * FROM user_exercises WHERE user_id = ? AND exercise_id = ?";
    if ($stmt = mysqli_prepare($conn, $check_query)) {
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $exercise_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $message = "Cet exercice a déjà été attribué à cet utilisateur.";
        } else {
            // Attribuer l'exercice à l'utilisateur
            $assign_query = "INSERT INTO user_exercises (user_id, exercise_id, assigned_date, status) 
                             VALUES (?, ?, NOW(), 'not_started')";
            if ($stmt_assign = mysqli_prepare($conn, $assign_query)) {
                mysqli_stmt_bind_param($stmt_assign, "ii", $user_id, $exercise_id);
                if (mysqli_stmt_execute($stmt_assign)) {
                    $message = "Exercice attribué avec succès.";
                } else {
                    $message = "Erreur lors de l'attribution de l'exercice.";
                }
                mysqli_stmt_close($stmt_assign);
            }
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Panel Kiné</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Ajout de Chart.js pour les graphiques -->
</head>

<body>
    <h1>Panel Kiné - Ajouter des exercices aux utilisateurs</h1>

    <!-- Section pour assigner des exercices -->
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

    <hr> <!-- Séparation entre l'assignation et la section de suivi des progrès -->

    <!-- Section pour afficher les progrès des élèves -->
    <h2>Suivi des progrès des élèves</h2>

    <!-- Formulaire pour choisir un élève pour afficher ses progrès -->
    <form method="POST" action="">
        <label for="progress_user_id">Sélectionner un élève :</label>
        <select name="progress_user_id" id="progress_user_id" onchange="this.form.submit()">
            <option value="">Choisir un élève</option>
            <?php
            // Réinitialiser la requête pour la liste des utilisateurs
            $user_result = mysqli_query($conn, $user_query);
            while ($row = mysqli_fetch_assoc($user_result)): ?>
                <option value="<?php echo $row['id']; ?>" <?php echo (isset($_POST['progress_user_id']) && $_POST['progress_user_id'] == $row['id']) ? 'selected' : ''; ?>>
                    <?php echo $row['username']; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php
    if (isset($_POST['progress_user_id'])) {
        $user_id = intval($_POST['progress_user_id']);

        // Récupérer les progrès de l'élève sélectionné
        $progress_query = "SELECT progress.progress_date, exercises.name, progress.score
                           FROM progress 
                           JOIN exercises ON progress.exercise_id = exercises.id 
                           WHERE progress.user_id = ?";
        if ($stmt_progress = mysqli_prepare($conn, $progress_query)) {
            mysqli_stmt_bind_param($stmt_progress, "i", $user_id);
            mysqli_stmt_execute($stmt_progress);
            $result_progress = mysqli_stmt_get_result($stmt_progress);

            $exercise_data = [];
            while ($row = mysqli_fetch_assoc($result_progress)) {
                $exercise_data[$row['name']][] = [
                    'date' => $row['progress_date'],
                    'score' => $row['score']
                ];
            }

            mysqli_stmt_close($stmt_progress);
        }

        // Affichage des graphiques si des données sont disponibles
        if (!empty($exercise_data)): ?>
            <h3>Progrès de l'élève</h3>
            <?php foreach ($exercise_data as $exercise_name => $data): ?>
                <h4>Progression pour <?php echo $exercise_name; ?></h4>
                <div class="chart-container">
                    <canvas id="chart-<?php echo md5($exercise_name); ?>"></canvas>
                </div>

                <script>
                    var ctx = document.getElementById('chart-<?php echo md5($exercise_name); ?>').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: <?php echo json_encode(array_column($data, 'date')); ?>, // Dates
                            datasets: [{
                                label: 'Score de progression',
                                data: <?php echo json_encode(array_column($data, 'score')); ?>, // Scores
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            maintainAspectRatio: false, // Permet de contrôler la taille avec le CSS
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 10
                                }
                            }
                        }
                    });
                </script>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun progrès trouvé pour cet élève.</p>
        <?php endif;
    }
    ?>

    <a href="dashboard.php">Retour au tableau de bord</a>
</body>

</html>