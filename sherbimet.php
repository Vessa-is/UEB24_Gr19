<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'greeting.php';
include 'DatabaseConnection.php';

$db = new DatabaseConnection();
$conn = $db->startConnection();

require_once 'ServiceRepository.php';
$serviceRepo = new ServiceRepository($conn);

if (!$conn) {
    die("Failed to connect to the database");
}

$nav_links = [
    'BALLINA' => 'index.php',
    'SHERBIMET' => 'sherbimet.php',
    'GALERIA' => 'galeria.php',
    'PRODUKTET' => 'produktet.php',
    'RRETH NESH' => 'per_ne.php',
    'KONTAKTI' => 'kontakti.php'
];
$reservation_success = false;
$reservation_error = '';
$show_booking_form = false;
$selected_service = null;

$sort_by = $_GET['sort_by'] ?? 'name_asc';
$sort_options = [
    'name_asc' => 'name ASC',
    'name_desc' => 'name DESC',
    'price_asc' => 'price ASC',
    'price_desc' => 'price DESC',
    'time_asc' => 'time ASC',
    'time_desc' => 'time DESC',
];
$order_by = $sort_options[$sort_by] ?? $sort_options['name_asc'];

$services = $serviceRepo->getAll($order_by);

if (isset($_POST['book_service'])) {
    $sherbim_id = filter_var($_POST['sherbim_id'], FILTER_VALIDATE_INT);
    if ($sherbim_id) {
        foreach ($services as &$srv) {
            if ($srv['id'] == $sherbim_id) {
                $selected_service = &$srv;
                $show_booking_form = true;
                break;
            }
        }
        unset($srv);
        if (!$selected_service) {
            $reservation_error = "Shërbimi nuk u gjet.";
        }
    } else {
        $reservation_error = "ID e shërbimit nuk është valide.";
    }
} elseif (isset($_POST['confirm_booking'])) {
    // Log session for debugging
    error_log("Session: " . print_r($_SESSION, true), 3, "logs/session.log");

    if (!isset($_SESSION['user_id'])) {
        $reservation_error = "Ju lutem kyçuni për të bërë rezervimin.";
    } else {
        $user_id = (int)$_SESSION['user_id'];
        $sherbim_id = filter_var($_POST['sherbim_id'], FILTER_VALIDATE_INT);
        $date = $_POST['date'] ?? null;
        $time = $_POST['time'] ?? null;

        if (!$sherbim_id || !$date || !$time) {
            $reservation_error = "Ju lutem plotësoni datën dhe orën.";
        } else {
            try {
                // Validate date and time
                $data_rezervimit = new DateTime("$date $time:00");
                $data_rezervimit_str = $data_rezervimit->format('Y-m-d H:i:s');
                error_log("Data rezervimit: $data_rezervimit_str", 3, "logs/rezervimet.log");

                if ($data_rezervimit->getTimestamp() < time()) {
                    $reservation_error = "Nuk mund të rezervoni për një kohë të kaluar.";
                } elseif ($data_rezervimit->format('H') < 8 || $data_rezervimit->format('H') >= 16) {
                    $reservation_error = "Orari i rezervimeve është nga ora 08:00 deri në 16:00.";
                } else {
                    // Verify user_id and sherbim_id exist
                    $stmt_user = $conn->prepare("SELECT id FROM users WHERE id = ?");
                    $stmt_user->execute([$user_id]);
                    if (!$stmt_user->fetch()) {
                        $reservation_error = "Përdoruesi nuk ekziston.";
                        error_log("Invalid user_id: $user_id", 3, "logs/rezervimet.log");
                    } else {
                        $stmt_service = $conn->prepare("SELECT id FROM sherbimet WHERE id = ?");
                        $stmt_service->execute([$sherbim_id]);
                        if (!$stmt_service->fetch()) {
                            $reservation_error = "Shërbimi nuk ekziston.";
                            error_log("Invalid sherbim_id: $sherbim_id", 3, "logs/rezervimet.log");
                        } else {
                            // Check for conflicts
                            $stmt_check = $conn->prepare("SELECT COUNT(*) FROM rezervimet WHERE sherbim_id = ? AND data_rezervimit = ?");
                            $stmt_check->execute([$sherbim_id, $data_rezervimit_str]);
                            $exists = $stmt_check->fetchColumn();

                            if ($exists > 0) {
                                $reservation_error = "Ky orar është i zënë. Ju lutem provoni një orar tjetër.";
                            } else {
                                $stmt = $conn->prepare("INSERT INTO rezervimet (user_id, sherbim_id, data_rezervimit) VALUES (?, ?, ?)");
                                error_log("Inserting: user_id=$user_id, sherbim_id=$sherbim_id, data_rezervimit=$data_rezervimit_str", 3, "logs/rezervimet.log");
                                if ($stmt->execute([$user_id, $sherbim_id, $data_rezervimit_str])) {
                                    $selected_service = $serviceRepo->findById($sherbim_id);
                                    $reservation_success = true;
                                    $show_booking_form = false;
                                } else {
                                    $reservation_error = "Dështoi rezervimi. Ju lutem provoni përsëri.";
                                    error_log("Insert failed: " . print_r($stmt->errorInfo(), true), 3, "logs/rezervimet.log");
                                }
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                $reservation_error = "Gabim në formatin e datës/orës: " . $e->getMessage();
                error_log("Date error: " . $e->getMessage(), 3, "logs/rezervimet.log");
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/logo1.png" />
    <title>Shërbimet-Radiant Touch</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
    <style>
        body, html {
            margin: 0;
            padding: 0;
            background-color: #f4e4d4;
        }
        .sherbimet {
            font-family: Arial, sans-serif;
            background-color: #f4e4d4;
            margin: 0;
            padding: 0;
        }
        h1, h2, p {
            margin: 0;
            padding: 0;
            line-height: normal;
        }
        .sherbimet {
            margin-bottom: -1px;
        }
        .services-table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
        }
        .services-table th {
            background-color: #6d4c3d;
            color: #fff;
            font-size: 14px;
            letter-spacing: 0.5px;
            padding: 15px;
            text-transform: uppercase;
        }
        .services-table td {
            font-size: 14px;
            color: #4b4b4b;
            padding: 15px;
            text-align: center;
            border: 1px solid #f3e5d8;
        }
        .services-table tr:nth-child(even) {
            background-color: #fdf3e8;
        }
        .services-table tr:hover {
            background-color: #decfbc;
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        .services-table button {
            background-color: #6d4c3d;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 20px;
            font-size: 14px;
            transition: background-color 0.3s ease;
            font-weight: bold;
        }
        .services-table button:hover {
            background-color: #8b5e4c;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            color: #6d4c3d;
            margin-top: 0;
            font-size: 40px;
            padding-top: 20px;
            padding-bottom: 10px;
        }
        .services {
            text-align: center;
            padding: 50px 20px;
            background-color: #f4e4d4;
        }
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(3px);
            animation: fadeIn 0.3s ease-out;
            pointer-events: none;
        }
        .modal-content {
            position: relative;
            background-color: #fff;
            width: 90%;
            max-width: 450px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            animation: scaleIn 0.35s ease-out;
            z-index: 1001;
            pointer-events: auto;
        }
        .modal-header {
            background: linear-gradient(135deg, #6d4c3d 0%, #5a3921 100%);
            color: #fff;
            padding: 20px;
            font-size: 1.25rem;
            font-weight: 600;
            text-align: center;
            letter-spacing: 0.5px;
        }
        .modal-body {
            padding: 25px 30px;
            color: #444;
        }
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 999;
            opacity: 0;
            cursor: pointer;
            margin: 0;
            padding: 0;
            border: none;
        }
        .booking-form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .form-group label {
            font-weight: 500;
            color: #333;
            font-size: 0.95rem;
            margin-left: 2px;
        }
        .form-group input {
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
        }
        .form-group input:focus {
            outline: none;
            border-color: #6d4c3d;
            box-shadow: 0 0 0 2px rgba(109, 76, 61, 0.2);
            background-color: #fff;
        }
        .submit-btn {
            background: linear-gradient(135deg, #6d4c3d 0%, #5a3921 100%);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 15px;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(109, 76, 61, 0.3);
        }
        .modal-footer {
            background-color: #f8f8f8;
            padding: 18px 20px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        .success-message {
            color: #2e7d32;
            font-weight: 500;
            margin-bottom: 12px;
            font-size: 1.1rem;
        }
        .ok-btn {
            background: linear-gradient(135deg, #6d4c3d 0%, #5a3921 100%);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .ok-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(109, 76, 61, 0.2);
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scaleIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        button.book-btn {
            background-color: #6d4c3d;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: none;
            transform: none;
            font-weight: normal;
            letter-spacing: normal;
        }
        button.book-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(109, 76, 61, 0.3);
        }
        .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }
        .close-btn:hover {
            color: #f1f1f1;
        }
        .close-modal-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.8rem;
            cursor: pointer;
            padding: 0 12px;
            line-height: 1;
            transition: all 0.3s ease;
            display: block;
        }
        .close-modal-form {
            position: absolute;
            top: 0;
            right: 0;
            z-index: 1002;
            margin: 0;
        }
        .close-modal-btn:hover {
            color: #f1f1f1;
            transform: scale(1.1);
        }
        @media (max-width: 576px) {
            .modal-content {
                width: 95%;
                max-width: none;
            }
            .modal-body {
                padding: 20px 15px;
            }
            .form-group input {
                padding: 10px 12px;
            }
            .submit-btn {
                padding: 12px;
            }
        }
        .video-ad {
            position: relative;
            height: 400px;
            background: url('path-to-placeholder.jpg') center center / cover no-repeat;
            background-attachment: fixed;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .video-ad video {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            min-width: 100%;
            min-height: 100%;
            z-index: -2;
            object-fit: cover;
            filter: brightness(0.7);
        }
        .ad-content h2 {
            font-size: 36px;
            margin-bottom: 10px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }
        .ad-content p {
            font-size: 20px;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }
        .ad-content button {
            padding: 10px 20px;
            font-size: 18px;
            color: white;
            background-color: #6d4c3d;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .ad-content button:hover {
            background-color: #8b5e4c;
        }
        #calendar {
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        #calendar h2 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 15px;
        }
        .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        .day {
            padding: 10px;
            background-color: #f4f4f4;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
        }
        .day:hover {
            background-color: #3498db;
            color: white;
        }
        .sorting-form {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 10px;
            font-family: inherit;
            flex-wrap: wrap;
            max-width: 100%;
        }
        .table-wrapper {
            overflow-x: auto;
            max-width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .sorting-label {
            font-weight: bold;
            color: #5C4438;
            font-size: 16px;
        }
        .sorting-select {
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fdf6f0;
            color: #5C4438;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }
        .sorting-select:hover {
            border-color: #bfa48a;
        }
        .sorting-button {
            padding: 6px 14px;
            border: none;
            border-radius: 8px;
            background-color: #5C4438;
            color: white;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }
        .sorting-button:hover {
            background-color: #7b5c4a;
        }
        #sherbimet-page {
            overflow: hidden;
        }
        .message {
            color: #4caf50;
            margin-top: 10px;
            font-weight: bold;
        }
        .price-cell {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }
        .new-price {
            font-weight: 600;
            color: #27ae60;
            font-size: 1.1em;
        }
        .original-price {
            text-decoration: line-through;
            color: #888;
            font-size: 0.9em;
        }
        .discount-banner {
            display: inline-flex;
            align-items: center;
            padding: 12px 20px;
            border-radius: 8px;
            background: linear-gradient(90deg, #ff9a9e 0%, #fad0c4 100%);
            color: #5d2120;
            font-size: 1.05rem;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            animation: fadeIn 0.5s ease-in-out;
        }
        .discount-banner i.fa-tag, .discount-banner svg {
            margin-right: 12px;
            font-size: 1.4rem;
        }
        .discount-banner span.highlight {
            color: #c72c41;
            text-transform: uppercase;
            margin: 0 4px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body id="sherbimet-page">
<?php include 'header.php'; ?>

<?php if ($reservation_error): ?>
    <div class="modal">
        <div class="modal-content">
            <a href="sherbimet.php" class="close-modal-btn">×</a>
            <div class="modal-header">Gabim</div>
            <div class="modal-body">
                <p class="error-message"><?php echo htmlspecialchars($reservation_error); ?></p>
            </div>
            <div class="modal-footer">
                <a href="sherbimet.php" class="ok-btn">OK</a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($reservation_success): ?>
    <div class="modal">
        <div class="modal-content">
            <a href="sherbimet.php" class="close-modal-btn">×</a>
            <div class="modal-header">Rezervimi u Konfirmua</div>
            <div class="modal-body">
                <p class="success-message">Rezervimi juaj u pranua me sukses!</p>
                <p><strong>Shërbimi:</strong> <?php echo htmlspecialchars($selected_service['name'] ?? '—'); ?></p>
            </div>
            <div class="modal-footer">
                <a href="sherbimet.php" class="ok-btn">OK</a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
if (isset($_GET['sort_by'])) {
    $sort_by = $_GET['sort_by'];
    switch ($sort_by) {
        case 'price_asc':
            $prices = array_column($services, 'price');
            asort($prices);
            $services = array_map(function($key) use (&$services) {
                return $services[$key];
            }, array_keys($prices));
            break;
        case 'price_desc':
            $prices = array_column($services, 'price');
            arsort($prices);
            $services = array_map(function($key) use (&$services) {
                return $services[$key];
            }, array_keys($prices));
            break;
        case 'name_asc':
            $services_by_name = [];
            foreach ($services as &$service) {
                $services_by_name[$service['name']] = &$service;
            }
            unset($service);
            ksort($services_by_name);
            $services = array_values($services_by_name);
            break;
        case 'name_desc':
            $services_by_name = [];
            foreach ($services as &$service) {
                $services_by_name[$service['name']] = &$service;
            }
            unset($service);
            krsort($services_by_name);
            $services = array_values($services_by_name);
            break;
        case 'time_asc':
            usort($services, function($a, $b) {
                $time_a = (int)filter_var($a['time'], FILTER_SANITIZE_NUMBER_INT);
                $time_b = (int)filter_var($b['time'], FILTER_SANITIZE_NUMBER_INT);
                return $time_a - $time_b;
            });
            break;
        case 'time_desc':
            usort($services, function($a, $b) {
                $time_a = (int)filter_var($a['time'], FILTER_SANITIZE_NUMBER_INT);
                $time_b = (int)filter_var($b['time'], FILTER_SANITIZE_NUMBER_INT);
                return $time_b - $time_a;
            });
            break;
    }
}
?>

<section class="sherbimet">
    <h1>Shërbimet tona</h1>

    <?php
    $isWeekend = (date('N') >= 6);
    if ($isWeekend) {
        foreach ($services as &$service) {
            if (!isset($service['original_price'])) {
                $service['original_price'] = $service['price'];
            }
            $service['price'] = $service['original_price'] * 0.9;
            $service['display_price'] = number_format($service['price'], 2) . ' €';
            $service['original_display_price'] = number_format($service['original_price'], 2) . ' €';
        }
        unset($service);
        $discountMessage = "<div class='discount-banner'>Fundjavë Speciale! Zbritje 10% për të gjitha shërbimet!</div>";
    } else {
        foreach ($services as &$service) {
            if (isset($service['original_price'])) {
                $service['price'] = $service['original_price'];
            }
            $service['display_price'] = number_format($service['price'], 2) . ' €';
        }
        unset($service);
        $discountMessageText = "";
    }
    ?>

    <?php if (!empty($discountMessage)): ?>
        <?php echo $discountMessage; ?>
    <?php endif; ?>

    <form method="GET" class="sorting-form">
        <label class="sorting-label" for="sort_by">Rendit sipas:</label>
        <select name="sort_by" class="sorting-select" id="sort_by">
            <option value="name_asc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] === 'name_asc') ? 'selected' : ''; ?>>Emri (A-Z)</option>
            <option value="name_desc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] === 'name_desc') ? 'selected' : ''; ?>>Emri (Z-A)</option>
            <option value="price_asc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] === 'price_asc') ? 'selected' : ''; ?>>Çmimi (Rritës)</option>
            <option value="price_desc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] === 'price_desc') ? 'selected' : ''; ?>>Çmimi (Zbritës)</option>
            <option value="time_asc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] === 'time_asc') ? 'selected' : ''; ?>>Koha (Rritës)</option>
            <option value="time_desc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] === 'time_desc') ? 'selected' : ''; ?>>Koha (Zbritës)</option>
        </select>
        <button type="submit" class="sorting-button">Rendit</button>
    </form>

    <table class="services-table">
        <thead>
            <tr>
                <th>Emri</th>
                <th>Koha</th>
                <th>Çmimi (€)</th>
                <th>Rezervo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
                <tr>
                    <td><?php echo htmlspecialchars($service['name'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($service['time'] ?? ''); ?> minuta</td>
                    <td>
                        <div class="price-cell">
                            <?php if (isset($service['original_price'])): ?>
                                <span class="original-price">
                                    <?php echo htmlspecialchars($service['original_display_price']); ?>
                                </span>
                                <span class="new-price">
                                    <?php echo htmlspecialchars($service['display_price']); ?>
                                </span>
                            <?php else: ?>
                                <span class="new-price">
                                    <?php echo number_format($service['price'], 2); ?> €
                                </span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="book_service" value="1">
                            <input type="hidden" name="sherbim_id" value="<?php echo htmlspecialchars($service['id'] ?? ''); ?>">
                            <button type="submit" class="book-btn">Rezervo</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($show_booking_form && $selected_service !== null): ?>
        <form method="POST" action="sherbimet.php" class="modal-overlay">
            <input type="hidden" name="click_outside" value="1">
        </form>
        <div class="modal">
            <div class="modal-content">
                <form method="POST" class="close-modal-form">
                    <input type="hidden" name="close_modal" value="1">
                    <button type="submit" class="close-modal-btn">×</button>
                </form>
                <div class="modal-header">Rezervoni <?php echo htmlspecialchars($selected_service['name'] ?? 'N/A'); ?></div>
                <div class="modal-body">
                    <form class="booking-form" method="POST">
                        <input type="hidden" name="confirm_booking" value="1">
                        <input type="hidden" name="sherbim_id" value="<?php echo htmlspecialchars($selected_service['id'] ?? ''); ?>">
                        <div class="form-group">
                            <label for="booking-date">Data e Rezervimit</label>
                            <input type="date" id="booking-date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="booking-time">Orari</label>
                            <input type="time" id="booking-time" name="time" required>
                        </div>
                        <button type="submit" class="submit-btn">Konfirmo Rezervimin</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>

<footer>
    <div class="footer-container">
        <div class="footer-section">
            <img src="images/logoo2.png" class="logo1" alt="Radiant Touch Logo" />
            <p>
                Radiant Touch ofron shërbime profesionale për flokët, qerpikët dhe
                vetullat. Synojmë t’ju ndihmojmë të ndiheni të bukur çdo ditë.
            </p>
        </div>
        <div class="footer-section">
            <h3>Kategoritë</h3>
            <ul>
                <li><a href="index.php">BALLINA</a></li>
                <li><a href="sherbimet.php">SHERBIMET</a></li>
                <li><a href="galeria.php">GALERIA</a></li>
                <li><a href="Produktet.php">PRODUKTET</a></li>
                <li><a href="per_ne.php">RRETH NESH</a></li>
                <li><a href="kontakti.php">KONTAKTI</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Kontakti</h3>
            <p><i class="fas fa-map-marker-alt"></i> <a href="https://www.google.com/maps?q=Prishtine+Kosove" target="_blank" rel="noopener noreferrer" style="color: #fff; text-decoration: none;"><abbr style="text-decoration: none;" title="Republic of Kosovo">Prishtine,Kosovë</abbr></a></p>
            <p>
                <i class="fas fa-phone"></i>
                <a href="tel:+38344222222" style="color: #fff; text-decoration: none">+383 44 222 222</a>
            </p>
            <p>
                <i class="fas fa-envelope"></i>
                <a href="mailto:info@radianttouch.com" style="color: #fff; text-decoration: none">info@radianttouch.com</a>
            </p>
        </div>
    </div>
    <hr style="width: 90%; margin: 10px auto; ">
    <div class="footer-section newsletter">
        <h3>Abonohuni</h3>
        <form id="abonimform" method="POST">
            <div class="newsletter-input">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Shkruani email-in tuaj" required />
                <button type="submit" aria-label="Dërgo email">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <script>
                document.querySelector('#abonimform').addEventListener('submit', function(event) {
                    event.preventDefault();
                    const email = document.querySelector('#abonimform input[type="email"]').value;
                    if (email) {
                        alert('Faleminderit për abonimin');
                    } else {
                        alert('Ju lutem, shkruani një email të vlef');
                    }
                });
            </script>
            <div class="icons">
                <a href="https://www.facebook.com" class="icon" aria-label="Facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com" class="icon" aria-label="Instagram" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.twitter.com" class="icon" aria-label="Twitter" target="_blank"><i class="fab fa-twitter"></i></a>
            </div>
        </form>
    </div>

    <div class="footer-bottom">
        © 2025 <a href="index.php" style="text-decoration: none;"><span> Radiant Touch </span></a>. Të gjitha të drejtat janë të rezervuara.
    </div>
</footer>
</body>
</html>
</xaiArtifactetaphor>

