<!DOCTYPE html>
<html lang="fr">
<head>
    <title> My Questions </title>
    <meta charset="utf-8">
    <link href="my.css" rel="stylesheet">
    <link href="forms.css" rel="stylesheet">
    <link href="PrettyQuestion.css" rel="stylesheet">
</head>
<h1> <center> AskAround </center> </h1>
<body>
    <header>
    <?php
        include 'Menu.php';
    ?>
    <center> <h1> My Questions </h1> </center>
</header>
<?php
    //session_start();
    if(isset($_SESSION["Pseudo"])) {
        include 'ConnexionSQL.php';
        $Pseudo = $_SESSION["Pseudo"];
        $conn = connect();
        $SQLArticles = "SELECT * FROM `Questions` where `Auteur` = '$Pseudo' ";
        $result = $conn->query($SQLArticles);
        if ($result->num_rows >0){
            while ($row = $result -> fetch_assoc()){
                $Id = $row["ID"];
                $Pseudo = $row["Auteur"];
                $Question = $row["Question"];
                $Texte = $row["Texte"];
                $Date = $row["Date"];
                $url = "UneQuestion.php?Id=" . $Id;
                ?>
                <div id="Article">                
                    <a href = <?php echo $url?> id="Title">  <?php echo $Question ?> </a>
                    <p class="Auteur"> Author: <?php echo $Pseudo ?> Date: <?php echo $Date ?> </p>
                    <p> <?php echo $Texte ?> </p>
                </div>
            <?php
            }
        }
    }   
    ?>
</body>