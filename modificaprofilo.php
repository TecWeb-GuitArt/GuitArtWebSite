<?php
    use DB\DBAccess;    
    require_once "connection.php";
    $connection = new DBAccess();
    $htmlPage = file_get_contents("./html/modificaprofilo.html");

    session_start();

    $messaggi ="";
    $username ="";
    $password ="";

    if(!isset($_SESSION['session_id'])) {
        header('Location: index.php');
        exit();
    } 

    
    if (isset($_SESSION['session_id']) && $_SESSION['session_role'] == 'guest') {
        $htmlPage = str_replace("<login />", '<li><a href="./preferiti.php"><img src="./images/favourites.svg" height="44" width="44" alt="preferiti"/></a></li><li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt="area personale"/></a></li>', $htmlPage);
        $htmlPage = str_replace("<loginM />", '<li><a href="./preferiti.php"><img src="./images/favourites.svg" height="44" width="44" alt="preferiti"/></a></li><li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt="area personale"/></a></li>', $htmlPage);
    } else if(isset($_SESSION['session_id']) && $_SESSION['session_role'] == 'admin') {    
        $htmlPage = str_replace("<login />", '<li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt="area personale"/></a></li>', $htmlPage);
        $htmlPage = str_replace("<loginM />", '<li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt="area personale"/></a></li>', $htmlPage);
    }

    function cleanInput($value) {
        $value = trim($value);
        $value = strip_tags($value);
        $value = htmlentities($value);
        return $value;
    }

    //valido form nome utente
    if(isset($_POST['nomesubmit'])){
        $username = cleanInput($_POST['nomeutente']);
        if(strlen($username) == 0){
            $messaggi .= "Il nome non può essere vuoto";
        } else{
            if (!preg_match("/^[a-zA-Z][a-zA-Z0-9_]{5,29}$/", $username)) {
                $messaggi .= '<li>L\'username deve essere di almeno 6 caratteri e al massimo 29, iniziare con una lettera, e contenere solo lettere e numeri</li>';
            }
        }

        if($messaggi == ""){
            //form valido
            $connOk = $connection->openConnection();
            if($connOk){
                //conn col db ok
                if($connection->updateUsername($_SESSION['session_user'], $username)){
                    //query ok
                    $messaggi .= "<p id='formSuccess'>Nome utente aggiornato con successo</p>";
                } else{
                    //query andata male
                    $messaggi = "<p class='formError'>Il database ha dato esito negativo, la query ha fallito. Riprovare in un altro momento.</p>";
                }
                $connection->closeConnection();
            } 
            else 
            { // NESSUNA CONNESSIONE COL DB
                $messaggi = "<p class='formError'>Database al momento non disponibile a causa di un errore interno. Riprovare in un altro momento.</p>";
            }
            $connection->closeConnection(); 
        } else{
            //form non valido
            $messaggi = "<ul class='formError'>" . $messaggi . "</ul>";
        }

        
        
    }

    //form password
    if(isset($_POST['passwordsubmit'])){
        $password = cleanInput($_POST['password']);
        if(strlen($password) == 0){
            $messaggi .= "La password non può essere vuota";
        } else{
            if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{8,}$/", $password)) {
                $messaggi .= '<li>La password deve avere almeno 8 caratteri, e contenere almeno una lettera minuscola, una lettera maiuscola, un numero e un carattere speciale tra @, $, !, %, *, #, ?, &</li>';
            }
        }

        if($messaggi == ""){
            //form valido
            $connOk = $connection->openConnection();
            if($connOk){
                //conn col db ok
                if($connection->updatePassword($_SESSION['session_user'], password_hash($password, PASSWORD_DEFAULT))){
                    //query ok
                    $messaggi .= "<p id='formSuccess'>Password aggiornata con successo.</p>";
                } else{
                    //query andata male
                    $messaggi = "<p class='formError'>Il database ha dato esito negativo, la query ha fallito. Riprovare in un altro momento.</p>";
                }
            } 
            else 
            { // NESSUNA CONNESSIONE COL DB
                $messaggi = "<p class='formError'>Database al momento non disponibile a causa di un errore interno. Riprovare in un altro momento.</p>";
            }
            $connection->closeConnection(); 
        } else{
            //form non valido
            $messaggi = "<ul class='formError'>" . $messaggi . "</ul>";
        }

        
        
    }

    //

$htmlPage = str_replace('<messaggiForm />', $messaggi, $htmlPage);
$htmlPage = str_replace('<valName />', $username, $htmlPage);
$htmlPage = str_replace('<valPassword />', $password, $htmlPage);


echo $htmlPage;
?>