<?php
session_start();

$formData = [
    'first-name' => '',
    'last-name' => '',
    'email' => '',
    'password' => '',
    'confirm-password' => '',
    'data-e-lindjes' => '',
    'nr-personal' => ''
];

include 'script/classes/UserRepository.php';
require_once 'script/classes/User.php';

$errors = [];

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['first-name'] = sanitizeInput($_POST['first-name'] ?? '');
    $formData['last-name'] = sanitizeInput($_POST['last-name'] ?? '');
    $formData['email'] = sanitizeInput($_POST['email'] ?? '');
    $formData['password'] = $_POST['password'] ?? '';
    $formData['confirm-password'] = $_POST['confirm-password'] ?? '';
    $formData['data-e-lindjes'] = sanitizeInput($_POST['data-e-lindjes'] ?? '');
    $formData['nr-personal'] = sanitizeInput($_POST['nr-personal'] ?? '');

    if (empty($formData['first-name'])) {
        $errors['first-name'] = 'First name is required';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $formData['first-name'])) {
        $errors['first-name'] = 'First name should contain only letters';
    }

    if (empty($formData['last-name'])) {
        $errors['last-name'] = 'Last name is required';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $formData['last-name'])) {
        $errors['last-name'] = 'Last name should contain only letters';
    }

    if (empty($formData['email'])) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }

    if (empty($formData['password'])) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($formData['password']) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    }

    if (empty($formData['confirm-password'])) {
        $errors['confirm-password'] = 'Please confirm your password';
    } elseif ($formData['password'] !== $formData['confirm-password']) {
        $errors['confirm-password'] = 'Passwords do not match';
    }

    if (empty($formData['data-e-lindjes'])) {
        $errors['data-e-lindjes'] = 'Birthdate is required';
    } elseif (!preg_match('/^\d{2}\-\d{2}\-\d{4}$/', $formData['data-e-lindjes'])) {
        $errors['data-e-lindjes'] = 'Birthdate should be in DD-MM-YYYY format';
    }

    if (empty($formData['nr-personal'])) {
        $errors['nr-personal'] = 'Personal number is required';
    } elseif (!preg_match('/^\d{10}$/', $formData['nr-personal'])) {
        $errors['nr-personal'] = 'Personal number should be 10 digits';
    }

    if (empty($errors)) {
        $userRepository = new UserRepository();
        $personalnr = $formData['nr-personal'];
        $email = $formData['email'];
        $name = $formData['first-name'];
        $lastname = $formData['last-name'];
        $hashedPassword = password_hash($formData['password'], PASSWORD_DEFAULT);

        if ($userRepository->personalNrExists($personalnr)) {
            echo "<script>alert('Ky numër personal ekziston tashmë!');</script>";
        } elseif ($userRepository->userExistsByEmail($email)) {
            echo "<script>alert('Ky email është përdorur tashmë!');</script>";
        } else {
            $user = new User($name, $lastname, $email, $hashedPassword, $personalnr);
            $userRepository->insertUser($user);

            $_SESSION['user'] = [
                'emri' => $name,
                'mbiemri' => $lastname,
                'email' => $email,
                'personalNr' => $personalnr
            ];

            header("Location: index.php"); 
            exit();
        }
    }
}
?>

        <div class="back-link">
            <a href="login.php">Return to Login</a>
        </div>
    </div>


      
   
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
