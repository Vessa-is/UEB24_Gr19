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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['first-name'] = sanitizeInput($_POST['first-name'] ?? '');
    $formData['last-name'] = sanitizeInput($_POST['last-name'] ?? '');
    $formData['email'] = sanitizeInput($_POST['email'] ?? '');
    $formData['password'] = $_POST['password'] ?? '';
    $formData['confirm-password'] = $_POST['confirm-password'] ?? '';
    $formData['data-e-lindjes'] = sanitizeInput($_POST['data-e-lindjes'] ?? '');
    $formData['nr-personal'] = sanitizeInput($_POST['nr-personal'] ?? '');

    if (empty($formData['first-name'])) {
        $errors['first-name'] = 'First name is required';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $formData['first-name'])) {
        $errors['first-name'] = 'First name should contain only letters';
    }

    if (empty($formData['last-name'])) {
        $errors['last-name'] = 'Last name is required';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $formData['last-name'])) {
        $errors['last-name'] = 'Last name should contain only letters';
    }

    if (empty($formData['email'])) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }

    if (empty($formData['password'])) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($formData['password']) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    }

    if (empty($formData['confirm-password'])) {
        $errors['confirm-password'] = 'Please confirm your password';
    } elseif ($formData['password'] !== $formData['confirm-password']) {
        $errors['confirm-password'] = 'Passwords do not match';
    }

    if (empty($formData['data-e-lindjes'])) {
        $errors['data-e-lindjes'] = 'Birthdate is required';
    } elseif (!preg_match('/^\d{2}\-\d{2}\-\d{4}$/', $formData['data-e-lindjes'])) {
        $errors['data-e-lindjes'] = 'Birthdate should be in DD-MM-YYYY format';
    } else {
        $date_parts = explode('-', $formData['data-e-lindjes']);
        if (count($date_parts) === 3 && !checkdate($date_parts[1], $date_parts[0], $date_parts[2])) {
            $errors['data-e-lindjes'] = 'Invalid birthdate';
        } else {
            $birthdate = DateTime::createFromFormat('d-m-Y', $formData['data-e-lindjes']);
            $today = new DateTime();
            $age = $today->diff($birthdate)->y;
            if ($age < 13) {
                $errors['data-e-lindjes'] = 'You must be at least 13 years old';
            }
        }
    }

    if (empty($formData['nr-personal'])) {
        $errors['nr-personal'] = 'Personal number is required';
    } elseif (!preg_match('/^\d{10}$/', $formData['nr-personal'])) {
        $errors['nr-personal'] = 'Personal number should be 10 digits';
    }

    if (empty($errors)) {
        try {
            $userRepository = new UserRepository();
            $personalNr = $formData['nr-personal'];
            $email = $formData['email'];
            $name = $formData['first-name'];
            $lastname = $formData['last-name'];
            $hashedPassword = password_hash($formData['password'], PASSWORD_DEFAULT);
            $birthdate = $formData['data-e-lindjes'];

            if ($userRepository->personalNrExists($personalNr)) {
                $errors['nr-personal'] = 'Ky numër personal ekziston tashmë!';
            } elseif ($userRepository->userExistsByEmail($email)) {
                $errors['email'] = 'Ky email është përdorur tashmë!';
            } else {
                $user = new User($name, $lastname, $email, $hashedPassword, $personalNr, $birthdate);
                $userRepository->insertUser($user);

                $log_file = 'logs/registrations.log';
                if (!file_exists('logs')) {
                    mkdir('logs', 0755, true);
                }
                $handle = fopen($log_file, 'a');
                if ($handle) {
                    $log_entry = date('Y-m-d H:i:s') . " | User Registered: $name $lastname | Email: $email | PersonalNr: $personalNr\n";
                    fwrite($handle, $log_entry);
                    fclose($handle);
                }

                $success = true;
            }
        } catch (Exception $e) {
            $errors['server'] = 'Registration failed: ' . $e->getMessage();
            $handle = fopen('logs/errors.log', 'a');
            if ($handle) {
                fwrite($handle, date('Y-m-d H:i:s') . " | Error: " . $e->getMessage() . "\n");
                fclose($handle);
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
    <title>Create - Radiant Touch</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
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
            background: #fff;
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
    </style>
</head>
<body class="create-page">
    <?php include 'header.php'; ?>
    <div class="register-container">
        <h1 class="register-title">Regjistrohu</h1>
        <?php if (isset($errors['server'])): ?>
            <p class="server-error"><?php echo htmlspecialchars($errors['server']); ?></p>
        <?php endif; ?>
        <form id="create-account-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="first-name" class="form-label">Emri</label>
            <input class="form-input" type="text" id="first-name" name="first-name" placeholder="First Name" value="<?php echo htmlspecialchars($formData['first-name']); ?>">
            <?php if (isset($errors['first-name'])): ?>
                <span class="error-message"><?php echo $errors['first-name']; ?></span>
            <?php endif; ?>

            <label for="last-name" class="form-label">Mbiemri</label>
            <input type="text" id="last-name" class="form-input" name="last-name" placeholder="Last Name" value="<?php echo htmlspecialchars($formData['last-name']); ?>">
            <?php if (isset($errors['last-name'])): ?>
                <span class="error-message"><?php echo $errors['last-name']; ?></span>
            <?php endif; ?>

            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" class="form-input" name="email" placeholder="Email" value="<?php echo htmlspecialchars($formData['email']); ?>">
            <?php if (isset($errors['email'])): ?>
                <span class="error-message"><?php echo $errors['email']; ?></span>
            <?php endif; ?>

            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" class="form-input" name="password" placeholder="Password">
            <?php if (isset($errors['password'])): ?>
                <span class="error-message"><?php echo $errors['password']; ?></span>
            <?php endif; ?>

            <label for="confirm-password" class="form-label">Konfirmo Password</label>
            <input type="password" id="confirm-password" class="form-input" name="confirm-password" placeholder="Confirm password">
            <?php if (isset($errors['confirm-password'])): ?>
                <span class="error-message"><?php echo $errors['confirm-password']; ?></span>
            <?php endif; ?>

            <label for="data-e-lindjes" class="form-label">Data e Lindjes (DD-MM-YYYY)</label>
            <input type="text" id="data-e-lindjes" class="form-input" name="data-e-lindjes" placeholder="DD-MM-YYYY" value="<?php echo htmlspecialchars($formData['data-e-lindjes']); ?>">
            <?php if (isset($errors['data-e-lindjes'])): ?>
                <span class="error-message"><?php echo $errors['data-e-lindjes']; ?></span>
            <?php endif; ?>

            <label for="nr-personal" class="form-label">Numri personal</label>
            <input type="text" id="nr-personal" class="form-input" name="nr-personal" placeholder="10-digit personal number" value="<?php echo htmlspecialchars($formData['nr-personal']); ?>">
            <?php if (isset($errors['nr-personal'])): ?>
                <span class="error-message"><?php echo $errors['nr-personal']; ?></span>
            <?php endif; ?>

            <button type="submit" name="signupbutton" class="submit-button">Krijo </button>
        </form>
        <div class="back-link">
            <a href="login.php">Return to Login</a>
        </div>
    </div>
    <?php if ($success): ?>
        <script>
            alert('Ju jeni regjistruar me sukses! Tani vazhdoni ne faqen login.');
            window.location.href = 'login.php';
        </script>
    <?php endif; ?>
    <?php include 'footer.php'; ?>
</body>
</html>