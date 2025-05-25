<?php
class User {
    private $name;
    private $lastname;
    private $email;
    private $password;
    private $personalnr;
    private $role;

    function __construct($name, $lastname, $email, $password, $personalnr, $role = 'user') {
        $this->name = $name;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->personalnr = $personalnr;
        $this->role = $role;
    }

    function getName() {
        return $this->name;
    }

    function getLastName() {
        return $this->lastname;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getPersonalNr() {
        return $this->personalnr;
    }

    function getRole() {
        return $this->role;
    }

    function setRole($role) {
        $this->role = $role;
    }
}

?>
