<!DOCTYPE html>
<html lang="fr">
 <head>
    <title>My Account</title>
    <meta charset="utf-8">
    <link href = "my.css" rel="stylesheet">
    <link href="forms.css" rel="stylesheet">
    <link href="account.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
 </head>
 <h1> <center> AskAround </center> </h1>
<?php
    include 'Menu.php';
    include 'ConnexionSQL.php';
    $conn = connect();
    $Pseudo = $_SESSION["Pseudo"];
    $sql = "SELECT * FROM `User` WHERE `Pseudo`='$Pseudo'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $Email = $row["Email"];
    $Points = 0;
?>
<div class="box">
    <h2> Your Profil </h2>
        <h3> Your email : <?php echo $Email ?> </h3>
        <h3> Your Pseudo : <?php echo $Pseudo ?> </h3>
</div>
<div class="box">
    <h2> Your points & Rewards </h2>
        <?php
            $sql2 = "SELECT * FROM `Commentaires` WHERE `Pseudo`='$Pseudo'";
            $result2 = $conn->query($sql2);
            while($row2=$result2->fetch_assoc()) {
                $idcom = $row2["ID"];
                $sql3 = "SELECT * FROM `LikeDislike` WHERE `IDCom`='$idcom'";
                $result3 = $conn->query($sql3);
                $row3 = $result3->fetch_assoc();
                $like = $row3["NbLike"]*10;
                $dislike = $row3["NbDislike"]*10;
                $Points = $Points + $like - $dislike;
            }
            $sql4 = "UPDATE `User` SET `Points` = '$Points' WHERE `Pseudo`='$Pseudo'";
            $result4 = $conn->query($sql4);
            ?>
        <h3> Your Points : <?php echo $Points ?> </h3>
        <?php
            if($Points>=100) {
                ?>
                <span title="Congrats ! It's your first reward">
                    <i class="bi bi-balloon-fill" style="font-size: 2rem; color: lightslategray;"></i>
            </span>
                <?php
            } else {
                ?>
                <span title="You need 100 points in order to have this reward">
                    <i class="bi bi-balloon" style="font-size: 2rem; color: lightslategray;"></i>
                </span>
                <?php
            }
            if($Points>=500) {
                ?>
                <span title="Congrats ! It's your second reward">
                    <i class="bi bi-binoculars-fill" style="font-size: 2rem; color: lightslategray;"></i>
                </span>
                <?php
            } else {
                ?>
                <span title="You need 500 points in order to have this reward">
                    <i class="bi bi-binoculars" style="font-size: 2rem; color: lightslategray;"></i>
                </span>
                <?php
            }
            if($Points>=1000) {
                ?>
                <span title="Congrats ! It's your third reward">
                    <i class="bi bi-chat-square-heart-fill" style="font-size: 2rem; color: lightslategray;"></i>
                </span>
                <?php
            } else {
                ?>
                <span title="You need 1000 points in order to have this reward">
                    <i class="bi bi-chat-square-heart" style="font-size: 2rem; color: lightslategray;"></i>
                </span>
                <?php
            }
            if($Points>=10000) {
                ?>
                <span title="Congrats ! You have all the rewards, you're a real BO$$">
                    <i class="bi bi-trophy-fill" style="font-size: 2rem; color: lightslategray;"></i>
                <?php
            } else {
                ?>
                <span title="You need 10000 points in order to have this reward">
                    <i class="bi bi-trophy" style="font-size: 2rem; color: lightslategray;"></i>
                </span>
                <?php
            }
            ?>
</div>