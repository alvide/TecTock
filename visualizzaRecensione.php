<?php
session_start();
require_once "./connections.php";

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $IDRecensione = $_GET['id'];

        $db = new Database();
        $db->OpenConnection();

        $query = "SELECT p.nomeorologio AS NomeProdotto, r.contenuto, r.punteggio FROM recensione r INNER JOIN prodotto p ON r.prodotto = p.ID WHERE r.ID = $IDRecensione AND r.utente = " . $_SESSION['ID'];
        $result = $db->EseguiQuery($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nomeProdotto = $row["NomeProdotto"];
            $contenutoRecensione = $row["contenuto"];
            $punteggio = $row["punteggio"];

            $singolaRecensione = file_get_contents('./html/visualizzaRecensione.html');
            $singolaRecensione = str_replace("%PRODOTTO%", $nomeProdotto, $singolaRecensione);
            $singolaRecensione = str_replace("%CONTENUTO%", $contenutoRecensione, $singolaRecensione);
            $singolaRecensione = str_replace("%PUNTEGGIO%", $punteggio, $singolaRecensione);

            echo $singolaRecensione;

        } else {
            echo "<p>Recensione non trovata.</p>";
        }

        $db->CloseConnection();
    } else {
        echo "<p>ID della recensione non valido.</p>";
    }
} else {
    header("Location: ./login.php");
    exit();
}
?>
