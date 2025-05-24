<?php

class DatabaseConnection {
    private $server = "metro.proxy.rlwy.net";
    private $port = "42104";
    private $username = "postgres";
    private $password = "hYvQCxIaVYdbTJJdqhPWdWfJbjVxaSTe";
    private $database = "railway";

    public function startConnection() {
        try {
            $conn = new PDO("pgsql:host=$this->server;port=$this->port;dbname=$this->database", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Database Connection Failed: " . $e->getMessage();
            return null;
        }
    }
}

$db = new DatabaseConnection();
$conn = $db->startConnection();

?>