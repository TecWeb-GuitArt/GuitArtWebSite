<?php
use DB\DBAccess;

session_start();
require_once "connessione.php"; 
$htmlPage = file_get_contents("favourites.html");
$connessione = new DBAccess();

$favourites = '';
$listText = '';
$loginBtns = '<li><a href="./login.php">Login</a></li><li><a href="./registrati.php">Registrati</a></li>';


if (isset($_SESSION['session_id'])) {
    //$userPage = '<li><a href="./utente.php">' . $_SESSION['session_username'] . '</a></li>';
    //$htmlPage = str_replace($loginBtns, $userPage, $HTMLpage);

} else {
    header('Location: login.php');
    exit;
}

$connOk = $connessione->openConnection();
if($connOk) {
    $favourites = $connection->getFavourites($_SESSION['email']);
    $connection->closeConnection();

    if($favourites != null) {
        $listText .= '<ul class="prodotti">';
        foreach ($favourites as $favourite) {
            $listText .= '<li>' .
            '<img src=". ' . $favourite['Image'] . '" height="300" width="200" alt="' . $favourite['Alt'] . '" />' . // manca alt
            '<h3>' . $favourite['Brand'] . '</h3>' .
            '<p>' . $favourite['Model'] . '</p>' .
            '<p>' . $favourite['Price'] . '</p>' .
            '<a href="./product.php?id=' . $favourite['ID'] . '">Vedi</a>' . //link
            '</li>';
        }
        $listText .= '</ul>'; 
    } else {
        $listText = "<p>Lista preferiti vuota</p>";
    }

    //clicca pulsante

} else {
    $listText = "<p>I nostri sistemi sono momentaneamente non disponibili, ci scusiamo per il disagio.</p>";
}

echo str_replace("<listaProdotti />", $listText, $HTMLpage);


echo $htmlPage;
?>