<?php
require_once("database.php");

if(isset($_POST['submit'])){
    $emri = $_POST['name'];
    $koha = $_POST['time'];
    $cmimi = $_POST['price'];

    $sql = "INSERT INTO sherbimet(emri, koha, cmimi) VALUES ('$emri', '$koha', '$cmimi')";
    
    if(mysqli_query($conn, $sql)){
        header("Location: sherbimet.php");
        exit();
    }else{
        echo "Error inserting into services" . mysqli_error($conn);
    }

}
?>