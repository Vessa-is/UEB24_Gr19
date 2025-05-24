


<!DOCTYPE html>
< lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/logo1.png" />
    <title>Shërbimet-Radiant Touch</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />

    <style>
      body,
      html {
        margin: 0;
        padding: 0;
        background-color: #f4e4d4;
      }
      .sherbimet {
        font-family: Arial, sans-serif;
        background-color: #f4e4d4;
        margin: 0;
        padding: 0;
      }

      h1,
      h2,
      p {
        margin: 0;
        padding: 0;
        line-height: normal;
      }
      .sherbimet {
        margin-bottom: -1px;
      }

      .services-table {
        width: 90%;
        margin: 30px auto;
        border-collapse: collapse;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        overflow: hidden;
        background-color: #fff;
      }

      .services-table th {
        background-color: #6d4c3d;
        color: #fff;
        font-size: 14px;
        letter-spacing: 0.5px;
        padding: 15px;
        text-transform: uppercase;
      }

      .services-table td {
        font-size: 14px;
        color: #4b4b4b;
        padding: 15px;
        text-align: center;
        border: 1px solid #f3e5d8;
      }

      .services-table tr:nth-child(even) {
        background-color: #fdf3e8;
      }

      .services-table tr:hover {
        background-color: #decfbc;
        transform: scale(1.01);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
      }

      .services-table button {
        background-color: #6d4c3d;
        color: white;
        padding: 8px 12px;
        border: none;
        cursor: pointer;
        border-radius: 20px;
        font-size: 14px;
        transition: background-color 0.3s ease;
        font-weight: bold;
      }

      .services-table button:hover {
        background-color: #8b5e4c;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      }

      h1 {
        text-align: center;
        color: #6d4c3d;
        margin-top: 0;
        font-size: 40px;
        padding-top: 20px;
        padding-bottom: 10px;
      }
      .services {
        text-align: center;
        padding: 50px 20px;
        background-color: #f4e4d4;
      }

      .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
      }

      .modal-content {
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
      }

      .modal-header,
      .modal-footer {
        padding: 10px;
        color: white;
        background-color: #6d4c3d;
        text-align: center;
        border-radius: 10px 10px 0 0;
      }

      .modal-body {
        margin: 20px 0;
        text-align: center;
      }

      .modal-footer {
        border-radius: 0 0 10px 10px;
      }

      .modal-footer button {
        padding: 10px 15px;
        margin: 5px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        background-color: #6d4c3d;
        color: #fff;
        font-size: 14px;
        font-weight: bold;
      }

      .modal-footer button:hover {
        background-color: #8b5e4c;
      }

      button.book-btn {
        background-color: #6d4c3d;
        color: white;
        padding: 5px 10px;
        border: none;
        cursor: pointer;
      }

      button.book-btn:hover {
        background-color: #9e765d;
      }
      .content {
      background: url('content-background.jpg') center center / cover no-repeat;
      padding: 50px;
      text-align: center;
      background-attachment: scroll;
    }
    .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4); 
    animation: fadeIn 0.4s ease;
}


@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}


.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    animation: slideIn 0.5s ease;
}


@keyframes slideIn {
    from { transform: translateY(-50%); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.video-ad {
        position: relative;
        height: 400px;
        background: url('path-to-placeholder.jpg') center center / cover no-repeat;
        background-attachment: fixed;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
      }
    
     
    
      .video-ad video {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        min-width: 100%;
        min-height: 100%;
        z-index: -2;
        object-fit: cover;
        filter: brightness(0.7);
      }
    
   
      .ad-content h2 {
        font-size: 36px;
        margin-bottom: 10px;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
      }
    
      .ad-content p {
        font-size: 20px;
        margin-bottom: 20px;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
      }
    
      .ad-content button {
        padding: 10px 20px;
        font-size: 18px;
        color: white;
        background-color: #6d4c3d;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }
    
      .ad-content button:hover {
        background-color: #8b5e4c;
      }
      #calendar {
    max-width: 300px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

#calendar h2 {
    text-align: center;
    font-size: 22px;
    margin-bottom: 15px;
}

.days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px;
}

.day {
    padding: 10px;
    background-color: #f4f4f4;
    text-align: center;
    border-radius: 5px;
    cursor: pointer;
}

.day:hover {
    background-color: #3498db;
    color: white;
}

.sorting-form {
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 20px 10px;
  font-family: inherit;
  flex-wrap: wrap; 
  max-width: 100%;
}

.table-wrapper {
  overflow-x: auto;
  max-width: 100%;
}

table {
  width: 100%;
  border-collapse: collapse;
}


.sorting-label {
    font-weight: bold;
    color: #5C4438;
    font-size: 16px;
}

.sorting-select {
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #fdf6f0;
    color: #5C4438;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
}

.sorting-select:hover {
    border-color: #bfa48a;
}

.sorting-button {
    padding: 6px 14px;
    border: none;
    border-radius: 8px;
    background-color: #5C4438;
    color: white;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}

.sorting-button:hover {
    background-color: #7b5c4a;
}

#sherbimet-page {
    overflow: hidden; 
}

