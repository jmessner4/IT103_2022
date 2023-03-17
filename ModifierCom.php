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
            ?>
            </header>
            <?php
            include 'ConnexionSQL.php';
            $conn = connect();
            $Idq = $_GET["Id1"];
            $Idcom = $_GET["Id2"];
            $sqlarticle = "SELECT * FROM `Commentaires` WHERE `Id`= '$Idcom'";
            $result = $conn->query($sqlarticle);
            $row = $result->fetch_assoc();
            $Comm = $row["Reponse"];
        ?>
        <div id="container">
            <form action="<?php $_PHP_SELF; ?>" method="post" id="QuestionForm">
                <textarea rows="4" cols="100" name="Texte" form="QuestionForm"> <?php echo $Comm;?> </textarea>
                <br>
                <input type="submit" name="submit" value="Modify">
            </form>
        </div>

        <?php
            if(isset($_POST["submit"])) {
                $newcom = $_POST["Texte"];
                $sqlupdate = "UPDATE `Commentaires` SET `Reponse`='$newcom' WHERE `ID`='$Idcom'";
                $result = $conn->query($sqlupdate);
                if($result === TRUE) {
                    $url = "UneQuestion.php?Id=" . $Idq;
                    header("Location:$url");
                    exit();
                } else {
                    echo "Commentaire non modifié";
                }
            }
        ?>
</body>
