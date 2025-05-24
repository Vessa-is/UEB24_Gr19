<?php

$currentHour = date("G");
$greeting = "";

session_start();

if (!isset($_SESSION['vizita'])) {
    $_SESSION['vizita'] = 1;
} else {
    $_SESSION['vizita']++;
}



if (isset($_SESSION['user']['email'])) {
    $email = $_SESSION['user']['email'];
    if ($_SESSION['vizita'] > 1) {
        $msg = "Mirë se vini përsëri, " . $email . "! " . $greeting;
    } else {
        $msg = "Mirë se vini, " . $email . "! " . $greeting;
    }
    echo "<script>alert('" . addslashes($msg) . "');</script>";
}

?>
