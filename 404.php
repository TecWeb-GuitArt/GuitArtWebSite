<?php
$htmlPage = file_get_contents("404.html");

if (isset($_SESSION['session_id'])) {
    $loggedInBtns = '<li><a href="./preferiti.php"><img src="./images/favourites.svg" height="44" width="44" alt="preferiti"/></a></li><li><a href="./utente.php"><img src="./images/account.svg" height="44" width="44" alt="area personale"/></a></li>';
    $htmlPage = str_replace($loginBtns, $loggedInBtns, $HTMLpage);
} 

echo $htmlPage;

?>