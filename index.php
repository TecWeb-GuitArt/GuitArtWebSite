<?php
$HTMLpage = file_get_contents("index.html");
$loginBtns = '<li><a href="./login.php"><span lang="en">Login</span></a></li><li><a href="./registrati.php">Registrati</a></li>';

if (isset($_SESSION['session_id'])) {
    $loggedInBtns = '<li><a href="./preferiti.php"><img src="./images/favourites.svg" height="44" width="44" alt="preferiti"/></a></li><li><a href="./utente.php"><img src="./images/account.svg" height="44" width="44" alt="account"/></a></li>';
    $HTMLpage = str_replace($loginBtns, $loggedInBtns, $HTMLpage);
}
echo $HTMLpage;
?>