<?php
session_start();
require_once "./connections.php";

$errore = "";

// Funzioni di validazione
function validatePunteggio($value) {
    return preg_match('/^(10|[1-9])$/', $value);
}

function validateComment($value) {
    return preg_match("/^[a-zA-Z0-9.,!?'\s]+$/", $value);
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $IDRecensione = $_GET['id'];

        $db = new Database();
        try{
            $db->OpenConnection();
        }catch(Exception $e) {
            header("Location: ./html/500.html");
            
        }

        $query = "SELECT p.nomeorologio AS NomeProdotto, r.punteggio FROM recensione r INNER JOIN prodotto p ON r.prodotto = p.ID WHERE r.ID = $IDRecensione AND r.utente = " . $_SESSION['ID'];
        $result = $db->EseguiQuery($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nomeProdotto = $row["NomeProdotto"];
            $punteggio = $row["punteggio"];

            $singolaRecensione = file_get_contents('./html/modificaRecensione.html');
            $singolaRecensione = str_replace("placeHolderID", $IDRecensione, $singolaRecensione);
            $singolaRecensione = str_replace("%PRODOTTO%", $nomeProdotto, $singolaRecensione);
            $singolaRecensione = str_replace("69696969", $punteggio, $singolaRecensione);

            $db->CloseConnection();

            // Processa l'aggiunta della recensione
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $contenuto = $_POST['commento'];
                $punteggio = $_POST['valutazione'];

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

                if ($errore == "") {
                    $db = new Database();
                    $db->OpenConnection();

                    $contenuto = $db->SanitizeString($contenuto);
                    $query = "UPDATE recensione SET contenuto = '$contenuto', punteggio = '$punteggio' WHERE ID = '$IDRecensione'";
                    $result = $db->EseguiQuery($query);

                    if ($result === true) {
                        header("Location: ./recensioni.php");
                        exit();
                    } else {
                        echo "Errore durante il salvataggio dei dati: " . $db->ConnectionState()->error;
                    }

                    $db->CloseConnection();
                }
            } 
        } else {
            echo "<p>Recensione non trovata.</p>";
        }
    } else {
        header("Location: ./login.php");
        exit();
    }
}

$singolaRecensione = str_replace("%ERRORE%", $errore, $singolaRecensione);
echo $singolaRecensione;
?>
