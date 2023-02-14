<?php

require_once('config.php');

// var_dump($_SESSION);

if (isset($_POST["submit"]) && !empty($_POST["titre"]) && !empty($_POST["description"]) && !empty($_POST["debut_date"]) && !empty($_POST["debut_heure"]) && !empty($_POST["fin_date"]) && !empty($_POST["fin_heure"])) {
        $debut = $_POST["debut_date"] . " " . $_POST["debut_heure"];
        $fin = $_POST["fin_date"] . " " . $_POST["fin_heure"];
        $titre = $_POST["titre"];
        $description = $_POST["description"];
        $debut_str = strtotime($debut);
        $fin_str = strtotime($fin);
        $id_utilisateur = $_SESSION["utilisateur"]["id"];

        $requete_creneau = $database->prepare('SELECT * FROM reservations WHERE debut= ?');
        $requete_creneau->execute(array($debut));
        $requete_creneau = $requete_creneau->fetch(PDO::FETCH_ASSOC);

        $week = explode("-", $_POST["debut_date"]);
        $day = date("N", mktime(0, 0, 0, $week[1], $week[2], $week[0]));

        if (empty($requete_creneau)) {
            if ($debut_str < time())                        
            {
                $msg_error =  "Vous ne pouvez pas réserver sur un horaire passé";
            } else {
                if ($_POST["debut_date"] == $_POST["fin_date"])
                {
                    $time_debut = explode(':', $_POST["debut_heure"]);                                    
                    $time_fin = explode(':', $_POST["fin_heure"]);

                    if ($fin_str < $debut_str)                                      
                    {
                        $msg_error = "Vous devez réserver le même jour";
                    } else if ($time_fin[0] - $time_debut[0] == 1)
                    {
                        if ($day <= 5)
                        {
                            $add = $database->prepare("INSERT INTO reservations (titre, description, debut, fin, id_utilisateur) VALUES (?,?,?,?,?)");
                            $add-> bindValue(":id_utilisateur", $id_utilisateur);
                            $add->execute([$titre, $description, $debut, $fin, $id_utilisateur]);
                            header("Location: planning.php");
                        } else {
                            $msg_error = "Il est impossible de réserver les Week-End";
                        }
                    } else {
                        $msg_error = "La réservation ne peut dépasser une heure";
                    }
                } else {
                    $msg_error = "La date de début et la date de fin n'est pas la même";
                }
            }
        } else {
            $msg_error = "L'horaire sélectionné est déjà réservé";
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="ressources/favicon.png">
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

<div>
        <main>
            <h1>Formulaire de Réservation</h1>

            <h2>Utilisateur : <?php echo $_SESSION["utilisateur"]["login"] ?> </h2>

            <form action="reservation-form.php" method="POST">
                <label for="titre">Titre</label>
                <input type="text" id="titre" name="titre" required>
                <label for="description">Description</label>
                <input type="text" id="description" name="description" required>

                <label for="debut">Date de Début</label>
                <?php
                if (isset($_GET["date_debut"])) {
                    $date_debut = $_GET["date_debut"];

                    if ($date_debut == 1) {
                        $date_select = date('Y-m-d', strtotime('monday this week'));
                    }
                    if ($date_debut == 2) {
                        $date_select = date('Y-m-d', strtotime('tuesday this week'));
                    }
                    if ($date_debut == 3) {
                        $date_select = date('Y-m-d', strtotime('wednesday this week'));
                    }
                    if ($date_debut == 4) {
                        $date_select = date('Y-m-d', strtotime('thursday this week'));
                    }
                    if ($date_debut == 5) {
                        $date_select = date('Y-m-d', strtotime('friday this week'));
                    }

                ?>
                    <input type="date" id="debut" name="debut_date" min="<?php echo date('Y-m-d') ?>" value="<?php echo $date_select; ?>" required>
                <?php
                } else {
                ?>
                    <input type="date" id="debut" name="debut_date" min="<?php echo date('Y-m-d') ?>" />
                <?php
                }
                ?>

                <select id="debut" name="debut_heure" required>
                    <?php
                    if (isset($_GET["heure_debut"])) {
                        for ($heure_select = 8; $heure_select <= 18; $heure_select++) {
                            if ($heure_select < 10) {
                    ?>
                                <option value="<?php echo "0" . $heure_select . ":00"; ?>" <?php if ($heure_select == $_GET["heure_debut"]) {
                                                                                                echo "selected";
                                                                                            } ?>><?php echo "0" . $heure_select . ":00"; ?></option>
                            <?php
                            } else {
                            ?>
                                <option value="<?php echo $heure_select . ":00"; ?>" <?php if ($heure_select == $_GET["heure_debut"]) {
                                                                                            echo "selected";
                                                                                        } ?>><?php echo $heure_select . ":00"; ?></option>
                            <?php
                            }
                        }
                    } else {
                        for ($heure_select = 8; $heure_select <= 18; $heure_select++) {
                            if ($heure_select < 10) {
                            ?>
                                <option value="<?php echo "0" . $heure_select . ":00"; ?>"><?php echo "0" . $heure_select . ":00"; ?></option>
                            <?php
                            } else {
                            ?>
                                <option value="<?php echo $heure_select . ":00"; ?>"><?php echo $heure_select . ":00"; ?></option>
                    <?php
                            }
                        }
                    }
                    ?>
                </select>
                <br>

                <label>Date de Fin</label>
                <?php
                if (isset($_GET["date_debut"])) {
                ?>
                    <input type="date" id="fin" name="fin_date" min="<?php echo date('Y-m-d') ?>" value="<?php echo $date_select; ?>" required>
                <?php
                } else {
                ?>
                    <input type="date" id="fin" name="fin_date" min="<?php echo date('Y-m-d') ?>" />
                <?php
                }
                ?>

                <select id="fin" name="fin_heure" required>
                    <?php
                    if (isset($_GET["heure_debut"])) {
                        for ($heure_fin = 9; $heure_fin <= 19; $heure_fin++) {
                            if ($heure_fin < 10) {
                    ?>
                                <option value="<?php echo "0" . $heure_fin . ":00"; ?>" <?php if ($heure_fin == $_GET["heure_debut"] + 1) {
                                                                                            echo "selected";
                                                                                        } ?>><?php echo "0" . $heure_fin . ":00"; ?></option>
                            <?php
                            } else {
                            ?>
                                <option value="<?php echo $heure_fin . ":00"; ?>" <?php if ($heure_fin == $_GET["heure_debut"] + 1) {
                                                                                        echo "selected";
                                                                                    } ?>><?php echo $heure_fin . ":00"; ?></option>
                            <?php
                            }
                        }
                    } else {
                        for ($heure_fin = 9; $heure_fin <= 19; $heure_fin++) {
                            if ($heure_fin < 10) {
                            ?>
                                <option value="<?php echo "0" . $heure_fin . ":00"; ?>"><?php echo "0" . $heure_fin . ":00"; ?></option>
                            <?php
                            } else {
                            ?>
                                <option value="<?php echo $heure_fin . ":00"; ?>"><?php echo $heure_fin . ":00"; ?></option>
                    <?php
                            }
                        }
                    }
                    ?>
                </select>
                <br>
                
                <input type="submit" name="submit" class="button" value="Valider ma Réservation">

                <?php
                if (isset($msg_error)) {
                    echo "<p>" . $msg_error . "</p><br/>";
                }
                if (isset($msg_valid)) {
                    echo "<p>" . $msg_valid . "</p><br/>";
                }
                ?>
            </form>
        </main>
    </div>

</body>
</html>