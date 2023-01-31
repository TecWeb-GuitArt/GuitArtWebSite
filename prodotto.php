<?php

use DB\DBAccess;
require_once "./connection.php";
$connection = new DBAccess();

$HTMLpage = file_get_contents("./html/product.html");

session_start();
$title = "";
$keywords = "";
$description = "";
$breadcrumb = "";
$error = "";
$mainReplace = "";
$id = "-1"; // id non valido

if(isset($_GET["id"])) {
    $id = $_GET["id"];
}


if (isset($_SESSION['session_id']) && $_SESSION['session_role'] == 'guest') {
    $HTMLpage = str_replace("<login />", '<li><a href="./preferiti.php"><img src="./images/favourites.svg" height="44" width="44" alt="preferiti"/></a></li><li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt="account"/></a></li>', $HTMLpage);
    $HTMLpage = str_replace("<loginM />", '<li><a href="./preferiti.php"><img src="./images/favourites.svg" height="44" width="44" alt=""/><p>Preferiti</p></a></li><li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt=""/><p lang="en">Account</p></a></li>', $HTMLpage);
} else if(isset($_SESSION['session_id']) && $_SESSION['session_role'] == 'admin') {    
    $HTMLpage = str_replace("<login />", '<li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt="account"/></a></li>', $HTMLpage);
    $HTMLpage = str_replace("<loginM />", '<li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt=""/><p lang="en">Account</p></a></li>', $HTMLpage);
} else{
    $HTMLpage = str_replace("<login />", '<li><a href="./login.php"><span lang="en">Login</span></a></li><li><a href="./registrati.php">Registrati</a></li>', $HTMLpage);
    $HTMLpage = str_replace("<loginM />", '<li><a href="./login.php"><img src="./images/login.svg" height="44" width="44" alt=""/><p lang="en">Login</p></a></li><li><a href="./registrati.php"><img src="./images/register.svg" height="44" width="44" alt=""/><p>Registrati</p></a></li>', $HTMLpage);
}

$connOk = $connection->openConnection();

if(isset($_POST["formDelete"])) { // ENTRA QUI SE L'ADMIN CANCELLA UNA CHITARRA
    if($connOk) {
        $connection->deleteGuitar($id);
        $connection->closeConnection();
        header('Location: prodotti.php');
        exit;
    } else {
        $error = "<p>Impossibile cancellare la chitarra a causa di un errore durante la connessione con il database.</p>";
    }
}

if(isset($_POST["formDelFav"])) { // ENTRA QUI SE LO USER TOGLIE DAI PREFERITI
    if($connOk) {
        $connection->removeFromFavourites($_SESSION['session_user'], $id);
    } else {
        $error = "<p>Impossibile togliere la chitarra dai preferiti a causa di un errore durante la connessione con il database.</p>";
    }
}

if(isset($_POST["formAddFav"])) { // ENTRA QUI SE LO USER AGGIUNGE AI PREFERITI
    if($connOk) {
        $connection->addToFavourites($_SESSION['session_user'], $id);
    } else {
        $error = "<p>Impossibile aggiungere la chitarra ai preferiti a causa di un errore durante la connessione con il database.</p>";
    }
}

if($connOk) { // CONNESSIONE AL DB OK
    $info = $connection->getGuitar($id);
    if($info != null) { // QUERY OK
        $title = $info['Alt'];
        $keywords = strip_tags($info['Brand']) . ', ' . strip_tags($info['Model']);
        $breadcrumb = $info['Model'];
        $description = $info['Description'];
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
                $mainReplace .= '<form method="post" action="./prodotto.php?id=' . $id . '">
                                    <input type="submit" id="buttonDelete" name="formDelete" value="Elimina chitarra" />
                                </form>';
            } else { // UTENTE NON ADMIN
                if($connection->checkFavourite($_SESSION['session_user'], $id)) { // CHITARRA TRA I PREFERITI
                    $mainReplace .= '<form method="post" action="./prodotto.php?id=' . $id . '">
                                        <input type="submit" id="buttonDelete" name="formDelFav" value="Togli dai preferiti" />
                                    </form>';
                } else { // CHITARRA NON TRA I PREFERITI
                    $mainReplace .= '<form method="post" action="./prodotto.php?id=' . $id . '">
                                        <input type="submit" id="button" name="formAddFav" value="Aggiungi ai preferiti" />
                                    </form>';
                }
            }
        } else { // UTENTE NON AUTENTICATO
            $mainReplace .= '<a id="link" href="./login.php">Effettua il login per salvare il prodotto tra i preferiti</a>';
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
$HTMLpage = str_replace("<keywords />", $keywords, $HTMLpage);
$HTMLpage = str_replace("<description />", substr(strip_tags($description), 0, 140) . "...", $HTMLpage);
$HTMLpage = str_replace("<breadcrumbReplace />", $breadcrumb, $HTMLpage);
$HTMLpage = str_replace("<mainReplace />", $mainReplace, $HTMLpage);
$HTMLpage = str_replace("<error />", $error, $HTMLpage);

echo $HTMLpage;
?>