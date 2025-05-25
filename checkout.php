<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=checkout.php");
    exit();
}

include 'greeting.php';
require_once 'DatabaseConnection.php';
require_once 'vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Fetch product stock
$products_stock = [];
try {
    $db = new DatabaseConnection();
    $conn = $db->startConnection();
    if ($conn) {
        $stmt = $conn->query("SELECT id, stock, name, price FROM products");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products_stock[$row['id']] = [
                'stock' => $row['stock'],
                'name' => $row['name'],
                'price' => $row['price']
            ];
        }
    } else {
        $error_message = "Lidhja me databazën dështoi.";
    }
} catch (PDOException $e) {
    $error_message = "Gabim gjatë marrjes së stokut: " . $e->getMessage();
}

// Initialize form data and errors
$form_data = [
    'street' => $_POST['street'] ?? '',
    'city' => $_POST['city'] ?? '',
    'postal_code' => $_POST['postal_code'] ?? '',
    'country' => $_POST['country'] ?? 'XK',
    'payment' => $_POST['payment'] ?? 'cash'
];
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
    // Server-side validation
    $street = trim($_POST['street'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $postal_code = trim($_POST['postal_code'] ?? '');
    $country = $_POST['country'] ?? '';
    $payment = $_POST['payment'] ?? '';

    // Street
    if (empty($street)) {
        $errors['street'] = 'Street is required';
    } elseif (!preg_match('/^[a-zA-Z0-9\s,.-]+$/', $street)) {
        $errors['street'] = 'Street should contain letters, numbers, spaces, commas, periods, or hyphens';
    }

    // City
    if (empty($city)) {
        $errors['city'] = 'City is required';
    } elseif (!preg_match('/^[a-zA-Z\s\'-]+$/', $city)) {
        $errors['city'] = 'City should contain letters, spaces, hyphens, or apostrophes';
    }

    // Postal code
    $postal_code_formats = [
        'XK' => '/^[0-9]{5}$/', // Kosovo
        'AL' => '/^[0-9]{4}$/', // Albania
        'DE' => '/^[0-9]{5}$/', // Germany
        'FR' => '/^[0-9]{5}$/', // France
        'GB' => '/^[A-Z0-9\s]{5,8}$/', // UK
        'default' => '/^[0-9A-Z\s-]{4,10}$/' // General
    ];
    $postal_regex = $postal_code_formats[$country] ?? $postal_code_formats['default'];
    if (empty($postal_code)) {
        $errors['postal_code'] = 'Postal code is required';
    } elseif (!preg_match($postal_regex, $postal_code)) {
        $errors['postal_code'] = "Invalid postal code for $country";
    }

    // Country
    $valid_countries = ['AL','AD','AM','AT','AZ','BY','BE','BA','BG','HR','CY','CZ','DK','EE','FI','FR','GE','DE','GR','HU','IS','IE','IT','KZ','XK','LV','LI','LT','LU','MT','MD','MC','ME','NL','MK','NO','PL','PT','RO','RU','SM','RS','SK','SI','ES','SE','CH','TR','UA','GB','VA','AX','FO','GI','GG','IM','JE','SJ','UM'];
    if (!in_array($country, $valid_countries)) {
        $errors['country'] = 'Please select a valid country';
    }

    // Payment
    if (!in_array($payment, ['cash', 'card'])) {
        $errors['payment'] = 'Invalid payment method';
    }

    // Cart
    $cart = json_decode($_POST['cart_json'] ?? '[]', true);
    if (empty($cart)) {
        $errors['cart'] = 'Shporta është bosh!';
    } else {
        // Validate stock
        $grouped_cart = [];
        foreach ($cart as $item) {
            $id = $item['id'];
            if (!isset($grouped_cart[$id])) {
                $grouped_cart[$id] = ['quantity' => 0, 'price' => $item['price']];
            }
            $grouped_cart[$id]['quantity']++;
        }
        foreach ($grouped_cart as $id => $data) {
            if (!isset($products_stock[$id]) || $products_stock[$id]['stock'] < $data['quantity']) {
                $errors['cart'] = "Nuk ka stok të mjaftueshëm për {$products_stock[$id]['name']}!";
                break;
            }
        }
    }

    // Process order if no errors
    if (empty($errors)) {
        try {
            $conn->beginTransaction();

            // Calculate total
            $total = array_sum(array_map(function($item) use ($grouped_cart) {
                return $grouped_cart[$item['id']]['quantity'] * $item['price'];
            }, $cart));

            // Insert order
            $stmt = $conn->prepare("
                INSERT INTO orders (user_id, street, city, postal_code, country, payment_method, total)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $_SESSION['user_id'],
                $street,
                $city,
                $postal_code,
                $country,
                $payment,
                $total
            ]);
            $order_id = $conn->lastInsertId();

            // Insert order items
            $stmt = $conn->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, price)
                VALUES (?, ?, ?, ?)
            ");
            foreach ($grouped_cart as $id => $data) {
                $stmt->execute([$order_id, $id, $data['quantity'], $data['price']]);
            }

            // Update stock
            $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
            foreach ($grouped_cart as $id => $data) {
                $stmt->execute([$data['quantity'], $id]);
            }

            // Send confirmation email
            $user_email = $_SESSION['user_email'] ?? 'unknown@example.com';
            $delivery_times = [
                'AL' => '2-3 ditë', 'AD' => '4-6 ditë', 'AM' => '4-6 ditë', 'AT' => '3-5 ditë', 'AZ' => '4-6 ditë',
                'BY' => '4-6 ditë', 'BE' => '3-5 ditë', 'BA' => '2-3 ditë', 'BG' => '2-3 ditë', 'HR' => '2-3 ditë',
                'CY' => '4-6 ditë', 'CZ' => '3-5 ditë', 'DK' => '3-5 ditë', 'EE' => '4-6 ditë', 'FI' => '5-7 ditë',
                'FR' => '3-5 ditë', 'GE' => '4-6 ditë', 'DE' => '3-5 ditë', 'GR' => '2-3 ditë', 'HU' => '3-5 ditë',
                'IS' => '5-7 ditë', 'IE' => '3-5 ditë', 'IT' => '3-5 ditë', 'KZ' => '4-6 ditë', 'XK' => '2-3 ditë',
                'LV' => '4-6 ditë', 'LI' => '3-5 ditë', 'LT' => '4-6 ditë', 'LU' => '3-5 ditë', 'MT' => '4-6 ditë',
                'MD' => '4-6 ditë', 'MC' => '4-6 ditë', 'ME' => '2-3 ditë', 'NL' => '3-5 ditë', 'MK' => '2-3 ditë',
                'NO' => '5-7 ditë', 'PL' => '3-5 ditë', 'PT' => '3-5 ditë', 'RO' => '2-3 ditë', 'RU' => '4-6 ditë',
                'SM' => '4-6 ditë', 'RS' => '2-3 ditë', 'SK' => '3-5 ditë', 'SI' => '3-5 ditë', 'ES' => '3-5 ditë',
                'SE' => '5-7 ditë', 'CH' => '3-5 ditë', 'TR' => '2-3 ditë', 'UA' => '4-6 ditë', 'GB' => '3-5 ditë',
                'VA' => '4-6 ditë', 'AX' => '5-7 ditë', 'FO' => '5-7 ditë', 'GI' => '4-6 ditë', 'GG' => '4-6 ditë',
                'IM' => '4-6 ditë', 'JE' => '4-6 ditë', 'SJ' => '5-7 ditë', 'UM' => '5-7 ditë'
            ];
            $delivery_time = $delivery_times[$country] ?? '3-7 ditë';

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'radianttouch.salon@gmail.com'; // Replace with your Gmail
            $mail->Password = 'abcd efgh ijkl mnop'; // Replace with App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('radianttouch.salon@gmail.com', 'Radiant Touch');
            $mail->addAddress($user_email);
            $mail->isHTML(true);
            $mail->Subject = 'Order Confirmation - Radiant Touch';
            $items_html = '<ul>';
            foreach ($grouped_cart as $id => $data) {
                $items_html .= "<li>{$products_stock[$id]['name']} - Quantity: {$data['quantity']} - Price: €{$data['price']}</li>";
            }
            $items_html .= '</ul>';
            $mail->Body = "
                <h2>Thank You for Your Order!</h2>
                <p>Order ID: $order_id</p>
                <p>Address: $street, $city, $postal_code, $country</p>
                <p>Payment Method: " . ($payment === 'cash' ? 'Cash' : 'Card') . "</p>
                <p>Items: $items_html</p>
                <p>Total: €" . number_format($total, 2) . "</p>
                <p>Estimated Delivery: $delivery_time</p>
                <p>Best regards,<br>Radiant Touch Team</p>
            ";
            $mail->AltBody = "Thank You for Your Order!\nOrder ID: $order_id\nAddress: $street, $city, $postal_code, $country\nPayment Method: " . ($payment === 'cash' ? 'Cash' : 'Card') . "\nTotal: €" . number_format($total, 2) . "\nEstimated Delivery: $delivery_time\nBest regards, Radiant Touch Team";
            $mail->send();

            $conn->commit();

            // Clear cart
            $_SESSION['success_message'] = "Porosia u konfirmua me sukses! Ju kemi dërguar një email konfirmimi.";
            header("Location: Produktet.php");
            exit();
        } catch (PDOException $e) {
            $conn->rollBack();
            $errors['server'] = "Gabim gjatë procesimit të porosisë: " . $e->getMessage();
        } catch (Exception $e) {
            $conn->rollBack();
            $errors['server'] = "Dështoi dërgimi i email-it: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagesa - Radiant Touch</title>
    <link rel="icon" href="images/logo1.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/4.1.5/css/flag-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4e4d4;
            margin: 0;
            padding: 0;
        }
        .checkout-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            color: #4d3a2d;
        }
        .checkout-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5em;
        }
        #cartItems {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }
        #cartItems li {
            padding: 15px;
            background: #f0e7db;
            margin-bottom: 10px;
            border-radius: 8px;
            border: 1px solid #d6c6b8;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.2s, background-color 0.2s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        #cartItems li:hover {
            transform: scale(1.02);
            background-color: #e8dfd3;
        }
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .quantity-controls button {
            background-color: #7c5b43;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .quantity-controls button:hover {
            background-color: #473524;
        }
        .stock-warning {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }
        .total {
            font-size: 1.2em;
            margin: 20px 0;
            text-align: right;
            color: #4d3a2d;
        }
        .payment-method, .address-section {
            margin: 20px 0;
        }
        .payment-method h3, .address-section h3 {
            margin-bottom: 10px;
            color: #4d3a2d;
            font-size: 18px;
        }
        .payment-method label {
            margin-right: 20px;
            font-size: 15px;
            color: #6d4c3d;
        }
        .payment-method input {
            margin-right: 5px;
        }
        .address-section .address-container {
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }
        .address-section input, .country-select {
            flex: 1;
            padding: 8px;
            border: 1px solid #d6c6b8;
            border-radius: 5px;
            font-size: 13px;
            color: #6d4c3d;
            background-color: #fff;
        }
        .country-select {
            min-width: 150px;
        }
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }
        .success-message {
            color: green;
            font-size: 14px;
            text-align: center;
            margin-bottom: 20px;
        }
        .server-error {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 20px;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        .confirm-button, .back-button {
            background-color: #7c5b43;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1em;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .confirm-button:hover, .back-button:hover {
            background-color: #473524;
        }
        @media (max-width: 600px) {
            .address-section .address-container {
                flex-direction: column;
            }
            .address-section input, .country-select {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="checkout-container">
        <h2><i class="fas fa-credit-card"></i> Pagesa</h2>
        <?php if (isset($error_message)): ?>
            <p class="server-error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <?php if (isset($errors['server'])): ?>
            <p class="server-error"><?php echo htmlspecialchars($errors['server']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['success_message'])): ?>
            <p class="success-message"><?php echo htmlspecialchars($_SESSION['success_message']); ?></p>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        <ul id="cartItems"></ul>
        <div class="total">
            Totali: €<span id="totalPrice">0</span>
        </div>
        <form id="checkout-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="hidden" name="cart_json" id="cart_json">
            <div class="address-section">
                <h3>Adresa e Dorëzimit</h3>
                <div class="address-container">
                    <div>
                        <input type="text" id="street" name="street" placeholder="Street" value="<?php echo htmlspecialchars($form_data['street']); ?>" required>
                        <?php if (isset($errors['street'])): ?>
                            <span class="error-message"><?php echo $errors['street']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <input type="text" id="city" name="city" placeholder="City" value="<?php echo htmlspecialchars($form_data['city']); ?>" required>
                        <?php if (isset($errors['city'])): ?>
                            <span class="error-message"><?php echo $errors['city']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <input type="text" id="postal_code" name="postal_code" placeholder="Postal Code" value="<?php echo htmlspecialchars($form_data['postal_code']); ?>" required>
                        <?php if (isset($errors['postal_code'])): ?>
                            <span class="error-message"><?php echo $errors['postal_code']; ?></span>
                        <?php endif; ?>
                    </div>
                    <select class="country-select" id="country" name="country" required>
                        <option value="AL" <?php echo $form_data['country'] === 'AL' ? 'selected' : ''; ?>>Albania (Shqipëri)</option>
                        <option value="AD" <?php echo $form_data['country'] === 'AD' ? 'selected' : ''; ?>>Andorra</option>
                        <option value="AM" <?php echo $form_data['country'] === 'AM' ? 'selected' : ''; ?>>Armenia</option>
                        <option value="AT" <?php echo $form_data['country'] === 'AT' ? 'selected' : ''; ?>>Austria</option>
                        <option value="AZ" <?php echo $form_data['country'] === 'AZ' ? 'selected' : ''; ?>>Azerbaijan</option>
                        <option value="BY" <?php echo $form_data['country'] === 'BY' ? 'selected' : ''; ?>>Belarus</option>
                        <option value="BE" <?php echo $form_data['country'] === 'BE' ? 'selected' : ''; ?>>Belgium</option>
                        <option value="BA" <?php echo $form_data['country'] === 'BA' ? 'selected' : ''; ?>>Bosnia and Herzegovina</option>
                        <option value="BG" <?php echo $form_data['country'] === 'BG' ? 'selected' : ''; ?>>Bulgaria</option>
                        <option value="HR" <?php echo $form_data['country'] === 'HR' ? 'selected' : ''; ?>>Croatia</option>
                        <option value="CY" <?php echo $form_data['country'] === 'CY' ? 'selected' : ''; ?>>Cyprus</option>
                        <option value="CZ" <?php echo $form_data['country'] === 'CZ' ? 'selected' : ''; ?>>Czech Republic</option>
                        <option value="DK" <?php echo $form_data['country'] === 'DK' ? 'selected' : ''; ?>>Denmark</option>
                        <option value="EE" <?php echo $form_data['country'] === 'EE' ? 'selected' : ''; ?>>Estonia</option>
                        <option value="FI" <?php echo $form_data['country'] === 'FI' ? 'selected' : ''; ?>>Finland</option>
                        <option value="FR" <?php echo $form_data['country'] === 'FR' ? 'selected' : ''; ?>>France</option>
                        <option value="GE" <?php echo $form_data['country'] === 'GE' ? 'selected' : ''; ?>>Georgia</option>
                        <option value="DE" <?php echo $form_data['country'] === 'DE' ? 'selected' : ''; ?>>Germany</option>
                        <option value="GR" <?php echo $form_data['country'] === 'GR' ? 'selected' : ''; ?>>Greece</option>
                        <option value="HU" <?php echo $form_data['country'] === 'HU' ? 'selected' : ''; ?>>Hungary</option>
                        <option value="IS" <?php echo $form_data['country'] === 'IS' ? 'selected' : ''; ?>>Iceland</option>
                        <option value="IE" <?php echo $form_data['country'] === 'IE' ? 'selected' : ''; ?>>Ireland</option>
                        <option value="IT" <?php echo $form_data['country'] === 'IT' ? 'selected' : ''; ?>>Italy</option>
                        <option value="KZ" <?php echo $form_data['country'] === 'KZ' ? 'selected' : ''; ?>>Kazakhstan</option>
                        <option value="XK" <?php echo $form_data['country'] === 'XK' ? 'selected' : ''; ?>>Kosovo</option>
                        <option value="LV" <?php echo $form_data['country'] === 'LV' ? 'selected' : ''; ?>>Latvia</option>
                        <option value="LI" <?php echo $form_data['country'] === 'LI' ? 'selected' : ''; ?>>Liechtenstein</option>
                        <option value="LT" <?php echo $form_data['country'] === 'LT' ? 'selected' : ''; ?>>Lithuania</option>
                        <option value="LU" <?php echo $form_data['country'] === 'LU' ? 'selected' : ''; ?>>Luxembourg</option>
                        <option value="MT" <?php echo $form_data['country'] === 'MT' ? 'selected' : ''; ?>>Malta</option>
                        <option value="MD" <?php echo $form_data['country'] === 'MD' ? 'selected' : ''; ?>>Moldova</option>
                        <option value="MC" <?php echo $form_data['country'] === 'MC' ? 'selected' : ''; ?>>Monaco</option>
                        <option value="ME" <?php echo $form_data['country'] === 'ME' ? 'selected' : ''; ?>>Montenegro</option>
                        <option value="NL" <?php echo $form_data['country'] === 'NL' ? 'selected' : ''; ?>>Netherlands</option>
                        <option value="MK" <?php echo $form_data['country'] === 'MK' ? 'selected' : ''; ?>>North Macedonia</option>
                        <option value="NO" <?php echo $form_data['country'] === 'NO' ? 'selected' : ''; ?>>Norway</option>
                        <option value="PL" <?php echo $form_data['country'] === 'PL' ? 'selected' : ''; ?>>Poland</option>
                        <option value="PT" <?php echo $form_data['country'] === 'PT' ? 'selected' : ''; ?>>Portugal</option>
                        <option value="RO" <?php echo $form_data['country'] === 'RO' ? 'selected' : ''; ?>>Romania</option>
                        <option value="RU" <?php echo $form_data['country'] === 'RU' ? 'selected' : ''; ?>>Russia</option>
                        <option value="SM" <?php echo $form_data['country'] === 'SM' ? 'selected' : ''; ?>>San Marino</option>
                        <option value="RS" <?php echo $form_data['country'] === 'RS' ? 'selected' : ''; ?>>Serbia</option>
                        <option value="SK" <?php echo $form_data['country'] === 'SK' ? 'selected' : ''; ?>>Slovakia</option>
                        <option value="SI" <?php echo $form_data['country'] === 'SI' ? 'selected' : ''; ?>>Slovenia</option>
                        <option value="ES" <?php echo $form_data['country'] === 'ES' ? 'selected' : ''; ?>>Spain</option>
                        <option value="SE" <?php echo $form_data['country'] === 'SE' ? 'selected' : ''; ?>>Sweden</option>
                        <option value="CH" <?php echo $form_data['country'] === 'CH' ? 'selected' : ''; ?>>Switzerland</option>
                        <option value="TR" <?php echo $form_data['country'] === 'TR' ? 'selected' : ''; ?>>Turkey</option>
                        <option value="UA" <?php echo $form_data['country'] === 'UA' ? 'selected' : ''; ?>>Ukraine</option>
                        <option value="GB" <?php echo $form_data['country'] === 'GB' ? 'selected' : ''; ?>>United Kingdom</option>
                        <option value="VA" <?php echo $form_data['country'] === 'VA' ? 'selected' : ''; ?>>Vatican City</option>
                        <option value="AX" <?php echo $form_data['country'] === 'AX' ? 'selected' : ''; ?>>Åland Islands</option>
                        <option value="FO" <?php echo $form_data['country'] === 'FO' ? 'selected' : ''; ?>>Faroe Islands</option>
                        <option value="GI" <?php echo $form_data['country'] === 'GI' ? 'selected' : ''; ?>>Gibraltar</option>
                        <option value="GG" <?php echo $form_data['country'] === 'GG' ? 'selected' : ''; ?>>Guernsey</option>
                        <option value="IM" <?php echo $form_data['country'] === 'IM' ? 'selected' : ''; ?>>Isle of Man</option>
                        <option value="JE" <?php echo $form_data['country'] === 'JE' ? 'selected' : ''; ?>>Jersey</option>
                        <option value="SJ" <?php echo $form_data['country'] === 'SJ' ? 'selected' : ''; ?>>Svalbard and Jan Mayen</option>
                        <option value="UM" <?php echo $form_data['country'] === 'UM' ? 'selected' : ''; ?>>United States Minor Outlying Islands</option>
                    </select>
                </div>
            </div>
            <div class="payment-method">
                <h3>Zgjidh Metodën e Pagesës</h3>
                <label><input type="radio" name="payment" value="cash" <?php echo $form_data['payment'] === 'cash' ? 'checked' : ''; ?>> Cash</label>
                <label><input type="radio" name="payment" value="card" <?php echo $form_data['payment'] === 'card' ? 'checked' : ''; ?>> Kartë</label>
                <?php if (isset($errors['payment'])): ?>
                    <span class="error-message"><?php echo $errors['payment']; ?></span>
                <?php endif; ?>
            </div>
            <div class="button-container">
                <a href="Produktet.php"><button type="button" class="back-button">← Kthehu te Produktet</button></a>
                <button type="submit" name="confirm_order" class="confirm-button">Konfirmo</button>
            </div>
        </form>
        <?php if (isset($errors['cart'])): ?>
            <p class="server-error"><?php echo htmlspecialchars($errors['cart']); ?></p>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
    <script>
        const cartItems = document.getElementById('cartItems');
        const totalPriceEl = document.getElementById('totalPrice');
        const cartJsonInput = document.getElementById('cart_json');
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const productsStock = <?php echo json_encode(array_map(function($item) { return ['stock' => $item['stock'], 'name' => $item['name'], 'price' => $item['price']]; }, $products_stock)); ?>;

        function updateCartDisplay() {
            cartItems.innerHTML = '';
            let totalPrice = 0;
            const groupedCart = cart.reduce((acc, item) => {
                if (!acc[item.id]) {
                    acc[item.id] = { ...item, quantity: 0 };
                }
                acc[item.id].quantity += 1;
                return acc;
            }, {});

            Object.values(groupedCart).forEach(item => {
                const listItem = document.createElement('li');
                const stock = productsStock[item.id]?.stock || 0;
                const isOutOfStock = item.quantity > stock;
                listItem.innerHTML = `
                    <span>${item.name} - €${(item.price * item.quantity).toFixed(2)} (Sasia: ${item.quantity})</span>
                    <div class="quantity-controls">
                        <button onclick="changeQuantity('${item.id}', -1)">-</button>
                        <button onclick="changeQuantity('${item.id}', 1)">+</button>
                    </div>
                    <div class="stock-warning" style="display: ${isOutOfStock ? 'block' : 'none'}">
                        Nuk ka stok të mjaftueshëm! (Në stok: ${stock})
                    </div>
                `;
                cartItems.appendChild(listItem);
                totalPrice += item.price * item.quantity;
            });
            totalPriceEl.textContent = totalPrice.toFixed(2);
            localStorage.setItem('cart', JSON.stringify(cart));
            cartJsonInput.value = JSON.stringify(cart);
        }

        function changeQuantity(productId, change) {
            const stock = productsStock[productId]?.stock || 0;
            const currentQuantity = cart.filter(item => item.id === productId).length;
            if (change > 0 && currentQuantity >= stock) {
                alert('Nuk ka stok të mjaftueshëm për të shtuar më shumë!');
                return;
            }
            if (change < 0 && currentQuantity <= 1) {
                cart = cart.filter(item => item.id !== productId);
            } else if (change < 0) {
                const index = cart.findIndex(item => item.id === productId);
                if (index !== -1) cart.splice(index, 1);
            } else {
                const item = cart.find(item => item.id === productId);
                if (item) cart.push({ ...item });
            }
            updateCartDisplay();
        }

     
        updateCartDisplay();

        // Client-side validation (optional, for UX)
        document.getElementById('checkout-form').addEventListener('submit', function(event) {
            const street = document.getElementById('street').value.trim();
            const city = document.getElementById('city').value.trim();
            const postalCode = document.getElementById('postal_code').value.trim();
            const country = document.getElementById('country').value;

            if (!street || !city || !postalCode || !country) {
                alert('Ju lutemi plotësoni të gjitha fushat e adresës!');
                event.preventDefault();
            } else if (cart.length === 0) {
                alert('Shporta është bosh!');
                event.preventDefault();
            }
        });
    </script>
</body>
</html>