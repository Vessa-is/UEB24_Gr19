<?php
$currentHour = date("G"); // kushtezimeettt
$greeting = "";

if ($currentHour >= 5 && $currentHour < 12) {
    $greeting = "Mirëmëngjes!";
} elseif ($currentHour >= 12 && $currentHour < 18) {
    $greeting = "Mirëdita!";
} elseif ($currentHour >= 18 && $currentHour < 24) {
    $greeting = "Mirëmbrëma!";
} else {
    $greeting = "Çkemi";
}
?>
