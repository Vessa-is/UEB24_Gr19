
const currentHour = new Date().getHours();
let greeting = document.getElementById("aboutusgreeting");

switch (true) {

    case(currentHour >= 5 && currentHour < 12 ) :

    greeting.textContent = " Mirmengjesi! ";
    break;



    case(currentHour >= 12 && currentHour < 18 ) :


    greeting.textContent = " Miredita! ";
    break;


    case(currentHour >= 18 && currentHour < 24 ) :


    greeting.textContent = " Mirembrema! ";
    break;
 
    default :
    greeting.textContent = "Ckemi";
    break;

}


console.log("JavaScript is working!");




$(document).ready(function() {
    $(".about-content h3").css("color", "#664f3e");    
});

$(document).ready(function() {
    $(".btn").hover(function() {
        $(this).css("background-color", "#6f6154");  
    }, function() {
        $(this).css("background-color", "#96887d");  
    });
});

document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); 
    const email = document.querySelector('input[type="email"]').value;

    if (email) {
        alert('Faleminderit për abonimin');
    } else {
        alert('Ju lutem, shkruani një email të vlefshëm.');
    }
});

$(document).ready(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 600) {
            $("#scrollToTop").fadeIn(); 
        } else {
            $("#scrollToTop").fadeOut(); 
        }
    });
    $("#scrollToTop").click(function() {
        $("html, body").animate({ scrollTop: 0 }, 600); 
    });
});
