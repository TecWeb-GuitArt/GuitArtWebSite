function showError(fieldName) {
    var field = document.getElementById(fieldName);
    var parent = field.parentNode;
    var err = document.createElement("p");        
    err.className = "messages";
    err.appendChild(document.createTextNode("Il campo " + fieldName + " non può essere vuoto"));
    parent.appendChild(err);
}

function removeError(fieldName) {
    var field = document.getElementById(fieldName);
    var parent = field.parentNode;
    if (parent.children.length == 2) {
        parent.removeChild(parent.children[1]);
    }
}

function isEmpty(field) {
    console.log(field.value);
    return (field.value == "");
}

function validate() {
    isOK = true;
    removeError("utente");
    removeError("password");
    if(isEmpty(document.getElementById("utente"))) {
        isOK = false;
        showError("utente");
    }
    if(isEmpty(document.getElementById("password"))) {
        isOK = false;
        showError("password");
    }
    return isOK;
}