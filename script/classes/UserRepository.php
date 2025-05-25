<?php

function myErrorHandler($errno, $errstr, $errfile, $errline) {
    echo "Gabim [$errno]: $errstr në fajllin $errfile në linjën $errline<br>";
}
set_error_handler("myErrorHandler");

require_once 'DatabaseConnection.php';

class UserRepository {
    private $conn;

    function __construct() {
        try {
            $conn = new DatabaseConnection;
            $this->conn = $conn->startConnection();
        } catch (PDOException $e) {
            echo "Gabim lidhjeje me databazën: " . $e->getMessage();
            exit;
        }
    }

    function insertUser($user) {
        try {
            $conn = $this->conn;

            $firstName = $user->getName();
            $lastName = $user->getLastName();
            $email = $user->getEmail();
            $password = $user->getPassword();
            $personalNr = $user->getPersonalNr();
            $birthdate = $user->getBirthdate();

            $sql = "INSERT INTO users (name, lastname, email, password, personalNr, birthdate) VALUES (?,?,?,?,?,?)";
            $statement = $conn->prepare($sql);
            $statement->execute([$firstName, $lastName, $email, $password, $personalNr, $birthdate]);

            return true;
        } catch (PDOException $e) {
            echo "Gabim në insertUser: " . $e->getMessage();
            return false;
        }
    }

    function getAllUsers() {
        try {
            $conn = $this->conn;
            $sql = "SELECT * FROM users";
            $statement = $conn->query($sql);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Gabim në getAllUsers: " . $e->getMessage();
            return [];
        }
    }

    function getUserByPersonalNr($personalNr) {
        try {
            $conn = $this->conn;
            $sql = "SELECT * FROM users WHERE personalNr = ?";
            $statement = $conn->prepare($sql);
            $statement->execute([$personalNr]);
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Gabim në getUserByPersonalNr: " . $e->getMessage();
            return null;
        }
    }

    function updateUser($personalNr, $name, $lastName, $email, $password, $birthdate) {
        try {
            $conn = $this->conn;
            $sql = "UPDATE users SET name = ?, lastname = ?, email = ?, password = ?, birthdate = ? WHERE personalNr = ?";
            $statement = $conn->prepare($sql);
            $statement->execute([$name, $lastName, $email, $password, $birthdate, $personalNr]);
            return true;
        } catch (PDOException $e) {
            echo "Gabim në updateUser: " . $e->getMessage();
            return false;
        }
    }

    function deleteUser($personalNr) {
        try {
            $conn = $this->conn;
            $sql = "DELETE FROM users WHERE personalNr = ?";
            $statement = $conn->prepare($sql);
            $statement->execute([$personalNr]);
            return true;
        } catch (PDOException $e) {
            echo "Gabim në deleteUser: " . $e->getMessage();
            return false;
        }
    }

    function userExistsByEmail($email) {
        try {
            $conn = $this->conn;
            $sql = "SELECT * FROM users WHERE email = ?";
            $statement = $conn->prepare($sql);
            $statement->execute([$email]);
            return $statement->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (PDOException $e) {
            echo "Gabim në userExistsByEmail: " . $e->getMessage();
            return false;
        }
    }

    function personalNrExists($personalNr) {
        try {
            $conn = $this->conn;
            $sql = "SELECT * FROM users WHERE personalNr = ?";
            $statement = $conn->prepare($sql);
            $statement->execute([$personalNr]);
            return $statement->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (PDOException $e) {
            echo "Gabim në personalNrExists: " . $e->getMessage();
            return false;
        }
    }
}
?>
