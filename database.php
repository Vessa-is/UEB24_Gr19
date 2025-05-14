<?php
    $server="localhost";
    $username="root";
    $password="";
    $database = "";


    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if(!$conn){
        echo "Error connecting to the Database!";
    }

?>