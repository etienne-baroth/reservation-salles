<?php

require_once('config.php');


if (isset($_GET["evenement"]) && !empty($_GET["evenement"])) {
    $id = $_GET["evenement"];

    $requete = $database->prepare("SELECT * FROM reservations INNER JOIN utilisateurs ON utilisateurs.id = reservations.id_utilisateur WHERE reservations.id = ? ");
    $requete->execute([$id]);
    $resa = $requete->fetchAll(PDO::FETCH_ASSOC);

    $titre = $resa[0]['titre'];
    $login = $resa[0]['login'];
    $description = $resa[0]['description'];

    $debut = explode(" ", $resa[0]['debut']);

    $H = explode(":", $debut[1]);
    $heure_debut = $H[0] . ":" . $H[1];

    $J =  explode("-", $debut[0]);
    $jour = $J[2] . "-" . $J[1] . "-" . $J[0];

    $fin = explode(" ", $resa[0]['fin']);

    $HF = explode(":", $fin[1]);
    $heure_fin = $HF[0] . ":" . $HF[1];
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning</title>
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
        <p><a class="header-btn-solo" href="planning.php">Planning 🧾</a></p>
        <p><a class="header-btn-solo" href="reservation-form.php">Formulaire de Réservation &#x2709</a></p>
        <p><a class="header-btn-solo" href="profil.php">Modifier Profil 🕶</a></p>
        <p><a class="header-btn-solo-last" href="logout.php">Déconnexion ⛌</a></p>
    </div>
</div>

</header>

    <main>
        <section>
            <h1>Réservé par <u><?php echo $login; ?></u></h1>
            <p>Le <?php echo $jour ?> de <?php echo $heure_debut; ?> à <?php echo $heure_fin; ?></p>
            <hr>
            <section>
                <h3><u>Titre</u> :</h3>
                <p><?php echo $titre; ?></p>
            </section>
            <hr>
            <section>
                <h3><u>Description</u> :</h3>
                <p><?php echo $description; ?></p>
            </section>

        </section>
    </main>

<footer>

    <div class="footer-names">

        <p>Etienne & Miguel Création</p>

    </div>

</footer>

</body>