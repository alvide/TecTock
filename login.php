<?php
session_start();

require_once "./connections.php"; 
$errore = "";
$username = "";
$password = "";

//Verifica se l'utente è già loggato
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: ./areaRiservata.php");
    exit();
} else {
    //Se l'utente non è loggato, mostra la pagina di login
    $login = file_get_contents('./html/login.html');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(strlen($username) == 0){
            $errore .= "<li> Lo Username non può essere vuoto</li>";
        }
        if(strlen($password) == 0){
            $errore .= "<li> La Password non può essere vuota</li>";
        }

        $username = strip_tags($username);
        $password = strip_tags($password);

        if($errore=="") {
            $db = new Database();
            try{
                $db->OpenConnection();
            }catch(Exception $e) {
                header("Location: ./html/500.html");
                
            }
            //Esecuzione Query
            $username = $db->SanitizeString($username);
            $password = $db->SanitizeString($password);
            $query = "SELECT * FROM utente WHERE username = '$username'";
            $result = $db->EseguiQuery($query);
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
    
                $hashed_password_from_db = $row['password'];
                $isAdmin = $row['admin'];
                $nome = $row['nome'];
                $email = $row['email'];
                $ID = $row['ID'];
    
    
                //Corrispondenza tra le due password
                if (password_verify($password, $hashed_password_from_db)) {
                    $_SESSION['logged_in'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['admin'] = $isAdmin;
                    $_SESSION['nome'] = $nome;
                    $_SESSION['email'] = $email;
                    $_SESSION['password'] = $password;
                    $_SESSION['ID'] = $ID;
                    header("Location: ./areaRiservata.php");
                    exit();
                } else {
                    $errore = "Credenziali Errate!";//password
                }
            } else {
                $errore = "Credenziali Errate!";//username
            }
    
            $db->CloseConnection();
        }

       
    }
    $login = str_replace("%USERNAME%", $username, $login);
    $login = str_replace("%ERRORE%", $errore, $login);
    echo $login;
}
?>
