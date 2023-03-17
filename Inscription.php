<!DOCTYPE html>
<html lang="fr">
 <head>
    <title>Sign up</title>
    <meta charset="utf-8">
    <link href = "my.css" rel="stylesheet">
    <link href="forms.css" rel="stylesheet">
 </head>
 <h1> <center> AskAround </center> </h1>
 <body>
    <header>
        <?php
            include 'Menu.php';
        ?>
        <center>
            <h1>Sign up !</h1>
        </center>
    </header>
</body>

<div id="container">
  <form action="<?php $_PHP_SELF; ?>" method="post">
    <legend>Your informations :</legend>
      <label for="Email">Email</label>
      <input type="text" name="Email">

      <label for="Pseudo">Login</label>
      <input type="text" name="Pseudo">

      <label for="MDP">Password</label>
      <input type="password" name="MDP">
      
      <input type="submit" name="submit" value='SIGN UP'>
  </form>
</div>


<?php
    if(isset($_POST["submit"])){
        include "ConnexionSQL.php";
        $conn = connect(); // On se connecte à la base de données
        $Email = $_POST["Email"];
        $MDP = $_POST["MDP"];
        $Pseudo = $_POST["Pseudo"];
        $Points = 0;
        if(filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $sqlverif = "SELECT * FROM `User` WHERE `Email`='$Email'";
            $result = $conn->query($sqlverif);
            $row = $result->fetch_assoc();
            if ($row["Email"]){
                echo "This email is already associated with an account !";
            } elseif ($row["Pseudo"]) {
                echo "Please choose a other alias !";
            } else {
                $sql = "INSERT INTO `User` (`Pseudo`,`MDP`,`Email`,`Points`) VALUES ('$Pseudo','$MDP','$Email','$Points')";
                $result = $conn->query($sql);// On lance la requête
                echo "coucou";
                if ($result === TRUE) {
                    echo "Registered successfully";
                    session_start();
                    $_SESSION["Pseudo"] = $Pseudo;
                    $url = "./AskAround.php";
                    header("Location:$url");
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        } else {
            echo "Email's format uncorrect </br>";
        }
    }
?>
</html>