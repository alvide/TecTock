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

function validateTextarea(inputId, hintId, regex, testobase) {
    const textareaField = document.getElementById(inputId);
    const hintField = document.getElementById(hintId);
    const value = textareaField.value.trim();

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
function validateValutazione() {
    return validateInput("valutazione", "Valutazione", /^[1-9]|10$/, "Sono concessi solo numeri in un range tra 1 e 10.");
}

function validateCommento() {
    return validateTextarea("commento", "Commento", /^[a-zA-Z0-9.,!?'\s]+$/, "Sono concessi solo caratteri alfanumerici, spazi e alcuni segni di punteggiatura.");
}