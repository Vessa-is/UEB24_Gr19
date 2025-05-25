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

        public function createUsersTable() {
        if (!$this->conn) {
            $this->startConnection();
        }

        try {
            $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                emri VARCHAR(100) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                fjalekalimi VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";

            $this->conn->exec($sql);
            echo "Tabela 'users' u krijua me sukses!";
        } catch (PDOException $e) {
            echo "Gabim gjatë krijimit të tabelës: " . $e->getMessage();
        }
    }
}
?>