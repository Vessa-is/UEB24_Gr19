<?php
if (isset($_COOKIE['roli'])) {
    $roli = $_COOKIE['roli'];

    if ($roli === 'admin') {
        echo "<a href='admin_dashboard.php'>Paneli i Adminit</a>";
    } elseif ($roli === 'user') {
        echo "<a href='user_dashboard.php'>Profili</a>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/logo1.png" />
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Radiant Touch'; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <header>
        <nav>
            <div class="logo-cont">
                <div class="logo">
                    <a href="index.php">
                        <img src="images/logoo2.png" alt="logo" title="Radiant Touch" />
                    </a>
                </div>
                <div class="login">
                    <a href="login.php"><button id="loginBtn" aria-label="Login">
                        <i class="fa fa-user"></i>
                    </button></a>
                </div>
            </div>
            <div id="navi">
                <ul>
                    <li><a href="index.php">Ballina</a></li>
                    <li><a href="sherbimet.php">Shërbimet</a></li>
                    <li><a href="galeria.php">Galeria</a></li>
                    <li><a href="Produktet.php">Produktet</a></li>
                    <li><a href="per_ne.php">Rreth nesh</a></li>
                    <li><a href="kontakti.php">Kontakti</a></li>
                </ul>
            </div>
        </nav>
    </header>