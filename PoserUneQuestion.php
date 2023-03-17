<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Ask a question</Title>
        <meta charset="utf-8">
        <link href="my.css" rel="stylesheet">
        <link href="forms.css" rel="stylesheet">
    </head>
    <h1> <center> AskAround </center> </h1>
    <body>
        <header>
            <?php
                include 'Menu.php';
            ?>
            <center>
                <h1>Ask something to the community</h1>
            </center>
        </header>
</body>
<div id="container">
    <form action="<?php $_PHP_SELF; ?>" method="post" id="QuestionForm">
        <input type="text" name="Question">
        <br>
        <textarea rows="4" cols="100" name="Texte" form="QuestionForm"> Entrer votre texte ici </textarea>
        <br>
        <input type="submit" name="Envoie">
    </form>
</div>

<?php
    if(isset($_POST["Envoie"])) {
        include "ConnexionSQL.php";
        $conn = connect();
        $Pseudo = $_SESSION["Pseudo"];
        $Question = $_POST["Question"];
        $Texte = htmlspecialchars($_POST["Texte"]);
        $Date = Date('y-m-d');
        $SQL = "INSERT INTO `Questions` (`Question`, `Texte`, `Auteur`, `Date`) VALUES ('$Question','$Texte', '$Pseudo', '$Date')";
        $result = $conn->query($SQL);
        if ($result === True) {
            echo "Question send";
        } else {
            echo "Error in the publication";
        }
    }
?>