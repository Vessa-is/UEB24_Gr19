<?php

if (!isset($_SESSION)) {
    session_start();
}
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
    
</head>
<body>
 <?php include 'header.php'; ?> 

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

        <?php if ($newsletter_message): ?>
            <p class="message"><?php echo htmlspecialchars($newsletter_message); ?></p>
        <?php endif; ?>