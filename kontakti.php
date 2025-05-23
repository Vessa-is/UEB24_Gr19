<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakti-Radiant Touch</title>
    <link rel="icon" href="images/logo1.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<style>
    body {
  font-family: Arial, sans-serif;
  background-color:#f4e4d4;
  margin: 0;
  padding: 0;
}
.contact-container {
  display: flex;
  flex-wrap: nowrap;
  align-items: flex-start;
  justify-content: space-between;
  padding: 40px;
  gap: 20px;
}
.contact-image img  {
max-width: 100%;
height: 700px;
border-radius: 10px;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.contact-form{
flex: 1;
max-width: 50%;
padding: 20px;
display: flex; 
flex-direction: column;
justify-content: space-between;
}
.contact-image {
flex: 1;
max-width: 50%;
display: flex;
align-items: center;
justify-content: center;
}

.contact-text {
margin-left: 20px;
text-align: center;
padding: 20px;
}
.contact-text h2 {
color: #6d4c3d;
font-family: 'Georgia', serif;
font-style: italic;
margin-bottom: 15px;
}
.contact-text p {
color: #6d4c3d;
font-size: 16px;
line-height: 1.6;
}    
.container {
max-width: 600px;
      margin: 50px auto;
      padding: 20px;
  }

h2 {
  font-family: 'Georgia', serif;
  font-style: italic;
  color: #6d4c3d;
  text-align: center;
  margin-bottom: 20px;
}

form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

label {
  font-weight: bold;
  color: #6d4c3d;
}

input, textarea {
  font-size: 14px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #faf8f2;
  width: 100%;
  box-sizing: border-box;
}

textarea {
  height: 150px;
  resize: vertical;
}

button {
  background-color: #6d4c3d;
  color: white;
  border: none;
  padding: 10px ;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
}
button:hover {
  background-color: #4f3d30;
}

.follow-us {
  text-align: center;
  margin-top: 10px;
  padding-bottom: 20px;
  color: #96887d;
}
.follow-us h3 {
color: #6d4c3d;
font-style: italic;
font-family: 'Georgia', serif;
margin-bottom: 10px;
}    
.checkbox-container input {
width: 16px;
height: 16px;}

.location .Orari {
padding: 20px;
margin-top: 20px;
text-align: center;
}
.location .Orari h3 {
color: #6d4c3d;
font-style: italic;
font-family: 'Georgia', serif;
text-decoration: underline;
margin-bottom: 10px;
}
.location .Orari ul {
list-style: none;
padding: 0;
color: #6d4c3d;
list-style-type: circle;
}
.location .Orari li {
margin: 5px 0;
}
.lokacioni-dyqanit {
padding: 20px;
margin: 5px;
margin-top: 30px;
text-align: center;

}
.lokacioni-dyqanit h2 {
color:#6d4c3d;
font-style: italic;
font-family: 'Georgia', serif;
margin-bottom: 20px;
}
.locations-wrapper {
display: flex;
justify-content: space-between;
gap: 2px;
flex-wrap: wrap;
}
.location {
flex: 1;
min-width: 150px;
max-width: 250px;
padding: 10px;
margin: 0 5px;
background-color: #faf8f2;
border: 1px solid #e0d9c8;
border-radius: 10px;
text-align: center;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
transition: transform 0.3s, box-shadow 0.3s;
}
.location:hover {
transform: translateY(-5px);
box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
}
.location-number {
display: block;
font-size: 24px;
font-weight: bold;
color: #6d4c3d;
margin-bottom: 10px;
}
.location p {
margin: 10px 0;
color: #6d4c3d;
font-size: 14px;
line-height: 1.5;
}
.map-link {
display: inline-block;
margin-top: 10px;
font-size: 14px;
color: #6d4c3d;
text-decoration: none;
font-weight: bold;
transition: color 0.3s;
}

.map-link:hover {
color: #d6c1ac;
text-decoration: underline;
}
.feedback-section {
background-color: #faf8f2;
border: 1px solid #e0d9c8;
border-radius: 10px;
padding: 20px;
margin: 20px auto;
max-width: 600px;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
text-align: center;
}
.feedback-section h3 {
color: #6d4c3d;
font-family: 'Georgia', serif;
font-style: italic;
margin-bottom: 15px;
padding-top: 20px;
}
.social-media-dropdown label,
.visit-options label {
font-size: 16px;
color: #6d4c3d;
display: block;
margin-bottom: 10px;
}

#social-media {
font-size: 14px;
padding: 10px;
border: 1px solid #ccc;
border-radius: 5px;
background-color: #faf8f2;
color: #6d4c3d;
width: 100%;
max-width: 300px;
margin: 0 auto;
display: block;
text-align: center;
}
.visit-options {
display: flex;
justify-content: center;
gap: 15px;
margin-top: 15px;
}
.visit-options label {
display: inline-block;
font-size: 16px;
color: #6d4c3d;
cursor: pointer;
}
</style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="contact-container" >
        <div class="contact-image">
            <img src="images/kontakti.jpg" alt="Contact Image">
        </div>
        <div class="contact-form">
            <h2>Na Kontaktoni</h2>
            <form id="contactForm">
                <label for="name">Emri dhe Mbiemri:</label>
                <input type="text" id="name" placeholder=" Emri dhe Mbiemri" required>
                <label for="email">Email-i:</label>
                <input type="text" id="email" placeholder="Email-i" required>
                
                <label for="phone">Telefoni:</label>
                <input type="text" id="phone" placeholder="+38349123456" required>
            
                <label for="message">Mesazhi:</label>
                <textarea id="message" placeholder="Mesazhi"></textarea>
            <div class="checkbox-container"> 
                <input type="checkbox" name="updates" id="up">
                <label for="updates">Sign me up for email updates</label></div>
               
                <button type="submit">Dergo mesazhin</button>
            </form>
        </div></div>
        <div class="feedback-section">
            <h3>Si ke dëgjuar për ne?</h3>
            <div class="social-media-dropdown">
                <label for="social-media">Zgjedh një opsion:</label>
                <input list="social-options" id="social-media" name="social-media" placeholder="Zgjidhni ose shkruani një opsion">
                <datalist id="social-options">                  
                    <option value="Google">
                    <option value="Facebook">
                    <option value="Instagram">
                    <option value="Shoqe/Familjarë">
                    <option value="Tjetër">
                </datalist>
            </div>
        
            <h3>A do të vizitonit përsëri?</h3>
            <div class="visit-options">
                <label><input type="radio" name="visit-again" value="Yes"> Po</label>
                <label><input type="radio" name="visit-again" value="No"> Jo</label>
                <label><input type="radio" name="visit-again" value="Maybe"> Ndoshta</label>
            </div>
        
            <button type="submit">Dergo Feedback</button>
        
            </div>
