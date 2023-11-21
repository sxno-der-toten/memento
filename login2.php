<?php
session_unset();

require 'assets/connexion.php';

function validationEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_Name = $_POST['first_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $password_confirmation = $_POST['password_confirmation'];

    if (!empty($email) && !empty($password) && !empty($name) && !empty($password_confirmation)) {
        if (validationEmail($email) && strlen($password) >= 8) {
            if ($password !== $password_confirmation) {
                echo 'Les mots de passe ne correspondent pas.';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                try {
                    $stmt = $bdd->prepare("INSERT INTO admin (first_name, name, email, password) VALUES (:first_name, :name, :email, :password)");
                    $stmt->bindParam(':first_name', $first_Name);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $hashedPassword);
                    $stmt->execute();

                    echo "Données enregistrées avec succès.";
                    // Rediriger après l'insertion des données
                    header("Location: loged.php");
                    exit();
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            }
        } else {
            echo 'Email invalide ou mot de passe trop court (minimum 8 caractères).';
        }
    } else {
        echo 'Veuillez remplir tous les champs du formulaire.';
    }
}
?>




<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form>
        <h3>Connexion</h3>

        <label for="username">Nom d'utilisateur</label>
        <input type="text" placeholder="Email or Phone" id="username">

        <label for="password">Mot de passe</label>
        <input type="password" placeholder="Password" id="password">

        <button class="log">OK</button>
        <style>
            .log {
                color :white;
            }
        </style>

    </form>
</body>
</html>