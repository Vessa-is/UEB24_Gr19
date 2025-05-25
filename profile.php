<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once 'DatabaseConnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = new DatabaseConnection();
$conn = $db->startConnection();

$error = '';
$user = null;

try {
    $stmt = $conn->prepare("SELECT name, lastname, email, personalNr, birthdate FROM users WHERE id = :id");
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $error = "Përdoruesi nuk u gjet.";
    }
} catch (PDOException $e) {
    error_log(date('Y-m-d H:i:s') . " | User Profile Error: " . $e->getMessage() . "\n", 3, 'logs/errors.log');
    $error = "Ndodhi një gabim gjatë marrjes së të dhënave. Ju lutemi kontaktoni administratorin.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/logo1.png" />
    <title>Profili i Përdoruesit - Radiant Touch</title>
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
        .user-info {
            display: flex; /* Use flexbox for consistent alignment */
            align-items: center; /* Vertically align label and span */
            margin-bottom: 15px;
        }
        .user-info label {
            font-size: 15px;
            color: #7a6c59;
            width: 150px; /* Fixed width for the first column */
            text-align: left !important; /* Explicitly left-align labels */
            margin-right: 10px; /* Space between label and span */
        }
        .user-info span {
            font-size: 1rem;
            color: #333;
            flex: 1; /* Span takes remaining space */
            text-align: left; /* Left-align span, adjust if needed */
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
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Profili i Përdoruesit</h1>
        <?php if (!empty($error)) : ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php elseif ($user) : ?>
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
            <a href="logout.php" class="btn">Dil</a>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>