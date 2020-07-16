"use strict"

// spremenjivke z določanje stani in pomoč pri paginaciji
let trenutnaStran = 1;

function change_to_levo() {
    console.log( "Change page to the left, trenutna stran je " + trenutnaStran );
    if (trenutnaStran > 1) {
        trenutnaStran -= 1;
        // kliči ajax
    }
}

function change_to_desno() {
    console.log( "Change page to the left, trenutna stran je " + trenutnaStran );
    if (trenutnaStran < stStrani) {
        trenutnaStran += 1; 
       // kliči ajax
    }
}


function change_trenutna_stran() {
    // pridobi id strani
    let idOfClickedButton = $(this).text();

    // če je na isti strani, ni potrebe po refreshu
    if (idOfClickedButton != trenutnaStran) {
    trenutnaStran = idOfClickedButton; 
      // kliči ajax
    }
}