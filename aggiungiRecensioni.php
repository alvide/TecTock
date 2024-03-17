<?php
session_start();
require_once "./connections.php";

$aggiungiRecensione = "";

// Funzioni di validazione
function validatePunteggio($value) {
    return preg_match('/^(10|[1-9])$/', $value);
}

function validateComment($value) {
    return preg_match("/^[a-zA-Z0-9.,!?'\s]+$/", $value);
}

$errore = "";  // Dichiarazione della variabile $errore

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Carica la sezione di aggiunta recensione solo se l'utente è loggato
    $aggiungiRecensione = file_get_contents("html/aggiungiRecensioni.html");

    // Gestione benvenuto
    $saluto = "<h1>Benvenuto nella tua Area Personale " . htmlspecialchars($_SESSION['username']) . "!</h1>";
    $aggiungiRecensione = str_replace("<!--SALUTO-->", $saluto, $aggiungiRecensione);

    // Carica prodotti
    $db = new Database();
    $db->OpenConnection();

    $query = "SELECT nomeorologio FROM prodotto";
    $result = $db->EseguiQuery($query);

    $prodotti = '';

    while ($row = $result->fetch_assoc()) {
        $prodotti .= '<option value="' . htmlspecialchars($row['nomeorologio']) . '">' . htmlspecialchars($row['nomeorologio']) . '</option>';
    }

    $aggiungiRecensione = str_replace("<!--PRODOTTI-->", $prodotti, $aggiungiRecensione);
    
    try{
        $db->CloseConnection();
    }catch(Exception $e) {
        header("Location: ./html/500.html");
    
    }

    // Processa l'aggiunta della recensione
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ID = $_SESSION['ID'];
        $prodotto = $_POST["prodotto"];
        $punteggio = $_POST["valutazione"];
        $contenuto = $_POST["commento"];
        
        // Validazione dei dati
        if (strlen($punteggio) == 0) {
            $errore .= "<li>Il punteggio non può essere vuoto</li>";
        } else {
            $punteggio = strip_tags($punteggio);
            if (!validatePunteggio($punteggio)) {
                $errore .= "<li>Punteggio non corretto. Si prega di utilizzare solo numeri in un range tra 1 e 10.</li>";
            }
        }

        if (strlen($contenuto) == 0) {
            $errore .= "<li>Il commento non può essere vuoto</li>";
        } else {
            $contenuto = strip_tags($contenuto);
            if (!validateComment($contenuto)) {
                $errore .= "<li>Commento non corretto. Esso può contenere solo caratteri alfanumerici, spazi e alcuni segni di punteggiatura.</li>";
            }
        }

        $aggiungiRecensione = str_replace("%PUNTEGGIO%", $punteggio, $aggiungiRecensione);

        if ($errore == "") {
            $db = new Database();
            $db->OpenConnection();

            $contenuto = $db->SanitizeString($contenuto);

            $query = "INSERT INTO recensione (utente, prodotto, contenuto, punteggio) VALUES ('$ID',(SELECT ID FROM prodotto WHERE nomeorologio = '$prodotto'), '$contenuto', '$punteggio');";
            $result = $db->EseguiQuery($query);

            if ($result) {
                echo "Recensione inserita con successo";
                header("Location: ./recensioni.php");
                exit();
            } else {
                echo "Problemi guai malanni";
            }

            $db->CloseConnection();
        }
    }
} else {
    header("Location: ./login.php");
    exit();
}

$aggiungiRecensione = str_replace("<!--ERRORE-->", $errore, $aggiungiRecensione);
echo $aggiungiRecensione;
?>