.message {
   color: #4caf50;  
   margin-top: 10px;
   font-weight: bold;
}

    </style>
  </head>
  <body id="sherbimet-page">


  <body>
  <?php if (isset($_POST['book_service'])): ?>
    <div class="modal-content">
      <div class="modal-header">Konfirmim</div>
      <div class="modal-body">Shërbimi u rezervua me sukses!</div>
      <div class="modal-footer">
        <a href="sherbimet.php"><button>OK</button></a>
      </div>
    </div>
  <?php endif; ?>
  </body>
  <!-- <h1>Lista e Shërbimeve</h1>
  rest of your service list here -->


 <!-- <?php include 'header.php'; ?> -->

        <header>
    <nav>
        <div class="logo-cont">
            <div class="logo">
                <a href="index.php">
                    <img src="images/logoo2.png" alt="Radiant Touch Logo" title="Radiant Touch">
                </a>
            </div>
            <div class="login">
                <a href="login.php">
                    <button id="loginBtn">
                        <i class="fa fa-user"></i>
                    </button>
                </a>
            </div>
        </div>
        <div id="navi">
            <ul>
                <?php foreach ($nav_links as $name => $url): ?>
                    <li><a href="<?php echo htmlspecialchars($url); ?>"><?php echo htmlspecialchars($name); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>
</header>

     <?php

$services = [
    ["name" => "Prerje e flokëve", "time" => "30 min.", "price" => 10],
    ["name" => "Fenirim i flokëve", "time" => "15 min.", "price" => 5],
    ["name" => "Shatir i flokëve", "time" => "180 min.", "price" => 50],
    ["name" => "Larje e flokëve", "time" => "10 min.", "price" => 2],
    ["name" => "Rregullimi i vetullave", "time" => "15 min.", "price" => 3],
    ["name" => "Qerpikë Volume", "time" => "90 min.", "price" => 35],
    ["name" => "Tattoo me fije japoneze", "time" => "120 min.", "price" => 99],
    ["name" => "Depilim të fytyrës", "time" => "15 min.", "price" => 4],
    ["name" => "Frizura për femra", "time" => "30 min.", "price" => 30],
    ["name" => "Rregullim për nuse", "time" => "120 min.", "price" => 75],
    ["name" => "Trajtim me argjilë për fytyrë", "time" => "30 min.", "price" => 20],
    ["name" => "Ekstension flokësh", "time" => "120 min.", "price" => 100],
    ["name" => "Trajtim SPA për duar", "time" => "40 min.", "price" => 15],
    ["name" => "Peeling trupor", "time" => "60 min.", "price" => 30],
    ["name" => "Hidratim intensiv për flokë", "time" => "45 min.", "price" => 25],
    ["name" => "Trajtim anti-akne për fytyrë", "time" => "80 min.", "price" => 40],
    ["name" => "Laminim i vetullave", "time" => "30 min.", "price" => 10],
    ["name" => "Balayage për flokë", "time" => "150 min.", "price" => 120],
    ["name" => "Masazh për kokën", "time" => "150 min.", "price" => 50],
    ["name" => "Përkujdesje për flokët e thatë dhe të dëmtuar", "time" => "120 min.", "price" => 80]
];


if (isset($_GET['sort_by'])) {
    $sort_by = $_GET['sort_by'];

    switch ($sort_by) {
        case 'price_asc':
            $prices = array_column($services, 'price');
            asort($prices);
            $services = array_map(function($key) use ($services) {
                return $services[$key];
            }, array_keys($prices));
            break;

        case 'price_desc':
            $prices = array_column($services, 'price');
            arsort($prices);
            $services = array_map(function($key) use ($services) {
                return $services[$key];
            }, array_keys($prices));
            break;

        case 'name_asc':
            $services_by_name = [];
            foreach ($services as $service) {
                $services_by_name[$service['name']] = $service;
            }
            ksort($services_by_name); 
            $services = array_values($services_by_name); 
            break;

        case 'name_desc':
            $services_by_name = [];
            foreach ($services as $service) {
                $services_by_name[$service['name']] = $service;
            }
            krsort($services_by_name); 
            $services = array_values($services_by_name); 
            break;

        case 'time_asc':
            usort($services, function($a, $b) {
                $time_a = (int)filter_var($a['time'], FILTER_SANITIZE_NUMBER_INT);
                $time_b = (int)filter_var($b['time'], FILTER_SANITIZE_NUMBER_INT);
                return $time_a - $time_b;
            });
            break;

        case 'time_desc':
            usort($services, function($a, $b) {
                $time_a = (int)filter_var($a['time'], FILTER_SANITIZE_NUMBER_INT);
                $time_b = (int)filter_var($b['time'], FILTER_SANITIZE_NUMBER_INT);
                return $time_b - $time_a;
            });
            break;
    }
}

