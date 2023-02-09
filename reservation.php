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
</head>
<body>

<header>

<div class="header-nav">
    <div class="header-title"><a href="index.php">CLASSROOMS</a></div>

    <div class="header-btn">
        <p id="btn1"><a href="planning.php">Planning</a></p>
        <p id="btn1"><a href="reservation-form.php">Formulaire de Réservation</a></p>
        <p id="btn2"><a href="profil.php">Modifier Profil</a></p>
        <p id="btn3"><a href="logout.php">Déconnexion</a></p>
    </div>
</div>

</header>

<main>
        <section>
            <h1>Réserver par <u><?php echo $login; ?></u></h1>
            <p>Le <?php echo $jour ?> de <?php echo $heure_debut; ?> à <?php echo $heure_fin; ?></p>
            <hr>
            <section>
                <p><u>Titre</u> :</p>
                <p><?php echo $titre; ?></p>
            </section>
            <hr>
            <section>
                <p><u>Description</u> :</p>
                <p><?php echo $description; ?></p>
            </section>

        </section>
    </main>

</body>