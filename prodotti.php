<?php
use DB\DBAccess;
require_once "./connection.php";

$HTMLpage = file_get_contents("./html/products.html");
$connection = new DBAccess();

session_start();

$guitars = '';
$listText = '';
$guitarList = '';

$newGuitarLink = '<a id="addNewGuitar" href="./aggiungi-prodotto.php">Aggiungi chitarra</a>'; // link pagina nuova chitarra
if (isset($_SESSION['session_id'])) {
    
    if ($_SESSION['session_role'] == 'admin') {
        $HTMLpage = str_replace('<login />', '<li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt="account"/></a></li>', $HTMLpage);
        $HTMLpage = str_replace("<loginM />", '<li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt=""/><p lang="en">Account</p></a></li>', $HTMLpage);
        $HTMLpage = str_replace('<linkNuovaChitarra />', $newGuitarLink, $HTMLpage);
    }
    else {
        $HTMLpage = str_replace('<login />', '<li><a href="./preferiti.php"><img src="./images/favourites.svg" height="44" width="44" alt="preferiti"/></a></li><li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt="account"/></a></li>', $HTMLpage);
        $HTMLpage = str_replace("<loginM />", '<li><a href="./preferiti.php"><img src="./images/favourites.svg" height="44" width="44" alt=""/><p>Preferiti</p></a></li><li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt=""/><p lang="en">Account</p></a></li>', $HTMLpage);
        $HTMLpage = str_replace('<linkNuovaChitarra />', '', $HTMLpage);
    }
}
else {
    $HTMLpage = str_replace('<login />', '<li><a href="./login.php"><span lang="en">Login</span></a></li><li><a href="./registrati.php">Registrati</a></li>', $HTMLpage);
    $HTMLpage = str_replace("<loginM />", '<li><a href="./login.php"><img src="./images/login.svg" height="44" width="44" alt=""/><p lang="en">Login</p></a></li><li><a href="./registrati.php"><img src="./images/register.svg" height="44" width="44" alt=""/><p>Registrati</p></a></li>', $HTMLpage);
    $HTMLpage = str_replace('<linkNuovaChitarra />', '', $HTMLpage);
}

$connOk = $connection->openConnection();

if ($connOk) {
    $guitars = $connection->getGuitars();
    $connection->closeConnection();

    if ($guitars != null) {
        $listText .= '<ul class="prodotti">';
        foreach ($guitars as $guitar) {
            $guitarList .= strip_tags($guitar['Brand']) . ', ' . strip_tags($guitar['Model']) . ', ';
            $listText .= '<li>' .
                '<img src="./images/' . $guitar['ID'] . '.webp" height="300" width="200" alt="' . $guitar['Alt'] . '" />' .
                '<h3>' . $guitar['Brand'] . '</h3>' .
                '<p>' . $guitar['Model'] . '</p>' .
                '<p>' . $guitar['Price'] . '</p>' .
                '<a href="./prodotto.php?id=' . $guitar['ID'] . '">Vedi</a>' .
                '</li>';
        }
        $listText .= '</ul>';
        $guitarList = implode(', ',array_unique(explode(', ', $guitarList)));
    }
    else {
        $listText = "<p class='info'>Nessuna chitarra presente.</p>";
    }
}
else {
    $listText = "<p class='info'>I nostri sistemi sono momentaneamente non disponibili, ci scusiamo per il disagio.</p>";
}

$HTMLpage = str_replace("<keywords />", $guitarList, $HTMLpage);
echo str_replace("<listaProdotti />", $listText, $HTMLpage);

?>