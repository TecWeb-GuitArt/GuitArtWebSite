hints = {
    'Brand' : 'Sono concessi lettere, numeri, spazi e trattini.',
    'Model' : 'Sono concessi lettere, numeri, spazi e trattini.',
    'Color' : 'Sono concessi lettere, spazi e trattini.',
    'Price' : 'Il prezzo deve essere maggiore di 0. Sono concessi anche centesimi di euro.',
    'Strings' : 'Il numero di corde deve essere tra 4 e 12.',
    'Frets' : 'Il numero di tasti deve essere tra 12 e 36.',
    'Body' : 'Sono concessi lettere, spazi e trattini.',
    'Fretboard' : 'Sono concessi lettere, spazi e trattini.',
    'PickupType' : 'Sono concessi lettere, numeri, spazi e trattini.',
    'Description' : 'Formatta il testo usando i tag adeguati.'
}

function checkNull(value, field) {
    if(value.length == 0) {
        document.getElementById("p" + field).innerText = "Campo vuoto!";
        document.getElementById("p" + field).className = "messages";
    } else {
        document.getElementById("p" + field).innerText = hints[field];
        document.getElementById("p" + field).className = "";
    }
}

function typeChanged(value) {
    if(value == "Classica" || value == "Acustica") {
        document.getElementById("formPickupConf").disabled = true;
        document.getElementById("formPickupType").disabled = true;
    } else {
        document.getElementById("formPickupConf").disabled = false;
        document.getElementById("formPickupType").disabled = false;
    }
}