<!DOCTYPE html>
<html lagn= "fr">
<head>
    <title> Log in </title>
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
            <h1>Log in !</h1>
        </center>
    </header>
</body>


<div id="container">
    <form action="<?php $_PHP_SELF; ?>" method="post">
    <h2>Your informations</h2>
    <label for="Entrée">Email or Login</label>
    <input type="text" name="Entrée">

    <label for="MDP">Password</label>
    <input type= "password" name="MDP">

    <input type="submit" name="submit" value='LOGIN'>
    </form>
</div>


<center>
    <p>Don't have an account ? <a href="Inscription.php"> Sign up </a> </p>

<?php
    if(isset($_POST["submit"])){ //On effectue le script si l'utilisateur a entré ses identifiants.
        include "ConnexionSQL.php"; //Include du fichier de connexion à phpMyAdmin
        $conn = connect(); //Connexion à la base de donnée
        $Entrée = $_POST["Entrée"];
        $MDP = $_POST["MDP"]; 
        $sqlpseudo = "SELECT * FROM `User` WHERE (`Email`='$Entrée') OR (`Pseudo`='$Entrée')";
        $result = $conn->query($sqlpseudo);
        $row = $result->fetch_assoc();
        if($row["Email"]) {
            $sqlmdp = "SELECT * FROM `User` WHERE (`Email`='$Entrée') OR (`Pseudo`='$Entrée') AND `MDP`='$MDP'";
            $res2 = $conn->query($sqlmdp);
            $row2 = $res2->fetch_assoc();
            if($row2["MDP"]) {
                echo "Loged in succesfully ! </br>";
                session_start();
                $Pseudo = $row2["Pseudo"];
                $_SESSION["Pseudo"] = $Pseudo;
                $url = "./AskAround.php";
                header("Location:$url");
                exit();
            } else {
                echo "Wrong password, please try again </br>";
            }
        } else {
            echo "Unknown email or alias... </br>";
        }
    }
?>
</html>