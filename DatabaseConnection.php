<?php

class DatabaseConnection{
    private $server="localhost";
    private $username="root";
    private $password="";
    private $database = "radiant";


    function startConnection(){

        try{
            $conn = new PDO("mysql:host=$this->server;dbname=$this->database",$this->username);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }catch(PDOException $e){
            echo "Database Connection Failed".$e->getMessage();
            return null;
        }
    }
}

$db = new DatabaseConnection();
$db->startConnection();

?>