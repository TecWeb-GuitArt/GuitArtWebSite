<?php
use DB\DBAccess;

require_once "./connection.php"; 

$htmlPage = file_get_contents("./html/login.html");

session_start();

$connessione = new DBAccess();

$user = '';
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

if(isset($_POST['submit'])) {
    $user = cleanInput($_POST['utente']);
    if(strlen($user)== 0) {
        $messaggiPerForm .= '<li>Inserire un nome utente valido.</li>';
    }

    $password = cleanInput($_POST['password']);
    if(strlen($password) == 0) {
        $messaggiPerForm .= '<li>Inserire una <span lang="en">password</span>.</li>';
    } 

    if($messaggiPerForm == '') {
        $connOk = $connessione->openConnection();
        if($connOk) {
            $queryOk = $connessione->verifyLogin($user, $password);
            if($queryOk) {
                $role = $connessione->getUserRole($user);
                session_start();
                $_SESSION["session_id"] = session_id();
                $_SESSION["session_user"] = $user;
                $_SESSION["session_role"] = $role;
                header('Location: index.php');
                exit();
            } else {
                $messaggiPerForm = '<p class="errors">Credenziali errate.</p>';
            }
            $connessione->closeConnection();
        } else {
            $messaggiPerForm = '<p class="errors">I nostri sistemi sono al momento non funzionanti, ci scusiamo per il disagio.</p>';
        }
    } else {
        $messaggiPerForm = '<ul class="errors">' . $messaggiPerForm . '</ul>';
    }
}

$htmlPage = str_replace('<messaggiPerForm />', $messaggiPerForm, $htmlPage);
$htmlPage = str_replace('<valUtente />', $user, $htmlPage);
$htmlPage = str_replace('<valPassword />', $password, $htmlPage);
echo $htmlPage;

?>
