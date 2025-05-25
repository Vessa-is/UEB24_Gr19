<?php
session_start();

$formData = [
    'first-name' => '',
    'last-name' => '',
    'email' => '',
    'password' => '',
    'confirm-password' => '',
    'data-e-lindjes' => '',
    'nr-personal' => ''
];

include 'script/classes/UserRepository.php';
require_once 'script/classes/User.php';

$errors = [];
$success = false;

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cookie_consent'])) {
    $consent = $_POST['cookie_consent'] === 'accept' ? 'accepted' : 'declined';
    setcookie('cookie_consent', $consent, time() + (365 * 24 * 60 * 60), '/', '', true, true); // Secure, HttpOnly
    if ($consent === 'accepted') {
        setcookie('user_preference', 'default_theme', time() + (365 * 24 * 60 * 60), '/', '', true, true);
    }
    header("Location: create.php");
    exit;
}

$show_cookie_popup = !isset($_COOKIE['cookie_consent']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signupbutton'])) {
    $formData['first-name'] = sanitizeInput($_POST['first-name'] ?? '');
    $formData['last-name'] = sanitizeInput($_POST['last-name'] ?? '');
    $formData['email'] = sanitizeInput(strtolower($_POST['email'] ?? '')); // Normalize to lowercase
    $formData['password'] = $_POST['password'] ?? '';
    $formData['confirm-password'] = $_POST['confirm-password'] ?? '';
    $formData['data-e-lindjes'] = sanitizeInput($_POST['data-e-lindjes'] ?? '');
    $formData['nr-personal'] = sanitizeInput($_POST['nr-personal'] ?? '');

    error_log(date('Y-m-d H:i:s') . " | Email input: {$formData['email']}\n", 3, 'logs/debug.log');

    if (empty($formData['first-name'])) {
        $errors['first-name'] = 'Emri është i detyrueshëm';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $formData['first-name'])) {
        $errors['first-name'] = 'Emri duhet të përmbajë vetëm shkronja';
    }

    if (empty($formData['last-name'])) {
        $errors['last-name'] = 'Mbiemri është i detyrueshëm';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $formData['last-name'])) {
        $errors['last-name'] = 'Mbiemri duhet të përmbajë vetëm shkronja';
    }

    if (empty($formData['email'])) {
        $errors['email'] = 'Email është i detyrueshëm';
        error_log(date('Y-m-d H:i:s') . " | Email validation failed: Empty email\n", 3, 'logs/debug.log');
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Ju lutem jepni një adresë email të vlefshme';
        error_log(date('Y-m-d H:i:s') . " | Email validation failed: Invalid format ({$formData['email']})\n", 3, 'logs/debug.log');
    }

    if (empty($formData['password'])) {
        $errors['password'] = 'Fjalëkalimi është i detyrueshëm';
    } elseif (strlen($formData['password']) < 6) {
        $errors['password'] = 'Fjalëkalimi duhet të jetë të paktën 6 karaktere';
    }

    if (empty($formData['confirm-password'])) {
        $errors['confirm-password'] = 'Ju lutem konfirmoni fjalëkalimin';
    } elseif ($formData['password'] !== $formData['confirm-password']) {
        $errors['confirm-password'] = 'Fjalëkalimet nuk përputhen';
    }

    if (empty($formData['data-e-lindjes'])) {
        $errors['data-e-lindjes'] = 'Data e lindjes është e detyrueshme';
    } elseif (!preg_match('/^\d{2}\-\d{2}\-\d{4}$/', $formData['data-e-lindjes'])) {
        $errors['data-e-lindjes'] = 'Data e lindjes duhet të jetë në formatin DD-MM-YYYY';
    } else {
        $date_parts = explode('-', $formData['data-e-lindjes']);
        if (count($date_parts) === 3 && !checkdate($date_parts[1], $date_parts[0], $date_parts[2])) {
            $errors['data-e-lindjes'] = 'Data e lindjes është e pavlefshme';
        } else {
            $birthdate = DateTime::createFromFormat('d-m-Y', $formData['data-e-lindjes']);
            $today = new DateTime();
            $age = $today->diff($birthdate)->y;
            if ($age < 13) {
                $errors['data-e-lindjes'] = 'Duhet të jeni të paktën 13 vjeç';
            }
        }
    }

    if (empty($formData['nr-personal'])) {
        $errors['nr-personal'] = 'Numri personal është i detyrueshëm';
    } elseif (!preg_match('/^\d{10}$/', $formData['nr-personal'])) {
        $errors['nr-personal'] = 'Numri personal duhet të jetë 10 shifra';
    }

    if (empty($errors)) {
        try {
            $userRepository = new UserRepository();
            $personalNr = $formData['nr-personal'];
            $email = $formData['email'];
            $name = $formData['first-name'];
            $lastname = $formData['last-name'];
            $hashedPassword = password_hash($formData['password'], PASSWORD_DEFAULT);
            $birthdateFormatted = $birthdate ? $birthdate->format('Y-m-d') : '';

            if ($userRepository->personalNrExists($personalNr)) {
                $errors['nr-personal'] = 'Ky numër personal ekziston tashmë!';
            } elseif ($userRepository->userExistsByEmail($email)) {
                $errors['email'] = 'Ky email është përdorur tashmë!';
                error_log(date('Y-m-d H:i:s') . " | Duplicate email attempt: $email\n", 3, 'logs/debug.log');
            } else {
                $user = new User($name, $lastname, $email, $hashedPassword, $personalNr, $birthdateFormatted);
                $userRepository->insertUser($user);

                // Log registration
                $log_file = 'logs/registrations.log';
                if (!file_exists('logs')) {
                    mkdir('logs', 0755, true);
                }
                $log_entry = date('Y-m-d H:i:s') . " | User Registered: $name $lastname | Email: $email | PersonalNr: $personalNr\n";
                error_log($log_entry, 3, $log_file);
                error_log(date('Y-m-d H:i:s') . " | User inserted: $email\n", 3, 'logs/debug.log');

                $success = true;
            }
        } catch (Exception $e) {
            $errors['server'] = 'Regjistrimi dështoi. Ju lutemi provoni përsëri.';
            error_log(date('Y-m-d H:i:s') . " | Registration Error: " . $e->getMessage() . "\n", 3, 'logs/errors.log');
        }
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
    <title>Regjistrohu - Radiant Touch</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style.css" />
    <style>
        .create-page {
            background-color: #f4e4d4;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .register-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f9f4eb;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            color: #4d3a2d;
        }
        .register-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.8em;
            color: #7c5b43;
        }
        #create-account-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .form-label {
            font-size: 14px;
            color: #4d3a2d;
            margin-bottom: 5px;
        }
        .form-input {
            padding: 10px;
            border: 1px solid #d6c6b8;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }
        .submit-button {
            background-color: #7c5b43;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .submit-button:hover {
            background-color: #473524;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #7c5b43;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        .server-error {
            color: red;
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
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
</head>
<body class="create-page">
    <?php include 'header.php'; ?>
    <div class="register-container">
        <h1 class="register-title">Regjistrohu</h1>
        <?php if (isset($errors['server'])): ?>
            <p class="server-error"><?php echo htmlspecialchars($errors['server']); ?></p>
        <?php endif; ?>
        <form id="create-account-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
            <label for="first-name" class="form-label">Emri</label>
            <input class="form-input" type="text" id="first-name" name="first-name" placeholder="Emri" value="<?php echo htmlspecialchars($formData['first-name']); ?>">
            <?php if (isset($errors['first-name'])): ?>
                <span class="error-message"><?php echo htmlspecialchars($errors['first-name']); ?></span>
            <?php endif; ?>

            <label for="last-name" class="form-label">Mbiemri</label>
            <input class="form-input" type="text" id="last-name" name="last-name" placeholder="Mbiemri" value="<?php echo htmlspecialchars($formData['last-name']); ?>">
            <?php if (isset($errors['last-name'])): ?>
                <span class="error-message"><?php echo htmlspecialchars($errors['last-name']); ?></span>
            <?php endif; ?>

            <label for="email" class="form-label">Email</label>
            <input class="form-input" type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($formData['email']); ?>" required>
            <?php if (isset($errors['email'])): ?>
                <span class="error-message"><?php echo htmlspecialchars($errors['email']); ?></span>
            <?php endif; ?>

            <label for="password" class="form-label">Fjalëkalimi</label>
            <input class="form-input" type="password" id="password" name="password" placeholder="Fjalëkalimi">
            <?php if (isset($errors['password'])): ?>
                <span class="error-message"><?php echo htmlspecialchars($errors['password']); ?></span>
            <?php endif; ?>

            <label for="confirm-password" class="form-label">Konfirmo Fjalëkalimin</label>
            <input class="form-input" type="password" id="confirm-password" name="confirm-password" placeholder="Konfirmo fjalëkalimin">
            <?php if (isset($errors['confirm-password'])): ?>
                <span class="error-message"><?php echo htmlspecialchars($errors['confirm-password']); ?></span>
            <?php endif; ?>

            <label for="data-e-lindjes" class="form-label">Data e Lindjes (DD-MM-YYYY)</label>
            <input class="form-input" type="text" id="data-e-lindjes" name="data-e-lindjes" placeholder="DD-MM-YYYY" value="<?php echo htmlspecialchars($formData['data-e-lindjes']); ?>">
            <?php if (isset($errors['data-e-lindjes'])): ?>
                <span class="error-message"><?php echo htmlspecialchars($errors['data-e-lindjes']); ?></span>
            <?php endif; ?>

            <label for="nr-personal" class="form-label">Numri Personal</label>
            <input class="form-input" type="text" id="nr-personal" name="nr-personal" placeholder="Numër personal 10-shifror" value="<?php echo htmlspecialchars($formData['nr-personal']); ?>">
            <?php if (isset($errors['nr-personal'])): ?>
                <span class="error-message"><?php echo htmlspecialchars($errors['nr-personal']); ?></span>
            <?php endif; ?>

            <button type="submit" name="signupbutton" class="submit-button">Krijo</button>
        </form>
        <div class="back-link">
            <a href="login.php">Kthehu te Hyrja</a>
        </div>

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
    <?php if ($success): ?>
        <script>
            alert('Ju jeni regjistruar me sukses! Ju lutemi hyni për të vazhduar.');
            window.location.href = 'login.php';
        </script>
    <?php endif; ?>
    <script>
        $(document).ready(function() {
            <?php if ($show_cookie_popup): ?>
                $("#cookiePopup").fadeIn();
            <?php endif; ?>
            window.showCookiePopup = function() {
                $("#cookiePopup").fadeIn();
            };
        });
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>