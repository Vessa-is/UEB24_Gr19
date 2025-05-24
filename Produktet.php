<?php
require_once 'DatabaseConnection.php';

$products = [];
$result = $conn->query("SELECT * FROM products");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $result->free();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produktet - Radiant Touch</title>
    <link rel="icon" href="images/logo1.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4e4d4;
        }
        .product {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 300px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .product:hover {
            transform: scale(1.05);
        }
        .product img {
            width: 100%;
            border-radius: 10px;
            height: auto;
        }
        .details {
            margin-top: 5px;
            font-size: 14px;
            color: #555;
            padding: 10px;
        }
        .price {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .description, .ingredients {
            font-size: 13px;
            color: #6d4c3d;
            margin-bottom: 10px;
            line-height: 1.5;
            max-height: 90px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .buy-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #7c5b43;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 14px;
        }
        .buy-button:hover {
            background-color: #473524;
        }
        .add-to-cart {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4d3a2d;
            color: white;
            border-radius: 5px;
            margin-left: 10px;
            cursor: pointer;
            font-size: 14px;
        }
        .add-to-cart:hover {
            background-color: #2f231a;
        }
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            justify-content: center;
            gap: 20px;
            padding: 20px;
            background-color: #f4e4d4;
            margin-left: 55px;
        }
        video {
            width: 100%;
            max-height: 600px;
            object-fit: fill;
            display: block;
            margin: 0;
            background-color: black;
        }
        .cart {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            padding: 20px;
            width: 350px;
            text-align: center;
            font-family: 'Georgia', serif;
            color: #4d3a2d;
            position: relative;
            margin: 0 auto;
            margin-top: 20px;
            margin-bottom: 50px;
        }
        .cart h2 {
            font-size: 1.5em;
            margin-bottom: 15px;
            color: #4d3a2d;
        }
        #cartItems {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }
        #cartItems li {
            padding: 10px;
            background: #f0e7db;
 ANIMATED_WAVE_CSS
            margin-bottom: 10px;
            border-radius: 6px;
            border: 1px solid #d6c6b8;
        }
        .total {
            font-size: 1.2em;
            margin: 20px 0;
            color: #4d3a2d;
        }
        #clearCart, #proceedCheckout {
            background-color: #7c5b43;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1em;
            border-radius: 6px;
            cursor: pointer;
            margin: 5px;
            transition: background-color 0.3s;
        }
        #clearCart:hover, #proceedCheckout:hover {
            background-color: #473524;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <video autoplay muted loop>
        <source src="videos/produktetvideo.mp4" type="video/mp4" />
        Your browser does not support the video tag.
    </video>

    <div class="audio-container">
        <audio controls autoplay loop muted>
            <source src="audios/audio2.mp3" type="audio/mp3">
        </audio>
    </div>

    <section class="products">
        <?php foreach ($products as $product): ?>
            <div class="product" data-id="<?php echo $product['id']; ?>" data-name="<?php echo htmlspecialchars($product['name']); ?>" data-price="<?php echo htmlspecialchars($product['price']); ?>">
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product image">
                <div class="details">
                    <div class="productname" style="padding: 15px; background-color: #fff5eb; border-radius: 20px; margin-bottom: 5px;">
                        <b><?php echo htmlspecialchars($product['name']); ?></b>
                    </div>
                    <div class="price">$<?php echo htmlspecialchars($product['price']); ?>.00</div>
                    <div>Në stok: <?php echo htmlspecialchars($product['stock']); ?></div>
                    <div class="description"><?php echo htmlspecialchars($product['description'] ?? 'Nuk ka përshkrim të disponueshëm.'); ?></div>
                    <a href="product-details.php?product_id=<?php echo $product['id']; ?>" class="buy-button">Perberesit</a>
                    <span class="add-to-cart">+</span>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

    <section class="cart">
        <h2><i class="fas fa-shopping-cart"></i> Shporta</h2>
        <ul id="cartItems"></ul>
        <div class="total">
            Totali: $<span id="totalPrice">0</span>
        </div>
        <button id="clearCart">Pastro Shportën</button>
        <button id="proceedCheckout">Vazhdo Pagesën</button>
    </section>

    <canvas id="waveCanvas"></canvas>
    <script>
       
        const canvas = document.getElementById("waveCanvas");
        const ctx = canvas.getContext("2d");
        canvas.width = window.innerWidth;
        canvas.height = 100;

        let waveOffset = 0;

        function drawWave() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            const gradient = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
            gradient.addColorStop(0, "#f3e5d9");
            gradient.addColorStop(0.5, "#d9c9b9");
            gradient.addColorStop(1, "#fff8f0");
            ctx.fillStyle = gradient;
            ctx.beginPath();
            for (let x = 0; x < canvas.width; x++) {
                const y = 30 + Math.sin((x + waveOffset) * 0.03) * 10 + Math.sin((x + waveOffset) * 0.01) * 5;
                ctx.lineTo(x, y);
            }
            ctx.lineTo(canvas.width, canvas.height);
            ctx.lineTo(0, canvas.height);
            ctx.closePath();
            ctx.fill();
            waveOffset += 2;
            requestAnimationFrame(drawWave);
        }
        drawWave();

    
        const cartItems = document.getElementById('cartItems');
        const totalPriceEl = document.getElementById('totalPrice');
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        function updateCartDisplay() {
            cartItems.innerHTML = '';
            let totalPrice = 0;
            cart.forEach(item => {
                const listItem = document.createElement('li');
                listItem.textContent = `${item.name} - $${item.price.toFixed(2)}`;
                cartItems.appendChild(listItem);
                totalPrice += item.price;
            });
            totalPriceEl.textContent = totalPrice.toFixed(2);
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', () => {
                const product = button.closest('.product');
                const productId = product.dataset.id;
                const productName = product.dataset.name;
                const productPrice = parseFloat(product.dataset.price);
                cart.push({ id: productId, name: productName, price: productPrice });
                updateCartDisplay();
            });
        });

        document.getElementById('clearCart').addEventListener('click', () => {
            cart = [];
            updateCartDisplay();
        });

        document.getElementById('proceedCheckout').addEventListener('click', () => {
            if (cart.length > 0) {
                window.location.href = 'checkout.php';
            } else {
                alert('Shporta është bosh!');
            }
        });

        updateCartDisplay();
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>