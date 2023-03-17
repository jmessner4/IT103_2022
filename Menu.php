<!DOCTYPE html>
<html lang="fr">

<body>
    <header>
        <?php
            session_start();
            if (isset($_SESSION["Pseudo"])) {
                ?>
                <h4> <?php echo "Bonjour " . $_SESSION["Pseudo"]; ?> <h4>
                <?php
            }
        ?>
        <ul id="menu">     
            <li><a href="AskAround.php"> Home </a></li>
            <li><a href="Questions.php"> Questions </a></li>
            <?php
                if (!isset($_SESSION["Pseudo"])) {
                    ?>
                <li style="float:right" class="dropdown">
                    <a href="#" class="dropbtn">Log In</a>
                    <div class="dropdown-content">
                        <a href="Connexion.php"> Log In </a>
                        <a href="Inscription.php">Sign up</a>
                    </div>
                </li>
            <?php
                }
                    if (isset($_SESSION["Pseudo"])) {
                        ?>
                        <li style="float:right" class="dropdown">
                        <a href="#" class="dropbtn">Log In</a>
                        <div class="dropdown-content">
                            <a href="MyAccount.php">My Account</a>
                            <a href="PoserUneQuestion.php">Ask it !</a>                    
                            <a href="MesQuestions.php">My Questions</a>
                            <a href="Deconnexion.php">Log out</a>
                    <?php
                    }
                ?>
        </ul>
    </header>
</body>
</html>