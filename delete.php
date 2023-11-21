<?php
require 'assets/connexion.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('location: loged.php');
    exit();
}

$query = "SELECT * FROM post_it WHERE id=:id";
$response = $bdd->prepare($query);
$response->execute(['id' => $_GET['id']]);
$data = $response->fetch();

    $deleteQuery = "DELETE FROM post_it WHERE id=:id";
    $deleteResponse = $bdd->prepare($deleteQuery);
    if ($deleteResponse->execute(['id' => $_GET['id']])) {
        header('location: main.php');
        exit();
    } 