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
function validateNome() {
    return validateInput("nomeorologio", "NomeOrologio", /^[a-zA-Z0-9\s\-.,;:\'\(\)]*$/, "Sono concessi lettere, numeri, spazi e trattini.");
}

function validateDescOr() {
    return validateInput("descrizione", "DescrizioneOrologio", /^[a-zA-ZÀ-ÖÙ-öÙ-Ú0-9\s\-.,;:'\(\)]*$/, "Sono concessi lettere, numeri, spazi, trattini e segni di punteggiatura.");
}

function validateDescImg() {
    return validateInput("descImmagine", "DescrizioneImmagine", /^[a-zA-ZÀ-ÖÙ-öÙ-Ú0-9\s\-.,;:'\(\)]*$/, "Sono concessi lettere, numeri, spazi, trattini e segni di punteggiatura.");
}

function validateMatOr() {
    return validateInput("materiale", "MaterialeOrologio", /^[a-zA-Z\-\ ]+$/, "Sono concessi lettere, spazi e trattini");
}

function validateModOr() {
    return validateInput("modello", "ModelloOrologio", /^[a-zA-Z0-9\-\ ]+$/, "Sono concessi lettere, numeri, spazi e trattini.");
}

function validatePeso() {
    return validateInput("peso", "PesoOrologio", /^\d+(\.\d+)?$/, "Il peso è in grammi. Sono concessi solo numeri. Per i decimali mettere il punto.");
}

function validatePrezzoOr() {
    return validateInput("prezzo", "PrezzoOrologio", /^\d+(\.\d+)?$/, "Sono concessi solo numeri. Per i decimali mettere il punto.");
}

function validateMarcaOr() {
    return validateInput("marca", "MarcaOrologio", /^[a-zA-Z0-9\-\ ]+$/, "Sono concessi lettere, numeri, spazi e trattini.");
}

function validateDimCassa() {
    return validateInput("dimensioniCassa", "DimensioneCassa", /^[a-zA-Z0-9\-\ ]+$/, "Sono concessi numeri e lettere. Sono tre dimensioni");
}

function validateMisCassa() {
    return validateInput("misuraCassa", "MisuraCassa", /^[a-zA-Z\-\ ]+$/, "Sono concessi lettere e spazi.");
}

function validateFormaCassa() {
    return validateInput("forma", "FormaCassa", /^[a-zA-Z\-\ ]+$/, "Sono concessi lettere e spazi.");
}

function validateDimCinturino() {
    return validateInput("dimensioniCinturino", "DimensioneCinturino", /^[a-zA-Z0-9\-\ ]+$/, "Sono concessi numeri e lettere. Sono due dimensioni");
}

function validateMatCinturino() {
    return validateInput("materialeCinturino", "MaterialeCinturino", /^[a-zA-Z0-9\-\ ]+$/, "Sono concessi lettere, spazi e trattini.");
}
