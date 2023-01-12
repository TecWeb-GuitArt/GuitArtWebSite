<?php

// CONNESSIONE AL DB

$HTMLpage = file_get_contents("addproduct.html");
$allowedTags = '<span>';
$errors = "";
$brand = "";

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
    // PRICE
    // STRINGS
    // FRETS
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

    if($errors == "") {
        // INSERT con tutti i casi
    } else {
        $errors = "<div><ul>" . $errors . "</ul></div>";
    }
}

$HTMLpage = str_replace('<messaggiForm />', $errors, $HTMLpage);
$HTMLpage = str_replace('<valBrand />', $brand, $HTMLpage);
$HTMLpage = str_replace('<valModel />', $model, $HTMLpage);

echo $HTMLpage;
?>