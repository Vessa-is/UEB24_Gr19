<?php 

    function insertUser($firstName, $lastName, $email, $password, $personalNr){
    include '../UEB24_Gr19/database.php';

    if(isset($_POST['submit'])){

    $firstName = mysqli_real_escape_string($conn, $firstName);
    $lastName = mysqli_real_escape_string($conn, $lastName);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $personalNr = mysqli_real_escape_string($conn, $personalNr);

        $query = "INSERT INTO user(name, lastname, email, password, personalnr) VALUES ('$firstName', '$lastName', '$email', '$password', '$personalNr')";

    if (!mysqli_query($conn, $query)) {
    echo "Error: " . mysqli_error($conn);
}


}
    }


?>