<head>
    <title> Questions </title>
    <meta charset="utf-8">
    <link href="my.css" rel="stylesheet">
    <link href="forms.css" rel="stylesheet">
    <link href="PrettyQuestion.css" rel="stylesheet">
</head>
<h1> <center> AskAround </center> </h1>
<body>
    <header>
        <?php
            include 'Menu.php';
            include 'ConnexionSQL.php';
            $conn = connect();
            if (isset($_SESSION["Pseudo"])) {
                $SQL_Question = "SELECT * FROM `Questions` ORDER BY `ID` DESC";
                $result = $conn->query($SQL_Question);
                if ($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $Pseudo = $row["Auteur"];
                        $Question = $row["Question"];
                        $Texte = $row["Texte"];
                        $Date = $row["Date"];
                        $Id = $row["ID"];
                        $url = "UneQuestion.php?Id="
                        ?>
                        <div id="Article">
                            <a href = <?php echo $url . $Id ?> id="Title"> <?php echo $Question ?> </a>
                                <p class="Auteur">Author: <?php echo $Pseudo ?> Date: <?php echo $Date ?> </p>
                                <p> <?php echo $Texte ?> </p>
                        </div>
                        <?php
                    }
                }
            } else {
                ?>
                <h1 id="message">An account is required in order to view, post and answer questions on this blog</h1>
                <?php
            }
                ?>
    </header>
</body>
            