?>
<section class="sherbimet">
    <h1>Shërbimet tona</h1>

    <form method="GET" class="sorting-form">
      <label class="sorting-label" for="sort_by">Rendit sipas:</label>
      <select name="sort_by" class="sorting-select" id="sort_by">
        <option value="name_asc" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] === 'name_asc') ? 'selected' : '' ?>>Emri (A-Z)</option>
        <option value="name_desc" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] === 'name_desc') ? 'selected' : '' ?>>Emri (Z-A)</option>
        <option value="price_asc" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] === 'price_asc') ? 'selected' : '' ?>>Çmimi (Rritës)</option>
        <option value="price_desc" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] === 'price_desc') ? 'selected' : '' ?>>Çmimi (Zbritës)</option>
        <option value="time_asc" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] === 'time_asc') ? 'selected' : '' ?>>Koha (Rritës)</option>
        <option value="time_desc" <?= (isset($_GET['sort_by']) && $_GET['sort_by'] === 'time_desc') ? 'selected' : '' ?>>Koha (Zbritës)</option>
      </select>
      <button type="submit" class="sorting-button">Rendit</button>
    </form>

    <table class="services-table">
        <thead>
            <tr>
                <th>Emri</th>
                <th>Koha</th>
                <th>Çmimi (€)</th>
                <th>Rezervo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
            <tr>
                <td><?= htmlspecialchars($service['name']) ?></td>
                <td><?= htmlspecialchars($service['time']) ?> min.</td>
                <td><?= htmlspecialchars($service['price']) ?> €</td>
                <td>
                    <form method="POST">
                        <!-- Remove service_id if you don’t have IDs -->
                        <button type="submit" name="book_service" class="book-btn">Rezervo</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    
</section>
  </body>
  

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

    <script>
  function checkNumber() {
    let number = 1.7976931348623157e+308; 
    let invalidNumber = "text" / 2;  

    console.log("MAX_VALUE: ", number);
    console.log("NaN Example: ", invalidNumber);

    
    if (isNaN(invalidNumber)) {
      alert("Vlera nuk është një numër të vlefshëm!");
    }
  }
  let finiteNumber = 12345;
  console.log(Number.isFinite(finiteNumber));
  
  function formatNumber() {
    let num = 12345.6789;
    console.log("Numri në format eksponencial: " + num.toExponential(2));
    console.log("Numri si string: " + num.toString()); 
  }

 
  function manipulateString() {
    let text = "Rezervoni shërbimin tuaj tani!";
    
   
    let matched = text.match(/shërbimin/);
    console.log("Fjala e gjetur me match():", matched ? matched[0] : "Nuk u gjet.");

   
    let newText = text.replace("tani", "sot");
    console.log("Teksti i përditësuar: " + newText);
  }

  
  function openModal(service) {
    document.getElementById("serviceName").textContent = `Shërbimi: ${service}`;
    document.getElementById("bookingModal").style.display = "block";
    checkNumber();  
    formatNumber();  
    manipulateString(); 
  }

  function closeModal() {
    document.getElementById("bookingModal").style.display = "none";
  }

  function confirmBooking() {
    const date = document.getElementById("date").value;
    const time = document.getElementById("time").value;
    if (date && time) {
      alert(`Termini u rezervua me sukses për datën ${date} në orën ${time}`);
      closeModal();
    } else {
      alert("Ju lutem plotësoni të gjitha fushat.");
    }
  }

function openModal() {
  const modal = document.getElementById("reservationModal");
  modal.style.display = "block"; // E hapim modalin

 
  setTimeout(function() {
    modal.style.display = "none"; 
  }, 100000); 
}

document.getElementById("openModalButton").addEventListener("click", openModal);
function onModalClose() {
  console.log("Modal u mbyll. Rezervimi u mbyll me sukses!");
  alert("Shërbimi u rezervua me sukses! Ju mirëpresim.");
}
document.querySelectorAll(".rezervo-btn").forEach(button => {
  button.addEventListener("click", () => {
    const serviceName = button.getAttribute("data-service-name");
    openModal(serviceName, onModalClose);
  });
});
function openModal(serviceName) {
  
  document.getElementById('serviceName').innerText = "Shërbimi: " + serviceName;

  $('#bookingModal').slideDown();
}

function closeModal() {
  
  $('#bookingModal').slideUp();
}

function confirmBooking() {
  alert("Rezervimi është konfirmuar!");
  closeModal();
}

const calendar = document.getElementById('calendar');

function renderCalendar() {
    const currentDate = new Date();
    const currentMonth = currentDate.getMonth();
    const currentYear = currentDate.getFullYear();
    
    
    const monthNames = ["Janar", "Shkurt", "Mars", "Prill", "Maj", "Qershor", "Korrik", "Gusht", "Shtator", "Tetor", "Nëntor", "Dhjetor"];
    const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    
    let calendarHTML = `<h2>${monthNames[currentMonth]} ${currentYear}</h2>`;
    calendarHTML += '<div class="days">';
    
   
    for (let i = 1; i <= daysInMonth; i++) {
        calendarHTML += `<div class="day">${i}</div>`;
    }
    
    calendarHTML += '</div>';
    calendar.innerHTML = calendarHTML;
}

renderCalendar();
    </script>
  </body>
</html>
