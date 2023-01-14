<?php

use DB\DBAccess;
require_once "connection.php";
$connection = new DBAccess();

$HTMLpage = file_get_contents("product.html");
$title = "";
$breadcrumb = "";
$mainReplace = "";
$id = "0"; // se lasciamo vuoto mysql ovviamente si arrabbia

if(isset($_GET["id"])) {
    $id = $_GET["id"];
}

$connOk = $connection->openConnection();

if($connOk) {
    $info = $connection->getGuitar($id);
    $connection->closeConnection();
    
    if($info != null) {
        $title = $info['Alt'];
        $breadcrumb = $info['Model'];
        $mainReplace = '<main id="product">
                            <ul>
                                <li id="img">
                                    <img src=".' . $info['Image'] . '" alt="' . $info['Alt'] . '" height="510" width="340"/>
                                </li>
                                <li id="title">
                                    <h2>' . $info['Brand'] . '</h2>
                                    <h3>' . $info['Model'] . '</h3>
                                </li>
                                <li id="price">
                                    <p>' . $info['Price'] . '</p>
                                </li>
                                <li id="description">
                                    <p>' . $info['Description'] . '</p>
                                </li>
                                <li id="buy">
                                    <form>
                                        <input id="button" type="submit" value="Aggiungi ai Preferiti"/>
                                    </form>
                                </li>
                            </ul>
                            <h2>Caratteristiche del prodotto</h2>
                            <dl id="specs">
                                <dt class="spec1">Marchio:</dt>
                                <dd class="spec1">' . $info['Brand'] . '</dd>
                                <dt class="spec2">Colore:</dt>
                                <dd class="spec2">' . $info['Color'] . '</dd>
                                <dt class="spec1">Tipologia:</dt>
                                <dd class="spec1">' . $info['Type'] . '</dd>
                                <dt class="spec2">Numero di corde:</dt>
                                <dd class="spec2">' . $info['Strings'] . '</dd>
                                <dt class="spec1">Numero di tasti:</dt>
                                <dd class="spec1">' . $info['Frets'] . '</dd>
                                <dt class="spec2">Legno del corpo:</dt>
                                <dd class="spec2">' . $info['Body'] . '</dd>
                                <dt class="spec1">Legno della tastiera:</dt>
                                <dd class="spec1">' . $info['Fretboard'] . '</dd>';

        if(($info['Pickup_Configuration'] != "-") && ($info['Pickup_Type'] != "-")) { //le classiche e le acustiche non mostrano le info dei pickup perchè non li hanno
            $mainReplace .=     '<dt class="spec2">Configurazione Pickup:</dt>
                                <dd class="spec2">' . $info['Pickup_Configuration'] . '</dd>
                                <dt class="spec1">Tipologia Pickup:</dt>
                                <dd class="spec1">' . $info['Pickup_Type'] . '</dd>';
                                
        }
        $mainReplace .= '</dl></main>';
    } else {
        $title = "Errore - Chitarra non Trovata";
        $breadcrumb = "Errore";
        $mainReplace = "<main id='productError'>
                            <h2>Stiamo accordando le nostre chitarre...</h2>
                            <p>La chitarra non è stata trovata. Questo può essere perchè:</p>
                            <ul>
                                <li>la chitarra al momento non è disponibile;</li>
                                <li>la chitarra non esiste (link invalido);</li>
                            </ul>
                            <p>Assicurarsi di usare i link all'interno del nostro sito per essere sicuri di visualizzare le chitarre disponibili. Se l'errore persiste contattare l'amministratore.</p>
                        </main>";
    }
} else {
    $title = "Errore - Sistemi non disponibili";
    $breadcrumb = "Errore";
    $mainReplace = "<main id='productError'>
                        <h2>Stiamo accordando le nostre chitarre...</h2>
                        <p>I nostri sistemi al momento non sono disponibili a causa di un errore interno. Riprova più tardi.</p>
                    </main>";
}

$HTMLpage = str_replace("<titleReplace />", $title, $HTMLpage);
$HTMLpage = str_replace("<breadcrumbReplace />", $breadcrumb, $HTMLpage);
$HTMLpage = str_replace("<mainReplace />", $mainReplace, $HTMLpage);

echo $HTMLpage;
?>