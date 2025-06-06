<?php

if (!isset($_SESSION)) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rreth nesh-Radiant Touch</title>
    <link rel="icon" href="images/logo1.png" />
    <link rel="stylesheet" href="style.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>

      .text-section {
        flex: 1 1 50%;
        padding: 15px; 
      }
      
      .text-section h1 {
        font-size: 28px;
        font-family: 'Playfair Display', serif; 
        font-weight: 700;
        margin-bottom: 15px;
        color: #333; 
      }
      
      .text-section p {
        font-size: 16px;
        font-family: Arial, sans-serif;
        line-height: 1.8;
        color: #555; 
        margin-bottom: 15px;
      }
      
      
      .image-section {
        flex: 1 1 50%;
        padding: 15px; 
        text-align: center;
      }
      
      .interior-image {
        width: 85%; 
        border-radius: 12px;
        border: 2px solid #eaeaea; 
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
      }
      .interior-image:hover {
        transform: scale(1.02); 
        transition: transform 0.3s ease;
      }
      
      @media (max-width: 768px) {
        .about-us {
          flex-direction: column;
          align-items: center;
        }
      
        .text-section, .image-section {
          flex: 1 1 100%;
          text-align: center;
        }
      
        .interior-image {
          width: 90%; 
        }
      }
      
      .history-section {
          width: 100%;
          margin: 20px 0;
          padding: 0 10%;
          color: #333;
      }
      
      .content-block p,
      .subsection p {
          font-size: 16px;
          line-height: 1.8;
          margin: 20px 0;
      }
      
      .subsection h2 {
          font-size: 20px;
          font-family: 'Playfair Display', serif;
          color: #444;
          margin-top: 30px;
      }
      
      .history-section {
          background-color: transparent;
          padding: 20px 10%;
      }
      
     
      
      
      
      .photo-grid {
          display: grid;
          grid-template-columns: repeat(3, 1fr); 
          grid-template-rows: auto; 
          gap: 12px; 
          max-width: 1000px; 
          width: 90%;
          margin: 0 auto; 
         padding-bottom: 50px;
      }
      
      .photo {
          overflow: hidden;
          border-radius: 8px;
          aspect-ratio: 4 / 3; 
      }
      
      .photo img {
          width: 100%;
          height: 100%;
          object-fit: cover; 
      }
      
      .photo.large {
          grid-column: span 3; 
          aspect-ratio: 16 / 9; 
      }
      
      .photo.medium {
          grid-column: span 1; 
      }
      .rotating-logo {
        padding-top: 20px;
          width: 150px; 
          height: 150px;
          margin: 20px auto;
          display: flex;
          justify-content: center;
          align-items: center;
      }
      
      .rotating-logo img {
          width: 100%; 
          height: 100%;
          animation: rotate 10s linear infinite; 
          border-radius: 50%; 
      }
      
      @keyframes rotate {
          from {
              transform: rotate(0deg);
          }
          to {
              transform: rotate(360deg);
          }
      }
      .about-us-text {
          margin: 20px 0; 
      }
      
      .about-us-text h2 {
        text-align: center; 
          font-family: 'Playfair Display', serif; 
          font-size: 50px; 
          color: #ad6159; 
          text-transform: uppercase; 
          letter-spacing: 2px; 
          margin: 0; 
      }
      
      .qellimet {
    padding-left: 20px; 
    font-family: Arial, sans-serif; 
    font-style: normal; 
    font-size: 16px; 
    color: #555; 
    line-height: 1.8; 
}

.qellimet li {
    font-style: normal; 
    margin-bottom: 10px; 
}

.qellimet-inner {
    list-style-type: square; 
    padding-left: 20px; 
    font-family: Arial, sans-serif;
    font-style: normal; 
    font-size: 16px; 
    color: #555; 
    line-height: 1.8; 
}
.button {
    display: inline-block; 
    padding: 10px 20px; 
    font-size: 16px; 
    color: #fff; 
    background-color: #ad6159; 
    text-decoration: none; 
    border-radius: 5px; 
    transition: background-color 0.3s; 
}

