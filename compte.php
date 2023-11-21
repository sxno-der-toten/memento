<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'assets/connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['champ_contente_1'];
    $content = $_POST['champ_contente_2'];
    $date = $_POST['date'];

    $insertQuery = "INSERT INTO post_it (title, content, date) VALUES (:title, :content, :date)";
    $insertStatement = $bdd->prepare($insertQuery);
    $insertStatement->execute([
        'title' => $title,
        'content' => $content,
        'date' => $date,
    ]);

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un post-it</title>
</head>
<body>
    <h2>Ajouter un post-it</h2>
    <form action="" method="post">
        <label for="champ_contente_1">Titre :</label>
        <input type="text" id="champ_contente_1" name="champ_contente_1"><br><br>
        
        <label for="champ_contente_2">Contenu :</label>
        <input type="text" id="champ_contente_2" name="champ_contente_2"><br><br>
        
        <label for="date">Date :</label>
        <input type="date" id="date" name="date"><br><br>

        <button type="submit" class="send">Add Post-it</button>
    </form>
</body>
</html>