/*function showError(field) {
    if(field == "user") document.getElementById(field).innerText = "Inserisci un username o email validi";
    if(field == "password") document.getElementById(field).innerText = "Inserisci una password valida";
    document.getElementById(field).className = "error";
}

function isEmpty(value) {
    return (value.length == 0);
}

function checkInput() {
    if(isEmpty(document.getElementById("user")))
        showError("user");
    if(isEmpty(document.getElementById("password")))
        showError("password");
}*/

function validateName(){
    var field = document.getElementById("utente");
    var parent = field.parentNode;
    if (parent.children.length == 2) {
        parent.removeChild(parent.children[1]);
    }
    var rex = /^[a-zA-Z][a-zA-Z0-9_]{5,29}$/;
    if(field.value == "user" || field.value == "admin") {
        return true;
    }
    if(!rex.test(field.value)){
        var err = document.createElement("p");        
        err.className = "errors";
        err.appendChild(document.createTextNode("L\'username deve essere di almeno 6 caratteri e al massimo 29, iniziare con una lettera, e contenere solo lettere e numeri"));
        parent.appendChild(err);
        return false;
    }else{
        return true;
    }
}

function validatePassword(){
    var field = document.getElementById("password");
    var parent = field.parentNode;
    if (parent.children.length == 2) {
        parent.removeChild(parent.children[1]);
    }
    var rex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{7,}$/;
    if(field.value == "user" || field.value == "admin") {
        return true;
    }
    if(!rex.test(field.value)){
        var err = document.createElement("p");        
        err.className = "errors";
        err.appendChild(document.createTextNode("La password deve avere almeno 8 caratteri, e contenere almeno una lettera minuscola, una lettera maiuscola, un numero e un carattere speciale tra @, $, !, %, *, #, ?, &"));
        parent.appendChild(err);
        return false;
    }else{
        return true;
    }
}

function checkInput() {
    var inputOk = true;
    if(!validateName()) {
        inputOk = false;
    }
    if(!validatePassword()){
        inputOk = false;
    }
    return inputOk;
}