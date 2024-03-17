<?php
session_start();
require_once "./connections.php";

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $IDRecensione = $_GET['id'];

        $db = new Database();
        try{
            $db->OpenConnection();
        }catch(Exception $e) {
            header("Location: ./html/500.html");
            
        }

        $query = "DELETE FROM recensione WHERE id = '$IDRecensione'";
        $result = $db->EseguiQuery($query);

        if($result === true){
            echo "eliminazione riuscita";
            header("Location: ./recensioni.php");
            exit();
        }else{
            echo "Errore durante l'eliminazione della recensione ";
        }
    }
} else {
    header("Location: ./login.php");
    exit();
}
?>
