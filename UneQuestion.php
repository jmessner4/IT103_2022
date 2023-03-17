<head>
    <title> Question </title>
    <meta charset="utf-8">
    <link href="my.css" rel="stylesheet">
    <link href="PrettyQuestion.css" rel="stylesheet">
    <link href="forms.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<h1> <center> AskAround </center> </h1>

<body>
    <header>
        <?php
            include 'Menu.php';
            include 'ConnexionSQL.php';
            $conn = connect();
            $Id = $_GET["Id"];
            $sqlarticle = "SELECT * FROM `Questions` WHERE `ID`='$Id'";
            $result = $conn->query($sqlarticle);
            $row=$result->fetch_assoc();
            $Pseudo = $row["Auteur"];
            $Titre = $row["Question"];
            $Article = $row["Texte"];
            $Date = $row["Date"];
            ?>
            <div id="Article">
                <h3 id="TitreArt"> <?php echo $Titre ?> </h3>
                    <p class="auteur"> Author: <?php echo $Pseudo ?> Date: <?php echo $Date ?> </p>
                    <p> <?php echo $Article ?> </p>
                <?php
                if(isset($_SESSION["Pseudo"])) {
                    if($_SESSION["Pseudo"] === $Pseudo) {
                        $url = "ModifArt.php?Id=";
                        ?>
                        <div class="Modif1">
                            <a href = <?php echo $url . $Id; ?> class="Modif1"> Modify <a>
                        </div>
                        <?php
                    }
                } 
                ?>
            </div>
            <h1> Reply </h1>
            <div id="popup">
            <?php
            if(isset($_SESSION["message"])){
                ?>
                <p> 
                <script>// <![CDATA[
                    alert ("Too bad, you can't like yourself");
                // ]]></script>
                <?php
                unset($_SESSION["message"]);
            }
            ?>
            </div>
            <?php
            if(isset($_SESSION["Pseudo"])) {
                ?>
                <form action="<?php $_PHP_SELF; ?>" method="post" id="usrform">
                <br>
                <textarea rows="4" cols="40" name="Commentaire" form="usrform"> Enter your commentary here...</textarea>
                <br>
                <input type="submit" name="submit" value="Reply">
                </form>

                <?php
                    if(isset($_POST["submit"])) {
                        $conn = connect();
                        $Commentaire = htmlspecialchars($_POST["Commentaire"], ENT_QUOTES);
                        $Datecom = date('y-m-d');
                        $Pseudo = $_SESSION["Pseudo"];
                        $sql = "INSERT INTO `Commentaires` (`Question_ID`,`Pseudo`,`Date`,`Reponse`) VALUES ('$Id','$Pseudo','$Datecom','$Commentaire')";
                        $result = $conn->query($sql);// On lance la requête
                        $sql2 ="SELECT * FROM `Commentaires` WHERE `Question_ID`='$Id' AND `Reponse`='$Commentaire'";
                        $result2 = $conn->query($sql2);
                        $row = $result2->fetch_assoc();
                        $IDCom = $row["ID"];
                        if ($result === TRUE) {
                            echo "Registered successfully";
                            $SQL_Creation_LD = "INSERT INTO `LikeDislike` (`NbLike`,`NbDislike`,`IDCom`) VALUES ('0','0','$IDCom')";
                            $resultCom = $conn->query($SQL_Creation_LD);

                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
            }
            $sqlaffcom = "SELECT * FROM `Commentaires` JOIN `LikeDislike` ON Commentaires.ID = LikeDislike.IDCom WHERE `Question_ID`='$Id' ORDER BY `NbLike` DESC";
            $result = $conn->query($sqlaffcom);
            if($result->num_rows>0) {
                while($row = $result->fetch_assoc()) {
                    $Pseudo = $row["Pseudo"];
                    $Affcom = $row["Reponse"];
                    $Dateaffcom = $row["Date"];
                    $Id_com = $row["ID"];
                    $PseudoUtil = $_SESSION["Pseudo"];
                    $sql = "SELECT * FROM `LikeDislike` JOIN `Commentaires` ON LikeDislike.IDCom = Commentaires.ID WHERE (LikeDislike.IDCom='$Id_com')";
                    $result2 = $conn->query($sql);
                    $row2 = $result2->fetch_assoc();
                    $nblike = $row2["NbLike"];
                    $nbdis = $row2["NbDislike"];
                    $idlike = $row2["ID2"];
                    $Pseudouser = $_SESSION["Pseudo"];
                    $sql2 = "SELECT * FROM `LikeDislikePseudo` WHERE `Pseudo`='$Pseudouser' AND `IdLike`='$idlike'";
                    $result2 = $conn->query($sql2);
                    ?>
                    <div id="Reply">
                        <p class="auteur"> Author: <?php echo $Pseudo ?> Date: <?php echo $Dateaffcom ?> </p>
                        <p> <?php echo $Affcom ?> </p>
                        <p> Like : <?php echo $nblike ?>    Dislike : <? echo $nbdis ?> </p>
                        <?php
                            if ($result2->num_rows>0){
                                $row2 = $result2->fetch_assoc();
                                $Type = $row2["Type"];
                                if($Type == 1) {
                                    ?>
                                     <a href= <?php echo "LikeDislike.php?type=1&Idq=" . $Id . "&Idc=" . $Id_com ?> class="photo"> <i class="bi bi-hand-thumbs-down" style="font-size: 2rem; color: cornflowerblue;"></i> </a>
                                     <a href= <?php echo "LikeDislike.php?type=1&Idq=" . $Id . "&Idc=" . $Id_com ?> class="photo"> <i class="bi bi-hand-thumbs-up-fill"  style="font-size: 2rem; color: cornflowerblue;"></i> </a>
                                    <?php
                                } else if ($Type == 2) {
                                    ?>
                                     <a href= <?php echo "LikeDislike.php?type=1&Idq=" . $Id . "&Idc=" . $Id_com ?> class="photo"> <i class="bi bi-hand-thumbs-down-fill" style="font-size: 2rem; color: cornflowerblue;"></i> </a>
                                     <a href= <?php echo "LikeDislike.php?type=1&Idq=" . $Id . "&Idc=" . $Id_com ?> class="photo"> <i class="bi bi-hand-thumbs-up"  style="font-size: 2rem; color: cornflowerblue;"></i> </a>
                                    <?php
                                }
                            } else {
                                ?>
                                <a href= <?php echo "LikeDislike.php?type=2&Idq=" . $Id . "&Idc=" . $Id_com ?> class="photo"> <i class="bi bi-hand-thumbs-down"  style="font-size: 2rem; color: cornflowerblue;"></i> </a>
                                <a href= <?php  echo "LikeDislike.php?type=1&Idq=" . $Id . "&Idc=" . $Id_com ?> class="photo"> <i class="bi bi-hand-thumbs-up"  style="font-size: 2rem; color: cornflowerblue;"></i> </a>
                                <?php  
                            }  
                        if(isset($_SESSION["Pseudo"])) {
                            if($_SESSION["Pseudo"] === $Pseudo) {
                                $url = "ModifierCom.php?Id1=";
                                ?>
                                <a href = <?php echo $url . $Id . "&Id2=" . $Id_com; ?> class="Modif1"> Modify <a>
                                <?php
                            }
                        }
                    ?>
                    </div>
                <?php
                }
            }

        ?>
    </header>
</body>