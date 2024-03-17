<?php
session_start();
require_once "./connections.php";

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

$ID = $_SESSION['ID'];

//Gestione benvenuto
$recensioni = file_get_contents('html/recensioni.html');
$saluto = "Benvenuto nella tua Area Personale " . htmlspecialchars($_SESSION['username']) . "!";
$recensioni = str_replace("%SALUTO%", $saluto, $recensioni);

$db = new Database();

try{
    $db->OpenConnection();
}catch(Exception $e) {
    header("Location: ./html/500.html");
    
}

$query = "SELECT p.nomeorologio AS NomeProdotto, r.contenuto, r.punteggio, r.id FROM recensione r INNER JOIN prodotto p ON r.prodotto = p.ID WHERE r.utente = '$ID'";
$result = $db->EseguiQuery($query);

if ($result->num_rows > 0) {

    $content = file_get_contents('./html/recensioniContent.html');
    $prodottiContent = '';

    while($row = $result->fetch_assoc()) {
        $IDRecensione = $row["id"];
        $nomeProdotto = $row["NomeProdotto"];
        $punteggio = $row["punteggio"];

        $tempContent = str_replace("%PRODOTTO%", $nomeProdotto, $content);
        $tempContent = str_replace("%PUNTEGGIO%", $punteggio, $tempContent);
        $tempContent = str_replace("placeholderID", $IDRecensione, $tempContent);
        $prodottiContent .= $tempContent;
    }

    $recensioni = str_replace("%CONTENT%", $prodottiContent, $recensioni);
    
} else {
    $content = "<p>Nessuna recensione disponibile!</p>";
    $recensioni = str_replace("%CONTENT%", $content, $recensioni);
}


$recensioni = str_replace("%CONTENT%", $content, $recensioni);

echo $recensioni;

}else{ 
    header("Location: ./login.php");
    exit();
}
?>