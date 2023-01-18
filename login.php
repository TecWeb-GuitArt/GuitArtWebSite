<?php
use DB\DBAccess;

require_once "connessione.php"; 

$htmlPage = file_get_contents("login.html");
$connessione = new DBAccess();

$utente = '';
$password = '';
$role = '';
$messaggiPerForm  = '';
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

$isEmail = true;
if(isset($_POST['submit'])) {
    $email = cleanInput($_post['utente']);
    if(strlen($email)== 0) {
        $messaggiPerForm .= '<li>Inserire un nome utente o mail valida</li>';
    } else {
        if (!preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9.]+\.[a-zA-Z]{1,3]$/", $utente)) 
            //$messaggiPerForm .= '<li>Inserire un email valida</li>';
            $isEmail = false;        
    }

    $password = cleanInput($_POST['password']);
    if(strlen($password)) {
        $messaggiPerForm .= '<li>Inserire una password corretta</li>';
    } 

    if($messaggiPerForm == '') {
        $connOk = $connessione->openConnection();
        if($connOk) {
            $pw_hash = password_hash($password, PASSWORD_DEFAULT);
            if($isEmail)
                $queryOk = $connection->verifyLoginEmail($utente, $pw_hash);
            else 
                $queryOk = $connection->verifyLoginUsername($utente, $pw_hash); //da aggiungere query
            if($queryOk) {
                $formMessages = '<div id="success"><p>Login avvenuto con successo.</p></div>';
                $role = $connection->getUserRole($utente);
                $_SESSION["session_id"] = session_id();
                $_SESSION["session_user"] = $utente;
                $_SESSION["session_role"] = $role;
                header('Location: index.php');
                exit;
            } else {
                $messaggiPerForm = '<div id="errors"><p>Credenziali errate</p></div>';
            }
        } else {
            $messaggiPerForm = '<div id="errors"><p>I nostri sistemi sono al momento non funzionanti, ci scusiamo per il disagio.</p></div>';
        }
    } else {
        $messaggiPerForm = '<div id="errors"><ul>' . $messaggiPerForm . '</ul></div>';
    }
}

$HTMLpage = str_replace('<messaggiPerForm />', $messaggiPerForm, $HTMLpage);
$HTMLpage = str_replace('<valUtente />', $email, $HTMLpage);
$HTMLpage = str_replace('<valPassword />', $password, $HTMLpage);
echo $htmlPage;

?>