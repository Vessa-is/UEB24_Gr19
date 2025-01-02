
const currentHour = new Date().getHours();
let greeting = document.getElementById("greetingparagraph");

switch (true) {

    case(ncurrentHour >= 5 && currentHour <= 12 ) :

    greeting.textContent = " Mirmengjesi! ";
    break;



    case(ncurrentHour >= 12 && currentHour <= 18 ) :


    greeting.textContent = " Miredita! ";
    break;


    case(ncurrentHour >= 18& currentHour <=24 ) :


    greeting.textContent = " Mirembrema ";
    break;
 
    default :
    greeting.textContent = "Ckemi";
    break;

}