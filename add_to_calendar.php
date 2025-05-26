<?php
session_start();
require 'vendor/autoload.php';
require 'DatabaseConnection.php';

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

$db = new DatabaseConnection();
$conn = $db->startConnection();

// Configuration
$redirect_uri = 'http://localhost/UEB24_Gr19/UEB24_Gr19/UEB24_Gr20/add_to_calendar.php'; // Update to your domain
$timezone = 'Europe/Tirane';

// Google Client setup
$client = new Client();
$client->setAuthConfig('config/credentials.json');
$client->addScope(Calendar::CALENDAR_EVENTS);
$client->setRedirectUri($redirect_uri);
$client->setAccessType('offline');
$client->setPrompt('select_account consent');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Ju lutem regjistrohuni.";
    header("Location: login.php");
    exit;
}

// Get reservation ID
$reservation_id = filter_input(INPUT_GET, 'reservation_id', FILTER_VALIDATE_INT);
if (!$reservation_id) {
    $_SESSION['error'] = "Nuk u gjet rezervimi.";
    header("Location: profile.php");
    exit;
}

// Fetch reservation details
try {
    $stmt = $conn->prepare("SELECT r.date, r.time, r.status, s.name, s.price, s.duration 
                            FROM rezervimet r 
                            JOIN sherbimet s ON r.service_id = s.id 
                            WHERE r.id = ? AND r.user_id = ?");
    $stmt->execute([$reservation_id, $_SESSION['user_id']]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reservation || $reservation['status'] !== 'confirmed') {
        $_SESSION['error'] = "Rezervimi i pavlefshëm ose i anuluar.";
        header("Location: profile.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Gabim në databazë.";
    error_log("Database Error: {$e->getMessage()}", 3, "logs/database.log");
    header("Location: profile.php");
    exit;
}

// Calculate event times
try {
    $start_time = new DateTime("{$reservation['date']} {$reservation['time']}", new DateTimeZone($timezone));
    $duration = (int)$reservation['duration'];
    $end_time = clone $start_time;
    $end_time->modify("+{$duration} minutes");
} catch (Exception $e) {
    $_SESSION['error'] = "Gabim në formatin e datës.";
    error_log("Date Error: {$e->getMessage()}", 3, "logs/calendar.log");
    header("Location: profile.php");
    exit;
}

// Apply weekend discount
$is_weekend = in_array($start_time->format('N'), [6, 7]);
$discount = $is_weekend ? 0.10 : 0;
$price = $reservation['price'] * (1 - $discount);
$discount_text = $is_weekend ? " (10% zbritje fundjave)" : "";

// Fetch or refresh token
try {
    $stmt = $conn->prepare("SELECT google_token FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $google_token = $user['google_token'] ? json_decode($user['google_token'], true) : null;

    if ($google_token) {
        $client->setAccessToken($google_token);
        if ($client->isAccessTokenExpired() && isset($google_token['refresh_token'])) {
            $new_token = $client->fetchAccessTokenWithRefreshToken($google_token['refresh_token']);
            if (isset($new_token['error'])) {
                throw new Exception("Gabim në rifreskimin e tokenit: {$new_token['error']}");
            }
            $client->setAccessToken($new_token);
            $stmt = $conn->prepare("UPDATE users SET google_token = ? WHERE id = ?");
            $stmt->execute([json_encode($new_token), $_SESSION['user_id']]);
        }
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Gabim në token: {$e->getMessage()}";
    error_log("Token Error: {$e->getMessage()}", 3, "logs/calendar.log");
    header("Location: profile.php");
    exit;
}

// Handle OAuth flow
if (isset($_GET['code'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        if (isset($token['error'])) {
            throw new Exception("Gabim në autentikim: {$token['error']}");
        }
        $client->setAccessToken($token);
        $stmt = $conn->prepare("UPDATE users SET google_token = ? WHERE id = ?");
        $stmt->execute([json_encode($token), $_SESSION['user_id']]);
    } catch (Exception $e) {
        $_SESSION['error'] = "Gabim në autentikim: {$e->getMessage()}";
        error_log("OAuth Error: {$e->getMessage()}", 3, "logs/calendar.log");
        header("Location: profile.php");
        exit;
    }
}

// If no valid token, redirect to OAuth
if (!$client->getAccessToken()) {
    $authUrl = $client->createAuthUrl();
    header("Location: $authUrl");
    exit;
}

// Create calendar event
try {
    $service = new Calendar($client);
    $event = new Event([
        'summary' => "Rezervim në Radiant Touch: {$reservation['name']}",
        'description' => "Shërbimi: {$reservation['name']}\n" .
                        "Data: {$reservation['date']}\n" .
                        "Koha: {$reservation['time']}\n" .
                        "Çmimi: €" . number_format($price, 2) . "{$discount_text}\n" .
                        "Statusi: Konfirmuar",
        'start' => [
            'dateTime' => $start_time->format(DateTime::RFC3339),
            'timeZone' => $timezone,
        ],
        'end' => [
            'dateTime' => $end_time->format(DateTime::RFC3339),
            'timeZone' => $timezone,
        ],
        'reminders' => [
            'useDefault' => false,
            'overrides' => [
                ['method' => 'email', 'minutes' => 24 * 60],
                ['method' => 'popup', 'minutes' => 30],
            ],
        ],
    ]);

    $calendarId = 'primary';
    $event = $service->events->insert($calendarId, $event);
    $_SESSION['success'] = "Rezervimi u shtua në Google Calendar!";
} catch (Exception $e) {
    $_SESSION['error'] = "Gabim në shtimin e eventit: {$e->getMessage()}";
    error_log("Google Calendar Error: {$e->getMessage()}", 3, "logs/calendar.log");
} finally {
    header("Location: profile.php");
    exit;
}
?>