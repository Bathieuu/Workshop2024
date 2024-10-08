<?php
include ('header.php');
include ('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupère les progrès de l'utilisateur pour chaque exercice avec le groupe musculaire associé
$query = "SELECT exercises.name AS exercise_name, exercises.sets, exercises.reps, muscle_groups.name AS muscle_group_name, progress.exercise_id, progress.progress_date, progress.score 
          FROM progress 
          JOIN exercises ON progress.exercise_id = exercises.id 
          JOIN muscle_groups ON exercises.muscle_group_id = muscle_groups.id 
          WHERE progress.user_id = '$user_id'
          ORDER BY exercises.name, progress.progress_date ASC";
$result = mysqli_query($conn, $query);

// Organise les données par exercice
$exercise_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $exercise_data[$row['exercise_id']]['name'] = $row['exercise_name'];
    $exercise_data[$row['exercise_id']]['muscle_group'] = $row['muscle_group_name'];
    $exercise_data[$row['exercise_id']]['sets'] = $row['sets'];
    $exercise_data[$row['exercise_id']]['reps'] = $row['reps'];
    $exercise_data[$row['exercise_id']]['dates'][] = $row['progress_date'];
    $exercise_data[$row['exercise_id']]['scores'][] = $row['score'];
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Voir Progression</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Ajout de Chart.js -->
</head>

<body>
    <h1>Vos progrès</h1>

    <?php foreach ($exercise_data as $exercise_id => $data): ?>
        <h2>Progression pour <?php echo $data['name']; ?></h2>
        <p>Groupe musculaire : <?php echo $data['muscle_group']; ?></p>
        <p>Séries : <?php echo $data['sets'] ?: 'Non défini'; ?> | Répétitions :
            <?php echo $data['reps'] ?: 'Non défini'; ?></p>
        <div class="chart-container">
            <canvas id="chart-<?php echo $exercise_id; ?>"></canvas>
        </div>

        <script>
            var ctx = document.getElementById('chart-<?php echo $exercise_id; ?>').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($data['dates']); ?>, // Dates
                    datasets: [{
                        label: 'Score de progression',
                        data: <?php echo json_encode($data['scores']); ?>, // Scores
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 10
                        }
                    },
                    maintainAspectRatio: false // Permet au CSS de contrôler le ratio
                }
            });
        </script>
    <?php endforeach; ?>


</body>

</html>

<?php
include ('footer.php');
?>