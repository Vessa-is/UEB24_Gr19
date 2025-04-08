<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/logo1.png" />
    <title>Login-Radiant Touch</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
    <style>
      body {
      font-family: Arial, sans-serif;
      background-color: #f4e4d4;
      margin: 0;
      padding: 0;
    }
    .container {
      background-color: #f9f4eb;
      border: 1px solid #dcdcdc;
      padding: 20px;
      width: 400px;
      text-align: center;
    }
    .container h1 {
      font-size: 24px;
      margin-bottom: 20px;
      color: #664f3e;
    }
    .container input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #dcdcdc;
    }
    .container button {
      width: 100%;
      padding: 10px;
      background-color: #664f3e;
      color: white;
      border: none;
      cursor: pointer;
    }
    .container button:hover {
      background-color: #523f31;
    }
    </style>
    <script src="javascript.js"></script>
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
    
    <div class="container">
        <h1>Forgot Password</h1>
        <p>Enter your email to reset your password</p>
        <input type="email" id="reset-email" placeholder="Enter your email" required>
        <button onclick="sendResetLink()">Send Reset Link</button>
        <p id="message" style="color: rgba(128, 60, 0, 0.688); margin-top: 10px;"></p>
      </div>
      <script>
        function sendResetLink() {
          const email = document.getElementById('reset-email').value.trim();
          if (!email) {
            alert('Please enter your email.');
            return;
          }
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(email)) {
            alert('Please enter a valid email address.');
            return;
          }
          document.getElementById('message').innerText = 'A reset link has been sent to your email.';
        }
      </script>
    <footer>
      <div class="footer-container">
        <div class="footer-section">
          <img src="images/logoo2.png" class="logo1" alt="Radiant Touch Logo" />
          <p>
            Radiant Touch ofron shërbime profesionale për flokët, qerpikët dhe
            vetullat. Synojmë t’ju ndihmojmë të ndiheni të bukur çdo ditë.
          </p>
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
          <p>
            <i class="fas fa-phone"></i>
            <a href="tel:+38344222222" style="color: #fff; text-decoration: none"
              >+383 44 222 222</a
            >
          </p>
          <p>
            <i class="fas fa-envelope"></i
            ><a
              href="mailto:info@radianttouch.com"
              style="color: #fff; text-decoration: none"
              >info@radianttouch.com</a
            >
          </p>
        </div>
      </div>
      <hr style="width: 90%;  margin: 10px auto; ">
      <div class="footer-section newsletter">
        <h3>Abonohuni</h3>
        <form id="abonimform" method="POST">
          <div class="newsletter-input">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Shkruani email-in tuaj" required />
            <button type="submit" aria-label="Dërgo email">
              <i class="fas fa-paper-plane"></i>
            </button>
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
        &copy; 2025 <a href="index.php" style="text-decoration: none;"><span> Radiant Touch </span></a>. Të gjitha të drejtat janë të
        rezervuara.
      </div>
    </footer>
  </body>
</html>
