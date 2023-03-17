<!DOCTYPE html>
<html lang="fr">
    <head>
        <title> AskAround </title>
        <meta charset="utf-8">
        <link href="my.css" rel="stylesheet">
        <link href="forms.css" rel="stylesheet">
        <link href="PrettyQuestion.css" rel="stylesheet">
    </head>
    <h1> <center> AskAround </center> </h1>

<?php
    include "Menu.php";
    include "ConnexionSQL.php";
    if (isset($_SESSION["Pseudo"])) {
        $conn = connect();
        $sql = "SELECT * FROM `Questions` WHERE NOT EXISTS (SELECT * FROM `Commentaires` WHERE Questions.ID=Commentaires.Question_ID)"; //On met les 3 dernières questions sur la page d'accueil
        $result = $conn->query($sql);
        ?>
        <div class="global">
            <div class="left">
                <div class="boxg">
                    <h1> Waiting for an answer </h1>
                    <?php
                    if($result->num_rows>0) {
                        while($row = $result->fetch_assoc()) {
                            $Pseudo = $row["Auteur"];
                            $Titre = $row["Question"];
                            $Texte = $row["Texte"];
                            $Date = $row["Date"];
                            $Id = $row["ID"];
                            $url = "UneQuestion.php?Id=";
                        ?>
                        <a href= <?php echo $url . $Id ;?> id="Title"> <?php echo $Titre; ?> </a>
                        <p class="auteur"> Author: <?php echo $Pseudo; ?> Date: <?php echo $Date; ?> </p>
                        <p> <?php echo substr($Texte,0,20) . "..."; ?> </p>
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="right">
                <div class="cote">
                    <h2>You can see all your questions in "My Questions"</h2>
                </div>
                <div class="cote">
                    <h2>If you give the finest answer, you will be rewarded.</h2>
                    <p>You can follow your score and track your reward in "My Account"<p>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <h1 id="message">An account is required in order to view, post and answer questions on this blog</h1>
        <?php
    }
?>

