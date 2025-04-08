<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radiant Touch</title>
    <link rel="icon" href="images/logo1.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <script src="javascript.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" href="style.css">
    <style>
        .section {
        position: relative;
        width: 100%;
        height: 100vh;
        background: url("images/foto2.jpg") no-repeat;
        background-position: center; 
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #473524;
      }
      .content {
        
        text-align: left;
        max-width: 600px;
        padding: 20px;
      }
      .content h1 {
        font-size: 64px;
        line-height: 1.2;
        margin-top: 20px;
        margin-bottom: 20px;
        font-family: "Georgia", serif;
        font-style: italic;
        position: absolute;
        top: 20%;
        left: 5%;
        max-width: 600px;
        text-shadow: 3px 3px 10px #F2E8DE;
      }
      .content p {
        font-size: 19px;
        margin-bottom: 50px;
        line-height: 1.6;
        position: absolute;
        bottom: 10%;
        right: 10%;
        text-align: right;
        max-width: 400px;
      }
      .content button {
        padding: 15px 30px;
        font-size: 16px;
        color: #fff;
        background-color: #96887d;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 10px;
      }
      .content button:hover {
        background-color: #6f6154;
      }
      .content button:focus {
        outline: none;
      }
      .description {
        position: absolute;
        bottom: 20%;
        right: 10%;
        text-align: right;
        max-width: 400px;
      }
      .kontenti2{
        position: relative;
      width: 100%;
      height: 100vh;
      background-image: url('images/rez2.jpg'); 
      background-size: cover;
      background-position: center;
      display: flex;
  justify-content: center;
  align-items: center;
       }
       .rezervimi{
        position: relative;
      text-align: center;
      color: white;
       }
       .rezervimi h1{
        font-size: 40px;
      font-weight: 300;
      margin: 10px 0;
      line-height: 1.5;
       }
       .rezervimi p{
        font-size: 19px;
      font-weight: 400;
      margin: 10px 0;
       }

    .btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #7c5b43; 
      color: white;
      text-decoration: none;
      font-size: 16px;
      font-weight: bold;
      border-radius: 20px;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #5c432c; 
    }
    .container_index1 {
  position: relative;
  width: 100%;
  height: 100vh; 
  overflow: hidden;
}

.container_index1 video {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%); 
  width: 100%;
  height: auto; 
  object-fit: contain;
}
.overlay-text {
  position: absolute;
  top: 0.5%; 
  left: 50%;
  transform: translate(-50%,0);
  text-align: center;
  color: #e2cccc;
  text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.8);
  z-index: 100;
  font-family: "Playfair Display", serif;
  pointer-events: none; 

  background: rgba(132, 121, 121, 0.4); 
  padding: 10px 20px;
  border-radius: 10px;
}

.overlay-text h1 {
  font-size: 32px; 
  font-weight: bold;
  letter-spacing: 1px;
  margin-bottom: 10px;
  line-height: 1.3;
  text-transform: uppercase;
}

.overlay-text p {
  font-size: 16px; 
  font-weight: 300;
  letter-spacing: 0.5px;
}

