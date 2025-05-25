<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'DatabaseConnection.php';

$product = null;

try {
    $db = new DatabaseConnection();
    $conn = $db->startConnection();
    if (!$conn) {
        throw new Exception('Lidhja me databazën dështoi.');
    }

    $product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 1;
    $stmt = $conn->prepare("SELECT id, name, description, price, stock, image_url, ingredients FROM products WHERE id = ?");
    $stmt->bindValue(1, $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

 
    if (!$product) {
        $stmt = $conn->prepare("SELECT id, name, description, price, stock, image_url, ingredients FROM products LIMIT 1");
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    $error = 'Gabim: ' . $e->getMessage();
    file_put_contents('logs/errors.log', date('Y-m-d H:i:s') . " | ProductDetails Error: $error\n", FILE_APPEND);
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name'] ?? 'Produkt'); ?> - Radiant Touch</title>
    <link rel="icon" href="images/logo1.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
   
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

.back-button-container {
    margin: 20px 100px;
}

.back-button {
    background-color: #7c5b43;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.back-button:hover {
    background-color: #473524;
}

.error-message {
    color: red;
    margin: 100px;
    font-size: 16px;
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

    <?php if (isset($error)): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php elseif ($product): ?>
        <div class="container">
            <img src="<?php echo htmlspecialchars($product['image_url'] ?? 'images/default_product.png'); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
            <div class="details">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p>Çmimi: €<?php echo number_format($product['price'], 2); ?></p>
                <p>Stoku: <?php echo htmlspecialchars($product['stock']); ?> njësi</p>
                <div class="description-box">
                    <h3>Përshkrimi</h3>
                    <p><?php echo htmlspecialchars($product['description'] ?? 'Nuk ka përshkrim të disponueshëm.'); ?></p>
                </div>
                <div class="description-box">
                    <h3>Përbërësit</h3>
                    <p><?php echo htmlspecialchars($product['ingredients'] ?? 'Nuk ka përbërës të disponueshëm.'); ?></p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p class="error-message">Nuk u gjet asnjë produkt.</p>
    <?php endif; ?>

    <?php include 'footer.php'; ?>
</body>
</html>