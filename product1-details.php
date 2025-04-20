
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produktet-Radiant Touch</title>
    <link rel="icon" href="images/logo1.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
       
    </style>
</head>
<body>
<header>
 
</header>

<div class="back-button-container">
    <a href="Produktet.php">
        <button class="back-button">← Kthehu te Produktet</button>
    </a>
</div>

<div class="container">
    <img src="<?php echo $product->getImage(); ?>" alt="Product Image" class="product-image">
    <div class="details">
        <h1><?php echo $product->getName(); ?></h1>
        <p>Cmimi: $<?php echo number_format($product->getPrice(), 2); ?></p>
        <p>Ne Stok: <span id="stock"><?php echo $product->getStock(); ?></span></p>

        <form id="purchase-form" method="POST">
            <div class="form-group">
                <label for="card-type">Kartela</label>
                <select id="card-type" name="card-type" required>
                    <option value="visa">Visa</option>
                    <option value="mastercard">MasterCard</option>
                    <option value="amex">American Express</option>
                </select>
            </div>
            <div class="form-group">
                <label for="country">Shteti</label>
                <select id="country" name="country" required>
                    <option value="usa">Kosove</option>
                    <option value="canada">Shqiperi</option>
                    <option value="uk">Maqedoni</option>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Adresa</label>
                <input type="text" id="address" name="address" placeholder="Adresa" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="Email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}">
            </div>
            <div class="form-group">
    <label for="quantity">Sasia</label>
    <input type="number" id="quantity" name="quantity" max="<?php echo $product->getStock(); ?>" min="1" required>
</div>

    <button type="submit" style="padding: 5px; background-color: #6d4c3d; color:white; margin-top: 10px;">Porosit</button>


        <?php if ($warning): ?>
            <p class="warning"><?php echo $warning; ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
    </div>
</div>

<footer>
   
</footer>

<script>

    const form = document.getElementById('purchase-form');
    const stockElement = document.getElementById('stock');
    const warningElement = document.querySelector('.warning');
    const successElement = document.querySelector('.success');

    form.addEventListener('submit', function(event) {
        const stock = parseInt(stockElement.textContent, 10);
        const quantity = parseInt(document.getElementById('quantity').value, 10);

        if (quantity > stock) {
            event.preventDefault(); 
            warningElement.style.display = 'block';
            successElement.style.display = 'none';
        }
    });
</script>

</body>
</html>
