<?php 
include '../UEB24_Gr19/DatabaseConnection.php';

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
        $role = $user->getRole();

        $sql = "INSERT INTO user (name, lastname, email, password, personalnr, role) VALUES (?, ?, ?, ?, ?, ?)";

        $statement = $conn->prepare($sql);
        $statement->execute([$firstName, $lastName, $email, $password, $personalNr, $role]);

        echo "<script> alert('User has been inserted successfully!'); </script>";
    }

    function getAllUsers() {
        $conn = $this->conn;
        $sql = "SELECT * FROM user";
        $statement = $conn->query($sql);
        return $statement->fetchAll();
    }

    function getUserByPersonalNr($personalNr) {
        $conn = $this->conn;
        $sql = "SELECT * FROM user WHERE personalnr = ?";
        $statement = $conn->prepare($sql);
        $statement->execute([$personalNr]);
        return $statement->fetch();
    }

    function updateUser($personalNr, $name, $lastName, $email, $password, $role) {
        $conn = $this->conn;
        $sql = "UPDATE user SET name=?, lastname=?, email=?, password=?, role=? WHERE personalnr=?";
        $statement = $conn->prepare($sql);
        $statement->execute([$name, $lastName, $email, $password, $role, $personalNr]);
        echo "<script>alert('Update was successful');</script>";
    }

    function deleteUser($personalNr) {
        $conn = $this->conn;
        $sql = "DELETE FROM user WHERE personalnr = ?";
        $statement = $conn->prepare($sql);
        $statement->execute([$personalNr]);
        echo "<script>alert('Delete was successful');</script>";
    }

    function userExistsByEmail($email) {
        $conn = $this->conn;
        $sql = "SELECT * FROM user WHERE email = ?";
        $statement = $conn->prepare($sql);
        $statement->execute([$email]);
        return $statement->fetch() !== false;
    }

    function personalNrExists($personalNr) {
        $conn = $this->conn;
        $sql = "SELECT * FROM user WHERE personalnr = ?";
        $statement = $conn->prepare($sql);
        $statement->execute([$personalNr]);
        return $statement->fetch() !== false;
    }
}
?>
