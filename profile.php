<?php
session_start();
require_once 'DatabaseConnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cookie_consent'])) {
    $consent = $_POST['cookie_consent'] === 'accept' ? 'accepted' : 'declined';
    setcookie('cookie_consent', $consent, time() + (365 * 24 * 60 * 60), '/', '', true, true); // Secure, HttpOnly
    if ($consent === 'accepted') {
        setcookie('user_preference', 'default_theme', time() + (365 * 24 * 60 * 60), '/', '', true, true);
    }
    header("Location: profile.php");
    exit;
}

$show_cookie_popup = !isset($_COOKIE['cookie_consent']);

$db = new DatabaseConnection();
$conn = $db->startConnection();

$user_id = $_SESSION['user_id'];
$user = null;
$rezervimet = [];
$show_update_form = false;
$update_rezervim = null;

error_log(date('Y-m-d H:i:s') . " | Fetching profile for user_id: $user_id\n", 3, 'logs/debug.log');

try {
    $stmt = $conn->prepare("SELECT name, lastname, email, personalNr, birthdate FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['error'] = "Përdoruesi nuk u gjet.";
        error_log(date('Y-m-d H:i:s') . " | User not found for user_id: $user_id\n", 3, 'logs/debug.log');
    } else {
        $stmt = $conn->prepare("
            SELECT r.id, s.name AS sherbimi, s.description, s.price, s.time, r.data_rezervimit
            FROM rezervimet r
            LEFT JOIN sherbimet s ON r.sherbim_id = s.id
            WHERE r.user_id = :user_id
            ORDER BY r.data_rezervimit DESC
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $rezervimet = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log(date('Y-m-d H:i:s') . " | Fetched " . count($rezervimet) . " reservations for user_id: $user_id\n", 3, 'logs/debug.log');
    }
} catch (PDOException $e) {
    error_log(date('Y-m-d H:i:s') . " | User Profile Error: " . $e->getMessage() . "\n", 3, 'logs/errors.log');
    $_SESSION['error'] = "Ndodhi një gabim gjatë marrjes së të dhënave. Ju lutemi kontaktoni administratorin.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['anulo_rezervimin'])) {
    $rezervim_id = filter_input(INPUT_POST, 'rezervim_id', FILTER_VALIDATE_INT);
    if ($rezervim_id) {
        try {
            error_log(date('Y-m-d H:i:s') . " | Attempting to delete reservation ID: $rezervim_id for user ID: $user_id\n", 3, 'logs/debug.log');
            
            $stmt = $conn->prepare("
                DELETE FROM rezervimet 
                WHERE id = :id AND user_id = :user_id
            ");
            $stmt->bindParam(':id', $rezervim_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['success'] = "Rezervimi u anulua me sukses!";
                error_log(date('Y-m-d H:i:s') . " | Reservation ID: $rezervim_id deleted successfully\n", 3, 'logs/debug.log');
            } else {
                $_SESSION['error'] = "Rezervimi nuk u gjet ose nuk mund të anulohej.";
                error_log(date('Y-m-d H:i:s') . " | No rows affected for reservation ID: $rezervim_id\n", 3, 'logs/debug.log');
            }
            header("Location: profile.php");
            exit;
        } catch (PDOException $e) {
            error_log(date('Y-m-d H:i:s') . " | Delete Reservation Error: " . $e->getMessage() . "\n", 3, 'logs/errors.log');
            $_SESSION['error'] = "Ndodhi një gabim gjatë anulimit. Ju lutemi kontaktoni administratorin.";
            header("Location: profile.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "ID e rezervimit nuk është e vlefshme.";
        error_log(date('Y-m-d H:i:s') . " | Invalid reservation ID: " . print_r($_POST, true) . "\n", 3, 'logs/debug.log');
        header("Location: profile.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_rezervim'])) {
    $rezervim_id = filter_input(INPUT_POST, 'rezervim_id', FILTER_VALIDATE_INT);
    if ($rezervim_id) {
        try {
            $stmt = $conn->prepare("
                SELECT r.id, r.data_rezervimit, s.name AS sherbimi
                FROM rezervimet r
                LEFT JOIN sherbimet s ON r.sherbim_id = s.id
                WHERE r.id = :id AND r.user_id = :user_id
            ");
            $stmt->bindParam(':id', $rezervim_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $update_rezervim = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($update_rezervim) {
                $show_update_form = true;
            } else {
                $_SESSION['error'] = "Rezervimi nuk u gjet ose nuk i përket përdoruesit.";
                header("Location: profile.php");
                exit;
            }
        } catch (PDOException $e) {
            error_log(date('Y-m-d H:i:s') . " | Update Reservation Error: " . $e->getMessage() . "\n", 3, 'logs/errors.log');
            $_SESSION['error'] = "Ndodhi një gabim gjatë marrjes së rezervimit. Ju lutemi kontaktoni administratorin.";
            header("Location: profile.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "ID e rezervimit nuk është e vlefshme.";
        header("Location: profile.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_update'])) {
    $rezervim_id = filter_input(INPUT_POST, 'rezervim_id', FILTER_VALIDATE_INT);
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
    $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_STRING);

    if (!$rezervim_id || !$date || !$time) {
        $_SESSION['error'] = "Ju lutem plotësoni datën dhe orën.";
        header("Location: profile.php");
        exit;
    } elseif (!preg_match('/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/', $time)) {
        $_SESSION['error'] = "Formati i orës nuk është i vlefshëm.";
        header("Location: profile.php");
        exit;
    }

    try {
        $data_rezervimit = $date . ' ' . $time . ':00';
        if (strtotime($data_rezervimit) < time()) {
            $_SESSION['error'] = "Nuk mund të përditësoni për një kohë të kaluar.";
            header("Location: profile.php");
            exit;
        }

        $ora = (int)date('H', strtotime($data_rezervimit));
        if ($ora < 8 || $ora >= 16) {
            $_SESSION['error'] = "Orari i rezervimeve është nga ora 08:00 deri në 16:00.";
            header("Location: profile.php");
            exit;
        }

        $stmt = $conn->prepare("
            SELECT COUNT(*) FROM rezervimet
            WHERE sherbim_id = (SELECT sherbim_id FROM rezervimet WHERE id = :id)
            AND data_rezervimit = :data_rezervimit
            AND id != :id
        ");
        $stmt->bindParam(':id', $rezervim_id, PDO::PARAM_INT);
        $stmt->bindParam(':data_rezervimit', $data_rezervimit);
        $stmt->execute();
        $exists = $stmt->fetchColumn();

        if ($exists > 0) {
            $_SESSION['error'] = "Ky orar është i zënë. Ju lutem zgjidhni një orar tjetër.";
            header("Location: profile.php");
            exit;
        }

        $stmt = $conn->prepare("SELECT user_id FROM rezervimet WHERE id = :id");
        $stmt->bindParam(':id', $rezervim_id, PDO::PARAM_INT);
        $stmt->execute();
        $rezervim = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($rezervim && $rezervim['user_id'] == $user_id) {
            $stmt = $conn->prepare("UPDATE rezervimet SET data_rezervimit = :data_rezervimit WHERE id = :id");
            $stmt->bindParam(':data_rezervimit', $data_rezervimit);
            $stmt->bindParam(':id', $rezervim_id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Rezervimi u përditësua me sukses.";
            } else {
                $_SESSION['error'] = "Dështoi përditësimi i rezervimit. Ju lutemi provoni përsëri.";
            }
        } else {
            $_SESSION['error'] = "Rezervimi nuk u gjet ose nuk i përket përdoruesit.";
        }
        header("Location: profile.php");
        exit;
    } catch (PDOException $e) {
        error_log(date('Y-m-d H:i:s') . " | Update Reservation Error: " . $e->getMessage() . "\n", 3, 'logs/errors.log');
        $_SESSION['error'] = "Ndodhi një gabim gjatë përditësimit. Ju lutemi kontaktoni administratorin.";
        header("Location: profile.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link rel="icon" href="images/logo1.png" />
    <title>Profili i Përdoruesit - Radiant Touch</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4e4d4;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #f9f4eb;
            border: 1px solid #dcdcdc;
            width: 700px;
            padding: 20px;
            margin: 50px auto;
        }
        .container h1 {
            font-size: 30px;
            color: #664f3e;
            text-align: center;
            margin-bottom: 20px;
        }
        .container h2 {
            font-size: 24px;
            color: #664f3e;
            text-align: center;
            margin: 30px 0 20px;
        }
        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .user-info label {
            font-size: 15px;
            color: #7a6c59;
            width: 150px;
            text-align: left;
            margin-right: 10px;
        }
        .user-info span {
            font-size: 1rem;
            color: #333;
            flex: 1;
            text-align: center;
        }
        .reservation-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .reservation-table th, .reservation-table td {
            border: 1px solid #dcdcdc;
            padding: 10px;
            text-align: center;
        }
        .reservation-table th {
            background-color: #664f3e;
            color: white;
            font-size: 15px;
        }
        .reservation-table td {
            font-size: 14px;
            color: #333;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #664f3e;
            color: white;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background-color: #523f31;
        }
        .action-btn {
            padding: 5px 10px;
            font-size: 0.9rem;
            margin: 0 5px;
        }
        .update-btn {
            background-color: #4a7043;
        }
        .update-btn:hover {
            background-color: #3a5a34;
        }
        .delete-btn {
            background-color: #a94442;
        }
        .delete-btn:hover {
            background-color: #8b3a38;
        }
        .error, .success {
            text-align: center;
            margin-bottom: 15px;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
        .no-reservations {
            text-align: center;
            font-size: 1rem;
            color: #7a6c59;
            margin-top: 20px;
        }
        .update-form {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #dcdcdc;
            background-color: #fff;
        }
        .update-form label {
            display: block;
            margin-bottom: 5px;
            color: #7a6c59;
        }
        .update-form input {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #dcdcdc;
            border-radius: 4px;
        }
        .update-form button {
            width: 100%;
            padding: 10px;
            background-color: #4a7043;
            color: white;
            border: none;
            cursor: pointer;
        }
        .update-form button:hover {
            background-color: #3a5a34;
        }
        .cookie-popup {
            display: none;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f9f4eb;
            border: 1px solid #dcdcdc;
            padding: 20px;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            text-align: center;
            border-radius: 10px;
        }
        .cookie-popup p {
            font-size: 16px;
            color: #473524;
            margin-bottom: 20px;
        }
        .cookie-popup button {
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .cookie-popup .accept-btn {
            background-color: #664f3e;
            color: white;
        }
        .cookie-popup .accept-btn:hover {
            background-color: #523f31;
        }
        .cookie-popup .decline-btn {
            background-color: #a94442;
            color: white;
        }
        .cookie-popup .decline-btn:hover {
            background-color: #8b3a38;
        }
        .cookie-popup a {
            color: #664f3e;
            text-decoration: underline;
        }
        .cookie-popup a:hover {
            color: #523f31;
        }
        .cookie-settings {
            text-align: center;
            margin-top: 20px;
        }
        .cookie-settings a {
            color: #664f3e;
            text-decoration: underline;
            cursor: pointer;
        }
        .cookie-settings a:hover {
            color: #523f31;
        }
    </style>
    <script>
        function confirmDelete(rezervimId) {
            if (confirm("Jeni të sigurt që dëshironi të fshini këtë rezervim?")) {
                console.log("Submitting delete form for ID: " + rezervimId);
                document.getElementById('delete-form-' + rezervimId).submit();
            }
        }

        $(document).ready(function() {
            <?php if ($show_cookie_popup): ?>
                $("#cookiePopup").fadeIn();
            <?php endif; ?>

            window.showCookiePopup = function() {
                $("#cookiePopup").fadeIn();
            };
        });
    </script>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Profili i Përdoruesit</h1>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<p class="error">' . htmlspecialchars($_SESSION['error']) . '</p>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<p class="success">' . htmlspecialchars($_SESSION['success']) . '</p>';
            unset($_SESSION['success']);
        }
        ?>
        <?php if ($user) : ?>
            <div class="user-info">
                <label>Emri:</label>
                <span><?php echo htmlspecialchars($user['name']); ?></span>
            </div>
            <div class="user-info">
                <label>Mbiemri:</label>
                <span><?php echo htmlspecialchars($user['lastname']); ?></span>
            </div>
            <div class="user-info">
                <label>Email:</label>
                <span><?php echo htmlspecialchars($user['email']); ?></span>
            </div>
            <div class="user-info">
                <label>Numri Personal:</label>
                <span><?php echo htmlspecialchars($user['personalNr']); ?></span>
            </div>
            <div class="user-info">
                <label>Data e Lindjes:</label>
                <span><?php echo htmlspecialchars($user['birthdate']); ?></span>
            </div>

            <h2>Historiku i Rezervimeve</h2>
            <?php if ($show_update_form && $update_rezervim) : ?>
                <div class="update-form">
                    <h3>Përditëso Rezervimin: <?php echo htmlspecialchars($update_rezervim['sherbimi'] ?? 'N/A'); ?></h3>
                    <form method="POST" action="">
                        <input type="hidden" name="rezervim_id" value="<?php echo htmlspecialchars($update_rezervim['id']); ?>">
                        <label>Data:</label>
                        <input type="date" name="date" value="<?php echo htmlspecialchars(date('Y-m-d', strtotime($update_rezervim['data_rezervimit']))); ?>" required>
                        <label>Ora:</label>
                        <input type="time" name="time" value="<?php echo htmlspecialchars(date('H:i', strtotime($update_rezervim['data_rezervimit']))); ?>" required>
                        <button type="submit" name="confirm_update">Përditëso</button>
                    </form>
                </div>
            <?php endif; ?>
            <?php if (empty($rezervimet)) : ?>
                <p class="no-reservations">Nuk ka rezervime të regjistruara.</p>
            <?php else : ?>
                <table class="reservation-table">
                    <thead>
                        <tr>
                            <th>Shërbimi</th>
                            <th>Përshkrimi</th>
                            <th>Çmimi</th>
                            <th>Kohëzgjatja (min)</th>
                            <th>Data dhe Ora</th>
                            <th>Veprime</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rezervimet as $rezervim) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($rezervim['sherbimi'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($rezervim['description'] ?? 'Nuk ka përshkrim'); ?></td>
                                <td><?php echo htmlspecialchars(isset($rezervim['price']) ? number_format($rezervim['price'], 2) : 'N/A'); ?> €</td>
                                <td><?php echo htmlspecialchars($rezervim['time'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($rezervim['data_rezervimit']))); ?></td>
                                <td>
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="rezervim_id" value="<?php echo htmlspecialchars($rezervim['id']); ?>">
                                        <button type="submit" name="update_rezervim" class="btn action-btn update-btn">Përditëso</button>
                                    </form>
                                    <form id="delete-form-<?php echo htmlspecialchars($rezervim['id']); ?>" method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="rezervim_id" value="<?php echo htmlspecialchars($rezervim['id']); ?>">
                                        <input type="hidden" name="anulo_rezervimin" value="1">
                                        <button type="button" onclick="confirmDelete(<?php echo htmlspecialchars($rezervim['id']); ?>)" class="btn action-btn delete-btn">Anulo</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <a href="logout.php" class="btn">Dil</a>
        <?php else : ?>
            <p class="error">Përdoruesi nuk u gjet. Ju lutemi dilni dhe hyni përsëri.</p>
            <a href="logout.php" class="btn">Dil</a>
        <?php endif; ?>

        <div class="cookie-popup" id="cookiePopup">
            <p>
                Ne përdorim cookies për të përmirësuar përvojën tuaj në faqen tonë. 
                Duke vazhduar, ju pranoni përdorimin e cookies. 
                <a href="privacy.php">Mëso më shumë</a>.
            </p>
            <form method="POST" action="">
                <input type="hidden" name="cookie_consent" value="accept">
                <button type="submit" class="accept-btn">Prano</button>
            </form>
            <form method="POST" action="">
                <input type="hidden" name="cookie_consent" value="decline">
                <button type="submit" class="decline-btn">Refuzo</button>
            </form>
        </div>

        <div class="cookie-settings">
            <a onclick="showCookiePopup()">Përditëso Preferencat e Cookies</a>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>