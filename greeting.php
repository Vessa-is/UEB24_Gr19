<?php

$currentHour = date("G"); // kushtezimeettt, operatoret 
$greeting = "";

session_start();

if (!isset($_SESSION['vizita'])) {
    $_SESSION['vizita'] = 1;
} else {
    $_SESSION['vizita']++;
}

// if ($currentHour >= 5 && $currentHour < 12) {
//     $greeting = "Mirëmëngjes!";
// } elseif ($currentHour >= 12 && $currentHour < 18) {
//     $greeting = "Mirëdita!";
// } elseif ($currentHour >= 18 && $currentHour < 24) {
//     $greeting = "Mirëmbrëma!";
// } else {
//     $greeting = "Çkemi";
// }


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
