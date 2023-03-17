<?php
include "ConnexionSQL.php";
include "Menu.php";
$Type = $_GET["type"];
$Idq = $_GET["Idq"];
$Idc = $_GET["Idc"];
$Pseudo = $_SESSION["Pseudo"];
$conn = connect();

$SQL_Pseudo = "SELECT * FROM `LikeDislikePseudo` RIGHT JOIN `LikeDislike` ON LikeDislikePseudo.IdLike = LikeDislike.ID2 WHERE (`Pseudo`= '$Pseudo') AND (`IdQuestion`='$Idq')";
$ResultName = $conn->query($SQL_Pseudo);


$sqlverif = "SELECT * FROM `Commentaires` WHERE `ID` = '$Idc'";
$result3 = $conn->query($sqlverif);
$row2 = $result3->fetch_assoc();
if($row2["Pseudo"] === $Pseudo) {            /* On vérifie qu'il n'intérragisse pas avec son propre commentaire */
    
    $_SESSION["message"] = "Too bad, you can't like yourself";
    $url = "UneQuestion.php?Id=" . $Idq;
    header("Location:$url");

} else {
    if ($ResultName->num_rows > 0){             /* On vérifie si le user a déjà like ou dislike des commentaires sous cette question */
        if ($ResultName->num_rows == 1) {
            $row = $ResultName->fetch_assoc();
            $Idlike = $row["IdLike"];           /* Ici on récupère l'IdLike de l'élément liké ou disliké dans la table */
            $Liketype = $row["Type"];           /* on récupère le type d'interraction */


            $sqlverif = "SELECT * FROM `Commentaires` WHERE `ID` = '$Idc'";
            $result3 = $conn->query($sqlverif);
            $row2 = $result3->fetch_assoc();


            $sqlverif2 = "SELECT * FROM `LikeDislike` WHERE `IDCom`='$Idc'";
            $result4 = $conn->query($sqlverif2);
            $row3 = $result4->fetch_assoc();
            $likeidact = $row3["ID2"];                   /* On récupère l'IdLike du commentaire que l'utilisateur souhaite like ou dislike lors de cette action */

            if($Type == 1){                             /* Cas d'un like */
                if ($Liketype == 1) {    /* on vérifie si il veut liker un autre commentaire */
                    if($Idlike != $likeidact) {             /* on change d'avis de like */
                        $SQL_Like = "SELECT * FROM `LikeDislike` WHERE `ID2`='$Idlike'";
                        $result = $conn->query($SQL_Like);
                        $row = $result->fetch_assoc();
                        $nb_like = $row["NbLike"]-1;
                        $SQL_upd = "UPDATE `LikeDislike` SET `NbLike`='$nb_like' WHERE `ID2`='$Idlike'";
                        $result2 = $conn->query($SQL_upd);

                        $SQL_Like2 = "SELECT * FROM `LikeDislike` WHERE `ID2`='$likeidact'";
                        $result7 = $conn->query($SQL_Like2);
                        $row4 = $result7->fetch_assoc();
                        $nb_like = $row4["NbLike"]+1;
                        $IdLikesql = $row4["ID2"];
                        $SQL_upd = "UPDATE `LikeDislike` SET `NbLike`='$nb_like' WHERE `ID2`='$IdLikesql'";
                        $result2 = $conn->query($SQL_upd);
                        $SQL_upd2 = "UPDATE `LikeDislikePseudo` SET `Idlike`='$IdLikesql' WHERE `IdQuestion`='$Idq'";
                        $result6 = $conn->query($SQL_upd2);
                    } else {                                            /* on retire notre like sans like autre chose */
                        $SQL_Like = "SELECT * FROM `LikeDislike` WHERE `IDCom`='$Idc'";
                        $result = $conn->query($SQL_Like);
                        $row = $result->fetch_assoc();
                        $nb_like = $row["NbLike"]-1;
                        $IdLike = $row["ID2"];
                        $SQL_upd = "UPDATE `LikeDislike` SET `NbLike`='$nb_like' WHERE `IDCom`='$Idc'";
                        $result2 = $conn->query($SQL_upd);
                        if($nb_like == 0) {
                            $SQL_Retire = "DELETE FROM `LikeDislikePseudo` WHERE `IdLike`='$IdLike'";
                            $result5 = $conn->query($SQL_Retire);
                        }
                    }
                } else {            /* on like alors qu'on avait déjà un dislike dans la table */
                    $SQL_Like = "SELECT * FROM `LikeDislike` WHERE `IDCom`='$Idc'";
                    $result = $conn->query($SQL_Like);
                    $row = $result->fetch_assoc();
                    $nb_like = $row["NbLike"]+1;
                    $IdLike = $row["ID2"];
                    $SQL_upd = "UPDATE `LikeDislike` SET `NbLike`='$nb_like' WHERE `ID2`='$IdLike'";
                    $result2 = $conn->query($SQL_upd);
                    $SQL_Ajout = "INSERT INTO `LikeDislikePseudo` (`IdLike`,`Type`,`Pseudo`,`IdQuestion`) VALUES ('$IdLike','$Type','$Pseudo','$Idq')";
                    $result_Ajout = $conn->query($SQL_Ajout);      
                }
                
            }
            
            if($Type == 2){                     /* Cas d'un dislike */
                if($Liketype == 2) {      /* on vérifie qu'on a déjà dislike un commentaire */
                    if (($Idlike != $likeidact)){            /* on change d'avis de dislike*/
                        $SQL_Like = "SELECT * FROM `LikeDislike` WHERE `ID2`='$Idlike'";
                        $result = $conn->query($SQL_Like);
                        $row = $result->fetch_assoc();
                        $nb_like = $row["NbDislike"]-1;
                        $SQL_upd = "UPDATE `LikeDislike` SET `NbDislike`='$nb_like' WHERE `ID2`='$Idlike'";
                        $result2 = $conn->query($SQL_upd);

                        $SQL_Like = "SELECT * FROM `LikeDislike` WHERE `ID2`='$likeidact'";
                        $result = $conn->query($SQL_Like);
                        $row = $result->fetch_assoc();
                        $nb_like = $row["NbDislike"]+1;
                        $IdLikesql = $row["ID2"];
                        $SQL_upd = "UPDATE `LikeDislike` SET `NbDislike`='$nb_like' WHERE `ID2`='$IdLikesql'";
                        $result2 = $conn->query($SQL_upd);
                        $SQL_upd2 = "UPDATE `LikeDislikePseudo` SET `Idlike`='$IdLikesql' WHERE `IdQuestion`='$Idq'";
                        $result6 = $conn->query($SQL_upd2);
                    } else {                                /* on dislike le même com donc on retire notre dislike */
                        $SQL_Dislike = "SELECT * FROM `LikeDislike` WHERE `IDCom`='$Idc'";
                        $result8 = $conn->query($SQL_Dislike);
                        $row8 = $result8->fetch_assoc();
                        $IdLike = $row8["ID2"];
                        $nb_dislike = $row["NbDislike"]-1;
                        $SQL_upd = "UPDATE `LikeDislike` SET `NbDislike` = '$nb_dislike' WHERE `IDCom`='$Idc'";
                        $result2 = $conn->query($SQL_upd);
                        if($nb_dislike == 0) {
                            $SQL_Retire = "DELETE FROM `LikeDislikePseudo` WHERE `IdLike`='$IdLike'";
                            $result5 = $conn->query($SQL_Retire);
                        }
                    }
                } else {                                        /* on dislike alors qu'on avait déjà un like dans la table */
                    $SQL_Dislike = "SELECT * FROM `LikeDislike` WHERE `IDCom`='$Idc'";
                    $result11 = $conn->query($SQL_Dislike);
                    $row11 = $result11->fetch_assoc();
                    $IdLike = $row11["ID2"];
                    $nb_dislike = $row11["NbDislike"]+1;
                    $SQL_upd = "UPDATE `LikeDislike` SET `NbDislike` = '$nb_dislike' WHERE `IDCom`='$Idc'";
                    $result12 = $conn->query($SQL_upd);
                    $SQL_Ajout = "INSERT INTO `LikeDislikePseudo` (`IdLike`,`Type`,`Pseudo`,`IdQuestion`) VALUES ('$IdLike','$Type','$Pseudo','$Idq')";
                    $result_Ajout = $conn->query($SQL_Ajout);       
                    }
            }

        } else {            /* déjà un like et un dislike dans cette question */
            while($row = $ResultName->fetch_assoc()){
                $Idlike = $row["IdLike"];           /* Ici on récupère l'IdLike de l'élément liké ou disliké dans la table */
                $Liketype = $row["Type"];           /* on récupère le type d'interraction */
                $Idpseudolike = $row["ID1"];

                $sqlverif = "SELECT * FROM `Commentaires` WHERE `ID` = '$Idc'";
                $result3 = $conn->query($sqlverif);
                $row2 = $result3->fetch_assoc();


                $sqlverif2 = "SELECT * FROM `LikeDislike` WHERE `IDCom`='$Idc'";
                $result4 = $conn->query($sqlverif2);
                $row3 = $result4->fetch_assoc();
                $likeidact = $row3["ID2"];                   /* On récupère l'IdLike du commentaire que l'utilisateur souhaite like ou dislike lors de cette action */

                if($Type == 1){                             /* Cas d'un like */
                    if ($Liketype == 1) {    /* on vérifie si il veut liker un autre commentaire */
                        if($Idlike != $likeidact) {             /* on change d'avis de like */
                            $SQL_Like = "SELECT * FROM `LikeDislike` WHERE `ID2`='$Idlike'";
                            $result = $conn->query($SQL_Like);
                            $row = $result->fetch_assoc();
                            $nb_like = $row["NbLike"]-1;
                            $SQL_upd = "UPDATE `LikeDislike` SET `NbLike`='$nb_like' WHERE `ID2`='$Idlike'";
                            $result2 = $conn->query($SQL_upd);

                            $SQL_Like2 = "SELECT * FROM `LikeDislike` WHERE `ID2`='$likeidact'";
                            $result7 = $conn->query($SQL_Like2);
                            $row4 = $result7->fetch_assoc();
                            $nb_like = $row4["NbLike"]+1;
                            $IdLikesql = $row4["ID2"];
                            $SQL_upd = "UPDATE `LikeDislike` SET `NbLike`='$nb_like' WHERE `ID2`='$IdLikesql'";
                            $result2 = $conn->query($SQL_upd);

                            $SQL_upd2 = "UPDATE `LikeDislikePseudo` SET `Idlike`='$IdLikesql' WHERE `ID1`='$Idpseudolike'";
                            $result6 = $conn->query($SQL_upd2);

                        } else {                                            /* on retire notre like sans like autre chose */
                            $SQL_Like = "SELECT * FROM `LikeDislike` WHERE `IDCom`='$Idc'";
                            $result9 = $conn->query($SQL_Like);
                            $row9 = $result9->fetch_assoc();
                            $nb_like = $row9["NbLike"]-1;
                            $IdLike = $row9["ID2"];
                            $SQL_upd = "UPDATE `LikeDislike` SET `NbLike`='$nb_like' WHERE `IDCom`='$Idc'";
                            $result2 = $conn->query($SQL_upd);
                            if($nb_like == 0) {
                                $SQL_Retire = "DELETE FROM `LikeDislikePseudo` WHERE `IdLike`='$IdLike'";
                                $result5 = $conn->query($SQL_Retire);
                            }
                        }
                    }
                    
                }
                
                if($Type == 2){                     /* Cas d'un dislike */
                    if($Liketype == 2) {      /* on vérifie qu'on a déjà dislike un commentaire */
                        if (($Idlike != $likeidact)){            /* on change d'avis de dislike*/
                            $SQL_Like = "SELECT * FROM `LikeDislike` WHERE `ID2`='$Idlike'";
                            $result = $conn->query($SQL_Like);
                            $row = $result->fetch_assoc();
                            $nb_like = $row["NbDislike"]-1;
                            $SQL_upd = "UPDATE `LikeDislike` SET `NbDislike`='$nb_like' WHERE `ID2`='$Idlike'";
                            $result2 = $conn->query($SQL_upd);
    
                            $SQL_Like = "SELECT * FROM `LikeDislike` WHERE `ID2`='$likeidact'";
                            $result = $conn->query($SQL_Like);
                            $row = $result->fetch_assoc();
                            $nb_like = $row["NbDislike"]+1;
                            $IdLikesql = $row["ID2"];
                            $SQL_upd = "UPDATE `LikeDislike` SET `NbDislike`='$nb_like' WHERE `ID2`='$IdLikesql'";
                            $result2 = $conn->query($SQL_upd);

                            $SQL_upd2 = "UPDATE `LikeDislikePseudo` SET `Idlike`='$IdLikesql' WHERE `ID1`='$Idpseudolike'";
                            $result6 = $conn->query($SQL_upd2);

                        } else {                                /* on dislike le même com donc on retire notre dislike */
                            $SQL_Dislike = "SELECT * FROM `LikeDislike` WHERE `IDCom`='$Idc'";
                            $result8 = $conn->query($SQL_Dislike);
                            $row8 = $result8->fetch_assoc();
                            $IdLike = $row8["ID2"];
                            $nb_dislike = $row["NbDislike"]-1;
                            $SQL_upd = "UPDATE `LikeDislike` SET `NbDislike` = '$nb_dislike' WHERE `IDCom`='$Idc'";
                            $result2 = $conn->query($SQL_upd);
                            if($nb_dislike == 0) {
                                $SQL_Retire = "DELETE FROM `LikeDislikePseudo` WHERE `IdLike`='$IdLike'";
                                $result5 = $conn->query($SQL_Retire);
                            }
                        }
                    }
                }
            }
        }

    } else {
        if($Type == 1){
            $SQL_Like = "SELECT * FROM `LikeDislike` WHERE `IDCom`='$Idc'";
            $result = $conn->query($SQL_Like);
            $row = $result->fetch_assoc();
            $nb_like = $row["NbLike"]+1;
            $IdLike = $row["ID2"];
            $SQL_upd = "UPDATE `LikeDislike` SET `NbLike`='$nb_like' WHERE `ID2`='$IdLike'";
            $result2 = $conn->query($SQL_upd);
            $SQL_Ajout = "INSERT INTO `LikeDislikePseudo` (`IdLike`,`Type`,`Pseudo`,`IdQuestion`) VALUES ('$IdLike','$Type','$Pseudo','$Idq')";
            $result_Ajout = $conn->query($SQL_Ajout);   
        }    
        if($Type == 2){
            $SQL_Dislike = "SELECT * FROM `LikeDislike` WHERE `IDCom`='$Idc'";
            $result = $conn->query($SQL_Dislike);
            $row = $result->fetch_assoc();
            $IdLike = $row["ID2"];
            $nb_dislike = $row["NbDislike"]+1;
            $SQL_upd = "UPDATE `LikeDislike` SET `NbDislike` = '$nb_dislike' WHERE `IDCom`='$Idc'";
            $result2 = $conn->query($SQL_upd);
            $SQL_Ajout = "INSERT INTO `LikeDislikePseudo` (`IdLike`,`Type`,`Pseudo`,`IdQuestion`) VALUES ('$IdLike','$Type','$Pseudo','$Idq')";
            $result_Ajout = $conn->query($SQL_Ajout);        
        }
    }
    $url = "UneQuestion.php?Id=" . $Idq;
    header("Location:$url");
}

?>