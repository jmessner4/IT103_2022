<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Modify</title>
    <meta charset="utf-8">
    <link href="my.css" rel="stylesheet">
    <link href="forms.css" rel="stylesheet">
</head>
<h1> <center> AskAround </center> </h1>
<body>
    <header>
        <?php
            include 'Menu.php';
            include 'ConnexionSQL.php';
            $conn = connect();
            $Id = $_GET["Id"];
            $sqlarticle = "SELECT * FROM `Questions` WHERE `ID`= '$Id'";
            $result = $conn->query($sqlarticle);
            $row = $result->fetch_assoc();
            $Titre = $row["Question"];
            $TexteQ = $row["Texte"];
        ?>
        <div id="container">
            <form action="<?php $_PHP_SELF; ?>" method="post" id="QuestionForm">
                <textarea rows="1" cols="100" name="Question" form="QuestionForm"> <?php echo $Titre; ?> </textarea>
                <br>
                <textarea rows="4" cols="100" name="Texte" form="QuestionForm"> <?php echo $TexteQ;?> </textarea>
                <br>
                <input type="submit" name="submit" value="Modify">
            </form>
        </div>
        <?php
            if(isset($_POST["submit"])) {
                $newq = $_POST["Question"];
                $newt = $_POST["Texte"];
                echo $newq;
                $sqlupdate = "UPDATE `Questions` SET `Question`='$newq' WHERE `ID`='$Id'";
                $result2 = $conn->query($sqlupdate);
                $sqlupdate2 = "UPDATE `Questions` SET `Texte`='$newt' WHERE `ID`='$Id'";
                $result3 = $conn->query($sqlupdate2);
                if($result2 === TRUE) {
                    $url = "UneQuestion.php?Id=" . $Id;
                    header("Location:$url");
                    exit();
                } else {
                    echo "Article non modifié";
                }
            }
        ?>