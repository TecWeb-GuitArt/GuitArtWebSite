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
        $paginaHTML = str_replace("<login />", '<li><a href="./preferiti.php"><img src="./images/favourites.svg" height="44" width="44" alt="preferiti"/></a></li><li><img src="./images/accountActive.svg" height="44" width="44" alt="account"/></li>', $paginaHTML);
        $paginaHTML = str_replace("<loginM />", '<li><a href="./preferiti.php"><img src="./images/favourites.svg" height="44" width="44" alt=""/><p>Preferiti</p></a></li><li><img src="./images/accountActive.svg" height="44" width="44" alt=""/><p lang="en">Account</p></li>', $paginaHTML);
    } else if(isset($_SESSION['session_id']) && $_SESSION['session_role'] == 'admin') {    
        $paginaHTML = str_replace("<login />", '<li><img src="./images/accountActive.svg" height="44" width="44" alt="account"/></li>', $paginaHTML);
        $paginaHTML = str_replace("<loginM />", '<li><img src="./images/accountActive.svg" height="44" width="44" alt=""/><p lang="en">Account</p></li>', $paginaHTML);
    }


    
    //connessione DB
    $connection = new DBAccess();
    $connOk = $connection->openConnection();
    //

    if(isset($_POST['elimina'])) {
        if($connOk){
            $ris = $connection->verifyLogin($_SESSION['session_user'],$_POST['password']);
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
                    $messaggi .= "<p class='errors'>Il database ha dato esito negativo, la query ha fallito. Riprovare in un altro momento.</p>";
                }
            } else if($ris == 0){                
                // password sbagliata
                $messaggi .= "<p class='errors'>La password inserita non è corretta.</p>";
            } else if($ris == -1){
                //query andata male 
                $messaggi .= "<p class='errors'>Database al momento non disponibile a causa di un errore interno. Riprovare in un altro momento.</p>";
            }
            $connection->closeConnection();
        } else{
            // NESSUNA CONNESSIONE COL DB
            $messaggi .= "<p class='errors'>Database al momento non disponibile a causa di un errore interno. Riprovare in un altro momento.</p>";
        }
    }

    

    //paginaAdmin
    $paginaAdmin = "";
    $paginaAdmin .= "<div><ul>";
    $paginaAdmin .= "<li><a href='./modificaprofilo.php'>Modifica il profilo</a></li>";
    $paginaAdmin .= "</ul>";
    $paginaAdmin .= '<form id="formLogout" method="post" action="./areapersonale.php">
                        <span><input type="submit" id="logout" name="logout" value="Logout"></span>
                    </form></div>';

    //paginaUtente
    $paginaUtente = "";
    $paginaUtente .= "<div><ul>";
    $paginaUtente .= "<li><a href='./preferiti.php'>Visualizza i preferiti</a></li>";
    $paginaUtente .= "<li><a href='./modificaprofilo.php'>Modifica il profilo</a></li>";
    $paginaUtente .= "</ul>";
    $paginaUtente .= '<form id="formLogout" method="post" action="./areapersonale.php">
                        <span><input type="submit" id="logout" name="logout" value="Logout"></span>
                    </form>';
    $paginaUtente .= "<messaggiForm />";
    $paginaUtente .= "<form id='formDelete' method='post' action='areapersonale.php' onsubmit='return validatePassword();'>
                        <fieldset>
                        <legend>Elimina il profilo</legend>
                        <p class='messages'>Attenzione: questa azione ti porterà alla pagina iniziale.</p>
                        <label for='password'>Inserisci la password:</label>
                        <span><input type='password' name='password' id='password'  /></span>
                        <span><input type='submit' name='elimina' id='elimina' value='Elimina profilo' /></span>
                        </fieldset>
                    </form></div>";
    

    if (isset($_SESSION['session_id'])) {
        if ($_SESSION['session_role'] == 'admin') {
            $paginaHTML = str_replace('<areaPersonale/>', $paginaAdmin, $paginaHTML);
        }
        else {
            $paginaHTML = str_replace('<areaPersonale/>', $paginaUtente, $paginaHTML);
        }
        $paginaHTML = str_replace('<user />', $_SESSION['session_user'], $paginaHTML);
    }

    $paginaHTML = str_replace('<messaggiForm />', $messaggi, $paginaHTML);
    echo $paginaHTML;

?>