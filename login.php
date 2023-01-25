<?php
use DB\DBAccess;

require_once "./connection.php"; 

$htmlPage = file_get_contents("./html/login.html");

session_start();

$connessione = new DBAccess();

$email = '';
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
    $email = cleanInput($_POST['utente']);
    if(strlen($email)== 0) {
        $messaggiPerForm .= '<li>Inserire un nome utente o mail valida.</li>';
    } else {
        if (!preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9.]+\.[a-zA-Z]{1,3]$/", $email)) 
            $isEmail = false;
    }

    $password = cleanInput($_POST['password']);
    if(strlen($password) == 0) {
        $messaggiPerForm .= '<li>Inserire una password corretta.</li>';
    } 

    if($messaggiPerForm == '') {
        $connOk = $connessione->openConnection();
        if($connOk) {
            if($isEmail)
                $queryOk = $connessione->verifyLoginEmail($email, $password);
            else 
                $queryOk = $connessione->verifyLoginUsername($email, $password);
            if($queryOk) {
                $role = $connessione->getUserRole($email);
                session_start();
                $_SESSION["session_id"] = session_id();
                $_SESSION["session_user"] = $email;
                $_SESSION["session_role"] = $role;
                header('Location: index.php');
                exit();
            } else {
                $messaggiPerForm = '<p class="errors">Credenziali errate.</p>';
            }
        } else {
            $messaggiPerForm = '<p class="errors">I nostri sistemi sono al momento non funzionanti, ci scusiamo per il disagio.</p>';
        }
    } else {
        $messaggiPerForm = '<ul class="errors">' . $messaggiPerForm . '</ul>';
    }
}

$htmlPage = str_replace('<messaggiPerForm />', $messaggiPerForm, $htmlPage);
$htmlPage = str_replace('<valUtente />', $email, $htmlPage);
$htmlPage = str_replace('<valPassword />', $password, $htmlPage);
echo $htmlPage;

?>