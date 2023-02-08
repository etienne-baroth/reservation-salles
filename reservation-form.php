<?php

require_once('config.php');

// var_dump($_SESSION);

$getUser = $database->prepare('SELECT* FROM utilisateurs');

$getUser->execute();

$user = $getUser->fetch();

if(isset($_POST["submit"])) {

    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);
    $dateDébut = htmlspecialchars($_POST['date-début']);
    $dateFin = htmlspecialchars($_POST['date-fin']);
    $id_utilisateur = $_SESSION["utilisateur"]["id"];

    if(!empty($titre) && !empty($description) && !empty($dateDébut) && !empty($dateFin)) {

        $userId = $_SESSION["utilisateur"]["id"];
        $getUser = $database->prepare("INSERT INTO reservations (titre, description, debut, fin, id_utilisateur) VALUES (?,?,?,?,?)");

        $getUser-> bindValue(":id_utilisateur", $id_utilisateur);
        $getUser->execute([$titre, $description, $dateDébut, $dateFin, $id_utilisateur]);

        echo "La réservation est validée";

    } else {
        echo "Veuillez remplir correctement les champs";
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Réservation</title>
</head>
<body>

<header>

<div class="header-nav">
    <div class="header-title"><a href="index.php">CLASSROOMS</a></div>

    <div class="header-btn">
        <p id="btn1"><a href="planning.php">Planning</a></p>
        <p id="btn2"><a href="profil.php">Modifier Profil</a></p>
        <p id="btn3"><a href="logout.php">Déconnexion</a></p>
    </div>
</div>

</header>

<main>

<h1>Formulaire de Réservation</h1>

<h2>Utilisateur : <?php echo $_SESSION["utilisateur"]["login"] ?> </h2>

<form class="form" method="post" action="">
    <label for="Titre">Titre</label>
    <input type="text" name="titre" autocomplete="off">
    <label for="Description">Description</label>
    <input type="text" name="description" autocomplete="off">
    <label for="Date de Début">Date de Début</label>
    <input type="datetime-local" name="date-début" autocomplete="off">
    <label for="Date de Fin">Date de Fin</label>
    <input type="datetime-local" name="date-fin" autocomplete="off">
    <input id="submit_btn" type="submit" name="submit" value="Valider ma Réservation">
</form>

</main>

</body>
</html>