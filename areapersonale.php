<?php
    use DB\DBAccess;
    require_once "./connection.php";
    $paginaHTML = file_get_contents("./html/areapersonale.html");

    if(!isset($_SESSION['session_id'])) {
        header('Location: accessonegato.php');
        exit();
    }

    //controllo logout
    if(isset($_POST['logout'])){
        session_destroy();
        header('Location: index.php');
        exit();
    }

    //connessione DB
    $connection = new DBAccess();
    $connOk = $connection->openConnection();
    //
    

    //paginaAdmin
    $paginaAdmin = "";
    $paginaAdmin .= "<p>" . $_SESSION['session_username'] . "</p>";
    $paginaAdmin .= "<ul>";
    $paginaAdmin .= "<li><a href='./'>Modifica il profilo</a></li>";
    $paginaAdmin .= "</ul>";

    //paginaUtente
    $paginaUtente = "";
    $paginaUtente .= "<p>" . $_SESSION['session_username'] . "</p>";
    $paginaUtente .= "<ul>";
    $paginaUtente .= "<li><a href='./preferiti.php'>Visualizza i preferiti</a></li>";
    $paginaUtente .= "<li><a href='./'>Modifica il profilo</a></li>";
    $paginaUtente .= "<li><a href='./'>Elimina il profilo</a></li>";
    $paginaUtente .= "</ul>";

    if (isset($_SESSION['session_id'])) {
        if ($_SESSION['role'] == 'admin') {
            $paginaHTML = str_replace('<areaPersonale/>', $paginaAdmin, $paginaHTML);
        }
        else {
            $paginaHTML = str_replace('<areaPersonale/>', $paginaUtente, $paginaHTML);
        }
    }

    echo $paginaHTML;

?>