<div class="lokacioni-dyqanit">
    <h2>Vendndodhjet e Dyqaneve Tona</h2>
    <div class="locations-wrapper">
        <div class="location">
            <span class="location-number">1</span>
            <address>
            <p><strong>Prishtinë:</strong> Rruga B,Royal Mall</p>
             <a href="https://www.google.com/maps/place/Royal+Mall/@42.6538179,21.1747672,17z/data=!4m14!1m7!3m6!1s0x13549edaa73c5815:0x8ce096f362fa06bb!2sRoyal+Mall!8m2!3d42.6538179!4d21.1773421!16s%2Fg%2F11g9g_n6b1!3m5!1s0x13549edaa73c5815:0x8ce096f362fa06bb!8m2!3d42.6538179!4d21.1773421!16s%2Fg%2F11g9g_n6b1?entry=ttu&g_ep=EgoyMDI0MTIxMS4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="map-link">Shiko në hartë</a>
            </address>
            <button class="toggle-orari">Shfaq Orarin</button>
            <div class="Orari">
                <h3>Orari i Punës</h3>
                <ul>
                    <li>E Hënë - E Premte: 08:30 - 18:00</li>
                    <li>E Shtunë: 10:00 - 16:00</li>
                    <li>E Diel: Mbyllur</li>
                </ul>
            </div>
        </div>
        <div class="location">
            <address>
            <span class="location-number">2</span>
            <p><strong>Prizren:</strong> ABI Carshia, Nr. 10</p><a href="https://www.google.com/maps/place/ABI+%C3%87arshia/@42.2180145,20.7242061,17.35z/data=!4m6!3m5!1s0x1353957e9046af55:0x9b12caa8bed3c878!8m2!3d42.2173705!4d20.7256931!16s%2Fg%2F11gtyt8zy2?entry=ttu&g_ep=EgoyMDI0MTIxMS4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="map-link">Shiko në hartë</a>
            </address>
            <button class="toggle-orari">Shfaq Orarin</button>
            <div class="Orari">
                <h3>Orari i Punës</h3>
                <ul>
                    <li>E Hënë - E Premte: 09:00 - 18:00</li>
                    <li>E Shtunë: 10:00 - 16:00</li>
                    <li>E Diel: Mbyllur</li>
                </ul>
            </div>
        </div>
        <div class="location">
            <span class="location-number">3</span>
            <address>
            <p><strong>Ferizaj:</strong> Ferizaj Mall</p>
            <a href="https://www.google.com/maps/place/Ferizaj+Mall/@42.3842742,21.1675289,17z/data=!3m1!4b1!4m6!3m5!1s0x13547fbefc06e153:0x2a5ab8e4815e007e!8m2!3d42.3842742!4d21.1675289!16s%2Fg%2F11vqpd2347?entry=ttu&g_ep=EgoyMDI0MTIxMS4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="map-link">Shiko në hartë</a>
            </address>
            <button class="toggle-orari">Shfaq Orarin</button>
            <div class="Orari">
                <h3>Orari i Punës</h3>
                <ul>
                    <li>E Hënë - E Premte: 08:00 - 17:00</li>
                    <li>E Shtunë: 09:00 - 14:00</li>
                    <li>E Diel: Mbyllur</li>
                </ul>
            </div>
        </div>
        <div class="location">
            <span class="location-number">4</span>
            <address>
            <p><strong>Mitrovicë:</strong> Rruga Adem Jashari, Nr. 20</p>
            <a href="https://www.google.com/maps/place/Adem+Jashari/@42.8882602,20.8671181,17z/data=!3m1!4b1!4m6!3m5!1s0x13534512ddeaaaab:0x5f90836c8070656c!8m2!3d42.8882602!4d20.869693!16s%2Fg%2F11sskrf43v?entry=ttu&g_ep=EgoyMDI0MTIxMS4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="map-link">Shiko në hartë</a>
            </address>
            <button class="toggle-orari">Shfaq Orarin</button>
            <div class="Orari">
                <h3>Orari i Punës</h3>
                <ul>
                    <li>E Hënë - E Premte: 09:00 - 18:00</li>
                    <li>E Shtunë: 10:00 - 16:00</li>
                    <li>E Diel: Mbyllur</li>
                </ul>
            </div>
        </div>
    </div>
