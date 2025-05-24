<?php

class DatabaseConnection {
    private $server = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "radiant";
    public $conn; 

    public function startConnection() {
        try {
            $this->conn = new PDO(
                "mysql:host=$this->server;dbname=$this->database",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch(PDOException $e) {
            echo "Database Connection Failed: " . $e->getMessage();
            return null;
        }
    }
}
?>