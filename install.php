<?php
    function connect() {
        $servername = "localhost";
        $username =  "root";
        $password = "";
        $dbname = "DBNAME";
 
        // On crée notre connexion
        $conn = new mysqli($servername, $username, $password, $dbname);
        // On vérifie si elle a bien fonctionnée
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

$conn = connect();

//Création des tables
$SQL_Create_Commentaires = "CREATE TABLE `Commentaires` (`ID` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, `Question_ID` INT(11) NULL, `Pseudo` VARCHAR(45) NULL, `Date` DATE NULL, `Reponse` TEXT NULL)";
$SQL_Create_LikeDislike = "CREATE TABLE `LikeDislike` (`ID2` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, `NbLike` INT(11) NULL, `NbDislike` INT(11) NULL, `IDCom` INT(11) NULL) ";
$SQL_Create_LikeDislikePseudo = "CREATE TABLE `LikeDislikePseudo` (`ID1` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, `IdLike` INT(11) NULL, `Type` INT(11) NULL, `Pseudo` VARCHAR(45) NULL, `IdQuestion` INT(11) NULL)";
$SQL_Create_Questions = "CREATE TABLE `Questions` (`ID` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, `Question` TEXT NULL, `Texte` TEXT NULL, `Auteur` VARCHAR(45) NULL, `Date` DATE NULL)";
$SQL_Create_Users = "CREATE TABLE `User` (`ID` INT PRIMARY KEY NOT NULL, `Pseudo` VARCHAR(45) NULL, `MDP` VARCHAR(45) NULL, `Email` VARCHAR(320) NULL, `Points` INT(11) NULL)";

$result_Commentaires = $conn->query($SQL_Create_Commentaires);
$result_LikeDislike = $conn->query($SQL_Create_LikeDislike);
$result_LikeDislikePseudo = $conn->query($SQL_Create_LikeDislikePseudo);
$result_Questions = $conn->query($SQL_Create_Questions);
$result_Users = $conn->query($SQL_Create_Users);

//Création des utilisateurs
$SQL_Create_Bob = "INSERT INTO `User` (`Pseudo`, `MDP`, `Email`) VALUES ('Bob', 'Bob', 'bob@gmail.com')";
$SQL_Create_Max = "INSERT INTO `User` (`Pseudo`, `MDP`, `Email`) VALUES ('Max','Max', 'max@gmail.com')";

$result_Bob = $conn->query($SQL_Create_Bob);
$result_Max = $conn->query($SQL_Create_Max);

$row=fetch_assoc($result_Bob);
$row=fetch_assoc($result_Max);

//Création de la question
$Date = Date('y-m-d');
$SQL_Create_Question = "INSERT INTO `Questions` (`Question`,`Texte`, `Auteur`,`Date`) VALUES ('Hello ?', 'Hello ?', 'Max', '$Date')";
$result_Question = $conn->query($SQL_Create_Question);
$SQL_select_Question = "SELECT * FROM `Questions` WHERE `Auteur`='Max'";
$result_Questions_2 = $conn->query($SQL_select_Question);
$row1=fetch_assoc($result_Question_2);
$IDq = $row1['ID'];

//Création de la réponse

$SQL_Create_Reponse = "INSERT INTO `Commentaires` (`Question_ID`,`Pseudo`, `Date`, `Reponse`) VALUES ('$IDq', 'Bob', '$Date', 'Hello !')";
$result_Reponse = $conn->query($SQL_Create_Reponse);
$SQL_Select_Reponse = "SELECT * FROM `Commentaires` WHERE `Question_ID`='$IDq'";
$result_Reponse_2 = $conn->query($SQL_Select_Reponse);
$row2 = fetch_assoc($result_reponse_2);
$IDc = $row2['ID'];

//Ajout d'un pouce

$SQL_Create_Vote = "INSERT INTO `LikeDislike` (`NbLike`,`NbDislike`, `IDCom`) VALUES ('1','0','$IDc')";
$result_Vote = $conn->query($SQL_Create_Vote);
$SQL_Select_Vote = "SELECT * FROM `LikeDislike` WHERE `IDCom`='$IDc'";
$result_Vote_2 = $conn->query($SQL_Select_Vote);
$row3 = fetch_assoc($result_Vote_2);
$IDLike = $row3['ID'];

//Ajout à la table LikeDislilePseudo

$SQL_Create_LDPseudo = "INSERT INTO `LikeDislikePseudo` (`IdLike`, `Type`, `Pseudo`, `IdQuestion`) VALUES ('$IDLike', '1', 'Max', '$IDq')";
$result_LDPseudo = $conn->query($SQL_Create_LDPseudo);
?> 
