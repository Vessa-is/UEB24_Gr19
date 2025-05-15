<?php

class User{
    private $name;
    private $lastname;
    private $email;
    private $password;
    private $personalnr;

    function __construct($name, $lastname, $email, $password, $personalnr){
            $this->name = $name;
            $this->lastname = $lastname;
            $this->email = $email;
            $this->password = $password;
            $this->personalnr = $personalnr;
    }


    function getName(){
        return $this->name;
    }

    function getLastName(){
        return $this->lastname;
    }

    function getEmail(){
        return $this->email;
    }

    function getPassword(){
        return $this->password;
    }

    function getPersonalNr(){
        return $this->personalnr;
    }
}

?>