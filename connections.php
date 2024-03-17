<?php

class Database {
    private const HOST_DB = "127.0.0.1";
    private const DATABASE_NAME = "dmaffei";
    private const USERNAME = "root";
    private const PASSWORD = "";

    private $connection;

    public function OpenConnection() {
        
        $this->connection = new mysqli(self::HOST_DB, self::USERNAME, self::PASSWORD, self::DATABASE_NAME);

        if ($this->connection->connect_error) {
            throw new Exception("Errore di connessione: " . $this->connection->connect_error);
        } else {
            return true;
        }
    }

    public function SanitizeString($string) {
        // Utilizza la funzione real_escape_string per sanificare la stringa
        return $this->connection->real_escape_string($string);
    }
    

    public function EseguiQuery($query) {
        $result = $this->connection->query($query);

        if ($result === false) {
            echo "Errore nella query: " . $this->connection->error;
        }

        return $result;
    }
    
    public function ConnectionState(){
        return $this->connection;
    }

    public function CloseConnection() {
        $this->connection->close();
    }

    public function getWatches($query = "SELECT * FROM prodotto ORDER BY nomeorologio ASC") {
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in openDBConnection: " . mysqli_error($this->connection));

        if (mysqli_num_rows($queryResult) == 0) {
            return null;
        }
        else {
            $result = array();
            while ($riga = mysqli_fetch_assoc($queryResult)) {
                array_push($result, $riga);
            }
            $queryResult->free();
            return $result;
        }
    }
}
?>
