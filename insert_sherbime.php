<?php
require_once 'DatabaseConnection.php';


$db = new DatabaseConnection();
$pdo = $db->startConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emri = $_POST['emri'] ?? '';
    $emriSherbim = $_POST['emriSherbim'] ?? '';
    $koha = $_POST['koha'] ?? '';
    $cmimi = $_POST['cmimi'] ?? '';

    if (!empty($emri) && !empty($emriSherbim) && !empty($koha) && !empty($cmimi)) {
        try {
            $sql = "INSERT INTO sherbime (emri, emriSherbim, koha, cmimi) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$emri, $emriSherbim, $koha, $cmimi]);
            echo "Rezervimi u regjistrua me sukses!";
        } catch (PDOException $e) {
            error_log("Gabim gjatë regjistrimit: " . $e->getMessage(), 3, "error.log");
            echo "Gabim gjatë regjistrimit. Ju lutemi kontaktoni administratorin.";
        }
    } else {
        echo "Ju lutemi plotësoni të gjitha fushat!";
    }
} else {
    echo "Kërkesa nuk është POST!";
}
?>

