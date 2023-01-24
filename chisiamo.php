<?php
    $htmlPage = file_get_contents("./html/chisiamo.html");

    session_start();

    if (isset($_SESSION['session_id'])) {
        $htmlPage = str_replace("<login />", '<li><a href="./preferiti.php"><img src="./images/favourites.svg" height="44" width="44" alt="preferiti"/></a></li><li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt="area personale"/></a></li>', $htmlPage);
    } else {
        $htmlPage = str_replace("<login />", '<li><a href="./login.php"><span lang="en">Login</span></a></li><li><a href="./registrati.php">Registrati</a></li>', $htmlPage);
    }

    echo $htmlPage;
?>