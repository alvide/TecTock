<?php
session_start();

//Elimina tutte le variabili di sessione
$_SESSION = array();

//Distrugge la sessione
session_destroy();

//Reindirizza l'utente alla pagina di login o ad altre pagine come desiderato
header("Location: ./login.php");
exit();
?>
