<?php
    $server="localhost";
    $username="root";
    $password="";
    $database = "sherbimet";


    $conn = mysqli_connect($server, $username, $password, $database);

    if(!$conn){
        echo "Error connecting to the Database!";
    }

?>