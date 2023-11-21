<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=memento;charset=utf8', 'root', '');
$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "SELECT * FROM post_it";
$response = $bdd->query($query);
$datas = $response->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Memento</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<header>
  <div class="logo">
    <h1 class='titre'>Memento</h1>
  </div>
  <nav class="logs">
  <a href="login.php" class="connexion">Login</a>
  <a href="register.php" class="register">Register</a>
  </nav>
</header>
<hr>
<div class="add">
<h1 class="head">Memento</h1>
<a href="add.php" class="ajouter">Ajouter un post-it</a>
</div>
<div class='parent'>
  <?php foreach($datas as $data) { ?>
    <div class="postits">
    <a href='delete.php?id=<?= $data['id']?>' class="supprimer" title='<?= $data['title']?>'>✖</a>
      <h4 class='titres'><?= $data['title']?></h4>
      <p class='contenu'><?= $data['content']?><br><?= $data['date']?></p>
    </div>
  <?php } ?>
</div>

</body>
</html>
