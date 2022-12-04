"use strict";
window.addEventListener("load", () => {
    var desplegable = document.querySelector('#imagen-perfil');
    
    desplegable.addEventListener("click", () => {
        // Lo redireccionamos
        location.href = "?menu=edicion";
    });
    
});

// var opciones = document.querySelectorAll('.c-nav__menu');
// // var btnMantenimiento = opciones[0];
// var btnParticipantes = opciones[1];
// var btnConcurso = opciones[2];
// btnMantenimiento.addEventListener("click", function () {
    //     location.href = "?menu=mantenimiento";
    // });
//     btnParticipantes.addEventListener("click", function () {
//     location.href = "?menu=listadoparticipantes";
// });
// btnConcurso.addEventListener("click", function () {
//     location.href = "?menu=listadoconcursos";
// });