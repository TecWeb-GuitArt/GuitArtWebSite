<?php
    $paginaHTML = file_get_contents("contatti.html");
    $stringapagina = "";
    $stringapagina .= "<h1 id='title'>Contattaci</h1>        
    <div class='info' >
        <dl class='uffici'>
            <dt class='uffici'>Uffici</dt>
            <dd class='uffici'>Via Crosetto, 67 36100 Vicenza(IT)</dd>
        </dl>
        <dl class='telefono'>
            <dt class='telefono'>Servizio Clienti</dt>
            <dd class='telefono'><a href='tel:+123456'>+123456</a></dd>
        </dl>
        <dl class='email'>
            <dt class='email'><span lang='en'>Email</span></dt>
            <dd class='email'><a href='mailto:servizioclienti@guitart.it'>servizioclienti@guitart.it</a></dd>
        </dl>
        <dl class='orario'>
            <dt id='titleorario'>Orario apertura</dt>
            <dd>
                <dl>
                    <dt class='orario'>Lunedì</dt><dd><time>8:30</time>-<time>13:00</time></dd>
                    <dt class='orario'>Martedì</dt><dd><time>8:30</time>-<time>13:00</time></dd>
                    <dt class='orario'>Mercoledì</dt><dd><time>8:30</time>-<time>12:00</time></dd>
                    <dt class='orario'>Giovedì</dt><dd><time>8:30</time>-<time>13:00</time></dd>
                    <dt class='orario'>Venerdì</dt><dd><time>8:30</time>-<time>13:00</time></dd>
                </dl>
            </dd>
        </dl>        
    </div>";
    
    
    

    $paginaHTML =str_replace("<contatti/>",$stringapagina, $paginaHTML);
    echo $paginaHTML;

?>