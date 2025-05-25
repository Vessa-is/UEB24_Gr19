<?php



if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newsletter_email'])) {
    $errors = [];

  
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $errors['server'] = 'Sesioni i pavlefshëm. Ju lutemi provoni përsëri.';
    } else {
      
        $email = filter_var(trim($_POST['newsletter_email']), FILTER_SANITIZE_EMAIL);
        if (empty($email)) {
            $errors['email'] = 'Email-i është i detyrueshëm.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email-i është i pavlefshëm.';
        }

        try {
            $db = new DatabaseConnection();
            $conn = $db->startConnection();
            if ($conn) {
                $stmt = $conn->prepare("SELECT COUNT(*) FROM subscribers WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->fetchColumn() > 0) {
                    $errors['email'] = 'Ky email është tashmë i abonuar.';
                }
            } else {
                $errors['server'] = 'Lidhja me databazën dështoi.';
            }
        } catch (PDOException $e) {
            $errors['server'] = 'Gabim gjatë verifikimit të email-it: ' . $e->getMessage();
            $handle = fopen('logs/errors.log', 'a');
            if ($handle) {
                fwrite($handle, date('Y-m-d H:i:s') . " | Subscriber Check Error: " . $e->getMessage() . "\n");
                fclose($handle);
            }
        }

        if (empty($errors)) {
            try {
              
                $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
                $stmt->execute([$email]);

              
                $to = $email;
                $subject = 'Faleminderit për Abonimin në Radiant Touch!';
                $message = "Përshëndetje,\n\nFaleminderit që u abonuat në Radiant Touch! Tani jeni pjesë e komunitetit tonë. Do të merrni përditësime për ofertat dhe shërbimet e reja.\n\nVizitoni faqen tonë: https://radianttouch.com\n\nMe respekt,\nEkipi Radiant Touch";
                $headers = "From: no-reply@radianttouch.com\r\n";
                $headers .= "Reply-To: info@radianttouch.com\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

               
                if (mail($to, $subject, $message, $headers)) {
                    $_SESSION['success_message'] = 'Abonimi u krye me sukses! Ju kemi dërguar një email konfirmimi.';
                } else {
                    $errors['server'] = 'Email-i nuk mund të dërgohej. Ju lutemi provoni përsëri.';
                    $handle = fopen('logs/errors.log', 'a');
                    if ($handle) {
                        fwrite($handle, date('Y-m-d H:i:s') . " | Email Send Error: Unable to send to $email\n");
                        fclose($handle);
                    }
                }
            } catch (PDOException $e) {
                $errors['server'] = 'Gabim gjatë abonimit: ' . $e->getMessage();
                $handle = fopen('logs/errors.log', 'a');
                if ($handle) {
                    fwrite($handle, date('Y-m-d H:i:s') . " | Subscriber Insert Error: " . $e->getMessage() . "\n");
                    fclose($handle);
                }
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    }

   
    header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
    exit();
}
?>

<footer>
    <div class="footer-container">
        <div class="footer-section">
            <img src="images/logoo2.png" class="logo1" alt="Radiant Touch Logo">
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
            <p>
                <i class="fas fa-map-marker-alt"></i>
                <a href="https://www.google.com/maps?q=Prishtine+Kosove" target="_blank" rel="noreferrer">Prishtinë, Kosovë</a>
            </p>
            <p>
                <i class="fas fa-phone"></i>
                <a href="tel:+38344222222">+383 44 222 222</a>
            </p>
            <p>
                <i class="fas fa-envelope"></i>
                <a href="mailto:info@radianttouch.com">info@radianttouch.com</a>
            </p>
        </div>
    </div>
    <hr>
    <div class="footer-section newsletter">
        <h3>Abonohuni</h3>
        <?php if (isset($_SESSION['success_message'])): ?>
            <p class="success-message"><?php echo htmlspecialchars($_SESSION['success_message']); ?></p>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['errors'])): ?>
            <p class="error-message"><?php echo htmlspecialchars($_SESSION['errors']['email'] ?? $_SESSION['errors']['server']); ?></p>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        <form id="abonimform" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <div class="newsletter-input">
                <i class="fas fa-envelope"></i>
                <input type="email" name="newsletter_email" placeholder="Shkruani email-in tuaj" required>
                <button type="submit" aria-label="Dërgo email">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <div class="icons">
                <a href="https://www.facebook.com" class="icon" aria-label="Facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com" class="icon" aria-label="Instagram" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.twitter.com" class="icon" aria-label="Twitter" target="_blank"><i class="fab fa-twitter"></i></a>
            </div>
        </form>
    </div>
    <div class="footer-bottom">
        © 2025 <a href="index.php">Radiant Touch</a>. Të gjitha të drejtat e rezervuara.
    </div>
</footer>