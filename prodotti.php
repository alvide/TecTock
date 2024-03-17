<?php
    function tagliaStringa($testo) {
        $numeroParole = 20;
        $parole = explode(' ', $testo);

        // Verifica se ci sono abbastanza parole
        if (count($parole) > $numeroParole) {
            $paroleTagliate = array_slice($parole, 0, $numeroParole);
            $testoTagliato = implode(' ', $paroleTagliate);

            $testoTagliato .= ' ...';

            return $testoTagliato;
        } else {
            return $testo;
        }
    }


    session_start();
    require_once "./connections.php";

    $pageID = 'prodotti';
    $title = "Prodotti - TecTock";

    $HTMLpage = file_get_contents("./html/prodotti.html");
    $connection = new Database;
    

    $content = '<h1>I Nostri Prodotti</h1>';

    $listText = '';


    $bottoniAdmin = '';
    

    if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        $bottoniAdmin = '<div class="container"><a class="button" href="aggiungiProdotto.php" id="addProductButton">Aggiungi un prodotto</a></div>';
    }

    $HTMLpage = str_replace("<!--bottoniAdmin-->", $bottoniAdmin,  $HTMLpage);
    
    $orderby = '';

    if (isset($_GET['order'])) {
        $order = $_GET['order'];
        if($order == 'name') {
            $orderby = 'ORDER BY nomeorologio ASC';
        } else if ($order == 'lowest_price') {
            $orderby = 'ORDER BY prezzo ASC';
        } else if ($order == 'highest_price') {
            $orderby = 'ORDER BY prezzo DESC';
        }
    }



    $query = "SELECT * FROM prodotto " . $orderby;
    try{
        if ($connection->OpenConnection()) {
            $products = $connection->getWatches($query);
            $connection->closeConnection();

            if ($products != null) {
                foreach ($products as $product) {
                    //$descrizione = $product['descrizione'];
                    $descrizione = tagliaStringa($product['descrizione']);
                    $listText .= '<div class="card-watch">' .
                        '<img src="images/' . $product['immagine'] . '"  alt="' . $product['keywords'] . '" >' .
                        '<h3>' . $product['nomeorologio'] . '</h3>' .
                        '<p>' . $descrizione . '</p>' .
                        '<p class="price">' . $product['prezzo'] . '</p>' .
                        '<a class="button" href="./prodotto.php?id=' . $product['ID'] . '">Visualizza</a>' .
                        '</div>';
                }
            } else {
                $listText = "<p class='info'>Nessun prodotto presente..</p>";
            }
        }
    }catch(Exception $e) {
        header("Location: ./html/500.html");
        
    }
    echo str_replace("<!--listaProdotti-->", $listText,  $HTMLpage);

    ?>

