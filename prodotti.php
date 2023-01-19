<?php
use DB\DBAccess;
require_once "connection.php";

$HTMLpage = file_get_contents("products.html");
$connection = new DBAccess();

$loginBtns = '<li><a href="./login.php"><span lang="en">Login</span></a></li><li><a href="./registrati.php">Registrati</a></li>';

$guitars = '';
$listText = '';

$newGuitarLink = '<a id="addNewGuitar" href="">Aggiungi chitarra</a>'; // link pagina nuova chitarra
if (isset($_SESSION['session_id'])) {
    $loggedInBtns = '<li><a href="./preferiti.php"><img src="./images/favourites.svg" height="44" width="44" alt="preferiti"/></a></li><li><a href="./utente.php"><img src="./images/account.svg" height="44" width="44" alt="area personale"/></a></li>';
    $HTMLpage = str_replace($loginBtns, $loggedInBtns, $HTMLpage);
    if ($_SESSION['role'] == 'admin') {
        $HTMLpage = str_replace('<linkNuovaChitarra />', $newGuitarLink, $HTMLpage);
    }
    else {
        $HTMLpage = str_replace('<linkNuovaChitarra />', '', $HTMLpage);
    }
}

$connOk = $connection->openConnection();

if ($connOk) {
    $guitars = $connection->getGuitars();
    $connection->closeConnection();

    if ($guitars != null) {
        $listText .= '<ul class="prodotti">';
        foreach ($guitars as $guitar) {
            $listText .= '<li>' .
                '<img src=". ' . $guitar['Image'] . '" height="300" width="200" alt="' . $guitar['Alt'] . '" />' . // manca alt
                '<h3>' . $guitar['Brand'] . '</h3>' .
                '<p>' . $guitar['Model'] . '</p>' .
                '<p>' . $guitar['Price'] . '</p>' .
                '<a href="./product.php?id=' . $guitar['ID'] . '">Vedi</a>' . // manca il link alla pagina specifica
                '</li>';
        }
        $listText .= '</ul>';
    }
    else {
        $listText = "<p>Nessuna chitarra presente.</p>";
    }
}
else {
    $listText = "<p>I nostri sistemi sono momentaneamente non disponibili, ci scusiamo per il disagio.</p>";
}

echo str_replace("<listaProdotti />", $listText, $HTMLpage);

?>