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

$gallery_images = [
    ['src' => 'images/g13.jpg', 'alt' => 'Image 1'],
    ['src' => 'images/g11.jpg', 'alt' => 'Image 2'],
    ['src' => 'images/g8.jpg', 'alt' => 'Image 3'],
    ['src' => 'images/g18.jpg', 'alt' => 'Image 4'],
    ['src' => 'images/g20.jpg', 'alt' => 'Image 5'],
    ['src' => 'images/g9.jpg', 'alt' => 'Image 6'],
    ['src' => 'images/g16.jpg', 'alt' => 'Image 7'],
    ['src' => 'images/foto1.jpg', 'alt' => 'Image 8'],
    ['src' => 'images/vetlla2.jpeg', 'alt' => 'Image 9'],
    ['src' => 'images/g3.jpg', 'alt' => 'Image 10'],
    ['src' => 'images/g7.jpg', 'alt' => 'Image 11'],
    ['src' => 'images/g12.jpg', 'alt' => 'Image 12'],
    ['src' => 'images/g4.jpg', 'alt' => 'Image 13'],
    ['src' => 'images/g14.jpg', 'alt' => 'Image 14'],
    ['src' => 'images/g21.jpg', 'alt' => 'Image 15'],
    ['src' => 'images/sherbim3.jpg', 'alt' => 'Image 16']
];

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
    <title>Galeria - Radiant Touch</title>
    <link rel="icon" href="images/logo1.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        section {
            background-color: #f4e4d4;
            background-image: url('images/background.jpg'), url('images/overlay.png');
            background-size: cover, contain;
            background-position: center center, top left;
            background-attachment: fixed, scroll;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            padding: 20px 0;
        }
        .gallery-item img {
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.5);
            width: 100%;
            height: auto;
        }
        #galleryheading {
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
            text-align: center;
            color: #664f3e;
            margin: 20px 0;
        }
        .galeria {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 0 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <!-- <?php include 'header.php'; ?> -->

        <header>
    <nav>
        <div class="logo-cont">
            <div class="logo">
                <a href="index.php">
                    <img src="images/logoo2.png" alt="Radiant Touch Logo" title="Radiant Touch">
                </a>
            </div>
            <div class="login">
                <a href="login.php">
                    <button id="loginBtn">
                        <i class="fa fa-user"></i>
                    </button>
                </a>
            </div>
        </div>
        <div id="navi">
            <ul>
                <?php foreach ($nav_links as $name => $url): ?>
                    <li><a href="<?php echo htmlspecialchars($url); ?>"><?php echo htmlspecialchars($name); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>
</header>

    <section>
        <h1 id="galleryheading">Galeria</h1>
        <div class="galeria">
            <?php foreach ($gallery_images as $image): ?>
                <div class="gallery-item">
                    <img src="<?php echo htmlspecialchars($image['src']); ?>" alt="<?php echo htmlspecialchars($image['alt']); ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- <?php include 'footer.php'; ?> -->
</body>
</html>
<?php
global $nav_links;
?>

<?php
global $nav_links;
global $newsletter_message;
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
                <?php foreach ($nav_links as $name => $url): ?>
                    <li><a href="<?php echo htmlspecialchars($url); ?>"><?php echo htmlspecialchars($name); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Kontakti</h3>
            <p>
                <i class="fas fa-map-marker-alt"></i>
                <a href="https://www.google.com/maps?q=Prishtine+Kosove" target="_blank" rel="noopener noreferrer" style="color: #fff; text-decoration: none;">
                    <abbr style="text-decoration: none;" title="Republic of Kosovo">Prishtine, Kosovë</abbr>
                </a>
            </p>
            <p>
                <i class="fas fa-phone"></i>
                <a href="tel:+38344222222" style="color: #fff; text-decoration: none;">+383 44 222 222</a>
            </p>
            <p>
                <i class="fas fa-envelope"></i>
                <a href="mailto:info@radianttouch.com" style="color: #fff; text-decoration: none;">info@radianttouch.com</a>
            </p>
        </div>
    </div>
    <hr style="width: 90%; margin: 10px auto;">
    <div class="footer-section newsletter">
        <h3>Abonohuni</h3>
        <form method="POST" action="">
            <div class="newsletter-input">
                <i class="fas fa-envelope"></i>
                <input type="email" name="newsletter-email" placeholder="Shkruani email-in tuaj" required>
                <button type="submit" aria-label="Dërgo email">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
        <?php if ($newsletter_message): ?>
            <p class="message"><?php echo htmlspecialchars($newsletter_message); ?></p>
        <?php endif; ?>
        <div class="icons">
            <a href="https://www.facebook.com" class="icon" aria-label="Facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.instagram.com" class="icon" aria-label="Instagram" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.twitter.com" class="icon" aria-label="Twitter" target="_blank"><i class="fab fa-twitter"></i></a>
        </div>
    </div>
    <div class="footer-bottom">
        © <?php echo date('Y'); ?> <a href="index.php" style="text-decoration: none;"><span>Radiant Touch</span></a>. Të gjitha të drejtat janë të rezervuara.
    </div>
</footer>