<?php

include("src/classe_connection.php");
        if (!empty($_SESSION['login'])){ // si l'utilisateur est déja connecté il est rediriger vers la page d'accueil.php
            header("Location:index.php");
            exit;
        }

if (isset($_POST["submit"])) {

    if ($_POST['login'] && $_POST['password'] && $_POST['password_confirm']) {
        
        $login = $_POST["login"];
        $password = $_POST["password"];
        $password_confirm = $_POST["password_confirm"];

        $utilisateur = new Userpdo;
        $utilisateur->register($login, $password, $password_confirm);
    } else {
        echo "veuillez remplir tous les champs";
    }

}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="widthfr, initial-scale=1.0">
    <link rel="stylesheet" href="./src/style.css">
    <title>Inscription</title>
</head>
<body>
    <?php include("header.php"); ?>
    <main>
        <section>
            <div class="container-form">
                <h1>Inscription</h1>
                <p class="msg-error"></p>
                <form method="post">
                    <label for="flogin">Login</label>
                    <input type="text" name="login" placeholder="Choisissez votre login">
                    <label for="fpassword">Mot de Passe</label>
                    <input type="password" name="password" placeholder="Mot de Passe">
                    <input type="password" name="password_confirm" placeholder="Confirmer le mot de Passe">
                    <input type="submit" name="submit" value="valider">
                </form>
            </div>
        </section> 
    </main>
    <?php include("footer.php"); ?> 
</body>
</html>