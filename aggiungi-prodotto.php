<?php

use DB\DBAccess;
require_once "./connection.php";
$connection = new DBAccess();

$HTMLpage = file_get_contents("./html/addproduct.html");

session_start();

$messaggi = "";
$model = "";
$brand = "";
$color = "";
$price = "0";
$type = "";
$strings = "0";
$frets = "0";
$body = "";
$fretboard = "";
$pickupConf = "";
$pickupType = "";
$description = "";

function cleanInput($value) {
    $value = trim($value);
    $value = strip_tags($value, '<span>');
    return $value;
}

function checkAllowNumbers($value) {
    return preg_match("/^[a-zA-Z0-9\-\ ]+$/", $value);
}

function checkProhibitNumbers($value) {
    return preg_match("/^[a-zA-Z\-\ ]+$/", $value);
}

if (!isset($_SESSION['session_id'])) {
    header('Location: index.php');
    exit;
} else {
    if($_SESSION['session_role'] != "admin") {
        header('Location: index.php');
        exit;
    }
}

if(isset($_POST['formSubmit'])) { // BOTTONE formSubmit PREMUTO
    $brand = cleanInput($_POST['formBrand']);
    if(strlen($brand) == 0) {
        $messaggi .= "<li>Marchio non può essere vuoto!</li>";
    } else {
        $brandNoTags = strip_tags($brand);
        if(!checkAllowNumbers($brandNoTags)) {
            $messaggi .= "<li>Il marchio può contenere solo lettere, numeri, spazi e trattini!</li>";
        }
    }
    $model = cleanInput($_POST['formModel']);
    if(strlen($model) == 0) {
        $messaggi .= "<li>Modello non può essere vuoto!</li>";
    } else {
        $modelNoTags = strip_tags($model);
        if(!checkAllowNumbers($modelNoTags)) {
            $messaggi .= "<li>Il modello può contenere solo lettere, numeri, spazi e trattini!</li>";
        }
    }
    $color = cleanInput($_POST['formColor']);
    if(strlen($color) == 0) {
        $messaggi .= "<li>Finitura non può essere vuoto!</li>";
    } else {
        $colorNoTags = strip_tags($color);
        if(!checkProhibitNumbers($colorNoTags)) {
            $messaggi .= "<li>La finitura può contenere solo lettere, spazi e trattini!</li>";
        }
    }
    $price = cleanInput($_POST['formPrice']);
    if(strlen($price) == 0) {
        $messaggi .= "<li>Prezzo non può essere vuoto!</li>";
    } else {
        if($price <= 0) {
            $messaggi .= "<li>Inserire un prezzo maggiore di 0!</li>";
        }
    }
    $type = $_POST['formType'];
    $strings = cleanInput($_POST['formStrings']);
    if(strlen($strings) == 0) {
        $messaggi .= "<li>Corde non può essere vuoto!</li>";
    } else {
        if($strings < 4 || $strings > 12) {
            $messaggi .= "<li>Inserire un numero di corde tra 4 e 12!</li>";
        }
    }
    $frets = cleanInput($_POST['formFrets']);
    if(strlen($frets) == 0) {
        $messaggi .= "<li>Tasti non può essere vuoto!</li>";
    } else {
        if($frets < 12 || $frets > 36) {
            $messaggi .= "<li>Inserire un numero di tasti tra 12 e 36!</li>";
        }
    }
    $body = cleanInput($_POST['formBody']);
    if(strlen($body) == 0) {
        $messaggi .= "<li>Legno del corpo non può essere vuoto!</li>";
    } else {
        $bodyNoTags = strip_tags($body);
        if(!checkProhibitNumbers($bodyNoTags)) {
            $messaggi .= "<li>Legno del corpo può contenere solo lettere, spazi e trattini!</li>";
        }
    }
    $fretboard = cleanInput($_POST['formFretboard']);
    if(strlen($fretboard) == 0) {
        $messaggi .= "<li>Legno della tastiera non può essere vuoto!</li>";
    } else {
        $fretboardNoTags = strip_tags($fretboard);
        if(!checkProhibitNumbers($fretboardNoTags)) {
            $messaggi .= "<li>Legno della tastiera può contenere solo lettere, spazi e trattini!</li>";
        }
    }
    if(isset($_POST['formPickupConf'])) {
        if($_POST['formPickupConf'] != "-")
            $pickupConf = $_POST['formPickupConf'];
        else
            $messaggi .= "<li>Una chitarra semiacustica o elettrica non può non avere una configurazione di <span lang='en'>pickup</span></li>";
    } else {
        $pickupConf = "-";
    }
    if(isset($_POST['formPickupType'])) {
        $pickupType = cleanInput($_POST['formPickupType']);
        if(strlen($pickupType) == 0) {
            $messaggi .= "<li>Tipologia pickup non può essere vuoto!</li>";
        } else {
            $pickupTypeNoTags = strip_tags($pickupType);
            if(!checkAllowNumbers($pickupTypeNoTags)) {
                $messaggi .= "<li>Tipologia pickup può contenere solo lettere, numeri, spazi e trattini!</li>";
            }
        }
    } else {
        $pickupType = "-";
    }
    
    $description = cleanInput($_POST['formDescription']);
    if(strlen($description) == 0) {
        $messaggi .= "<li>Descrizione non può essere vuoto!</li>";
    }

    if($messaggi == "") { // FORM VALIDO
        $connOk = $connection->openConnection();
        if($connOk) { // CONNESSIONE COL DB OK
            if($connection->insertNewGuitar($model, $brand, $color, "€ ". $price, $type, $strings, $frets, $body, $fretboard, $pickupConf, $pickupType, strip_tags($brand) . " " . strip_tags($model), $description)) { // QUERY HA AVUTO SUCCESSO
                $ID = $connection->getLastID();
                $name = explode(".", $_FILES["formImage"]["name"]);
                if(end($name) == "webp") { // IMMAGINE COL FORMATO GIUSTO
                    $image = $_FILES["formImage"]["tmp_name"];
                    $path = "images/".$ID . "." . end($name);
                    if(move_uploaded_file($image,$path)) { // FILE SPOSTATO CORRETTAMENTE
                        $messaggi = "<p class='success'>Chitarra inserita con successo!</p>";
                    } else { // FILE NON SPOSTATO CORRETTAMENTE
                        $connection->deleteGuitar($ID);
                        $messaggi = "<p class='errors'>L'immagine non è stata caricata a causa di un errore interno. Riprovare a reinviare il form in un altro momento.</p>";
                    }
                } else { // IMMAGINE COL FORMATO SBAGLIATO
                    $messaggi = "<p class='errors'>L'immagine non è nel formato .webp! Riprovare reinserendo un'immagine in questo formato.</p>";
                }
            } else { // QUERY FALLITA
                $messaggi = "<p class='errors'>Il database ha dato esito negativo, la query ha fallito. Riprovare in un altro momento.</p>";
            }
        } else { // NESSUNA CONNESSIONE COL DB
            $messaggi = "<p class='errors'>Database al momento non disponibile a causa di un errore interno. Riprovare in un altro momento.</p>";
        }
        $connection->closeConnection(); // posso chiudere solo qui la connessione
    } else { // FORM NON VALIDO
        $messaggi = "<ul class='errors'>" . $messaggi . "</ul>";
    }
}

$HTMLpage = str_replace('<messaggiForm />', $messaggi, $HTMLpage);
$HTMLpage = str_replace('<valBrand />', $brand, $HTMLpage);
$HTMLpage = str_replace('<valModel />', $model, $HTMLpage);
$HTMLpage = str_replace('<valColor />', $color, $HTMLpage);
$HTMLpage = str_replace('<valPrice />', $price, $HTMLpage);
$HTMLpage = str_replace('<valStrings />', $strings, $HTMLpage);
$HTMLpage = str_replace('<valFrets />', $frets, $HTMLpage);
$HTMLpage = str_replace('<valBody />', $body, $HTMLpage);
$HTMLpage = str_replace('<valFretboard />', $fretboard, $HTMLpage);
$HTMLpage = str_replace('<valPickupType />', $pickupType, $HTMLpage);
$HTMLpage = str_replace('<valDescription />', $description, $HTMLpage);

echo $HTMLpage;
?>