</div>

 <div class="contact-text">
            <h2>Na Kontaktoni</h2>
            <p id="kontaktgreeting"><?= $greeting ?></p>

            <p>Për të rezervuar një termin apo për të mësuar më shumë rreth gamës së 
                shërbimeve tona të ofruara, ne jemi këtu për t'ju ndihmuar të arrini 
                pamjen që dëshironi. Ofruesit tanë të trajnuar me përvojë janë të 
                specializuar në trajtime të ndryshme si: prerje dhe stilim flokësh, 
                trajtime rigjeneruese për flokët, kujdes profesional për lëkurën, 
                trajtime estetike për fytyrën, si dhe dizajne të personalizuara për 
                thonjtë. Në sallonin tonë, ne përdorim produkte cilësore për të 
                garantuar rezultate të shkëlqyera dhe për të ruajtur shëndetin tuaj 
                estetik. Gjithashtu, ne ofrojmë këshilla të personalizuara për t'ju 
                ndihmuar të kujdeseni për bukurinë tuaj edhe jashtë sallonit. Për çdo 
                pyetje lidhur me shërbimet tona, produktet që përdorim, apo për të mësuar
                 më shumë rreth ofertave dhe paketave speciale që ofrojmë, mos hezitoni
                  të na kontaktoni. Stafi ynë është gjithmonë i gatshëm për t'ju asistuar
                   dhe për t'ju siguruar një eksperiencë relaksuese dhe profesionale. 
                   Bukuria juaj është prioriteti ynë!</p>
        </div>

        <div class="keygen-container">
            <p id="key"></p>
            <button onclick="document.getElementById('key').innerText = generateKey();">&Ccedil;el&euml;si</button>
          </div>
 
    <?php include 'footer.php'; ?>
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
        <script src="javascript.js"></script>
    
    <script>
    document.getElementById("contactForm").addEventListener("submit", function (event) {
        event.preventDefault(); 
      
        let valid = true;
        const nameField = document.getElementById("name");
        const emailField = document.getElementById("email");
        const phoneField = document.getElementById("phone");
      
    
        let warnings = {
          name: "Ju lutem shkruani emrin dhe mbiemrin.",
          email: "Email-i nuk është në format të saktë.",
          phone: "Numri i telefonit është i pavlefshëm.",
        };
      
    
        document.querySelectorAll(".warning").forEach((w) => w.remove());
      

        if (!nameField.value.trim()) {
          displayWarning(nameField, warnings.name);
          valid = false;
        }
      
        if (!emailField.value.trim()) {
    displayWarning(emailField, warnings.email);
    valid = false;
} else {
    let email = emailField.value.trim();
    let emailRegex = /^[\w.-]+@[\w.-]+\.\w{2,}$/;

    if (!emailRegex.test(email)) {
        displayWarning(emailField, warnings.email);
        valid = false;
    }
}

      
        if (!phoneField.value.trim() || !/^\+\d{9,15}$/.test(phoneField.value)) {
          displayWarning(phoneField, warnings.phone);
          valid = false;
        }
      
        if (valid) {
        
            const formData = {
                name: nameField.value,
                email: emailField.value,
                phone: phoneField.value,
                message: document.getElementById("message").value,
                updates: document.getElementById("up").checked
            };

            
            const validEntries = Object.entries(formData).filter(([key, value]) => value);

            
            const transformedData = validEntries.map(([key, value]) => {
                return { field: key, value: value };
            });

           
            const summary = transformedData.reduce((acc, { field, value }) => {
                return acc + `${field}: ${value}\n`;
            }, "Form Data:\n");

     
            console.log(summary);
            alert("Mesazhi u dërgua me sukses!");

            
            this.reset();
        }
    });

    function displayWarning(field, message) {
        const warning = document.createElement("div");
        warning.textContent = message;
        warning.className = "warning";
        warning.style.color = "red";
        warning.style.fontSize = "12px";
        warning.style.marginTop = "5px";
        field.parentNode.insertBefore(warning, field.nextSibling);
    }
    const socialMediaDropdown = document.getElementById("social-media");
