<?php
session_start();
require_once "./connections.php";

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
//Gestione benvenuto
$areaRiservata = file_get_contents('./html/areaRiservata.html');
$saluto = "Benvenuto nella tua Area Personale " . htmlspecialchars($_SESSION['username']) . "!";
$areaRiservata = str_replace("%SALUTO%", $saluto, $areaRiservata);

//Gestione contenuto
$contenutoUser = file_get_contents('./html/areaUser.html');
$contenutoAdmin = file_get_contents('./html/areaAdmin.html');

if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
    $areaRiservata = str_replace("%CONTENUTO%", $contenutoAdmin, $areaRiservata);
}else{
    $areaRiservata = str_replace("%CONTENUTO%", $contenutoUser, $areaRiservata);
}

//Gestione info profilo
$nome = htmlspecialchars($_SESSION['nome']);
$areaRiservata = str_replace("%NOME%", $nome, $areaRiservata);
$username = htmlspecialchars($_SESSION['username']);
$areaRiservata = str_replace("%USERNAME%", $username, $areaRiservata);
$email = htmlspecialchars($_SESSION['email']);
$areaRiservata = str_replace("%EMAIL%", $email, $areaRiservata);
$password = htmlspecialchars($_SESSION['password']);
$areaRiservata = str_replace("%PASSWORD%", $password, $areaRiservata);

echo $areaRiservata;
}else{
    header("Location: ./login.php");
    exit();
}

?>

