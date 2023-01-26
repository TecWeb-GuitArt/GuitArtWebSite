function validateName(){
    var field = document.getElementById("nomeutente");
    var parent = field.parentNode;
    if (parent.children.length == 2) {
        parent.removeChild(parent.children[1]);
    }
    var rex = /^[a-zA-Z][a-zA-Z0-9_]{5,29}$/;
    if(!rex.test(field.value)){
        var err = document.createElement("p");        
        err.className = "messages";
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
    var rex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{8,}$/;
    if(!rex.test(field.value)){
        var err = document.createElement("p");        
        err.className = "messages";
        err.appendChild(document.createTextNode("La password deve avere almeno 8 caratteri, e contenere almeno una lettera minuscola, una lettera maiuscola, un numero e un carattere speciale tra @, $, !, %, *, #, ?, &"));
        parent.appendChild(err);
        return false;
    }else{
        return true;
    }
}