<?php
use DB\DBAccess;

require_once "./connection.php"; 
$htmlPage = file_get_contents("./html/favourites.html");
$connessione = new DBAccess();

$favourites = '';
$listText = '';
$loginBtns = '<li><a href="./login.php"><span lang="en">Login</span></a></li><li><a href="./registrati.php">Registrati</a></li>';


if (isset($_SESSION['session_id'])) {
    $loggedInBtns = '<li><a href="./preferiti.php"><img src="./images/favourites.svg" height="44" width="44" alt="preferiti"/></a></li><li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt="area personale"/></a></li>';
    $htmlPage = str_replace($loginBtns, $loggedInBtns, $HTMLpage);
} else {
    header('Location: login.php');
    exit;
}

$connOk = $connessione->openConnection();
if($connOk) {
    $favourites = $connection->getFavourites($_SESSION['user']);
    $connection->closeConnection();

    if($favourites != null) {
        $listText .= '<ul class="preferiti">';
        foreach ($favourites as $favourite) {
            $listText .= '<li>' .
            '<img src="./images/' . $favourite['ID'] . '.webp" height="300" width="200" alt="' . $favourite['Alt'] . '" />' . 
            '<h3>' . $favourite['Brand'] . '</h3>' .
            '<p>' . $favourite['Model'] . '</p>' .
            '<p>' . $favourite['Price'] . '</p>' .
            '<a href="./prodotto.php?id=' . $favourite['ID'] . '">Vedi</a>' . 
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

echo str_replace("<listaPreferiti />", $listText, $HTMLpage);


echo $htmlPage;
?>