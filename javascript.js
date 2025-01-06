
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




function generateKey() {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let key = '';
    
    for (let i = 0; i < 4; i++) {
        let section = '';
        for (let j = 0; j < 4; j++) {
            section += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        key += section;
        if (i < 3) key += '-'; 
    }
    
    return key;
}