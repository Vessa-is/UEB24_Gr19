<?php
function myErrorHandler($errno, $errstr, $errfile, $errline) {
    error_log("Gabim [$errno]: $errstr në $errfile në linjën $errline", 3, "error.log");
    echo "Ndodhi një gabim. Ju lutemi kontaktoni administratorin.";
}
set_error_handler("myErrorHandler");

class DatabaseConnection {
    private $server = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "radiant";
    public $conn; 

    public function startConnection() {
        try {
            if (!$this->conn) {
                $this->conn = new PDO(
                    "mysql:host=$this->server;dbname=$this->database",
                    $this->username,
                    $this->password
                );
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return $this->conn;
        } catch(PDOException $e) {
            error_log("Gabim lidhjeje: " . $e->getMessage(), 3, "error.log");
            echo "Database Connection Failed. Ju lutemi kontrolloni konfigurimin.";
            return null;
        }
    }

    public function createUsersTable() {
        $this->startConnection();
        if (!$this->conn) {
            echo "Nuk mund të krijohet tabela sepse lidhja me databazën dështoi.";
            return;
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
            error_log("Gabim gjatë krijimit të tabelës: " . $e->getMessage(), 3, "error.log");
            echo "Gabim gjatë krijimit të tabelës. Ju lutemi kontaktoni administratorin.";
        }
    }
}
?>
