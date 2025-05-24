<?php 
    include '../UEB24_Gr19/DatabaseConnection.php';

class UserRepository{
    private $conn;

    function __construct(){
        $conn = new DatabaseConnection;
        $this->conn = $conn->startConnection();
    }


    function insertUser($user){

        $conn = $this->conn;

        $firstName = $user->getName();
        $lastName = $user->getLastName();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $personalNr = $user->getPersonalNr();

        $sql = "INSERT INTO user (name, lastname, email, password, personalnr) VALUES (?,?,?,?,?)";

        $statement = $conn->prepare($sql);

        $statement->execute([$firstName, $lastName, $email, $password, $personalNr]);

        echo "<script> alert('User has been inserted successfuly!'); </script>";

    }

    function getAllUsers(){
        $conn = $this->conn;

        $sql = "SELECT * FROM user";

        $statement = $conn->query($sql);
        $users = $statement->fetchAll();

        return $users;
    }

    function getUserByPersonalNr($personalNr){
        $conn = $this->conn;

        $sql = "SELECT * FROM user WHERE personalnr=?";
        $statement = $conn->prepare($sql);
        $statement->execute([$personalNr]);
        $user = $statement->fetch();

        return $user;
    }

    function updateUser($personalNr, $name, $lastName, $email, $password){
        $conn = $this->conn;

        $sql = "UPDATE user SET name=?, lastname=?, email=?, password=? WHERE personalnr=?";
        $statement = $conn->prepare($sql);
        $statement->execute([$name, $lastName, $email, $password, $personalNr]);

        echo "<script>alert('update was successful');</script>";
    }


    function deleteUser($personalNr){
        $conn = $this->conn;

        $sql = "DELETE FROM user WHERE personalnr=?";
        $statement = $conn->prepare($sql);
        $statement->execute([$personalNr]);

        echo "<script>alert('delete was successful');</script>";
    }

    function userExistsByEmail($email){
        $conn = $this->conn;
        $sql = "SELECT * FROM user WHERE email = ?";
        $statement = $conn->prepare($sql);
        $statement->execute([$email]);
        return $statement->fetch() !== false;
    }

        function personalNrExists($personalNr) {
    $conn = $this->conn;
    $sql = "SELECT * FROM users WHERE personal_nr = ?";
    $statement = $conn->prepare($sql);
    $statement->execute([$personalNr]);
    return $statement->fetch() !== false;
    }

    
}
?>