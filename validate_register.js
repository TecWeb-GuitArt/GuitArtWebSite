var form_details = [
    "username" = ["/^[a-zA-Z][a-zA-Z0-9_]{5,29}$/", "L\'username deve essere di almeno 6 caratteri e al massimo 29, iniziare con una lettera, e contenere solo lettere e numeri"],
    "email" = ["/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9.]+\.[a-zA-Z]{1,3}$/", "L\'email deve essere di almeno 6 caratteri e al massimo 29, e contenere solo lettere e numeri"],
    "password" = ["/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{8,}$/", "La password deve avere almeno 8 caratteri, e contenere almeno una lettera minuscola, una lettera maiuscola, un numero e un carattere speciale tra @, $, !, %, *, #, ?, &"]
];

function load() {
    for (var fieldId in form_details) {
        var field = document.getElementById(fieldId);
        field.onblur = validateField(this);
    }
    var p2 = document.getElementById("password2");
    field.onblur = validateP2();
}

function validateField(field) {
    var parent = field.parentNode;
    if (parent.children.length == 2) {
        parent.removeChild(parent.children[1]);
    }
    var regex = form_details[field.id][0];
    var value = field.value;
    if (!(regex.test(value))) { // modificare regex.test() perché non va
        showError(field);
        field.focus();
        return false;
    }
    return true;
}

function validateP2() {
    var field = document.getElementById("password2");
    var parent = field.parentNode;
    if (parent.children.length == 2) {
        parent.removeChild(parent.children[1]);
    }
    var p = document.getElementById("password");
    if (validateField(p)) {
        if (p.value != field.value) {
            showErrorP2("Le due password non combaciano");
            return false;
        }
        else {
            return true;
        }
    }
    else {
        showErrorP2("Le due password non combaciano");
        return false;
    }
}

function validate() {
    for (var fieldId in form_details) {
        var field = document.getElementById(fieldId);
        if (!validateField(field)) {
            return false;
        }
    }
    if (!validateP2()) {
        return false;
    }
    return true;
}

function showError(field) {
    var parent = field.parentNode;
    var err = document.createElement("p");
    err.className("errors");
    err.appendChild(document.createTextNode(form_details[field.id][1]));
    parent.appendChild(err);
}

function showErrorP2(error) {
    var parent = document.getElementById("password2").parentNode;
    var err = document.createElement("p");
    err.className("errors");
    err.appendChild(document.createTextNode(error));
    parent.appendChild(err);
}