<?php
include ('header.php');
include ('config.php');

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupère la liste des groupes musculaires disponibles
$group_query = "SELECT * FROM muscle_groups";
$group_result = mysqli_query($conn, $group_query);

// Gestion du groupe musculaire sélectionné par l'utilisateur
$selected_group = isset($_GET['muscle_group_id']) ? $_GET['muscle_group_id'] : '';

// Récupère les exercices associés au groupe musculaire sélectionné
if ($selected_group) {
    $exercise_query = "SELECT exercises.*, muscle_groups.name AS muscle_group_name 
                       FROM exercises 
                       JOIN muscle_groups ON exercises.muscle_group_id = muscle_groups.id 
                       WHERE muscle_group_id = '$selected_group'";
} else {
    $exercise_query = "SELECT exercises.*, muscle_groups.name AS muscle_group_name 
                       FROM exercises 
                       JOIN muscle_groups ON exercises.muscle_group_id = muscle_groups.id";
}
$exercise_result = mysqli_query($conn, $exercise_query);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Exercices disponibles</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main class="main-content"> <!-- Ajout d'une div wrapper pour éviter le padding du body -->
        <h1>Choisissez un groupe musculaire</h1>
        <form method="GET" action="">
            <label for="muscle_group_id">Groupe musculaire :</label>
            <select id="muscle_group_id" name="muscle_group_id" onchange="this.form.submit()">
                <option value="">Tous</option>
                <?php while ($row = mysqli_fetch_assoc($group_result)): ?>
                    <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $selected_group)
                           echo 'selected'; ?>>
                        <?php echo $row['name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </form>

        <h2>Liste des exercices</h2>
        <ul class="exercise-list">
            <?php while ($row = mysqli_fetch_assoc($exercise_result)): ?>
                <div class="exercise-card">
                    <strong><?php echo $row['name']; ?></strong><br>
                    Description : <?php echo $row['description']; ?><br>
                    Séries : <?php echo $row['sets'] ?: 'Non défini'; ?><br>
                    Répétitions : <?php echo $row['reps'] ?: 'Non défini'; ?><br>
                    Groupe musculaire : <?php echo $row['muscle_group_name']; ?><br>
                    Équipement nécessaire : <?php echo $row['equipment_needed'] ?: 'Aucun'; ?><br>
                    <?php if ($row['video_link']): ?>
                        <a href="<?php echo $row['video_link']; ?>" target="_blank">Voir la vidéo</a><br>
                    <?php endif; ?>
                    <button class="add-program-button" data-exercise-id="<?php echo $row['id']; ?>">
                        Ajouter à mon programme
                    </button>
                </div>

            <?php endwhile; ?>
        </ul>
    </main>
    <script>
        // Sélectionner tous les boutons "Ajouter à mon programme"
        const addProgramButtons = document.querySelectorAll('.add-program-button');

        // Ajouter un écouteur d'événement de clic à chaque bouton
        addProgramButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Récupérer l'ID de l'exercice depuis l'attribut data-exercise-id
                const exerciseId = this.getAttribute('data-exercise-id');

                // Envoyer une requête POST à assign_exercise.php avec l'ID de l'exercice
                fetch('assign_exercise.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `exercise_id=${exerciseId}`
                })
                    .then(response => response.json()) // Transformer la réponse en JSON
                    .then(data => {
                        // Vérifie le statut de la réponse
                        if (data.status === 'success') {
                            // Afficher un message de succès
                            alert(data.message);
                        } else {
                            // Afficher un message d'erreur
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Vous avez déjà ajouté cet exercice.');
                    });
            });
        });
    </script>


</body>

</html>

<?php
include ('footer.php');
?>