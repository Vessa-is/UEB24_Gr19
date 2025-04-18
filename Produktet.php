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
  <header>
      <nav>
        <div class="logo-cont">
          <div class="logo">
            <a href="index.php">
              <img src="images/logoo2.png" alt="logo" title="Radiant Touch" />
            </a>
          </div>
          <div class="login">
              <a href="login.php"><button id="loginBtn" >
                  <i class="fa fa-user"></i>
                </button></a>
              </div>
        </div>
        <div id="navi">
          <ul>
            <li><a href="index.php">Ballina</a></li>
            <li><a href="sherbimet.php">Shërbimet</a></li>
            <li><a href="galeria.php">Galeria</a></li>
            <li><a href="Produktet.php">Produktet</a></li>
            <li><a href="per_ne.php">Rreth nesh</a></li>
            <li><a href="kontakti.php">Kontakti</a></li>
          </ul>
        </div>
      </nav>
    </header> 

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

   

  <div class="product"  draggable="true"  data-name="BLOND ABSOLU. CONDITIONER FOR BLONDE HAIR."data-price="20">
    <img src="images/produkt3.webp" alt="Product 1">
    <div class="details">
        <div class="productname" style="padding: 15px; background-color: #fff5eb; border-radius: 20px; margin-bottom: 5px;"><b>BLOND ABSOLU. CONDITIONER FOR BLONDE HAIR.</b></div>
        <div class="price">$20.00</div>
        <div>Në stok: 15</div>
        <a href="product1-details.php" class="buy-button">Blej</a>
    </div>
</div>

<div class="product" draggable="true" data-name="DENSIFIQUE. THICKENING SHAMPOO FOR THINNING HAIR."data-price="35">
    <img src="images/produkt2.webp" alt="Product 2">
    <div class="details">
        <div class="productname" style="padding: 15px; background-color: #fff5eb; border-radius: 20px; margin-bottom: 5px;"><b>DENSIFIQUE. THICKENING SHAMPOO FOR THINNING HAIR.</b></div>
        <div class="price">$35.00</div>
        <div>Në stok: 8</div>
        <a href="product2-details.php" class="buy-button">Blej</a>
    </div>
</div>

<div class="product" draggable="true" data-name="ELIXIR ULTIME. NOURISHING HAIR OIL FOR ALL HAIR TYPES."data-price="25">
    <img src="images/produkt1.webp" alt="Product 3">
    <div class="details">
        <div class="productname" style="padding: 15px; background-color: #fff5eb; border-radius: 20px; margin-bottom: 5px;"><b>ELIXIR ULTIME. NOURISHING HAIR OIL FOR ALL HAIR TYPES.</b></div>
        <div class="price">$15.00</div>
        <div>Në stok: 25</div>
        <a href="product3-details.php" class="buy-button">Blej</a>
    </div>
</div>


<div class="product" draggable="true" data-name="CHRONOLOGISTE. ESSENTIAL REVITALIZING HAIR MASK"data-price="25">
    <img src="images/produkt4.webp" alt="Product 4">
    <div class="details">
        <div class="productname" style="padding: 15px; background-color: #fff5eb; border-radius: 20px; margin-bottom: 5px;"><b>CHRONOLOGISTE. ESSENTIAL REVITALIZING HAIR MASK</b></div>
        <div class="price">$15.00</div>
        <div>Në stok: 25</div>
        <a href="product4-details.php" class="buy-button">Blej</a>
    </div>
</div>

<div class="product" draggable="true" data-name="GENESIS. FORTIFYING SERUM FOR WEAKENED HAIR." data-price="15">
    <img src="images/produkt5.webp" alt="Product 5">
    <div class="details">
        <div class="productname" style="padding: 15px; background-color: #fff5eb; border-radius: 20px; margin-bottom: 5px;"><b>GENESIS. FORTIFYING SERUM FOR WEAKENED HAIR.</b></div>
        <div class="price">$15.00</div>
        <div>Në stok: 25</div>
        <a href="product5-details.php" class="buy-button">Blej</a>
    </div>
</div>


<div class="product" draggable="true" data-name="ELIXIR ULTIME. NOURISHING HAIR OIL FOR ALL HAIR TYPES."data-price="15">
    <img src="images/produkt6.webp" alt="Product 6">
    <div class="details">
        <div class="productname" style="padding: 15px; background-color: #fff5eb; border-radius: 20px; margin-bottom: 5px;"><b>ELIXIR ULTIME. NOURISHING HAIR OIL FOR ALL HAIR TYPES.</b></div>
        <div class="price">$15.00</div>
        <div>Në stok: 25</div>
        <a href="product6-details.php" class="buy-button">Blej</a>
    </div>
</div>


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
    
