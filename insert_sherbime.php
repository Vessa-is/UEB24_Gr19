<?php
include_once('DatabaseConnection.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emri = $_POST['emri'] ?? '';
    $emriSherbim = $_POST['emriSherbim'] ?? '';
    $koha = $_POST['koha'] ?? '';
    $cmimi = $_POST['cmimi'] ?? '';

    if (!empty($emri) && !empty($emriSherbim) && !empty($koha) && !empty($cmimi)) {
        $sql = "INSERT INTO sherbime (emri, emriSherbim, koha, cmimi) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([$emri, $emriSherbim, $koha, $cmimi]);
            echo "Rezervimi u regjistrua me sukses!";
        } catch (Exception $e) {
            echo "Gabim gjatë regjistrimit: " . $e->getMessage();
        }
    } else {
        echo "Ju lutemi plotësoni të gjitha fushat!";
    }
} else {
    echo "Kërkesa nuk është POST!";
}
?>
