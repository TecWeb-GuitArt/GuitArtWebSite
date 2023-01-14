<?php

// CONNESSIONE AL DB

$HTMLpage = file_get_contents("addproduct.html");
$allowedTags = '<span>';
$errors = "";
$brand = "";
$color = "";
$price = "";
$type = "";
$strings = "";
$frets = "";
$body = "";
$fretboard = "";
$pickupConf = "";
$pickupType = "";
$description = "";

function cleanInput($value) {
    $value = trim($value);
    $value = strip_tags($value, $allowedTag);
    return $value;
}

function checkAllowNumbers($value) {
    return preg_match("/^[a-zA-Z0-9\-\ ]+$/", $value);
}

function checkProhibitNumbers($value) {
    return preg_match("/^[a-zA-Z\-\ ]+$/", $value);
}

function checkOnlyNumbers($value) {
    return preg_match("/^[0-9\.]+$/", $value);
}

if(isset($_POST['formSubmit'])) { // if user clicked submit button do this
    $brand = cleanInput($_POST['formBrand']);
    if(strlen($brand) == 0) {
        $errors .= "<li>Marchio non può essere vuoto!</li>";
    } else {
        $brandNoTags = strip_tags($brand);
        if(!checkAllowNumbers($brandNoTags)) {
            $errors .= "<li>Il marchio può contenere solo lettere, numeri e trattini -!</li>";
        }
    }
    $model = cleanInput($_POST['formModel']);
    if(strlen($model) == 0) {
        $errors .= "<li>Modello non può essere vuoto!</li>";
    } else {
        $modelNoTags = strip_tags($model);
        if(!checkAllowNumbers($modelNoTags)) {
            $errors .= "<li>Il modello può contenere solo lettere, numeri e trattini -!</li>";
        }
    }
    $color = cleanInput($_POST['formColor']);
    if(strlen($color) == 0) {
        $errors .= "<li>Finitura non può essere vuoto!</li>";
    } else {
        $colorNoTags = strip_tags($color);
        if(!checkProhibitNumbers($colorNoTags)) {
            $errors .= "<li>La finitura può contenere solo lettere e trattini -!</li>";
        }
    }
    $price = cleanInput($_POST['formPrice']);
    if(strlen($price) == 0) {
        $errors .= "<li>Prezzo non può essere vuoto!</li>";
    } else {
        if(!checkOnlyNumbers($price)) {
            $errors .= "<li>Il prezzo può contenere solo numeri!</li>";
        }
    }
    $strings = cleanInput($_POST['formStrings']);
    if(strlen($strings) == 0) {
        $errors .= "<li>Corde non può essere vuoto!</li>";
    } else {
        if(!checkOnlyNumbers($strings)) {
            $errors .= "<li>Corde può contenere solo numeri!</li>";
        }
    }
    $frets = cleanInput($_POST['formFrets']);
    if(strlen($frets) == 0) {
        $errors .= "<li>Tasti non può essere vuoto!</li>";
    } else {
        if(!checkOnlyNumbers($frets)) {
            $errors .= "<li>Tasti può contenere solo numeri!</li>";
        }
    }
    $body = cleanInput($_POST['formBody']);
    if(strlen($body) == 0) {
        $errors .= "<li>Legno del corpo non può essere vuoto!</li>";
    } else {
        $bodyNoTags = strip_tags($body);
        if(!checkProhibitNumbers($bodyNoTags)) {
            $errors .= "<li>Legno del corpo può contenere solo lettere e trattini -!</li>";
        }
    }
    $fretboard = cleanInput($_POST['formFretboard']);
    if(strlen($fretboard) == 0) {
        $errors .= "<li>Legno della tastiera non può essere vuoto!</li>";
    } else {
        $fretboardNoTags = strip_tags($fretboard);
        if(!checkProhibitNumbers($fretboardNoTags)) {
            $errors .= "<li>Legno della tastiera può contenere solo lettere e trattini -!</li>";
        }
    }
    $pickupType = cleanInput($_POST['formPickupType']);
    if(strlen($pickupType) == 0) {
        $errors .= "<li>Tipologia pickup non può essere vuoto!</li>";
    } else {
        $pickupTypeNoTags = strip_tags($pickupType);
        if(!checkAllowNumbers($pickupTypeNoTags)) {
            $errors .= "<li>Tipologia pickup può contenere solo lettere, numeri e trattini -!</li>";
        }
    }
    $description = cleanInput($_POST['formDescription']);
    if(strlen($description) == 0) {
        $errors .= "<li>Descrizione non può essere vuoto!</li>";
    }

    if($errors == "") {
        // INSERT con tutti i casi
    } else {
        $errors = "<div><ul>" . $errors . "</ul></div>";
    }
}

$HTMLpage = str_replace('<messaggiForm />', $errors, $HTMLpage);
$HTMLpage = str_replace('<valBrand />', $brand, $HTMLpage);
$HTMLpage = str_replace('<valModel />', $model, $HTMLpage);
$HTMLpage = str_replace('<valColor />', $color, $HTMLpage);
$HTMLpage = str_replace('<valPrice />', $price, $HTMLpage);
$HTMLpage = str_replace('<valType />', $type, $HTMLpage); //NON CORRETTO
$HTMLpage = str_replace('<valStrings />', $strings, $HTMLpage);
$HTMLpage = str_replace('<valFrets />', $frets, $HTMLpage);
$HTMLpage = str_replace('<valBody />', $body, $HTMLpage);
$HTMLpage = str_replace('<valFretboard />', $fretboard, $HTMLpage);
$HTMLpage = str_replace('<valPickupConf />', $pickupConf, $HTMLpage); //NON CORRETTO
$HTMLpage = str_replace('<valPickupType />', $pickupType, $HTMLpage);
$HTMLpage = str_replace('<valDescription />', $description, $HTMLpage);

echo $HTMLpage;
?>