<?php

require_once('config.php');

$error = "";
$error2 ="";

if(isset($_POST['submit'])) {

    if(!empty($_POST['login']) && !empty($_POST['mdp']) && !empty($_POST['mdpconf'])) {

        if($_POST['mdp'] == $_POST['mdpconf']) {

            $login = htmlspecialchars($_POST['login']);
            $mdp = $_POST['mdp'];

            $request = $database->prepare('INSERT INTO utilisateurs (login, password) VALUES (?,?)');

            if($request->execute(array($login, $mdp))) {

                header('Location: connexion.php');
            }
        }
        else {
            $error2 = "Veuillez rentrer des informations correctes";
        }
    }
    else {
        $error = "Veuillez remplir tous les champs";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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
        <p><a a class="header-btn-solo-last" href="connexion.php">Se connecter &#x2611</a></p>
    </div>
</div>

</header>

<main>

<h1>Formulaire d'inscription</h1>

<form class="form" method="post" action="">
    <input type="text" name="login" placeholder="Login" autocomplete="off">
    <input type="password" name="mdp" placeholder="Mot de passe" autocomplete="off">
    <input type="password" name="mdpconf" placeholder="Confirmation mot de passe" autocomplete="off">
    <input class="submit_btn" type="submit" name="submit" value="Validation">
</form>

<div class="error">
<?php echo $error; ?>
</div>
<div class="error2">
<?php echo $error2; ?>
</div>

</main>

<footer>

    <div class="footer-names">

        <p>Etienne & Miguel Création</p>

    </div>

</footer>

</body>
</html>