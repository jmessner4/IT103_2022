<!DOCTYPE html>
<html lang="fr">
 <head>
    <meta charset="utf-8">
    <title>See you soon</title>
    <link href="my.css" rel="stylesheet">
    <link href="PrettyQuestion.css" rel="stylesheet">
</head>
<h1> <center> AskAround </center> </h1>
 <body>
    <header>
        <?php
            include 'Menu.php';
        ?>
        <center>
            <h1>Bye and See ya !</h1>
        </center>
    </header>
    <?php
        session_destroy();
    ?>
</body>