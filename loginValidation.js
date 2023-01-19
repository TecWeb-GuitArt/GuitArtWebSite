function showError(field) {
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
}