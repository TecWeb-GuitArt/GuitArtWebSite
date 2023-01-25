<?php
    use DB\DBAccess;
    require_once "./connection.php";
    $paginaHTML = file_get_contents("./html/areapersonale.html");
    session_start();

    $messaggi ="";


    if(!isset($_SESSION['session_id'])) {
        header('Location: index.php');
        exit();
    }

    //controllo logout
    if(isset($_POST['logout'])){
        session_destroy();
        header('Location: index.php');
        exit();
    }


    
    if (isset($_SESSION['session_id']) && $_SESSION['session_role'] == 'guest') {
        $paginaHTML = str_replace("<login />", '<li><a href="./preferiti.php"><img src="./images/favourites.svg" height="44" width="44" alt="preferiti"/></a></li><li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt="area personale"/></a></li>', $paginaHTML);
    } else if(isset($_SESSION['session_id']) && $_SESSION['session_role'] == 'admin') {    
        $paginaHTML = str_replace("<login />", '<li><a href="./areapersonale.php"><img src="./images/account.svg" height="44" width="44" alt="area personale"/></a></li>', $paginaHTML);
    }


    
    //connessione DB
    $connection = new DBAccess();
    $connOk = $connection->openConnection();
    //

    if(isset($_POST['elimina'])) {
        if($connOk){
            $ris = $connection->verifyLoginUsername($_SESSION['session_user'],$_POST['password']);
            if($ris == 1){
                //utente ha inserito password corretta
                //elimino utente
                if($connection->deleteUser($_SESSION['session_user'])){
                    // eliminato con successo
                    session_destroy();//non può più navigare nelle pagine che richiedono una sessione
                    header('Location: index.php');
                    exit();
                } else{
                    // query andata male
                    $messaggi .= "<p class='formError'>Il database ha dato esito negativo, la query ha fallito. Riprovare in un altro momento.</p>";
                }
            } else if($ris == 0){                
                // password sbagliata
                $messaggi .= "<p class='formError'>La password inserita non è corretta.</p>";
            } else if($ris == -1){
                //query andata male 
                $messaggi .= "<p class='formError'>Database al momento non disponibile a causa di un errore interno. Riprovare in un altro momento.</p>";
            }
            $connection->closeConnection();
        } else{
            // NESSUNA CONNESSIONE COL DB
            $messaggi .= "<p class='formError'>Database al momento non disponibile a causa di un errore interno. Riprovare in un altro momento.</p>";
        }
    }

    

    //paginaAdmin
    $paginaAdmin = "";
    $paginaAdmin .= "<p>" . $_SESSION['session_user'] . "</p>";
    $paginaAdmin .= "<ul>";
    $paginaAdmin .= "<li><a href='./modificaprofilo.php'>Modifica il profilo</a></li>";
    $paginaAdmin .= "</ul>";

    //paginaUtente
    $paginaUtente = "";
    $paginaUtente .= "<p>" . $_SESSION['session_user'] . "</p>";
    $paginaUtente .= "<ul>";
    $paginaUtente .= "<li><a href='./preferiti.php'>Visualizza i preferiti</a></li>";
    $paginaUtente .= "<li><a href='./modificaprofilo.php'>Modifica il profilo</a></li>";
    $paginaUtente .= "</ul>";
    $paginaUtente .= "<messaggiForm />";
    $paginaUtente .= "<form method='post' action='areapersonale.php' onsubmit='return validatePassword();'>
                        <fieldset>
                        <legend>Elimina il profilo</legend>
                        <p>Attenzione: questa azione ti porterà alla pagina iniziale.</p>
                        <label>Inserisci la password:</label>
                        <span><input type='password' name='password' id='password'  /></span>
                        <span><input type='submit' name='elimina' id='elimina' value='Elimina profilo' /></span>
                        </fieldset>
                    </form>";
    

    if (isset($_SESSION['session_id'])) {
        if ($_SESSION['session_role'] == 'admin') {
            $paginaHTML = str_replace('<areaPersonale/>', $paginaAdmin, $paginaHTML);
        }
        else {
            $paginaHTML = str_replace('<areaPersonale/>', $paginaUtente, $paginaHTML);
        }
    }


    $paginaHTML = str_replace('<messaggiForm />', $messaggi, $paginaHTML);
    echo $paginaHTML;

?>