<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/logo1.png" />
    <title>Create-Radiant Touch</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="style.css" />

    <style>
       body {
      font-family: Arial, sans-serif;
      background-color:  #f4e4d4;
      margin: 0;
      padding: 0;
     
    }
    .container {
      max-width: 700px;
      margin: 50px auto;
      background-color:#f9f4eb;
      padding: 20px;
      border: 2px solid #7a6c59;
      border: 1px solid #dcdcdc;
    }

    h1 {
      font-size: 30px;
      text-align: center;
      color: #664f3e;
      margin-bottom: 20px;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      font-size: 15px;
      margin-bottom: 5px;
      color: #7a6c59;
    }

    input {
      padding: 10px;
      font-size: 1rem;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      
      background-color: #f9f4eb;
    }

    button {
      padding: 10px;
      font-size: 1rem;
      background-color: #664f3e;
      color: white;
      border: none;
      cursor: pointer;
    }

    button:hover {
      background-color: #664f3e;
    }

    .back-link {
      text-align: center;
      margin-top: 15px;
    }

    .back-link a {
      color: #7a6c59;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .back-link a:hover {
      text-decoration: underline;
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
            <a href="login.php"><button id="loginBtn" aria-label="Login" >
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
        <h1>Create Account</h1>
        <form id="create-account-form" novalidate>
            <label for="first-name">First Name</label>
            <input type="text" id="first-name" name="first-name" placeholder="First Name" >
            
    
            <label for="last-name">Last Name</label>
            <input type="text" id="last-name" name="last-name" placeholder="Last Name" >
            
    
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" >
            
    
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" >
            
    
            <button type="submit">Create New Account</button>
        </form>
        <div class="back-link">
            <a href="login.php">Return to Login</a>
        </div>
    </div>
    
   
    
    <script>
        document.getElementById('create-account-form').addEventListener('submit', function (e) {
  e.preventDefault(); 

  const firstName = document.getElementById('first-name').value.trim();
  const lastName = document.getElementById('last-name').value.trim();
  const email = document.getElementById('email').value.trim();
  const password = document.getElementById('password').value.trim();

  try {
    validateFields(firstName, lastName, email, password);
    const account = createAccount(firstName, lastName, email, password);
    alert(`Llogaria u krijua me sukses më: ${account.creationDate.toLocaleString()}`);
    window.location.href = "login.php";
  } catch (error) {
    alert(`Gabim: ${error.message}`);
  }
});

function validateFields(firstName, lastName, email, password) {
  if (!firstName || !lastName || !email || !password) {
    throw new Error('Të gjitha fushat janë të detyrueshme.');
  }

  if (!/^[a-zA-Z\s]+$/.test(firstName) || !/^[a-zA-Z\s]+$/.test(lastName)) {
    throw new Error('Emri dhe mbiemri duhet të përmbajnë vetëm shkronja.');
  }

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    throw new Error('Ju lutem jepni një adresë email-i të vlefshme.');
  }

  if (password.length < 6) {
    throw new Error('Fjalëkalimi duhet të jetë të paktën 6 karaktere.');
  }
}

function createAccount(firstName, lastName, email, password) {
  const creationDate = new Date();
  return {
    firstName,
    lastName,
    email,
    password, 
    creationDate,
  };
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
