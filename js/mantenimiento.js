window.addEventListener("load",() => {
    var  btnModo = document.getElementById('mantModo');
    var btnBanda = document.getElementById('mantBanda');
    var btnMensaje = document.getElementById('mantQso');
    var btnConcurso = document.getElementById('mantConcurso');
    
    btnModo.addEventListener("click",() =>{
        location.href = "?menu=modo";
    });
    btnBanda.addEventListener("click",() =>{
        location.href = "?menu=banda";
    });
    btnMensaje.addEventListener("click",() =>{
        location.href = "?menu=mensaje";
    });
    btnConcurso.addEventListener("click",() =>{
        location.href = "?menu=concurso";
    });
});