<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/style.css">
    <title>Accueil</title>
</head>
<body>
    <?php session_start(); include("header.php"); ?>
    <main>
        <section>
            <?php if (!empty($_SESSION['login'])): ?>
                <h1>Bienvenue <?= $_SESSION['login'] ?></h1>
            <?php else: ?>
                <h1>Bienvenue</h1>
            <?php endif; ?>
        </section>    
    </main>
</body>
</html>