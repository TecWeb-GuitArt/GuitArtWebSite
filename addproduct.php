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

if(isset($_POST['formSubmit'])) { // if user clicked submit button do this
    $brand = cleanInput($_POST['formBrand']);
    if(strlen($brand) == 0) {
        $errors .= "<li>Il modello non può essere vuoto!</li>";
    } else {
        $brandNoTags = strip_tags($brand);
        if(!checkAllowNumbers($brandNoTags)) {
            $errors .= "<li>Il modello può contenere solo lettere, numeri e trattini -</li>";
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

echo $HTMLpage;
?>