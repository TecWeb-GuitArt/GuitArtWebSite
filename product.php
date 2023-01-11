<?php

$HTMLpage = file_get_contents("product.html");
$productName = "";
$mainReplace = "";

// CONNESSIONE AL DB

if($connOk) {
    // QUERY select * from guitars where id = xxx;
    // Fai anche il caso in cui la query non ritorna nulla;
    $productName = $info['Alt'];
    $mainReplace = '<main id="product">
                <ul>
                    <li id="img">
                        <img src="' . $info['Image'] . '" alt="' . $info['Alt'] . '" height="510" width="340"/>
                    </li>
                    <li id="title">
                        <h2>' . $info['Brand'] . '</h2>
                        <h3>' . $info['Model'] . '</h3>
                    </li>
                    <li id="price">
                        <p>' . $info['Price'] . '</p>
                    </li>
                    <li id="description">
                        <p>' . $info['Description'] . '</p>
                    </li>
                    <li id="buy">
                        <form>
                            <input id="button" type="submit" value="Aggiungi ai Preferiti"/>
                        </form>
                    </li>
                </ul>
                <h2>Caratteristiche del prodotto</h2>
                <dl id="specs">
                    <dt class="spec1">Marchio:</dt>
                    <dd class="spec1">' . $info['Brand'] . '</dd>
                    <dt class="spec2">Colore:</dt>
                    <dd class="spec2">' . $info['Color'] . '</dd>
                    <dt class="spec1">Tipologia:</dt>
                    <dd class="spec1">' . $info['Type'] . '</dd>
                    <dt class="spec2">Numero di corde:</dt>
                    <dd class="spec2">' . $info['Strings'] . '</dd>
                    <dt class="spec1">Numero di tasti:</dt>
                    <dd class="spec1">' . $info['Frets'] . '</dd>
                    <dt class="spec2">Legno del corpo:</dt>
                    <dd class="spec2">' . $info['Body'] . '</dd>
                    <dt class="spec1">Legno della tastiera:</dt>
                    <dd class="spec1">' . $info['Fretboard'] . '</dd>
                    <dt class="spec2">Configurazione Pickup:</dt>
                    <dd class="spec2">' . $info['Pickup_Configuration'] . '</dd>
                    <dt class="spec1">Tipologia Pickup:</dt>
                    <dd class="spec1">' . $info['Pickup_Type'] . '</dd>
                </dl>   
            </main>';
} else {
    $productName = "Prodotto non disponibile";
    $mainReplace = "<main>
                        <h2>Errore interno - Database non disponibile</h2>
                        <p>I nostri sistemi al momento non sono disponibili a causa di un errore interno. Riprova più tardi.</p>
                    </main>";
}

$HTMLpage = str_replace("<productName />", $productName, $HTMLpage);
$HTMLpage = str_replace("<mainReplace />", $mainReplace, $HTMLpage);

echo $HTMLpage;
?>