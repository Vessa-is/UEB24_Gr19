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
        form {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 10px;
            text-align: left;
            color: #ad6159;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #6d4c3d;
        }
        .form-group input, select {
            width: 100%;
            padding: 6px;                         
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;                     
        }
        button {
            padding: 8px 15px;
            background-color: #6d4c3d;
            color: white;
            font-size: 14px;                      
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }
        .warning {
            color: red;
            display: none;
        }
        .success {
            color: green;
            display: none;
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

    <div class="container">
    <?php
$product = [
    "name" => "ELIXIR ULTIME. NOURISHING HAIR OIL FOR ALL HAIR TYPES.",
    "price" => 15,
    "stock" => 25,
    "image" => "images/produkt3.jpg"
];
?>
<img src="<?php echo $product['image']; ?>" alt="Product Image" class="product-image">
<div class="details">
    <h1><?php echo $product['name']; ?></h1>
    <p>Cmimi: $<?php echo number_format($product['price'], 2); ?></p>
    <p>Ne Stok: <span id="stock"><?php echo $product['stock']; ?></span></p>
    </div>
        <form id="purchase-form">
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
            <input type="text" id="address" name="address"placeholder ="Adresa" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email"  required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}">
          </div>
          <div class="form-group">
            <label for="quantity">Sasia</label>
            <input type="number" id="quantity" name="quantity" max="25" min="1" required>
          </div>
          <button type="submit" style="padding: 10px; background-color: #6d4c3d; color: #fff; margin-top: 10px;">Submit</button>
        </form>
        
        <p class="warning" id="warning">Nuk ka mjaftueshem ne stok!</p>
        <p class="success" id="success">Faleminderit per Porosine tuaj! Produkti juaj do arrij per 5-7 dite.</p>
      </div>
    </div>



       <script>
                  
                  document.querySelector('#abonimform').addEventListener('submit', function(event) {
                      event.preventDefault(); 
                      const email = document.querySelector('#abonimform input[type="email"]').value;
              
                      if (email) {
                          alert('Faleminderit për abonimin');
                      } else {
                          alert('Ju lutem, shkruani një email të vlefshëm.');
                      }
                  });
              </script>   
               
    <?php include 'footer.php'; ?>

<script>
    const form = document.getElementById('purchase-form');
    const stockElement = document.getElementById('stock');
    const warningElement = document.getElementById('warning');
    const successElement = document.getElementById('success');

    form.addEventListener('submit', function(event) {
      event.preventDefault();
      const stock = parseInt(stockElement.textContent, 10);
      const quantity = parseInt(document.getElementById('quantity').value, 10);

      if (quantity > stock) {
        warningElement.style.display = 'block';
        successElement.style.display = 'none';
      } else {
        warningElement.style.display = 'none';
        successElement.style.display = 'block';
      }
    });
  </script>


</body>
</html>

