<?php
class User {
    private $name;
    private $lastName;
    private $email;
    private $password;
    private $personalNr;
    private $birthdate;

    public function __construct($name, $lastName, $email, $password, $personalNr, $birthdate = null) {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->personalNr = $personalNr;
        $this->birthdate = $birthdate;
    }

    public function getName() {
        return $this->name;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getPersonalNr() {
        return $this->personalNr;
    }

    public function getBirthdate() {
        return $this->birthdate;
    }
}
?>