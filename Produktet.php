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
    background-color:#f4e4d4;
 
}

    .product {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            width:275px;
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

.products {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
            justify-content: center;
            gap: 20px;
            padding: 20px;
            background-color:#f4e4d4;
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
      margin-bottom: 10px;
      border-radius: 6px;
      border: 1px solid #d6c6b8;
    }

    .total {
      font-size: 1.2em;
      margin: 20px 0;
      color: #4d3a2d;
    }

    #clearCart {
      background-color:#7c5b43;
      color: white;
      border: none;
      padding: 12px 24px;
      font-size: 1em;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    #clearCart:hover {
      background-color:#473524;
    }
</style>
</head>
<body>
  <?php include 'header.php'; ?>

    <?php
    $products = [
        ["name" => "BLOND ABSOLU. CONDITIONER FOR BLONDE HAIR.", "price" => 20, "stock" => 15, "image" => "produkt3.webp", "details" => "product1-details.php"],
        ["name" => "DENSIFIQUE. THICKENING SHAMPOO FOR THINNING HAIR.", "price" => 35, "stock" => 8, "image" => "produkt2.webp", "details" => "product2-details.php"],
        ["name" => "ELIXIR ULTIME. NOURISHING HAIR OIL FOR ALL HAIR TYPES.", "price" => 15, "stock" => 25, "image" => "produkt1.webp", "details" => "product3-details.php"],
        ["name" => "CHRONOLOGISTE. ESSENTIAL REVITALIZING HAIR MASK", "price" => 15, "stock" => 25, "image" => "produkt4.webp", "details" => "product4-details.php"],
        ["name" => "GENESIS. FORTIFYING SERUM FOR WEAKENED HAIR.", "price" => 15, "stock" => 25, "image" => "produkt5.webp", "details" => "product5-details.php"],
        ["name" => "ELIXIR ULTIME. NOURISHING HAIR OIL FOR ALL HAIR TYPES.", "price" => 15, "stock" => 25, "image" => "produkt6.webp", "details" => "product6-details.php"],
    ];
  ?>

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
      <div class="product" draggable="true" data-name="<?= htmlspecialchars($product['name']) ?>" data-price="<?= htmlspecialchars($product['price']) ?>">
        <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="Product image">
        <div class="details">
          <div class="productname" style="padding: 15px; background-color: #fff5eb; border-radius: 20px; margin-bottom: 5px;">
            <b><?= htmlspecialchars($product['name']) ?></b>
          </div>
          <div class="price">$<?= htmlspecialchars($product['price']) ?>.00</div>
          <div>Në stok: <?= htmlspecialchars($product['stock']) ?></div>
          <a href="<?= htmlspecialchars($product['details']) ?>" class="buy-button">Blej</a>
        </div>
      </div>
    <?php endforeach; ?>
  </section>



<section class="cart">
  <h2><i class="fas fa-shopping-cart"></i>  Shto në Shportë</h2>
  <ul id="cartItems">
  </ul>
  <div class="total">
    Totali: $<span id="totalPrice">0</span>
  </div>
  <button id="clearCart">Pastro Shportën</button>
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
      const y =
        30 + Math.sin((x + waveOffset) * 0.03) * 10 +
        Math.sin((x + waveOffset) * 0.01) * 5;
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
  const products = document.querySelectorAll('.product');
        const cartItems = document.getElementById('cartItems');
        const totalPriceEl = document.getElementById('totalPrice');
        let totalPrice = 0;

      
        products.forEach(product => {
            product.addEventListener('dragstart', () => {
                product.classList.add('dragging');
            });

            product.addEventListener('dragend', () => {
                product.classList.remove('dragging');
            });
        });

        const cart = document.querySelector('.cart');

        cart.addEventListener('dragover', (e) => {
            e.preventDefault();
        });

        cart.addEventListener('drop', (e) => {
            e.preventDefault();
            const draggedProduct = document.querySelector('.dragging');
            if (draggedProduct) {
                const productName = draggedProduct.getAttribute('data-name');
                const productPrice = parseFloat(draggedProduct.getAttribute('data-price'));

                
                const listItem = document.createElement('li');
                listItem.textContent = `${productName} - $${productPrice.toFixed(2)}`;
                cartItems.appendChild(listItem);

              
                totalPrice += productPrice;
                totalPriceEl.textContent = totalPrice.toFixed(2);
            }
        });
        document.getElementById('clearCart').addEventListener('click', function() {
      const cartItems = document.getElementById('cartItems');
      const totalPrice = document.getElementById('totalPrice');
      const notification = document.getElementById('notification');
      cartItems.innerHTML = '';
      totalPrice.textContent = '0';
      notification.style.display = 'block';
     setTimeout(() => {
        notification.style.display = 'none';
      }, 3000);
    });
    </script>
</body>

</script>

       
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
    </body>
</html>
    
