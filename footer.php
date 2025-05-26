<?php
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
                <a href="mailto:radiantsallon@gmail.com">radiantsallo@gmail.com</a>
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
            <p class="error-message"><?php echo htmlspecialchars($_SESSION['errors']['email'] ?? $_SESSION['errors']['server'] ?? 'Gabim i panjohur.'); ?></p>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        <form id="abonimform" method="POST" action="sendemail.php">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <div class="newsletter-input">
                <i class="fas fa-user"></i>
                <input type="text" name="user-name" placeholder="Shkruani emrin tuaj" required>
            </div>
            <div class="newsletter-input">
                <i class="fas fa-envelope"></i>
                <input type="email" name="user-email" placeholder="Shkruani email-in tuaj" required>
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
    <style>
        .success-message {
            color: #2e7d32;
            font-weight: 500;
            margin-bottom: 12px;
            font-size: 1.1rem;
            text-align: center;
        }
        .error-message {
            color: #d32f2f;
            font-weight: 500;
            margin-bottom: 12px;
            font-size: 1.1rem;
            text-align: center;
        }
    </style>
</footer>