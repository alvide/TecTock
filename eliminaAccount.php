<?php
session_start();
require_once "./connections.php";

$db = new Database();
try{
    $db->OpenConnection();
}catch(Exception $e) {
    header("Location: ./html/500.html");
}

$deleteReviewsQuery = "DELETE FROM recensione WHERE `recensione`.`utente` = " . htmlspecialchars($_SESSION['ID']);

$deleteUserQuery = "DELETE FROM utente WHERE  `utente`.`ID` = " . htmlspecialchars($_SESSION['ID']);


$result = $db->EseguiQuery($deleteReviewsQuery);
$result = $db->EseguiQuery($deleteUserQuery);

if ($result === true) {
    echo "Eliminazione avvenuta con successo!";
    //Elimina tutte le variabili di sessione
    $_SESSION = array();
    //Distrugge la sessione
    session_destroy();
    header("Location: ./login.php");
    exit();
} else {
    echo "Errore durante l'eliminazione: " . $db->ConnectionState()->error;
}
$db->CloseConnection();

?>