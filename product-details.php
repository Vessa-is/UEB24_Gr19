<?php
require_once 'DatabaseConnection.php';

// Fetch product stock for validation
$products_stock = [];
try {
    $db = new DatabaseConnection();
    $conn = $db->startConnection();
    if ($conn) {
        $stmt = $conn->query("SELECT id, stock FROM products");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products_stock[$row['id']] = $row['stock'];
        }
    } else {
        echo "<p style='color: red; text-align: center;'>Lidhja me databazën dështoi.</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color: red; text-align: center;'>Gabim gjatë marrjes së stokut: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagesa - Radiant Touch</title>
    <link rel="icon" href="images/logo1.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4e4d4;
            margin: 0;
            padding: 0;
        }
        .checkout-container {
            max-width: 700px;
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
        .address-section textarea {
            width: 100%;
            height: 80px;
            padding: 10px;
            border: 1px solid #d6c6b8;
            border-radius: 5px;
            font-size: 13px;
            color: #6d4c3d;
        }
        .address-warning {
            color: #6d4c3d;
            font-size: 13px;
            margin-top: 10px;
        }
        .country-select {
            margin-top: 10px;
            padding: 8px;
            border: 1px solid #d6c6b8;
            border-radius: 5px;
            font-size: 13px;
            color: #6d4c3d;
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
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="checkout-container">
        <h2><i class="fas fa-credit-card"></i> Pagesa</h2>
        <ul id="cartItems"></ul>
        <div class="total">
            Totali: $<span id="totalPrice">0</span>
        </div>
        <div class="address-section">
            <h3>Konfirmo Adresën</h3>
            <textarea placeholder="Shkruaj adresën tënde këtu (do të përdoret nga baza e të dhënave më vonë)"></textarea>
            <p class="address-warning">Ju lutemi sigurohuni që adresa juaj aktuale është përditësuar në profilin tuaj.</p>
            <select class="country-select" id="country">
                <option value="Albania">Shqipëri</option>
                <option value="Kosovo">Kosovë</option>
                <option value="USA">SHBA</option>
                <option value="Germany">Gjermani</option>
            </select>
        </div>
        <div class="payment-method">
            <h3>Zgjidh Metodën e Pagesës</h3>
            <label><input type="radio" name="payment" value="cash" checked> Cash</label>
            <label><input type="radio" name="payment" value="card"> Kartë</label>
        </div>
        <div class="button-container">
            <a href="Produktet.php"><button class="back-button">← Kthehu te Produktet</button></a>
            <button class="confirm-button" onclick="confirmOrder()">Konfirmo</button>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script>
        const cartItems = document.getElementById('cartItems');
        const totalPriceEl = document.getElementById('totalPrice');
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const productsStock = <?php echo json_encode($products_stock); ?>;

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
                const stock = productsStock[item.id] || 0;
                const isOutOfStock = item.quantity > stock;
                listItem.innerHTML = `
                    <span>${item.name} - $${(item.price * item.quantity).toFixed(2)} (Sasia: ${item.quantity})</span>
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
        }

        function changeQuantity(productId, change) {
            const stock = productsStock[productId] || 0;
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

        function confirmOrder() {
            if (cart.length === 0) {
                alert('Shporta është bosh!');
                return;
            }
            const paymentMethod = document.querySelector('input[name="payment"]:checked').value;
            const country = document.getElementById('country').value;
            const deliveryTimes = {
                'Albania': '2-3 ditë',
                'Kosovo': '2-3 ditë',
                'USA': '5-7 ditë',
                'Germany': '3-5 ditë'
            };
            const deliveryTime = deliveryTimes[country] || '3-7 ditë';
            alert(`Porosia u konfirmua me sukses! Metoda e pagesës: ${paymentMethod === 'cash' ? 'Cash' : 'Kartë'}. Koha e parashikuar e dorëzimit: ${deliveryTime}.`);
            cart = [];
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartDisplay();
            window.location.href = 'Produktet.php';
        }

        // Initialize cart display
        updateCartDisplay();
    </script>
</body>
</html>