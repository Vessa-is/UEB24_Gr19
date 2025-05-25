<?php
session_start();
require_once 'DatabaseConnection.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

try {
    $db = new DatabaseConnection();
    $conn = $db->startConnection();

    $socialMedia = sanitizeInput($_POST['social_media'] ?? '');
    $visitAgain = sanitizeInput($_POST['visit_again'] ?? '');

    if (empty($socialMedia)) {
        $response['message'] = 'Ju lutemi zgjidhni një opsion për "Si ke dëgjuar për ne"';
        error_log(date('Y-m-d H:i:s') . " | Feedback error: Empty social media\n", 3, 'logs/debug.log');
        echo json_encode($response);
        exit;
    }

    if (!in_array($visitAgain, ['Yes', 'No', 'Maybe'])) {
        $response['message'] = 'Ju lutemi zgjidhni një opsion të vlefshëm për "A do të vizitonit përsëri"';
        error_log(date('Y-m-d H:i:s') . " | Feedback error: Invalid visit again ($visitAgain)\n", 3, 'logs/debug.log');
        echo json_encode($response);
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO feedback (social_media, visit_again)
        VALUES (:social_media, :visit_again)
    ");
    $stmt->bindParam(':social_media', $socialMedia, PDO::PARAM_STR);
    $stmt->bindParam(':visit_again', $visitAgain, PDO::PARAM_STR);
    $stmt->execute();

    $response['success'] = true;
    $response['message'] = 'Feedback i juaj është dërguar!';
    error_log(date('Y-m-d H:i:s') . " | Feedback submitted: $socialMedia, $visitAgain\n", 3, 'logs/debug.log');

} catch (PDOException $e) {
    $response['message'] = 'Ndodhi një gabim. Ju lutemi provoni përsëri.';
    error_log(date('Y-m-d H:i:s') . " | Feedback error: " . $e->getMessage() . "\n", 3, 'logs/errors.log');
} catch (Exception $e) {
    $response['message'] = 'Gabim i papritur.';
    error_log(date('Y-m-d H:i:s') . " | Feedback error: " . $e->getMessage() . "\n", 3, 'logs/errors.log');
}

echo json_encode($response);
?>