.button:hover {
    background-color: #943c43; 
}
.team-section {
  max-width: 800px;
  margin: 50px auto;
  text-align: center;
}

.team-section h2 {
  margin-bottom: 30px;
  font-size: 2rem;
  color: #ad6159;
  text-align: center;
}

.team-container {
  display: grid;
  grid-template-columns: repeat(2, 1fr); 
  gap: 20px;
}

.team-member {
  display: flex;
  align-items: center;
  padding: 20px;
  border-radius: 10px;

}

.team-image {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  object-fit: cover;
  margin-right: 20px;
  border: 1px solid #523f31;
}

.team-info {
  text-align: left;
  flex: 1;
}

.team-info h3 {
  font-size: 1.5rem;
  color: #333;
  margin-bottom: 10px;
}

.team-info p {
  font-size: 1rem;
  color: #555;
  margin-bottom: 10px;
}

.details {
  display: none;
  font-size: 0.9rem;
  color: #777;
  margin-top: 10px;
}

.details-toggle {
  background-color: #523f31;
  color: #fff;
  border: none;
  padding: 8px 15px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1rem;
}

.details-toggle:hover {
  background-color: #664f3e;
}

      </style>
</head>
<body id="aboutuspagebody">

       <?php include 'header.php'; ?>


      <div class="rotating-logo">
        <img src="images/rotatinglogo.png" alt="Rotating Logo" />
    </div>
    <div class="about-us-text">
      <h2>Rreth nesh</h2>
  </div>

      <section class="history-section">
        <article class="subsection">
            <h2>Historia jonë</h2>
            <p id="aboutusgreeting"></p>
            <p>
                Radiant Touch është një sallon i bukurisë i themeluar në vitin 2020, i krijuar me pasion për të ofruar shërbime të jashtëzakonshme dhe një përvojë relaksuese për klientët tanë. Qëllimi ynë ka qenë gjithmonë të nxjerrim në pah bukurinë dhe vetëbesimin e çdo personi që viziton sallonin tonë. Me një staf të dedikuar dhe me përvojë, Radiant Touch ofron shërbime moderne të kujdesit për flokët, lëkurën dhe trupin, duke përdorur produkte të cilësisë më të lartë dhe teknika inovative. Historia jonë reflekton përkushtimin tonë për ekselencë dhe dëshirën për të krijuar një ambient të ngrohtë dhe mikpritës ku klientët tanë ndihen të veçantë dhe të vlerësuar.
            </p>
        </article>
   
      
        <article class="subsection">
          <h2>Qellimet tona</h2>
          <p>
            <ol class="qellimet">
              <li>Ofrojme nje eksperience relaksuese dhe te kendshme për klientet tane.
                  <ol class="qellimet-inner">
                      <li>Krijimi i nje atmosfere te qete dhe te rehatshme.</li>
                      <li>Sigurimi i sherbimeve profesionale per çdo lloj kerkese.</li>
                  </ol>
              </li>
              <li>Sigurojme sherbime të cilesise së larte per kujdesin e trupit dhe lekures.
                  <ol class="qellimet-inner">
                      <li>Perdorimi i produkteve natyrale dhe te certifikuara.</li>
                      <li>Pershtatja e trajtimeve sipas nevojave të individeve.</li>
                  </ol>
              </li>
          </ol>
          </p>
      </article>
      


        <article class="subsection">
            <h2>Produktet tona</h2>
            <p>
                Radiant Touch ofron produkte cilesore per kujdesin e flokeve dhe bukurine. Ne krenohemi me produktet Kerastase, qe ndihmojne rritjen e shpejte dhe te shendetshme te flokeve, maska ushqyese per floke, dhe ngjyra te shendetshme qe ruajne shkelqimin natyral te flokeve. Radiant Touch sjell nje eksperience unike, duke u perkushtuar qe cdo produkt te jete i sigurt dhe efektiv per pamjen tuaj me te mire.
            </p>
            <a href="produktet.php" class="button">Shiko Produktet</a>
        </article>
    </section>
    <script>
      $(document).ready(function() {
    $(".button").click(function(event) {
        
        var currentText = $(this).text();
        console.log("Teksti i tanishëm: " + currentText);

        
        $(this).text("Po të dërgojmë tek Produktet...");

        
        $(this).addClass("highlight");

        
        setTimeout(function() {
            
            $("button").removeClass("highlight");

            
            $(".button").text(currentText);
        }, 1000);
    });
});

    </script>
    <div class="team-section">
      <h2>Stafi Ynë</h2>
      <div class="team-container">
          
          <div class="team-member">
              <img src="images/stafi1.jpg" alt="Adelina Kastrati" class="team-image">
              <div class="team-info">
                  <h3>Adelina Kastrati</h3>
                  <p>Parukiere e talentuar me përvojë të madhe në stilimin dhe ngjyrosjen e flokëve.</p>
                  <button class="details-toggle">Më shumë</button>
                  <div class="details">
                    Adelina është eksperte në stilimin modern dhe ngjyrosjen e flokëve, duke përdorur teknika inovative për rezultatet më të mira.
                  </div>
              </div>
          </div>
  
        
          <div class="team-member">
              <img src="images/stafi2 (2).jpg" alt="Drita Murati" class="team-image">
              <div class="team-info"> 
                  <h3>Drita Murati</h3>
                  <p>Eksperte për Kujdesin dhe Modelimin e Qerpikëve</p>
                  <button class="details-toggle">Më shumë</button>
                  <div class="details">
                    Drita është e njohur për aftësinë e saj për të krijuar pamje natyrale dhe elegante. Ajo përdor teknika të avancuara për rritjen dhe forcimin e qerpikëve të klientëve.
                  </div>
              </div>
          </div>
  
         
          <div class="team-member">
              <img src="images/stafi3 (2).jpg" alt="Sofija Kelmendi" class="team-image">
              <div class="team-info">
                  <h3>Sofija Kelmendi</h3>
                  <p>Eksperte për trajtimet e vetullave</p>
                  <button class="details-toggle">Më shumë</button>
                  <div class="details">
                    Sofija përdor teknika precize për të krijuar formën perfekte të vetullave. Ajo është gjithashtu e specializuar në ngjyrosjen dhe modelimin e tyre sipas tipareve të fytyrës.
                  </div>
              </div>
          </div>
  
  
          <div class="team-member">
              <img src="images/stafi4 (2).jpeg" alt="Ardita Berisha" class="team-image">
              <div class="team-info">
                  <h3>Ardita Berisha</h3>
                  <p>Specialistja e produkteve për kujdesin e flokëve dhe bukurinë</p>
                  <button class="details-toggle">Më shumë</button>
                  <div class="details">
                    Ardita ofron këshilla profesionale dhe rekomandime për përdorimin e produkteve të duhur për çdo lloj flokësh, si dhe për kujdesin e përditshëm të flokëve dhe trupit.
                  </div>
              </div>
          </div>
      </div>
    </div>
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      $(document).ready(function(){
    $(".details-toggle").click(function(){
      var details = $(this).siblings(".details");
      
      if (details.is(":visible")) {
        details.hide(500); 
        $(this).text("Më shumë"); 
      } else {
        details.show(500); 
        $(this).text("Më pak"); 
      }
    });
  });
  
  </script>

       
    <div class="photo-grid">
      <div class="photo large">
          <img src="images/a4.jpg" alt="interior">
      </div>
      <div class="photo medium">
          <img src="images/a1.jpg" alt="Interior 1">
      </div>
      <div class="photo medium">
          <img src="images/a3.jpg" alt="Interior 2">
      </div>
      <div class="photo medium">
          <img src="images/a2.jpg" alt="Interior 3">
      </div>
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
            
    


    <script src="javascript.js"></script>


    <?php include 'footer.php'; ?>

</body>
</html>



