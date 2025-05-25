<?php 
include '../UEB24_Gr19/DatabaseConnection.php';

class UserRepository {
    private $conn;

    function __construct() {
        $conn = new DatabaseConnection;
        $this->conn = $conn->startConnection();
    }

    function insertUser($user) {
        try {
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
        } catch (PDOException $e) {
            $this->logError("insertUser", $e->getMessage());
            echo "<script> alert('Gabim gjatë shtimit të përdoruesit.'); </script>";
        }
    }

    function getAllUsers() {
        try {
            $conn = $this->conn;
            $sql = "SELECT * FROM user";
            $statement = $conn->query($sql);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            $this->logError("getAllUsers", $e->getMessage());
            return [];
        }
    }

    function getUserByPersonalNr($personalNr) {
        try {
            $conn = $this->conn;
            $sql = "SELECT * FROM user WHERE personalnr = ?";
            $statement = $conn->prepare($sql);
            $statement->execute([$personalNr]);
            return $statement->fetch();
        } catch (PDOException $e) {
            $this->logError("getUserByPersonalNr", $e->getMessage());
            return false;
        }
    }

    function updateUser($personalNr, $name, $lastName, $email, $password, $role) {
        try {
            $conn = $this->conn;
            $sql = "UPDATE user SET name=?, lastname=?, email=?, password=?, role=? WHERE personalnr=?";
            $statement = $conn->prepare($sql);
            $statement->execute([$name, $lastName, $email, $password, $role, $personalNr]);
            echo "<script>alert('Update was successful');</script>";
        } catch (PDOException $e) {
            $this->logError("updateUser", $e->getMessage());
            echo "<script>alert('Gabim gjatë përditësimit');</script>";
        }
    }

    function deleteUser($personalNr) {
        try {
            $conn = $this->conn;
            $sql = "DELETE FROM user WHERE personalnr = ?";
            $statement = $conn->prepare($sql);
            $statement->execute([$personalNr]);
            echo "<script>alert('Delete was successful');</script>";
        } catch (PDOException $e) {
            $this->logError("deleteUser", $e->getMessage());
            echo "<script>alert('Gabim gjatë fshirjes');</script>";
        }
    }

    function userExistsByEmail($email) {
        try {
            $conn = $this->conn;
            $sql = "SELECT * FROM user WHERE email = ?";
            $statement = $conn->prepare($sql);
            $statement->execute([$email]);
            return $statement->fetch() !== false;
        } catch (PDOException $e) {
            $this->logError("userExistsByEmail", $e->getMessage());
            return false;
        }
    }

    function personalNrExists($personalNr) {
        try {
            $conn = $this->conn;
            $sql = "SELECT * FROM user WHERE personalnr = ?";
            $statement = $conn->prepare($sql);
            $statement->execute([$personalNr]);
            return $statement->fetch() !== false;
        } catch (PDOException $e) {
            $this->logError("personalNrExists", $e->getMessage());
            return false;
        }
    }

    private function logError($method, $message) {
        $file = fopen("../UEB24_Gr19/log.txt", "a");
        fwrite($file, "[" . date("Y-m-d H:i:s") . "] Error in $method: $message" . PHP_EOL);
        fclose($file);
    }
}
?>

