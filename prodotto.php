<?php

use DB\DBAccess;
require_once "connection.php";
$connection = new DBAccess();

$HTMLpage = file_get_contents("product.html");
$title = "";
$breadcrumb = "";
$error = "";
$mainReplace = "";
$id = "-1"; // id non valido

if(isset($_GET["id"])) {
    $id = $_GET["id"];
}

$loginBtns = '<li><a href="./login.php"><span lang="en">Login</span></a></li><li><a href="./registrati.php">Registrati</a></li>';

if (isset($_SESSION['session_id'])) {
    $loggedInBtns = '<li><a href="./preferiti.php"><img src="./images/favourites.svg" height="44" width="44" alt="preferiti"/></a></li><li><a href="./utente.php"><img src="./images/account.svg" height="44" width="44" alt="area personale"/></a></li>';
    $HTMLpage = str_replace($loginBtns, $loggedInBtns, $HTMLpage);
}

$connOk = $connection->openConnection();

if(isset($_POST["formDelete"])) { // ENTRA QUI SE L'ADMIN CANCELLA UNA CHITARRA
    if($connOK) {
        $connection->deleteGuitar($id);
        $connection->closeConnection();
        header('Location: prodotti.php');
        exit;
    } else {
        $error = "<p>Impossibile cancellare la chitarra a causa di un errore durante la connessione con il database.</p>";
    }
}

if(isset($_POST["formDelFav"])) { // ENTRA QUI SE LO USER TOGLIE DAI PREFERITI
    if($connOK) {
        $connection->removeFromFavourites($_SESSION['session_email'], $id);
    } else {
        $error = "<p>Impossibile togliere la chitarra dai preferiti a causa di un errore durante la connessione con il database.</p>";
    }
}

if(isset($_POST["formAddFav"])) { // ENTRA QUI SE LO USER AGGIUNGE AI PREFERITI
    if($connOK) {
        $connection->addToFavourites($_SESSION['session_email'], $id);
    } else {
        $error = "<p>Impossibile aggiungere la chitarra ai preferiti a causa di un errore durante la connessione con il database.</p>";
    }
}

if($connOk) { // CONNESSIONE AL DB OK
    $info = $connection->getGuitar($id);
    if($info != null) { // QUERY OK
        $title = $info['Alt'];
        $breadcrumb = $info['Model'];
        $mainReplace = '<main id="product"><error />
                            <ul>
                                <li id="img">
                                    <img src="./images/' . $info['ID'] . '.webp" alt="' . $info['Alt'] . '" height="510" width="340"/>
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
                                <li id="buy">';
                                
        if(isset($_SESSION['session_id'])) { // UTENTE AUTENTICATO
            if($_SESSION['session_role'] == 'admin') { // UTENTE ADMIN
                $mainReplace .= '<form method="post" action="prodotto.php?id=\'' . $id . '\'">
                                    <input type="submit" id="buttonDelete" name="formDelete" value="Elimina chitarra" />
                                </form>';
            } else { // UTENTE NON ADMIN
                if($connection->checkFavourite($_SESSION['session_email'], $id)) { // CHITARRA TRA I PREFERITI
                    $mainReplace .= '<form method="post" action="prodotto.php?id=\'' . $id . '\'">
                                        <input type="submit" id="buttonDelete" name="formDelFav" value="Togli dai preferiti" />
                                    </form>';
                } else { // CHITARRA NON TRA I PREFERITI
                    $mainReplace .= '<form method="post" action="prodotto.php?id=\'' . $id . '\'">
                                        <input type="submit" id="button" name="formAddFav" value="Aggiungi ai preferiti" />
                                    </form>';
                }
            }
        } else { // UTENTE NON AUTENTICATO
            $mainReplace .= '<a id="button" href="login.php">Effettua il login</a>';
        }
        $connection->closeConnection(); // chiudo qui la connessione con il DB perchè ora sono sicuro che non mi serve più
        $mainReplace .=         '</li>
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
    } else { // QUERY NON OK
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
} else { // NESSUNA CONNESSIONE AL DB
    $title = "Errore - Sistemi non disponibili";
    $breadcrumb = "Errore";
    $mainReplace = "<main id='productError'>
                        <h2>Stiamo accordando le nostre chitarre...</h2>
                        <p>I nostri sistemi al momento non sono disponibili a causa di un errore interno. Riprova più tardi.</p>
                    </main>";
}

$HTMLpage = str_replace("<titleReplace />", $title, $HTMLpage);
$HTMLpage = str_replace("<breadcrumbReplace />", $breadcrumb, $HTMLpage);
$HTMLpage = str_replace("<error />", $error, $HTMLpage);
$HTMLpage = str_replace("<mainReplace />", $mainReplace, $HTMLpage);

echo $HTMLpage;
?>