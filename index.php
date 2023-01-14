<?php
$HTMLpage = file_get_contents("index.html");
$loginBtns = '<li><a href="./login.php">Login</a></li><li><a href="./registrati.php">Registrati</a></li>';

if (isset($_SESSION['session_id'])) {
    $userPage = '<li><a href="./utente.php">' . $_SESSION['session_username'] . '</a></li>';
    $HTMLpage = str_replace($loginBtns, $userPage, $HTMLpage);
}
echo $HTMLpage;
?>