socialMediaDropdown.addEventListener("change", () => {
    const selectedOption = socialMediaDropdown.value;
    console.log(`Si ke dëgjuar për ne: ${selectedOption}`);
});
function getSelectedVisitOption() {
    const visitOptions = document.querySelectorAll('input[name="visit-again"]');
    let selectedOption = null;
    visitOptions.forEach((option) => {
        if (option.checked) {
            selectedOption = option.value;
        }
    });
    return selectedOption;
}
const visitOptions = document.querySelectorAll('input[name="visit-again"]');
visitOptions.forEach((option) => {
    option.addEventListener("change", () => {
        const selectedOption = getSelectedVisitOption();
        console.log(`A do të vizitonit përsëri: ${selectedOption}`);
    });
});
const submitButton = document.querySelector('.feedback-section button');
    submitButton.addEventListener("click", (event) => {
        event.preventDefault(); 
        collectFeedback();
    });
function collectFeedback() {
    const socialMediaSelection = socialMediaDropdown.value;
    const visitAgainSelection = getSelectedVisitOption();

    if (!visitAgainSelection) {
        alert("Ju lutemi zgjidhni një opsion për 'A do të vizitonit përsëri?'.");
        return;
    }
    console.log("Feedback i mbledhur:");
    console.log(`Si ke dëgjuar për ne: ${socialMediaSelection}`);
    console.log(`A do të vizitonit përsëri: ${visitAgainSelection}`);
    alert(
        `Feedback i juaj është dërguar:\n- Si ke dëgjuar për ne: ${socialMediaSelection}
        \n- A do të vizitonit përsëri: ${visitAgainSelection}`
    );
}
$(document).ready(function() {
   
    
    $('.feedback-section button').on('click', function() {
      $('.feedback-section').fadeOut(500, function() {
        alert('Faleminderit për feedback-un tuaj!');
        $(this).fadeIn(500);
      });
    });
  });

  $(document).ready(function() {
    
    $('.Orari').hide(); 

    $('.toggle-orari').click(function() {
        var orariDiv = $(this).siblings('.Orari');
        
        
        if (orariDiv.is(':visible')) {
            orariDiv.slideUp(500); 
            $(this).text('Shfaq Orarin'); 
        } else {
            orariDiv.slideDown(500); 
            $(this).text('Fshih Orarin'); 
        }
    });
});


</script>
</body>
</html>