<?php
session_start();


$nav_links = [
    'Ballina' => 'index.php',
    'Shërbimet' => 'sherbimet.php',
    'Galeria' => 'galeria.php',
    'Produktet' => 'Produktet.php',
    'Rreth nesh' => 'per_ne.php',
    'Kontakti' => 'kontakti.php'
];

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset-email'])) {
    $email = trim($_POST['reset-email']);
    if (empty($email)) {
        $message = 'Please enter your email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
    } else {
        
        $message = 'A reset link has been sent to your email.';
    }
}


$newsletter_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newsletter-email'])) {
    $newsletter_email = trim($_POST['newsletter-email']);
    if (empty($newsletter_email)) {
        $newsletter_message = 'Ju lutem, shkruani një email të vlefshëm.';
    } elseif (!filter_var($newsletter_email, FILTER_VALIDATE_EMAIL)) {
        $newsletter_message = 'Ju lutem, shkruani një email të vlefshëm.';
    } else {

        $newsletter_message = 'Faleminderit për abonimin!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo1.png">
    <title>Forgot Password - Radiant Touch</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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
            padding: 20px;
            width: 400px;
            text-align: center;
            margin: 50px auto;
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #664f3e;
        }
        .container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #dcdcdc;
            box-sizing: border-box;
        }
        .container button {
            width: 100%;
            padding: 10px;
            background-color: #664f3e;
            color: white;
            border: none;
            cursor: pointer;
        }
        .container button:hover {
            background-color: #523f31;
        }
        .message {
            color: rgba(128, 60, 0, 0.688);
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Forgot Password</h1>
        <p>Enter your email to reset your password</p>
        <form method="POST" action="">
            <input type="email" name="reset-email" placeholder="Enter your email" required>
            <button type="submit">Send Reset Link</button>
        </form>
        <?php if ($message): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
