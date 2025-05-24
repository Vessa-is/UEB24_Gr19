<?php
require_once 'DatabaseConnection.php';

$product = null;

// Get the product ID from the URL
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 1;

// Fetch the product
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    $product_id = 1; 
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name'] ?? 'Produkt'); ?> - Radiant Touch</title>
    <link rel="icon" href="images/logo1.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin: 100px;
        }
        .product-image, .details {
            flex: 1;
            max-width: 45%;
            height: auto;
        }
        .product-image {
            width: 100%;
            object-fit: cover;
            border-radius: 8px;
        }
        .details {
            padding: 15px;
            background: none;
            border-radius: 8px;
        }
        .description-box {
            margin-top: 20px;
            padding: 15px;
            background-color: #fff5eb;
            border: 1px solid #d6c6b8;
            border-radius: 8px;
            color: #6d4c3d;
            font-size: 14px;
            line-height: 1.6;
        }
        .description-box h3 {
            margin-top: 0;
            color: #4d3a2d;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="back-button-container">
        <a href="Produktet.php">
            <button class="back-button">← Kthehu te Produktet</button>
        </a>
    </div>

    <?php if ($product): ?>
        <div class="container">
            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product Image" class="product-image">
            <div class="details">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p>Cmimi: $<?php echo number_format($product['price'], 2); ?></p>
                <div class="description-box">
                    <h3>Përshkrimi</h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                </div>
                <div class="description-box">
                    <h3>Përbërësit</h3>
                    <p><?php echo htmlspecialchars($product['ingredients'] ?? 'Nuk ka përbërës të disponueshëm.'); ?></p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p style="color: red; margin: 100px;">Nuk u gjet asnjë produkt.</p>
    <?php endif; ?>

    <?php include 'footer.php'; ?>
</body>
</html>