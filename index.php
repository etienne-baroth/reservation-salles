<?php

require_once('config.php');



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="ressources/favicon.png">
</head>
<body>

<header>

<div class="header-nav">
    <div class="header-title"><a class="header-title-solo" href="index.php">CLASSROOMS</a></div>

    <div class="header-btn">
        <?php 
        if(isset($_SESSION["utilisateur"]["login"])) {
            echo '<p><a class="header-btn-solo" href="planning.php">Planning 🧾</a></p>';
            echo '<p><a class="header-btn-solo" href="reservation-form.php">Formulaire de Réservation &#x2709</a></p>';
            echo '<p><a class="header-btn-solo" href="profil.php">Modifier Profil 🕶</a></p>';
            echo '<p><a class="header-btn-solo-last" href="logout.php">Déconnexion ⛌</a></p>';
        }
        else {
        echo '<p><a class="header-btn-solo" href="connexion.php">Se connecter &#x2611</a></p>';
        echo '<p><a class="header-btn-solo-last" href="inscription.php">Nouveau compte &#x270e</a></p>';
        } ?>
    </div>
</div>

</header>

<main>

<h1>Bienvenue sur notre site de réservation de salles <?php if (isset($_SESSION["utilisateur"]["login"])) {echo $_SESSION["utilisateur"]["login"];} ?> ! Vous pouvez accéder au GitHub du site <a class="lien-github "href="https://github.com/etienne-baroth/reservation-salles" target="_blank">ici</a>🎯</h1>

</main>

<footer>

    <div class="footer-names">

        <p>Etienne & Miguel Création</p>

    </div>

</footer>

</body>
</html>