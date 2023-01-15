<?php
use DB\DBAccess;

session_start();
require_once "connessione.php"; 

$htmlPage = file_get_contents("login.html");
$connessione = new DBAccess();

$msg = '';
$utente = '';
$password = '';
function cleanInput($value) { 
    $value = trim($value);
    $value = strip_tags($value);
    $value = htmlentities($value);
    return $value;
}

//controllo se loggato
if (isset($_SESSION['session_id'])) {
    header('Location: index.php');
    exit;
}

if(isset($_POST['submit'])) {
    $email = cleanInput($_post['email']);
    if(strlen($email)== 0) {
        $messaggiPerForm .= '<li>Inserire una mail valida</li>';
    } else {
        if(!preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9.]+\.[a-zA-Z]{1,3]$/", $email))
            $formMessages .= '<li>Inserire un email valida</li>';
    }

    $password = cleanInput($_POST['password']);
    if(strlen($password)) {
        $messaggiPerForm .= '<li>Inserire una password corretta</li>';
    } 

    if($messaggiPerForm == '') {
        $connOk = $connessione->openConnection();
        if($connOk) {
            $pw_hash = password_hash($password, PASSWORD_DEFAULT);
            $queryOk = $connection->verifyLogin($email, $pw_hash);
            if($queryOk) {
                $formMessages = '<div id="success"><p>Login avvenuto con successo.</p></div>';
                $_SESSION["session_id"] = session_id();
                $_SESSION["session_user"] = $email;
                header('Location: index.php');
                exit;
            } else {
                $formMessages = '<div id="errors"><p>Credenziali errate</p></div>';
            }
        } else {
            $formMessages = '<div id="errors"><p>I nostri sistemi sono al momento non funzionanti, ci scusiamo per il disagio.</p></div>';
        }
    } else {
        $formMessages = '<div id="errors"><ul>' . $formMessages . '</ul></div>';
    }
}

$HTMLpage = str_replace('<formMessages />', $formMessages, $HTMLpage);
$HTMLpage = str_replace('<valEmail />', $email, $HTMLpage);
$HTMLpage = str_replace('<valPassword />', $password, $HTMLpage);
