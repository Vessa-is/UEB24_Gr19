<?php
include 'DatabaseConnection.php';

class UserRepository {
    private $conn;

    function __construct() {
        $conn = new DatabaseConnection;
        $this->conn = $conn->startConnection();
    }

    function insertUser($user) {
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
    }

    function getAllUsers() {
        $conn = $this->conn;
        $sql = "SELECT * FROM users";
        $statement = $conn->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function getUserByPersonalNr($personalNr) {
        $conn = $this->conn;
        $sql = "SELECT * FROM users WHERE personalNr = ?";
        $statement = $conn->prepare($sql);
        $statement->execute([$personalNr]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function updateUser($personalNr, $name, $lastName, $email, $password, $birthdate) {
        $conn = $this->conn;
        $sql = "UPDATE users SET name = ?, lastname = ?, email = ?, password = ?, birthdate = ? WHERE personalNr = ?";
        $statement = $conn->prepare($sql);
        $statement->execute([$name, $lastName, $email, $password, $birthdate, $personalNr]);
    }

    function deleteUser($personalNr) {
        $conn = $this->conn;
        $sql = "DELETE FROM users WHERE personalNr = ?";
        $statement = $conn->prepare($sql);
        $statement->execute([$personalNr]);
    }

    function userExistsByEmail($email) {
        $conn = $this->conn;
        $sql = "SELECT * FROM users WHERE email = ?";
        $statement = $conn->prepare($sql);
        $statement->execute([$email]);
        return $statement->fetch(PDO::FETCH_ASSOC) !== false;
    }

    function personalNrExists($personalNr) {
        $conn = $this->conn;
        $sql = "SELECT * FROM users WHERE personalNr = ?";
        $statement = $conn->prepare($sql);
        $statement->execute([$personalNr]);
        return $statement->fetch(PDO::FETCH_ASSOC) !== false;
    }
}
?>