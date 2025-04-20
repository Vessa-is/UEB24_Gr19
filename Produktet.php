<?php
// KONSTANTE
define("SITE_NAME", "Radiant Touch");

// VARIABLA GLOBALE
$globalDiscount = 0.10; // 10% zbritje

// FUNKSION PER LLOGARITJE CMIMI ME ZBRITJE DHE STRING FUNKSIONE
function calculateDiscountedPrice($price, $productName) {
    global $globalDiscount; // qasje në variabël globale

    // Funksione për string: strtoupper dhe strlen
    $uppercaseName = strtoupper($productName);
    $nameLength = strlen($productName);

    // Operator: arithmetic
    $discountedPrice = $price - ($price * $globalDiscount);

    // var_dump  debug
    echo "<pre>";
    var_dump([
        'Product Name (upper)' => $uppercaseName,
        'Name Length' => $nameLength,
        'Original Price' => $price,
        'Discount' => $globalDiscount * 100 . "%",
        'Discounted Price' => $discountedPrice,
    ]);
    echo "</pre>";

    return $discountedPrice;
}

// Shembull perdorimi
$productName = "Elixir Ultime";
$originalPrice = 25;
$finalPrice = calculateDiscountedPrice($originalPrice, $productName);

// Operatore 
$nameLength = strlen($productName);
$isExpensive = $finalPrice > 20 && $nameLength > 5 ? "Yes" : "No";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo SITE_NAME; ?> - Hair Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Welcome to <?php echo SITE_NAME; ?>!</h1>
    <p>Your destination for premium hair care</p>
</header>

<video autoplay loop muted plays-inline class="back-video">
    <source src="images/video.mp4" type="video/mp4">
</video>

<div style="padding:20px; background-color:#fff7ec; text-align:center; font-family:Georgia;">
  <h2>Produkti testues: <strong><?php echo $productName; ?></strong></h2>
  <p>Çmimi origjinal: $<?php echo $originalPrice; ?></p>
  <p>Çmimi me zbritje (10%): <strong>$<?php echo $finalPrice; ?></strong></p>
  <p>A është produkti i shtrenjtë dhe ka emër të gjatë? <strong><?php echo $isExpensive; ?></strong></p>
</div>

<section class="products">
    <h2>Our Products</h2>
    <div class="product">
        <img src="images/kerastase1.jpg" alt="Kérastase Elixir Ultime">
        <h3>Kérastase Elixir Ultime</h3>
        <p>Versatile beautifying oil for all hair types</p>
        <p class="price">$25</p>
    </div>
    <div class="product">
        <img src="images/kerastase2.jpg" alt="Kérastase Nutritive Bain Satin 2">
        <h3>Kérastase Nutritive Bain Satin 2</h3>
        <p>Exceptional hair nutrition shampoo for dry, sensitized hair</p>
        <p class="price">$30</p>
    </div>
    <div class="product">
        <img src="images/kerastase3.jpg" alt="Kérastase Discipline Maskeratine">
        <h3>Kérastase Discipline Maskeratine</h3>
        <p>Smoothing treatment for frizzy, unruly hair</p>
        <p class="price">$40</p>
    </div>
</section>

<footer>
    <p>&copy; 2025 <?php echo SITE_NAME; ?>. All rights reserved.</p>
</footer>

</body>
</html>


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

          <footer>
        
            <div class="footer-container">
                <div class="footer-section">
                    <img src="images/logoo2.png" class="logo1" alt="Radiant Touch Logo" >
                    <p>Radiant Touch ofron shërbime profesionale për flokët, qerpikët dhe vetullat. Synojmë t’ju ndihmojmë të ndiheni të bukur &ccedil;do ditë.</p>
                </div>
                <div class="footer-section">
                    <h3>Kategorit&euml;</h3>
                    <ul>
                        <li><a href="index.php">BALLINA</a></li>
                        <li><a href="sherbimet.php">SHERBIMET</a></li>
                        <li><a href="galeria.php">GALERIA</a></li>
                        <li><a href="Produktet.php">PRODUKTET</a></li>
                        <li><a href="per_ne.php">RRETH NESH</a></li>
                        <li><a href="kontakti.php">KONTAKTI</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Kontakti</h3>
                    <p><i class="fas fa-map-marker-alt"></i> <a href="https://www.google.com/maps?q=Prishtine+Kosove" target="_blank" rel="noopener noreferrer" style="color: #fff; text-decoration: none;"><abbr style="text-decoration: none;" title="Republic of Kosovo">Prishtine,Kosovë</abbr></a></p>
                    <p> <i class="fas fa-phone"></i> <a href="tel:+38344222222" style="color: #fff; text-decoration: none;">+383 44 222 222</a></p> 
                    <p><i class="fas fa-envelope"></i><a href="mailto:info@radianttouch.com" style="color: #fff; text-decoration: none;">info@radianttouch.com</a></p>  
                </div>
    
                </div>
                <hr style="width: 90%;  margin: 10px auto; ">
                <div class="footer-section newsletter">
                    <h3>Abonohuni</h3>
                    <form id="abonimform" method="POST">
                        <div class="newsletter-input">
                            <i class="fas fa-envelope"></i>
                            <input type="email" placeholder="Shkruani email-in tuaj" required>
                            <button type="submit" aria-label="Dërgo email"><i class="fas fa-paper-plane"></i></button>
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
                        <div class="icons">
                            <a href="https://www.facebook.com" class="icon"  aria-label="Facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com" class="icon" aria-label="Instagram" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.twitter.com" class="icon" aria-label="Twitter" target="_blank"><i class="fab fa-twitter"></i></a>
        
                        </div>
                    </form>
                </div>
                
                <div class="footer-bottom">
                    &copy; 2025 <a href="index.php" style="text-decoration: none;"><span> Radiant Touch </span></a>. Të gjitha të drejtat janë të rezervuara.
    
                </div>        
        </footer>
    </body>
</html>
    
