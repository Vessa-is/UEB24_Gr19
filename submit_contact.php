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

    $name = sanitizeInput($_POST['name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $message = sanitizeInput($_POST['message'] ?? '');
    $updates = isset($_POST['updates']) && $_POST['updates'] === 'true' ? 1 : 0;

    if (empty($name)) {
        $response['message'] = 'Emri dhe Mbiemri është i detyrueshëm';
        error_log(date('Y-m-d H:i:s') . " | Contact form error: Empty name\n", 3, 'logs/debug.log');
        echo json_encode($response);
        exit;
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Email-i nuk është në format të saktë';
        error_log(date('Y-m-d H:i:s') . " | Contact form error: Invalid email ($email)\n", 3, 'logs/debug.log');
        echo json_encode($response);
        exit;
    }

    if (empty($phone) || !preg_match('/^\+\d{9,15}$/', $phone)) {
        $response['message'] = 'Numri i telefonit është i pavlefshëm';
        error_log(date('Y-m-d H:i:s') . " | Contact form error: Invalid phone ($phone)\n", 3, 'logs/debug.log');
        echo json_encode($response);
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO contacts (name, email, phone, message, updates)
        VALUES (:name, :email, :phone, :message, :updates)
    ");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $stmt->bindParam(':updates', $updates, PDO::PARAM_INT);
    $stmt->execute();

    $response['success'] = true;
    $response['message'] = 'Mesazhi u dërgua me sukses!';
    error_log(date('Y-m-d H:i:s') . " | Contact form submitted: $email\n", 3, 'logs/debug.log');

} catch (PDOException $e) {
    $response['message'] = 'Ndodhi një gabim. Ju lutemi provoni përsëri.';
    error_log(date('Y-m-d H:i:s') . " | Contact form error: " . $e->getMessage() . "\n", 3, 'logs/errors.log');
} catch (Exception $e) {
    $response['message'] = 'Gabim i papritur.';
    error_log(date('Y-m-d H:i:s') . " | Contact form error: " . $e->getMessage() . "\n", 3, 'logs/errors.log');
}

echo json_encode($response);
?>