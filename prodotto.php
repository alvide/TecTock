<?php
    session_start();
    require_once "./connections.php";

    $HTMLpage = file_get_contents("./html/prodotto.html");
    $connection = new Database;

    $nomeProdotto = 'Visualizza prodotto';
    $content = '';

    $id = $_GET['id'];
    $queryMarca = "SELECT marca.nomemarca FROM prodotto JOIN marca ON prodotto.nomemarca = marca.ID WHERE prodotto.ID = $id;";
    $queryCinturino = "SELECT cinturino.dimensioni, cinturino.materiale FROM prodotto JOIN cinturino ON prodotto.cinturino = cinturino.ID WHERE prodotto.ID = $id;";


    try{
        if ($connection->OpenConnection()) {
            $query = "SELECT * FROM prodotto WHERE ID = $id";
            $marca = ($connection->EseguiQuery($queryMarca))->fetch_assoc();
            $cinturino = ($connection->EseguiQuery($queryCinturino))->fetch_assoc();

            $result = $connection->EseguiQuery($query); 
            if ($result) {
                $product = $result->fetch_assoc(); 

                $nomeProdotto = $product["nomeorologio"];

                $content .= '<div class="product-showcase">
                        <div class="product-images">
                            <img src="images/' . $product["immagine"] . '" alt="' . $product["keywords"] . '">
                        </div>
                        <div class="product-info">
                            <h2>' . $product["nomeorologio"] . '</h2>
                            <p>' . $product["descrizione"] . '</p>
                            <p><span>Materiale</span>: ' . $product["materiale"] . '</p>
                            <p><span>Modello</span>: ' . $product["modello"] . '</p>
                            <p><span>Sesso</span>: ' . ($product["sesso"] == 'm' ? 'Uomo' : 'Donna') . '</p>
                            <p><span>Peso</span>: ' . $product["peso"] . '</p>
                            <p><span>Cinturino</span>: ' . $cinturino["materiale"] . ', ' . $cinturino["dimensioni"] . '</p>
                            <p><span>Marca</span>: ' . $marca["nomemarca"] . '</p>
                            <p><span>Prezzo</span>: ' . $product["prezzo"] . '</p>
                            <!--bottoniAdmin-->
                        </div>
                    </div>';
            } else {
                echo "No product found with ID: $id";   //page 404
            }
        }
    }catch(Exception $e) {
            header("Location: ./html/500.html");
            
        }


    $bottoniAdmin = '<a href="eliminaProdotto.php?id='.$id.'" class="button">Elimina</a>';

    if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        $content = str_replace("<!--bottoniAdmin-->", $bottoniAdmin,  $content);
    } else {
        $content = str_replace("<!--bottoniAdmin-->", "",  $content);
    }

    $HTMLpage = str_replace("<!--nomeProdotto-->", $nomeProdotto,  $HTMLpage);
    echo str_replace("<!--prodotto-->", $content,  $HTMLpage);
?>

