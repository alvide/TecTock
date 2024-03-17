<?php
    session_start();
    require_once "./connections.php";

    $connection = new Database;

    $HTMLpage = file_get_contents("./html/aggiungiProdotto.html");

    

    if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) ) {      
        header('Location: ./prodotti.php');
        exit();
    } else {
        if(!(isset($_SESSION['admin']) && $_SESSION['admin'] == 1)) {
            header('Location: ./prodotti.php');
            exit();
        }
    }

    /*stringa che compare all'utente se sbaglia ad inserire. questa var la uso per controllare se il form è valido prima di fare la query*/ 
    $errore = "";

    $nomeorologio = "";
    $descrizione = "";
    $descImmagine = "";
    $materiale = "";
    $modello = "";
    $replaceSesso = '<option value="uomo" selected>Uomo</option> <option value="donna">Donna</option>';
    $peso = "0.00";
    $prezzo = "0.00";
    $dimensioniCassa = "";
    $misuraCassa =  "";
    $forma = "";
    $dimensioniCinturino =  "";
    $materialeCinturino = "";
    $marcaToAdd = "";

    
    function AllowNumbers($value) {
        return preg_match("/^[a-zA-Z0-9\-\ ]+$/", $value);
    }

    function AllowPunctuation($value) {
        return preg_match("/^[a-zA-ZÀ-ÖÙ-öÙ-Ú0-9\s\-.,;:'\(\)]*$/", $value);
    }
    
    function NoNumbers($value) {
        return preg_match("/^[a-zA-Z\-\ ]+$/", $value);
    }

    function OnlyNumbersWithComma($value) {
        return preg_match("/^[0-9.]+$/", $value);
    }

    function Alphanumeric($value) {
        return preg_match("/^[a-zA-Z0-9]+$/", $value);
    }

    function LettersAndSpaces($value) {
        return preg_match("/^[a-zA-Z\s]+$/", $value);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recupera i valori dai campi del form
        $nomeorologio = $_POST["nomeorologio"];
        $descrizione = $_POST["descrizione"];
        $descImmagine = $_POST["descImmagine"];
        $materiale = $_POST["materiale"];
        $modello = $_POST["modello"];
        $sesso = $_POST["sesso"];
        $peso = $_POST["peso"];
        $prezzo = $_POST["prezzo"];
        $dimensioniCassa = $_POST["dimensioniCassa"];
        $misuraCassa = $_POST["misuraCassa"];
        $forma = $_POST["forma"];
        $dimensioniCinturino = $_POST["dimensioniCinturino"];
        $materialeCinturino = $_POST["materialeCinturino"];
        $marcaToAdd = $_POST["marca"];
    }

    $pageID = 'prodotti';
    $title = "Prodotti - TecTock";
    

    $listText = '';

    if(isset($_POST['formSubmit']))
    {

        if(strlen($nomeorologio) == 0)
        {
            $errore .= "<li> Il nome dell'orologio non può essere vuoto</li>";
        }else
        {
            $nomeorologio = strip_tags($nomeorologio);
            if(!AllowNumbers($nomeorologio))
            {
                $errore .= "<li> Il nome dell'orologio può contenere solo lettere, numeri, spazi e trattini</li>";
            }
        }

        if(strlen($descrizione) == 0)
        {
            $errore .= "<li> La descrizione non può essere vuota</li>";
        }else
        {
            $descrizione = strip_tags($descrizione);
            if(!AllowPunctuation($descrizione))
            {
                $errore .= "<li> La descrizione può contenere solo lettere, numeri, spazi, trattini e segni di punteggiatura</li>";
            }
        }

        if(strlen($descImmagine) == 0)
        {
            $errore .= "<li> La descrizione dell'immagine non può essere vuota</li>";
        }else
        {
            $descImmagine = strip_tags($descImmagine);
            if(!AllowPunctuation($descImmagine))
            {
                $errore .= "<li> La descrizione dell'immagine può contenere solo lettere, numeri, spazi, trattini e segni di punteggiatura</li>";
            }
        }

        if(strlen($materiale) == 0)
        {
            $errore .= "<li> Il materiale non può essere vuoto</li>";
        }else
        {
            $materiale = strip_tags($materiale);
            if(!AllowNumbers($materiale))
            {
                $errore .= "<li> Il materiale può contenere solo lettere, numeri, spazi e trattini</li>";
            }
        }

        if(strlen($modello) == 0)
        {
            $errore .= "<li> Il modello non può essere vuoto</li>";
        }else
        {
            $modello = strip_tags($modello);
            if(!AllowNumbers($modello))
            {
                $errore .= "<li> Il modello può contenere solo lettere, numeri, spazi e trattini</li>";
            }
        }

        if($sesso == "uomo")
            $replaceSesso = str_replace('<option value="uomo" selected>Uomo</option>','<option value="uomo" selected>Uomo</option>', $replaceSesso);
        if($sesso == "donna")
            $replaceSesso = str_replace('<option value="donna">Donna</option>','<option value="donna" selected>Donna</option>', $replaceSesso);

        if(strlen($peso) == 0)
        {
            $errore .= "<li> Il peso non può essere vuoto</li>";
        }else
        {
            $peso = strip_tags($peso);
            if(!OnlyNumbersWithComma($peso))
            {
                $errore .= "<li> Il peso può contenere solo numeri interi e decimali con il punto</li>";
            }
        }

        if(strlen($prezzo) == 0)
        {
            $errore .= "<li> Il prezzo non può essere vuoto</li>";
        }else
        {
            $prezzo = strip_tags($prezzo);
            if(!OnlyNumbersWithComma($prezzo))
            {
                $errore .= "<li> Il prezzo può contenere solo numeri interi e decimali con il punto</li>";
            }
        }

        if(strlen($dimensioniCassa) == 0)
        {
            $errore .= "<li> Le dimensioni della cassa non possono essere vuote</li>";
        }else   
        {
            $dimensioniCassa = strip_tags($dimensioniCassa);
            if(!Alphanumeric($dimensioniCassa))
            {
                $errore .= "<li> Le dimensioni della cassa possono contenere solo numeri e lettere</li>";
            }
        }

        if(strlen($misuraCassa) == 0)
        {
            $errore .= "<li> La misura della cassa non può essere vuota</li>";
        }else
        {
            $misuraCassa = strip_tags($misuraCassa);
            if(!LettersAndSpaces($misuraCassa))
            {
                $errore .= "<li> La misura della cassa può contenere solo lettere e spazi /li>";
            }
        }

        if(strlen($forma) == 0)
        {
            $errore .= "<li> La forma della cassa non può essere vuota</li>";
        }else
        {
            $forma = strip_tags($forma);
            if(!LettersAndSpaces($forma))
            {
                $errore .= "<li> La misura della cassa può contenere solo lettere e spazi /li>";
            }
        }

        if(strlen($dimensioniCinturino) == 0)
        {
            $errore .= "<li> Le dimensioni del cinturino non possono essere vuote</li>";
        }else
        {
            $dimensioniCinturino = strip_tags($dimensioniCinturino);
            if(!Alphanumeric($dimensioniCinturino))
            {
                $errore .= "<li> Le dimensioni del cinturino possono contenere solo lettere e numeri </li>";
            }
        }

        if(strlen($materialeCinturino) == 0)
        {
            $errore .= "<li> Il materiale del cinturino non può essere vuoto</li>";

        }else
        {
            $materialeCinturino = strip_tags($materialeCinturino);
            if(!NoNumbers($materialeCinturino))
            {
                $errore .= "<li> Il materiale del cinturino può contenere solo lettere, spazi e trattini</li>";
            }
        }

        if(strlen($marcaToAdd) == 0)
        {
            $errore .= "<li> La marca non può essere vuota</li>";
        }else
        {
            $marcaToAdd = strip_tags($marcaToAdd);
            if(!NoNumbers($marcaToAdd))
            {
                $errore .= "<li> La marca può contenere solo lettere, spazi e trattini</li>";
            }
        }

        if($errore == "") {
            try{
                if ($connection->OpenConnection()) {    //Connessione ok 
                
                    $name = explode(".", $_FILES["formImage"]["name"]);
                    if(end($name) == "webp") { // IMMAGINE COL FORMATO GIUSTO
                        $image = $_FILES["formImage"]["tmp_name"];
                        $path = "images/".$nomeorologio."." . end($name);
                        if(move_uploaded_file($image,$path)) { // FILE SPOSTATO CORRETTAMENTE
                            $queryMarca = "INSERT INTO marca (nomemarca) VALUES ('".$marcaToAdd."');";
                            $connection->EseguiQuery($queryMarca);
                            $queryTrovaMarca = "SELECT ID FROM marca WHERE nomemarca = '".$marcaToAdd."';";
                            $marca = ($connection->EseguiQuery($queryTrovaMarca))->fetch_assoc();
                            $descImmagine = $connection->SanitizeString($descImmagine);
                            $descrizione = $connection->SanitizeString($descrizione);
                            $queryCassa = "INSERT INTO cassa (dimensioni, misura, forma) VALUES ('".$dimensioniCassa."', '".$misuraCassa."', '".$forma."');";
                            $connection->EseguiQuery($queryCassa);
                            $queryTrovaCassa = "SELECT ID FROM cassa WHERE dimensioni = '".$dimensioniCassa."' AND misura = '".$misuraCassa."' AND forma = '".$forma."';";
                            $cassa = ($connection->EseguiQuery($queryTrovaCassa))->fetch_assoc();
                            $queryCinturino = "INSERT INTO cinturino (dimensioni, materiale) VALUES ('".$dimensioniCinturino."', '".$materialeCinturino."');";
                            $connection->EseguiQuery($queryCinturino);
                            $queryTrovaCinturino = "SELECT ID FROM cinturino WHERE dimensioni = '".$dimensioniCinturino."' AND materiale = '".$materialeCinturino."';";
                            $cinturino = ($connection->EseguiQuery($queryTrovaCinturino))->fetch_assoc();
                            $queryOrologio = "INSERT INTO prodotto (nomeorologio, immagine, descrizione, keywords, materiale, modello, sesso, peso, prezzo, cinturino, cassa, nomemarca) VALUES (
                                                '".$nomeorologio."',
                                                '".$nomeorologio.".webp',
                                                '".$descrizione."',
                                                '".$descImmagine."',
                                                '".$materiale."',
                                                '".$modello."',
                                                '".($sesso == "maschio" ? "m" : "f" )."',
                                                '".$peso."',
                                                ".$prezzo.",
                                                ".$cinturino["ID"].",
                                                ".$cassa["ID"].",
                                                ".$marca["ID"].");";
                            header("Location: ./prodotti.php");
                        }
                    if($connection->EseguiQuery($queryOrologio)) {}
                    }
                }
            }catch(Exception $e) {
                header("Location: ./html/500.html");
                
            }
        }
    }

    if($errore != "") {
        $HTMLpage = str_replace('<!--messaggiErrore-->', '<div class="formGroup" id="errori"><!--messaggiErrore--></div>', $HTMLpage);
        $HTMLpage = str_replace('<!--messaggiErrore-->', $errore, $HTMLpage);
    }

    $HTMLpage = str_replace('<validateNome/>', $nomeorologio, $HTMLpage);
    $HTMLpage = str_replace('<validateDescOr/>', $descrizione, $HTMLpage);
    $HTMLpage = str_replace('<validateDescImg/>', $descImmagine, $HTMLpage);
    $HTMLpage = str_replace('<validateMatOr/>', $materiale, $HTMLpage);
    $HTMLpage = str_replace('<validateModOr/>', $modello, $HTMLpage);
    $HTMLpage = str_replace('<!--selectSessoReplace-->', $replaceSesso, $HTMLpage);
    $HTMLpage = str_replace('<validatePeso/>', $peso, $HTMLpage);
    $HTMLpage = str_replace('<validatePrezzoOr/>', $prezzo, $HTMLpage);
    $HTMLpage = str_replace('<validateDimCassa/>', $dimensioniCassa, $HTMLpage);
    $HTMLpage = str_replace('<validateMisCassa/>', $misuraCassa, $HTMLpage);
    $HTMLpage = str_replace('<validateFormaCassa/>', $forma, $HTMLpage);
    $HTMLpage = str_replace('<validateDimCinturino/>', $dimensioniCinturino, $HTMLpage);
    $HTMLpage = str_replace('<validateMatCinturino/>', $materialeCinturino, $HTMLpage);
    $HTMLpage = str_replace('<validateMarcaOr/>', $marcaToAdd, $HTMLpage);

    echo $HTMLpage;

?>