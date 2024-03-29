<?php
use DB\DBAccess;
require_once "./connection.php"; //importo DBAccess dentro connection.php

$HTMLpage = file_get_contents("./html/register.html");
$connection = new DBAccess();

session_start();

$tagPermessi = '<em><strong><ul><li><span>';
$formMessages = '';

$username = '';
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
        $formMessages .= '<li>Inserire un nome utente.</li>';
    }
    else {
        if (!preg_match("/^[a-zA-Z][a-zA-Z0-9_]{5,29}$/", $username)) {
            $formMessages .= '<li>L\'<span lang="en">username</span> deve essere di almeno 6 caratteri e al massimo 29, iniziare con una lettera, e contenere solo lettere e numeri.</li>';
        }
    }

    // Controllo PASSWORD
    $password = cleanInput($_POST['password']);
    $password2 = cleanInput($_POST['password2']);
    $passCheck = false;

    if (strlen($password) == 0) {
        $formMessages .= '<li>Inserire una <span lang="en">password</span>.</li>';
    }
    else {
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{8,}$/", $password)) {
            $formMessages .= '<li>La <span lang="en">password</span> deve avere almeno 8 caratteri, e contenere almeno una lettera minuscola, una lettera maiuscola, un numero e un carattere speciale tra @, $, !, %, *, #, ?, &.</li>';
        }
        else {
            $passCheck = true;
        }
    }

    if (strlen($password2) == 0) {
        $formMessages .= '<li>Ripetere la <span lang="en">password</span>.</li>';
    }
    else {
        if ($passCheck) {
            if ($password != $password2) {
                $formMessages .= '<li>Le due <span lang="en">password</span> non combaciano.</li>';
            }
        }
        else {
            $formMessages .= '<li>Le due <span lang="en">password</span> non combaciano.</li>';
        }
    }

    // Inserimento nel DB
    if ($formMessages == '') { // Ovvero non ci sono errori
        $connOK = $connection->openConnection();
        if ($connOK) {
            if($connection->checkAlreadyExistingUser($username)) {
                $formMessages .= '<div class="errors"><p>Il nome utente è già stato usato per creare un <span lang="en">account</span>. Usare un nome utente diverso.</p></div>';
            } else {
                $pw_hash = password_hash($password, PASSWORD_DEFAULT);
                $queryOK = $connection->insertNewUser($username, $pw_hash);
                if ($queryOK) {
                    $formMessages = '<div class="success"><p>Registrazione avvenuta con successo.</p><a href="./login.php">Effettua il login</a></div>';
                }
                else {
                    $formMessages = '<div class="errors"><p>Problema nell\'inserimento dei dati, controlla di non aver usato caratteri speciali.</p></div>';
                }
            }
            $connection->closeConnection();
        }
        else {
            $formMessages = '<div class="errors"><p>I nostri sistemi sono al momento non funzionanti, ci scusiamo per il disagio.</p></div>';
        }
    }
    else {
        $formMessages = '<div class="errors"><ul>' . $formMessages . '</ul></div>';
    }
}

$HTMLpage = str_replace('<formMessages />', $formMessages, $HTMLpage);
$HTMLpage = str_replace('<valusername />', $username, $HTMLpage);
echo $HTMLpage;
?>
