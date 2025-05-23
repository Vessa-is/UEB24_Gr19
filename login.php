<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $valid_email = "admin@gmail.com";
    $valid_password = "sekret123";

    if ($email === $valid_email && $password === $valid_password) {
        $_SESSION['user'] = [
            'email' => $email,
            'role' => 'admin'
        ];

        setcookie("user_email", $email, time() + (7 * 24 * 60 * 60), "/");

        header("Location: index.php");
        exit();
    } else {
        $error = "Email ose fjalëkalim i pasaktë!";
    }
}
?>





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
      background-color:  #f4e4d4;
      margin: 0;
      padding: 0;
     
    }

    .container {
      background-color:#f9f4eb;
      border: 1px solid #dcdcdc;
      width: 700px;
      padding: 20px;
      
    }

    .container h1 {
      font-size: 30px;
      color: #664f3e;
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-size: 15px;
      margin-bottom: 5px;
      color: #7a6c59;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #dcdcdc;
      background-color: #f9f4eb;
      font-size: 1rem;
    }

    .form-group a {
      display: block;
      font-size: 0.8rem;
      color: #664f3e;
      text-decoration: none;
      margin-top: 5px;
    }

    .form-group a:hover {
      text-decoration: underline;
    }

    .btn {
      width: 100%;
      padding: 10px;
      background-color: #664f3e;
      color: white;
      border: none;
      font-size: 1rem;
      cursor: pointer;
      margin-bottom: 10px;
    }

    .btn:hover {
      background-color: #523f31;
    }

    .or {
      text-align: center;
      font-size: 0.9rem;
      color: #999;
      margin: 10px 0;
    }

    .create-account {
      display: block;
      width: 100%;
      padding: 10px;
      border: 1px solid #dcdcdc;
      text-align: center;
      font-size: 1rem;
      color: #664f3e;
      text-decoration: none;
    }

    .create-account:hover {
      background-color: #f4ebe4;
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
        <h1>Login</h1>
        <?php if (!empty($error)) : ?>
  <p style="color:red; text-align:center;"><?php echo $error; ?></p>
      <?php endif; ?>

        <form id="login-form" action="" method="POST">
          <div class="form-group">
            <label for="email">Your Email </label>
            <input name="email" type="email" id="email" placeholder="Email-i" required>
          </div>
          <div class="form-group">
            <label for="password">Your Password </label>
            <input name="password" type="password" id="password" placeholder="Password" required>
          </div>
          <div class="form-group">
            <a href="forgot_password.php">Forgot your password?</a>
          </div>
          <button type="submit" class="btn">Log In</button>
        </form>
        <div class="or">or</div>
        <a href="create_account.php" class="create-account">Create account</a>
      </div>
      <script>
//           document.getElementById('login-form').addEventListener('submit', function (e) {
//   e.preventDefault();

//   const email = document.getElementById('email').value.trim();
//   const password = document.getElementById('password').value.trim();

//   // try {
//   //   validateLoginFields(email, password);
//   //   alert('Llogaria u hap me sukses!');
//   // } catch (error) {
//   //   alert(`Gabim: ${error.message}`);
//   // }
// });

function validateLoginFields(email, password) {
  if (!email || !password) {
    throw new Error('Të gjitha fushat janë të detyrueshme.');
  }

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    throw new Error('Ju lutem jepni një adresë email-i të vlefshme.');
  }

  if (password.length < 6) {
    throw new Error('Fjalëkalimi duhet të jetë të paktën 6 karaktere.');
  }
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
