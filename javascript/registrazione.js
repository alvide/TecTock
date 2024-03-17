// Funzione generica per il controllo di vuoto e valore corretto
function validateInput(inputId, hintId, regex, testobase) {
    const inputField = document.getElementById(inputId);
    const hintField = document.getElementById(hintId);
    const value = inputField.value.trim();

    if (value === "") {
        hintField.innerText = "Campo vuoto!";
        hintField.className = "pStyle messages";
        return false;
    } else if (!regex.test(value)) {
        hintField.innerText = "Valore non valido!";
        hintField.className = "pStyle messages";
        return false;
    } else {
        hintField.innerText = testobase;
        hintField.className = "pStyle";
        return true;
    }
}

// Controlli specifici per ciascun campo
function validateUsername() {
    return validateInput("username", "Username", /^[a-zA-Z0-9_.-]+$/, "Sono concessi lettere, numeri, spazi e trattini.");
}

function validatePass() {
    return validateInput("password", "Password", /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/, "Deve avere lettere minuscole e maiuscole, un numero, un carattere speciale e lunga minimo 8 caratteri.");
}

function validateEmail() {
    return validateInput("email", "Emal", /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/, "Inserire un indirizzo di posta valido.");
}

function validateNome() {
    return validateInput("nome", "Nome", /^[a-zA-Z]+$/, "Sono concesse solo lettere minuscole e maiuscole.");
}