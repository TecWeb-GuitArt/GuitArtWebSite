<?php

use DB\DBAccess;
require_once "connection.php";
$connection = new DBAccess();

$HTMLpage = file_get_contents("addproduct.html");
$messaggi = "";
$model = "";
$brand = "";
$color = "";
$price = "";
$type = "";
$strings = "";
$frets = "";
$body = "";
$fretboard = "";
$pickupConf = "";
$pickupType = "-";
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

if(isset($_POST['formSubmit'])) { // if user clicked submit button do this
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
        $pickupConf = $_POST['formPickupConf'];
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

    if($messaggi == "") {
        $connOk = $connection->openConnection();
        if($connOk) {
            if($connection->insertNewGuitar($model, $brand, $color, $price, $type, $strings, $frets, $body, $fretboard, $pickupConf, $pickupType, strip_tags($brand) . " " . strip_tags($model), $description)) {
                $messaggi = "<p id='formSuccess'>Chitarra inserita con successo!</p>";
            } else {
                $messaggi = "<p class='formError'>Il database ha dato esito negativo, la query ha fallito. Riprovare in un altro momento.</p>";
            }
        } else {
            $messaggi = "<p class='formError'>Database al momento non disponibile a causa di un errore interno. Riprovare in un altro momento.</p>";
        }
        
    } else {
        $messaggi = "<ul class='formError'>" . $messaggi . "</ul>";
    }
}

$HTMLpage = str_replace('<messaggiForm />', $messaggi, $HTMLpage);
$HTMLpage = str_replace('<valBrand />', $brand, $HTMLpage);
$HTMLpage = str_replace('<valModel />', $model, $HTMLpage);
$HTMLpage = str_replace('<valColor />', $color, $HTMLpage);
$HTMLpage = str_replace('<valPrice />', $price, $HTMLpage);
$HTMLpage = str_replace('<valType />', $type, $HTMLpage);
$HTMLpage = str_replace('<valStrings />', $strings, $HTMLpage);
$HTMLpage = str_replace('<valFrets />', $frets, $HTMLpage);
$HTMLpage = str_replace('<valBody />', $body, $HTMLpage);
$HTMLpage = str_replace('<valFretboard />', $fretboard, $HTMLpage);
$HTMLpage = str_replace('<valPickupConf />', $pickupConf, $HTMLpage);
$HTMLpage = str_replace('<valPickupType />', $pickupType, $HTMLpage);
$HTMLpage = str_replace('<valDescription />', $description, $HTMLpage);

echo $HTMLpage;
?>