<?php

class Database {
    private const HOST_DB = "127.0.0.1";
    private const DATABASE_NAME = "tectock";
    private const USERNAME = "root";
    private const PASSWORD = "";

    private $connection;

    public function OpenConnection() {
        $this->connection = new mysqli(self::HOST_DB, self::USERNAME, self::PASSWORD, self::DATABASE_NAME);

        if ($this->connection->connect_error) {
            die("Connessione al database fallita: " . $this->connection->connect_error);
        }
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
}
?>
