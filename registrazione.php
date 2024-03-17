<?php
require_once "./connections.php";


$registrazione = file_get_contents('./html/registrazione.html');
$errore = "";
$username = "";
$password = "";
$email = "";
$nome = "";

function validateUsername($value) {
    return preg_match("/^[a-zA-Z0-9_.-]+$/", $value);
}

function validatePassword($value) {
    return preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $value);
}

function validateEmail($value) {
    return preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $value);
}

function validateNome($value) {
    return preg_match("/^[a-zA-Z]+$/", $value);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nome = $_POST['nome'];

    //username
    if(strlen($username) == 0){
        $errore .= "<li> Lo Username non può essere vuoto</li>";
    }else{
        $username = strip_tags($username);
        if(!validateUsername($username)){
            $errore .= "<li> Username non corretto. Si prega di utilizzare solo lettere (minuscole o maiuscole), numeri, punti, trattini bassi o trattini.</li>";
        }
    }
    //password
    if(strlen($password) == 0){
        $errore .= "<li> La password non può essere vuota</li>";
    }else{
        $password = strip_tags($password);
        if(!validatePassword($password)){
            $errore .= "<li> La password deve contenere almeno una lettera (sia maiuscola che minuscola), un numero e almeno un carattere speciale tra @, $, !, %, *, ?, &. La lunghezza minima richiesta è di 8 caratteri.</li>";
        }
    }
    //email
    if(strlen($email) == 0){
        $errore .= "<li> L' E-mail non può essere vuota</li>";
    }else{
        $email = strip_tags($email);
        if(!validateEmail($email)){
            $errore .= "<li> L'indirizzo email inserito non è valido. Assicurati di inserire un indirizzo email corretto, come ad esempio 'nome@dominio.com'. </li>";
        }
    }
    //nome
    if(strlen($nome) == 0){
        $errore .= "<li> Il nome non può essere vuoto</li>";
    }else{
        $nome = strip_tags($nome);
        if(!validateNome($nome)){
            $errore .= "<li> Il nome deve contenere solo lettere minuscole e maiuscole. </li>";
        }
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

if($errore == ""){

    $db = new Database();
    try{
        $db->OpenConnection();
    }catch(Exception $e) {
        header("Location: ./html/500.html");
        
    }

    $username = $db->SanitizeString($username);
    $password = $db->SanitizeString($password);
    $nome = $db->SanitizeString($nome);
    $email = $db->SanitizeString($email);
    $query = "INSERT INTO utente (nome, username, email, password, admin) VALUES ('$nome', '$username', '$email', '$hashed_password', 0)";
    $result = $db->EseguiQuery($query);

    if ($result === true) {
        header("Location: ./login.php");
        exit();
    } else {
        $errore = "Errore durante la registrazione: " . $db->ConnectionState()->error;
    }

    $db->CloseConnection();
}
}

$registrazione = str_replace("%USERNAME%", $username, $registrazione);
$registrazione = str_replace("%PASSWORD%", $password, $registrazione);
$registrazione = str_replace("%EMAIL%", $email, $registrazione);
$registrazione = str_replace("%NOME%", $nome, $registrazione);
$registrazione = str_replace("%ERRORE%", $errore, $registrazione);
echo $registrazione;
?>

