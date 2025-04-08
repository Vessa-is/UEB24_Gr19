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

  <div class="back-button-container">
    <a href="Produktet.php">
        <button class="back-button">← Kthehu te Produktet</button>
    </a>
</div>

    <div class="container">
      <img src="images/produkt6.jpg" alt="Product Image" class="product-image">
      <div class="details">
        <h1>ELIXIR ULTIME. NOURISHING HAIR OIL FOR ALL HAIR TYPES.</h1>
        <p>Cmimi: $15</p>
        <p>Ne Stok: <span id="stock">25</span></p>
  
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
            <input type="text" id="address" name="address" placeholder="Adresa" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="Email"  pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}">
          </div>
          <div class="form-group">
            <label for="quantity">Sasia</label>
            <input type="number" id="quantity" name="quantity" max="25" min="1" required>
          </div>
          <button type="submit" style="padding: 10px; background-color: #6d4c3d; color: white; border-radius: 5%;">Porosit</button>
        </form>
        
        <p class="warning" id="warning">Nuk ka mjaftueshem ne stok!</p>
        <p class="success" id="success">Faleminderit per porosine tuaj! Produkti do arrij per 5-7 dite.</p>
      </div>
    </div>

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
