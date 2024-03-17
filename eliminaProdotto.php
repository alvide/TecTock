<?php

    if(!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
        header('Location: ./index.html');
    }

    require_once "./connections.php";

    $connection = new Database;


    $id = $_GET['id'];
try{
    if ($connection->OpenConnection()) {
        $query = "DELETE FROM prodotto WHERE ID = $id";
        $trovaImmagine = "SELECT immagine FROM prodotto WHERE ID = $id";
        $nomeImmagine = ($connection->EseguiQuery($trovaImmagine))->fetch_assoc();
        $file_path = './images/' . $nomeImmagine['immagine'];
        $result = $connection->EseguiQuery($query); 
        if ($result) {
            if (file_exists($file_path)) {
                unlink($file_path);
            } 
            header('Location: ./prodotti.php');
        } else {
            echo "No product found with ID: $id";   //page 404
        }
    }
}catch(Exception $e) {
    header("Location: ./html/500.html");
    
}
?>

