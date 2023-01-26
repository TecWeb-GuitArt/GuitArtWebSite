<?php
use DB\DBAccess;

require_once "./connection.php"; 
$HTMLpage = file_get_contents("./html/favourites.html");
$connection = new DBAccess();

session_start();

$favourites = '';
$listText = '';
if (!isset($_SESSION['session_id'])) {
    header('Location: index.php');
    exit;
} else {
    if($_SESSION['session_role'] == "admin") {
        header('Location: index.php');
        exit;
    }
}

$connOk = $connection->openConnection();
if($connOk) {
    $favourites = $connection->getFavourites($_SESSION['session_user']);
    $connection->closeConnection();

    if($favourites != null) {
        $listText .= '<ul class="prodotti">';
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
        $listText = "<p class='info'>Lista preferiti vuota</p>";
    }

    //clicca pulsante

} else {
    $listText = "<p class='info'>I nostri sistemi sono momentaneamente non disponibili, ci scusiamo per il disagio.</p>";
}

$HTMLpage = str_replace("<listaPreferiti />", $listText, $HTMLpage);


echo $HTMLpage;
?>