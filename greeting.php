<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['has_greeted'])) {
    $hour = (int) date("G");
    if ($hour < 12) {
        $greeting = "Mirëmëngjes";
    } elseif ($hour < 18) {
        $greeting = "Mirëdita";
    } else {
        $greeting = "Mirëmbrëma";
    }

    $email = $_SESSION['user']['email'] ?? 'Përdorues';

    $msg = $_SESSION['has_visited_before']
         ? "Mirë se vini përsëri, {$email}! {$greeting}!"
         : "Mirë se vini, {$email}! {$greeting}!";

    echo "<script>alert('" . addslashes($msg) . "');</script>";

    $_SESSION['has_greeted'] = true;
    $_SESSION['has_visited_before'] = true;
}
