<?php

require_once('config.php');

// var_dump($_SESSION);

$requete_resa = $database->prepare("SELECT * FROM utilisateurs INNER JOIN reservations ON utilisateurs.id = reservations.id_utilisateur WHERE week(debut) = week(curdate())");
$requete_resa->execute();
$info_resa = $requete_resa->fetchALL(PDO::FETCH_ASSOC);

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
        <p id="btn1"><a href="reservation-form.php">Formulaire de Réservation</a></p>
        <p id="btn2"><a href="profil.php">Modifier Profil</a></p>
        <p id="btn3"><a href="logout.php">Déconnexion</a></p>
    </div>
</div>

</header>

<main>

<div>

    <h1>Planning <?php echo $day_week = date('Y', time()); ?></h1>
    <h2>Semaine <?php echo $day_week = date('W', time()); ?></h2>
            
        <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Lundi <?php echo $day_week = date('d/m', strtotime('monday this week')); ?></th>
                        <th>Mardi <?php echo $day_week = date('d/m', strtotime('tuesday this week')); ?></th>
                        <th>Mercredi <?php echo $day_week = date('d/m', strtotime('wednesday this week')); ?></th>
                        <th>Jeudi <?php echo $day_week = date('d/m', strtotime('thursday this week')); ?></th>
                        <th>Vendredi <?php echo $day_week = date('d/m', strtotime('friday this week')); ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    for ($heure = 8; $heure <= 19; $heure++)
                    {
                        ?>
                        <tr>
                            <td>
                                <p><?php echo $heure . "h"; ?></p>
                            </td>
                            <?php
                            for ($day = 1; $day <= 5; $day++)
                        {

                                if (!empty($info_resa)) {
                                    foreach ($info_resa as $resa => $Hresa)
                                    {
                                        $JH = explode(" ", $Hresa["debut"]);

                                        $H = explode(":", $JH[1]);
                                        $heure_resa = date("G", mktime($H[0], $H[1], $H[2], 0, 0, 0));

                                        $J = explode("-", $JH[0]);
                                        $day_resa = date("N", mktime(0, 0, 0, $J[1], $J[2], $J[0]));

                                        $case_resa = $heure_resa . $day_resa;
                                        $case = $heure . $day;


                                        $titre = $Hresa["titre"];
                                        $login = $Hresa["login"];
                                        $desc = $Hresa["description"];
                                        $id = $Hresa["id"];

                                        if ($case == $case_resa) { ?>
                                            <td>
                                                <a href="reservation.php?evenement=<?php echo $id; ?>">
                                                    <?php echo $login; ?><br>
                                                    <?php echo $titre; ?><br>
                                                    <?php echo "Voir la Réservation"; ?>
                                                </a>
                                            </td>
                                        <?php
                                            break;
                                        } else
                                        {
                                            $case = null;
                                        }
                                    }
                                    if ($case == null) {
                                        ?>
                                        <td><a href="reservation-form.php?heure_debut=<?php echo $heure; ?>&amp;date_debut=<?php echo $day; ?>">Réserver l'horaire</a></td>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <td><a href="reservation-form.php?heure_debut=<?php echo $heure; ?>&amp;date_debut=<?php echo $day; ?>">Réserver l'horaire</a></td>
                                <?php
                                }
                            } ?>
                                </tr>
                                <?php
                    }
                    ?>
                </tbody>
            </table>

    </div>

</main>

</body>
</html>