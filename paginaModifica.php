<?php
session_start();
require_once "./connections.php";

// Funzioni di validazione
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

// Inizializzazione variabili
$errore = "";
$ID = $_SESSION['ID'];

if (!$ID) {
    header("Location: ./login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validazione dei dati
    if (strlen($username) == 0) {
        $errore .= "<li>Lo Username non può essere vuoto</li>";
    } else {
        $username = strip_tags($username);
        if (!validateUsername($username)) {
            $errore .= "<li>Username non corretto. Si prega di utilizzare solo lettere (minuscole o maiuscole), numeri, punti, trattini bassi o trattini.</li>";
        }
    }

    if (strlen($password) == 0) {
        $errore .= "<li>La password non può essere vuota</li>";
    } else {
        $password = strip_tags($password);
        if (!validatePassword($password)) {
            $errore .= "<li>La password deve contenere almeno una lettera (sia maiuscola che minuscola), un numero e almeno un carattere speciale tra @, $, !, %, *, ?, &. La lunghezza minima richiesta è di 8 caratteri.</li>";
        }
    }

    if (strlen($email) == 0) {
        $errore .= "<li>L' E-mail non può essere vuota</li>";
    } else {
        $email = strip_tags($email);
        if (!validateEmail($email)) {
            $errore .= "<li>L'indirizzo email inserito non è valido. Assicurati di inserire un indirizzo email corretto, come ad esempio 'nome@dominio.com'.</li>";
        }
    }

    if (strlen($nome) == 0) {
        $errore .= "<li>Il nome non può essere vuoto</li>";
    } else {
        $nome = strip_tags($nome);
        if (!validateNome($nome)) {
            $errore .= "<li>Il nome deve contenere solo lettere minuscole e maiuscole.</li>";
        }
    }

    // Se non ci sono errori di validazione, procedi con l'aggiornamento dei dati nel database
    if ($errore == "") {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

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
        $query = "UPDATE utente SET nome = '$nome', email = '$email', username = '$username', password = '$hashed_password' WHERE ID = '$ID'";
        $result = $db->EseguiQuery($query);

        if ($result === true) {
            echo "Modifica avvenuta con successo!";
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['admin'] = $isAdmin; // Assicurati di inizializzare $isAdmin
            $_SESSION['nome'] = $nome;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password; // Nota: Storing plain text password in session is not recommended for security reasons
            $_SESSION['ID'] = $ID;
            header("Location: ./areaRiservata.php");
            exit();
        } else {
            echo "Errore durante il salvataggio dei dati: " . $db->ConnectionState()->error;
        }

        $db->CloseConnection();
    }
}

// Carica la pagina HTML
$paginaModifica = file_get_contents('./html/paginaModifica.html');

// Gestione benvenuto e info profilo solo se l'utente è loggato
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $saluto = "Benvenuto nella tua Area Personale " . htmlspecialchars($_SESSION['username']) . "!";
    $paginaModifica = str_replace("%SALUTO%", $saluto, $paginaModifica);

    $paginaModifica = str_replace("%NOME%", htmlspecialchars($_SESSION['nome']), $paginaModifica);
    $paginaModifica = str_replace("%USERNAME%", htmlspecialchars($_SESSION['username']), $paginaModifica);
    $paginaModifica = str_replace("%EMAIL%", htmlspecialchars($_SESSION['email']), $paginaModifica);
    $paginaModifica = str_replace("%PASSWORD%", htmlspecialchars($_SESSION['password']), $paginaModifica);
}

$paginaModifica = str_replace("%ERRORE%", $errore, $paginaModifica);

// Stampa la pagina HTML
echo $paginaModifica;
?>
