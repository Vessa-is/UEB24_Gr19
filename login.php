<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once 'DatabaseConnection.php';
$db = new DatabaseConnection();
$conn = $db->startConnection();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!$email || !$password) {
        $error = "Ju lutem plotësoni të gjitha fushat.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Ju lutem jepni një email të vlefshëm.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name']; // Match header.php variable
                setcookie('user_email', $user['email'], time() + (86400 * 30), "/");
                header("Location: index.php");
                exit();
            } else {
                $error = "Email ose fjalëkalim i pasaktë.";
            }
        } catch (PDOException $e) {
            error_log(date('Y-m-d H:i:s') . " | Login Error: " . $e->getMessage() . "\n", 3, 'logs/errors.log');
            $error = "Ndodhi një gabim gjatë kyçjes. Ju lutemi kontaktoni administratorin.";
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
    <title>Login - Radiant Touch</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
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
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-size: 15px;
            margin-bottom: 5px;
            color: #7a6c59;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #dcdcdc;
            background-color: #f9f4eb;
            font-size: 1rem;
        }
        .form-group a {
            display: block;
            font-size: 0.8rem;
            color: #664f3e;
            text-decoration: none;
            margin-top: 5px;
        }
        .form-group a:hover {
            text-decoration: underline;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #664f3e;
            color: white;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            margin-bottom: 10px;
        }
        .btn:hover {
            background-color: #523f31;
        }
        .or {
            text-align: center;
            font-size: 0.9rem;
            color: #999;
            margin: 10px 0;
        }
        .create-account {
            display: block;
            width: 100%;
            padding: 10px;
            border: 1px solid #dcdcdc;
            text-align: center;
            font-size: 1rem;
            color: #664f3e;
            text-decoration: none;
        }
        .create-account:hover {
            background-color: #f4ebe4;
        }
    </style>
    <script src="javascript.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Login</h1>
        <?php if (!empty($error)) : ?>
            <p style="color:red; text-align:center;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form id="login-form" action="" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input name="email" type="email" id="email" placeholder="Email-i" required>
            </div>
            <div class="form-group">
                <label for="password">Fjalëkalimi</label>
                <input name="password" type="password" id="password" placeholder="Password" required>
            </div>
        
            <button type="submit" class="btn">Log In</button>
        </form>
        <div class="or">or</div>
        <a href="create_account.php" class="create-account">Create account</a>
    </div>
    <script>
        function validateLoginFields(email, password) {
            if (!email || !password) {
                throw new Error('Të gjitha fushat janë të detyrueshme.');
            }
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                throw new Error('Ju lutem jepni një adresë email-i të vlefshme.');
            }
            if (password.length < 6) {
                throw new Error('Fjalëkalimi duhet të jetë të paktën 6 karaktere.');
            }
        }

        document.querySelector('#login-form').addEventListener('submit', function(event) {
            const email = document.querySelector('#email').value;
            const password = document.querySelector('#password').value;
            try {
                validateLoginFields(email, password);
            } catch (error) {
                event.preventDefault();
                alert(error.message);
            }
        });
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>