<?php


$nav_pages = [
    ['title' => 'Ballina', 'url' => 'index.php'],
    ['title' => 'Shërbimet', 'url' => 'sherbimet.php'],
    ['title' => 'Galeria', 'url' => 'galeria.php'],
    ['title' => 'Produktet', 'url' => 'Produktet.php'],
    ['title' => 'Rreth nesh', 'url' => 'per_ne.php'],
    ['title' => 'Kontakti', 'url' => 'kontakti.php'],
];

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/logo1.png" />
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Radiant Touch'; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
   
     
</head>
<body>
    <header>
        <nav>
            <div class="logo-cont">
                <div class="logo">
                    <a href="index.php">
                        <img src="images/logoo2.png" alt="Radiant Touch Logo" title="Radiant Touch" />
                    </a>
                </div>
                <div class="login">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="profile.php" title="User Profile">
                            <button id="loginBtn" aria-label="User Profile">
                                <i class="fa fa-user"></i>
                                <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>
                            </button>
                        </a>
                        <a href="logout.php" title="Logout">
                            <button aria-label="Logout">
                                <i class="fa fa-sign-out-alt"></i>
                            </button>
                        </a>
                    <?php else: ?>
                        <a href="login.php"><button id="loginBtn" aria-label="Login">
                            <i class="fa fa-user"></i>
                        </button></a>
                    <?php endif; ?>
                </div>
            </div>
            <div id="navi">
                <ul>
                    <?php foreach ($nav_pages as $page): ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($page['url']); ?>" 
                               class="<?php echo $current_page === $page['url'] ? 'active' : ''; ?>">
                                <?php echo htmlspecialchars($page['title']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
    </header>