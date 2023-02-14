<?php

require_once('config.php');

// var_dump($_SESSION);

$getUser = $database->prepare('SELECT* FROM utilisateurs');

$getUser->execute();

$user = $getUser->fetch();


if(isset($_POST["submit"])) {

    $newmdp = $_POST['newmdp'];
    $newlogin = htmlspecialchars($_POST['newlogin']);

    if(!empty($newlogin) && !empty($newmdp)) {

        if($_POST['newmdp'] == $_POST['newmdpconf']) {

            $userId = $_SESSION["utilisateur"]["id"];
            $getUser = $database->prepare("UPDATE utilisateurs SET `login` = '$newlogin', `password` = :password WHERE `id`='$userId'");

            $getUser->bindValue(":password", $newmdp);

            $getUser->execute();

            echo "Les modifications sont enregistrées";
        }
        else {
            echo "Le mot de passe et sa confirmation ne sont pas identiques";
        }

    } else {
        echo "Toutes les informations sont nécessaires";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification Profil</title>
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
        <p><a class="header-btn-solo-last" href="logout.php">Déconnexion ⛌</a></p>
    </div>
</div>

</header>

<main>

<h1>Vous pouvez modifier vos informations ici <?php echo $_SESSION["utilisateur"]["login"] ?></h1>

<div>

<form class="form_profil" method="post" action="">
    <label for="Nouveau Login">Nouveau Login</label>
    <input class="input_profil" type="text" name="newlogin" value="<?php echo $_SESSION["utilisateur"]["login"] ?>" autocomplete="off">
    <label for="Nouveau Mot de Passe">Nouveau Mot de Passe</label>
    <input class="input_profil" type="password" name="newmdp"  autocomplete="off">
    <label for="Nouveau Mot de Passe Conf">Confirmation Nouveau Mot de Passe</label>
    <input class="input_profil" type="password" name="newmdpconf" autocomplete="off">
    <input class="submit_btn" type="submit" name="submit" value="Modifier">
</form>

</div>

</main>

<footer>

    <div class="footer-names">

        <p>Etienne & Miguel Création</p>

    </div>

</footer>

</body>
</html>