<?php
use DB\DBAccess;
require_once "./connection.php"; //importo DBAccess dentro connection.php

$HTMLpage = file_get_contents("./html/register.html");
$connection = new DBAccess();

$tagPermessi = '<em><strong><ul><li><span>';
$formMessages = '';

$username = '';
$email = '';
$password = '';
$password2 = '';

function cleanInput($value) { // l'ordine di queste istruzioni è fondamentale
    $value = trim($value);
    $value = strip_tags($value);
    $value = htmlentities($value);
    return $value;
}

if (isset($_SESSION['session_id'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['submit'])) {
    // Controllo USERNAME
    $username = cleanInput($_POST['username']);
    if (strlen($username) == 0) {
        $formMessages .= '<li>Inserire un username</li>';
    }
    else {
        if (!preg_match("/^[a-zA-Z][a-zA-Z0-9_]{5,29}$/", $username)) {
            $formMessages .= '<li>L\'username deve essere di almeno 6 caratteri e al massimo 29, iniziare con una lettera, e contenere solo lettere e numeri</li>';
        }
    }

    // Controllo EMAIL
    $email = cleanInput($_POST['email']);
    if (strlen($email) == 0) {
        $formMessages .= '<li>Inserire una email</li>';
    }
    else {
        if (!preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9.]+\.[a-zA-Z]{1,3}$/", $email)) {
            $formMessages .= '<li>L\'email deve essere di almeno 6 caratteri e al massimo 29, e contenere solo lettere e numeri</li>';
        }
    }

    // Controllo PASSWORD
    $password = cleanInput($_POST['password']);
    $password2 = cleanInput($_POST['password2']);
    $passCheck = false;

    if (strlen($password) == 0) {
        $formMessages .= '<li>Inserire una password</li>';
    }
    else {
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{8,}$/", $password)) {
            $formMessages .= '<li>La password deve avere almeno 8 caratteri, e contenere almeno una lettera minuscola, una lettera maiuscola, un numero e un carattere speciale tra @, $, !, %, *, #, ?, &</li>';
        }
        else {
            $passCheck = true;
        }
    }

    if (strlen($password2) == 0) {
        $formMessages .= '<li>Ripetere la password</li>';
    }
    else {
        if ($passCheck) {
            if ($password != $password2) {
                $formMessages .= '<li>Le due password non combaciano</li>';
            }
        }
        else {
            $formMessages .= '<li>Le due password non combaciano</li>';
        }
    }

    // Inserimento nel DB
    if ($formMessages == '') { // Ovvero non ci sono errori
        $connOK = $connection->openConnection();
        if ($connOK) {
            $pw_hash = password_hash($password, PASSWORD_DEFAULT);
            $queryOK = $connection->insertNewUser($username, $email, $pw_hash);
            if ($queryOK) {
                $formMessages = '<div id="success"><p>Registrazione avvenuta con successo.</p></div>';
            }
            else {
                $formMessages = '<div id="errors"><p>Problema nell\'inserimento dei dati, controlla di non aver usato caratteri speciali.</p></div>';
            }
        }
        else {
            $formMessages = '<div id="errors"><p>I nostri sistemi sono al momento non funzionanti, ci scusiamo per il disagio.</p></div>';
        }
    }
    else {
        $formMessages = '<div id="errors"><ul>' . $formMessages . '</ul></div>';
    }
}

$HTMLpage = str_replace('<formMessages />', $formMessages, $HTMLpage);
$HTMLpage = str_replace('<valusername />', $username, $HTMLpage);
$HTMLpage = str_replace('<valemail />', $email, $HTMLpage);
echo $HTMLpage;
?>