.container_index1::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(to bottom, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0));
  pointer-events: none;
}
.product-section {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 0;
    width: 100vw;
    height: 60vh; 
    background: linear-gradient(to right, #f7f7f7, #e3e3e3);
    border-top: 10px solid #664f3e;
    border-bottom: 10px solid #664f3e;
}

.text-container {
    position: relative;
    width: 100vw; 
    height: 100%; 
    background: url("images/produktebanner.webp") no-repeat center center;
    background-size: cover;
    display: flex;
    justify-content: flex-end; 
    align-items: center;
    color: #473524;
    padding:  20px; }

.text-content {
    display: flex;
    flex-direction: column;
    justify-content: center; 
    align-items: center;
    height: 100%; 
    text-align: center; 
    padding: 0 40px;
    box-sizing: border-box;
}

.text-content h1, .text-content h2 {
    margin: 0;
    padding: 10px 0;
}

.text-content h1 {
    font-size: 27px; 
    font-weight: bold;
}

.text-content h2 {
    font-size: 19px; 
    margin-bottom: 10px;
}

.button-container {
    margin-top: 20px 0;
}

.button-container a {
    text-decoration: none;
    background-color: #7c5b43;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease;
}

.button-container a:hover {
    background-color: #473524;
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

      <section>
        <div class="section">
          <div class="content">
            <h1>
              Where beauty <br />
              meets confidence 
            </h1>
            <div class="description">
            <p>
              Përjetoni kujdes profesional dhe trajtime që theksojnë shkëlqimin tuaj natyral.
            </p>
            <button onclick="location.href='sherbimet.php';">Rezervo Online</button>
          </div>
        </div>
      </section>

      <section id="perne" class="about">
        <h1 class="heading"> <span>Rreth </span> nesh</h1>

        <div class="about-container">
          <div class="about-image">
            <img src="images/about2.jpg" alt="Shërbim profesional për flokët" />
          </div>
      
          <div class="about-content">
            <h3>Radiant Touch</h3>
            <hr>
            <p>
              Radiant Touch është një sallon bukurie që ofron shërbime të specializuara për kujdesin e flokëve, qerpikëve dhe vetullave. Me një ekip profesionistësh të përkushtuar dhe produkte të cilësisë së lartë, ne synojmë të nxjerrim në pah bukurinë tuaj natyrale dhe t'ju ofrojmë një përvojë relaksuese e luksoze. Vizitoni sallonin tonë dhe përjetoni kujdesin e merituar!
            </p>
            <a href="per_ne.php" class="about-button">Lexo më shumë</a>
          </div>
        </div>
        <script>
          $(document).ready(function() {
              $(".about-content h3").css("color", "#664f3e");    
          });
      </script>
    
    </section>
    <div class="container_index1">
      <div class="overlay-text">
        <h1>Welcome to Radiant Touch</h1>
        <p>Where beauty meets confidence</p>
      </div>
      <video autoplay muted loop>
        <source
          src="videos/videoo3.mp4"
          type="video/mp4"
        />
      </video>
      </div>
    
      <div class="audio-container">
      <audio controls autoplay loop muted>
        <source src="audios/audio1.mp3" type="audio/mp3">
      </audio>
    </div>
    <section class="product-section">
      <div class="text-container">
          <div class="text-content">
              <h1>Flokë të Shëndetshëm dhe Plot Shkëlqim</h1>
              <h2><strong>Kerastase: Kujdesi që Flokët Tuaj e Meritojnë.</strong></h2>
              <div class="button-container">
                  <a href="Produktet.php">Blej Tani</a>
              </div>
          </div>
      </div>
  </section>
    <section class="container">
      <h2>SHËRBIMET TONA</h2>
      <div class="services">
          <div class="service-item">
              <img src="images/indexx2.jpg" alt="Stilim dhe trajtime për flokë">
              <p>STILIM DHE TRAJTIME PËR FLOKË</p>
          </div>
          <div class="service-item">
              <img src="images/sherbim2.jpg" alt="Aplikim qerpikësh">
              <p>APLIKIM QERPIKËSH</p>
          </div>
          <div class="service-item">
              <img src="images/indexx.jpg" alt="Stilim dhe laminim i vetullave">
              <p>STILIM DHE LAMINIM I VETULLAVE</p>
          </div>
      </div>
      <a href="galeria.php" class="main-btn">Shiko Galerinë <i class="fas fa-arrow-right"></i></a>
  </section>
  
  
    <section class="kontenti2">
      <div class="rezervimi">
        <svg width="100%" height="100">
          <text x="50%" y="50%" text-anchor="middle" fill="white" font-size="40" font-family="Arial">
            <animate
              attributeName="y"
              begin="0s"
              dur="4s"
              from="50%"
              to="30%"
              repeatCount="indefinite"
            />
            Rezervo Online
          </text>
        </svg>
      <p>Terminin tuaj...</p>
      <a href="sherbimet.php" class="btn">Rezervo</a>
    </div>
</section>
<script>
  $(document).ready(function() {
   
    $(".btn").hover(function() {
      $(this).css("background-color", "#6f6154");  
    }, function() {
      $(this).css("background-color", "#96887d");  
    });
  });
</script> 
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <img src="images/logoo2.png" class="logo1" alt="Radiant Touch Logo" >
                <p>Radiant Touch ofron shërbime profesionale për flokët, qerpikët dhe vetullat. </br>Synojmë t’ju ndihmojmë të ndiheni të bukur &ccedil;do ditë.</p>
            </div>
            <div class="footer-section">
                <h3>Kategorit&euml;</h3>
                <ul class="footer-list hidden">
                    <li><a href="index.php">BALLINA</a></li>
                    <li><a href="sherbimet.php">SHERBIMET</a></li>
                    <li><a href="galeria.php">GALERIA</a></li>
                    <li><a href="Produktet.php">PRODUKTET</a></li>
                    <li><a href="per_ne.php">RRETH NESH</a></li>
                    <li><a href="kontakti.php">KONTAKTI</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Kontakti </h3>
                  
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
                    <div class="icons">
                        <a href="https://www.facebook.com" class="icon"  aria-label="Facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com" class="icon" aria-label="Instagram" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.twitter.com" class="icon" aria-label="Twitter" target="_blank"><i class="fab fa-twitter"></i></a>
    
                    </div>
                </form>
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
            </div>
            
            <div class="footer-bottom">
                &copy; 2025 <a href="index.php" style="text-decoration: none;"><span> Radiant Touch </span></a>. Të gjitha të drejtat janë të rezervuara.

            </div>
            <button id="scrollToTop" title="Kthehu lart"><i class="fas fa-arrow-up"></i></button>
            <script>
              $(document).ready(function() {
                $(window).scroll(function() {
                  if ($(this).scrollTop() > 600) {
                    $("#scrollToTop").fadeIn(); 
                  }else {
                    $("#scrollToTop").fadeOut(); 
                  }});
                  $("#scrollToTop").click(function() {
                    $("html, body").animate({ scrollTop: 0 }, 600); 
                  });
                });

            </script>
           
            
    </footer>
  
</body>
</html>