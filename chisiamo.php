<?php
    $paginaHTML = file_get_contents("chisiamo.html");
    //connessione DB
    $stringapagina = "";
    $stringapagina .= "<h1 id='title'>Chi siamo</h1>
        <p id='presentation'>Guitart è il primo e-commerce Veneto di strumenti musicali a proporre ai propri clienti una selezione di chitarre non raggiungibile dalla concorrenza!<br/>
        Guitart nasce a Vicenza nel 2011 come piccolo mercatino di strumenti musicali. Nel 2017 Guitart diventa uno store online, in pochi mesi diventa lo store di strumenti musicali più conosciuto in Italia.<br/>Nello store Guitart trovi solo chitarre di qualità e a buon prezzo!</p>   
    <div id='ourteam'>
        <h2 id='titleteam'>Il nostro Team</h2>
        <ul id='team'>
            <li class='member1'>Nicola Cecchetto <p>L'esperto</p></li>
            <li class='member2'>Niccolò Fasolo <p>Il manager</p></li>
            <li class='member3'>Andrea Meneghello <p>Addetto alle vendite</p></li>
            <li class='member4'>Andrea Longo <p>Servizio clienti</p></li>
        </ul>           
    </div>";


    $paginaHTML =str_replace("<chisiamo/>",$stringapagina, $paginaHTML);
    echo $paginaHTML;
?>