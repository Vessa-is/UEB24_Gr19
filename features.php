<?php

// 1. KONSTANTET
define("SALON_NAME", "Radiant Touch");
define("VAT_RATE", 0.18); // 18% TVSH
define("OPENING_TIME", 9); // Salon opens at 9 AM
define("CLOSING_TIME", 20); // Salon closes at 8 PM

// 2. VARIABLAT
$currentHour = date('G');
$today = date('l'); // Dita e javës
$salonLocation = "Prishtinë";
$services = ["Shampoo", "Conditioner", "Hair Treatment", "Styling"];
$popularProducts = [
    "Blond Absolu" => 25.99,
    "Densifique" => 32.50,
    "Elixir Ultime" => 18.75
];

// 3. FUNKSIONET
/**
 * Llogarit çmimin me TVSH
 */
function calculatePriceWithVAT($price) {
    return $price * (1 + VAT_RATE);
}

/**
 * Kontrollon a eshte i hapur 
 */
function isSalonOpen($currentHour) {
    return ($currentHour >= OPENING_TIME && $currentHour < CLOSING_TIME);
}

//funskione me kushtezime per kohen
function getGreeting($hour) {
    if ($hour >= 5 && $hour < 12) return "Mirëmëngjes!";
    if ($hour >= 12 && $hour < 18) return "Mirëdita!";
    return "Mirëmbrëma!";
}

// 4. STRING FUNKSIONET
$welcomeMessage = "   Mirë se vini në " . SALON_NAME . "   ";
$welcomeMessage = trim($welcomeMessage); // Heq hapësirat
$welcomeMessage = ucfirst(strtolower($welcomeMessage)); // Shndërron në lowercase pastaj uppercase të parën
$messageLength = strlen($welcomeMessage);
$salonUpper = strtoupper(SALON_NAME);

// 5. OPERATORET
$totalProducts = count($popularProducts);
$totalValue = array_sum($popularProducts);
$averagePrice = $totalValue / $totalProducts;
$isWeekend = ($today == 'Saturday' || $today == 'Sunday');
$discount = $isWeekend ? 0.15 : 0; // 15% zbritje në fundjavë

// 6.  I var_dump() PER DEBUG
// var_dump($popularProducts); 

?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SALON_NAME ?> - Veçoritë e PHP</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #4d3a2d;
            background-color: #f4e4d4;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2 {
            color: #7c5b43;
        }
        .feature-box {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .variable-display {
            background-color: #f0e7db;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
        }
        .salon-status {
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .open {
            background-color: #d4edda;
            color: #155724;
        }
        .closed {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <header>
        <h1><?= SALON_NAME ?></h1>
        <h2>Demonstrim i Veçorive të PHP</h2>
    </header>

    <div class="feature-box">
        <h3>Përshëndetje dhe Statusi i Salonit</h3>
        <p><?= $welcomeMessage ?></p>
        <p>Gjatësia e mesazhit: <?= $messageLength ?> karaktere</p>
        
        <p class="salon-status <?= isSalonOpen($currentHour) ? 'open' : 'closed' ?>">
            <?= getGreeting($currentHour) ?> 
            Saloni <?= SALON_NAME ?> në <?= $salonLocation ?> është 
            <?= isSalonOpen($currentHour) ? 'i hapur' : 'i mbyllur' ?>.
            Orari: <?= OPENING_TIME ?>:00 - <?= CLOSING_TIME ?>:00
        </p>
    </div>

    <div class="feature-box">
        <h3>Produktet Tona</h3>
        <?php if ($isWeekend): ?>
            <p><strong>ZBIRITJE FUNDJAVOR!</strong> Të gjitha produktet me <?= ($discount * 100) ?>% zbritje!</p>
        <?php endif; ?>
        
        <ul>
            <?php foreach ($popularProducts as $product => $price): ?>
                <li>
                    <strong><?= $product ?></strong>:
                    <?= number_format($price, 2) ?>€
                    (me TVSH: <?= number_format(calculatePriceWithVAT($price), 2) ?>€)
                    <?php if ($isWeekend): ?>
                        <br><span style="color: #27ae60;">Çmimi me zbritje: <?= number_format($price * (1 - $discount), 2) ?>€</span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        
        <div class="variable-display">
            <p>Total produkte: <?= $totalProducts ?></p>
            <p>Vlera totale: <?= number_format($totalValue, 2) ?>€</p>
            <p>Çmimi mesatar: <?= number_format($averagePrice, 2) ?>€</p>
        </div>
    </div>

    <div class="feature-box">
        <h3>Shërbimet Tona</h3>
        <ul>
            <?php foreach ($services as $service): ?>
                <li><?= strtoupper($service) ?></li>
            <?php endforeach; ?>
        </ul>
        
        <div class="variable-display">
            <?php
           // STRING FUNCTIONS
            $sampleText = "  kujdesi-i-flokëve  ";
            echo "<p>Original: " . $sampleText . "</p>";
            echo "<p>Trimmed: " . trim($sampleText) . "</p>";
            echo "<p>Ucwords: " . ucwords(str_replace('-', ' ', $sampleText)) . "</p>";
            echo "<p>String length: " . strlen($sampleText) . "</p>";
            ?>
        </div>
    </div>

    <footer>
        <p>Data: <?= date('d.m.Y H:i:s') ?></p>
        <p>Saloni <?= $salonUpper ?> &copy; <?= date('Y') ?></p>
    </footer>
</body>
</html>