<?php
session_start();
require_once 'DatabaseConnection.php'; 

$error = '';
$success = '';

try {
    $db = new DatabaseConnection();
    $conn = $db->startConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST['name']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $personalnr = trim($_POST['personalnr']);

        if (!$name || !$lastname || !$email || !$password || !$password_confirm || !$personalnr) {
            $error = "Të gjitha fushat janë të detyrueshme.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Email i pavlefshëm.";
        } elseif ($password !== $password_confirm) {
            $error = "Fjalëkalimet nuk përputhen.";
        } else {
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $error = "Ky email është përdorur më parë.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("INSERT INTO users (name, lastname, email, password, personalnr) VALUES (:name, :lastname, :email, :password, :personalnr)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':personalnr', $personalnr);

                if ($stmt->execute()) {
                    $success = "Regjistrimi u krye me sukses. Ju lutemi kyquni.";
                } else {
                    $error = "Gabim gjatë regjistrimit.";
                }
            }
        }
    }
} catch (PDOException $e) {
    error_log("Gabim gjatë regjistrimit: " . $e->getMessage(), 3, "error.log");
    $error = "Ndodhi një gabim i papritur. Ju lutemi kontaktoni administratorin.";
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
<meta charset="UTF-8" />
<title>Regjistrimi</title>
</head>
<body>
<h1>Regjistrimi</h1>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php elseif ($success): ?>
    <p style="color:green;"><?php echo $success; ?></p>
<?php endif; ?>

<form method="POST" action="">
    <label>Emri:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Mbiemri:</label><br>
    <input type="text" name="lastname" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Fjalëkalimi:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Konfirmo fjalëkalimin:</label><br>
    <input type="password" name="password_confirm" required><br><br>

    <label>Nr Personal:</label><br>
    <input type="text" name="personalnr" required><br><br>

    <button type="submit">Regjistrohu</button>
</form>

<p>Ke llogari? <a href="login.php">Kyqu këtu</a></p>

</body>
</html>
