<?php
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$errors = [];
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, 'user-name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'user-email', FILTER_SANITIZE_EMAIL);

    // Validate inputs
    if (empty($name)) {
        $errors[] = "Emri është i detyrueshëm.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email i vlefshëm është i detyrueshëm.";
    }

    // If no errors, proceed to send email
    if (empty($errors)) {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'radiantsallon@gmail.com';
            $mail->Password = 'vlny hslz ulaj qcam';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($email, $name);
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Abonim në Newsletter nga ' . $name;
            $mail->Body = '<h3>Abonim në Newsletter</h3>' .
                          '<p><strong>Emri:</strong> ' . htmlspecialchars($name) . '</p>' .
                          '<p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>' .
                          '<p><strong>Mesazhi:</strong> Faleminderit per abonimin</p>';
            $mail->AltBody = "Emri: $name\nEmail: $email\nMesazhi: Faleminderit per abonimin";

            $mail->send();
            $success = "Faleminderit për abonimin!";
        } catch (Exception $e) {
            $errors[] = "Mesazhi nuk u dërgua. Gabim: {$mail->ErrorInfo}";
            error_log("PHPMailer Error: {$mail->ErrorInfo}", 3, "logs/email.log");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonimi në Newsletter</title>
</head>
<body>
    <script>
        <?php if (!empty($success)): ?>
            alert("<?php echo addslashes($success); ?>");
            window.location.href = "index.php";
        <?php elseif (!empty($errors)): ?>
            alert("<?php echo addslashes(implode('\n', $errors)); ?>");
            window.location.href = "index.php";
        <?php else: ?>
            window.location.href = "index.php";
        <?php endif; ?>
    </script>
</body>
</html>