<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria-Radiant Touch</title>
    <link rel="icon" href="images/logo1.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<style>
  section{
 background-color:#f4e4d4 ;
  }
  section{
    background-color: #f4e4d4;
    background-image: url('images/bg1.jpg'), url('images/bg2.jpg'); 
    background-size: cover, auto; 
    background-origin: padding-box;
    background-attachment: fixed, scroll; 
    background-position: center center, top left; 
  }
  section {
    background-image: url('images/background.jpg'), url('images/overlay.png');
    background-size: cover, contain;
    background-position: center center, top left;
    background-attachment: fixed, scroll;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3); /* Add shadow to the whole section */
}

.gallery-item img {
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.5); /* Add shadow to each image */
}

#galleryheading {
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5); /* Add text shadow to the title */
}

</style>
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
<section>
  <h1 id="galleryheading"> Galeria</h1>

  <div class="galeria">
    <div class="gallery-item"> <img src="images/g13.jpg" alt="image 1 "> </div>
    <div class="gallery-item"> <img src= "images/g11.jpg" alt= "image 2 "> </div>
    <div class="gallery-item"> <img src="images/g8.jpg" alt="image 3 "> </div>
    <div class="gallery-item"> <img src= "images/g18.jpg" alt= "image 4 "> </div>
    <div class="gallery-item"> <img src="images/g20.jpg" alt="image 5 "> </div>
    <div class="gallery-item"> <img src= "images/g9.jpg" alt= "image 6 "> </div>
    <div class="gallery-item"> <img src="images/g16.jpg" alt="image 7 "> </div>
    <div class="gallery-item"> <img src= "images/foto1.jpg" alt= "image 8 "> </div>
    <div class="gallery-item"> <img src= "images/vetlla2.jpeg" alt= "image 9 "> </div>
    <div class="gallery-item"> <img src= "images/g3.jpg" alt= "image 10 "> </div>
    <div class="gallery-item"> <img src= "images/g7.jpg" alt= "image 11 "> </div>
    <div class="gallery-item"> <img src= "images/g12.jpg" alt= "image 12 "> </div>
    <div class="gallery-item"> <img src= "images/g4.jpg" alt= "image 13 "> </div>
    <div class="gallery-item"> <img src= "images/g14.jpg" alt= "image 14 "> </div>
    <div class="gallery-item"> <img src= "images/g21.jpg" alt= "image 15 "> </div>
    <div class="gallery-item"> <img src= "images/sherbim3.jpg" alt= "image 15 "> </div>
     </div>

  

  </div>
</section>
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