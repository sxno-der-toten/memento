<?php
session_start();
session_unset();

require 'connexion.php';
function validationEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        if (validationEmail($email) && strlen($password) >= 8) {
            try {
                $stmt = $bdd->prepare("SELECT * FROM admin WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    
                    if (password_verify($password, $user['password'])) {

                        $stmt = $bdd->prepare("SELECT first_name FROM admin WHERE email = :email");
                        $stmt->bindParam(':email', $email);
                        $stmt->execute();
                        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
                
                        if ($userData) {
                            $_SESSION['first_name'] = $userData['first_name'];
                        }
                        $_SESSION['email'] = $email;
                        $_SESSION['islog']= true;
                        header('Location: loged.php');
                        exit();
                    } else {
                        
                        echo "Le mot de passe est incorrect.";
                    }
                } else {
                   
                    echo "L'email n'est pas enregistré.";
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        } else {
            echo "L'email n'est pas valide ou le mot de passe doit contenir au moins 8 caractères.";
        }
    } else {
        echo "Les champs email et password ne peuvent pas être vides.";
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