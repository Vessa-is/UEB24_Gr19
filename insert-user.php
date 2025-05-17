<?php
include_once '../UEB24_Gr19/script/classes/UserRepository.php';
include_once '../UEB24_Gr19/script/classes/User.php';

if(isset($_POST['submitbutton'])){
    if(empty($_POST['first-name']) || empty($_POST['last-name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['nr-personal'])){
        echo "Fill all fields!";
    }else{
        $firstname = $_POST['first-name'];
        $lastname = $_POST['last-name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $personalnr = $_POST['nr-personal'];

        $user  = new User($firstname, $lastname, $email, $password, $personalnr);
        $userRepository = new UserRepository();

        $userRepository->insertUser($user);
    }
}
?>