var clase;
var celda;

function programaGuardar(i) {
    return function() {
        clase.celdas[i].id = id.value;
        clase.celdas[i].iden = iden.value;
        clase.celdas[i].nombre=nombre.value;
        clase.celdas[i].email = email.value;
        clase.celdas[i].ubi=ubi.value;
        clase.celdas[i].puntos = puntos.value;

        clase.ordena();
        clase.pintar();
        crear.style="display:none;";
        cambiar.style="";
    }
}

function editar(i) {

    var btnEditar = document.getElementById('btnEditar');

    var id = document.getElementById('id');
    var nombre = document.getElementById('edNombre');
    var iden = document.getElementById('edIndicativo');
    var email = document.getElementById('edMail');
    var ubi = document.getElementById('edUbi');
    var puntos = document.getElementById('edPunt');
    var crear = document.getElementById('crear');
    var cambiar = document.getElementById('editar');

    var celda = clase.celdas[i];
    id.value = celda.id;
    iden.value = celda.iden;
    nombre.value = celda.nombre;
    email.value = celda.email;
    ubi.value = celda.ubi;
    puntos.value = puntos.ubi;
    
    crear.style="display:none;";
    cambiar.style="";
    btnEditar.onclick = function() {
        clase.celdas[i].id = id.value;
        clase.celdas[i].iden = iden.value;
        clase.celdas[i].nombre=nombre.value;
        clase.celdas[i].email = email.value;
        clase.celdas[i].ubi=ubi.value;
        clase.celdas[i].puntos = puntos.value;;

        clase.ordena();
        clase.pintar();
        crear.style="";
        cambiar.style="display:none;";
    }
    // programaGuardar(i,crear,cambiar);
}

window.onload = function () {
    // var tabla = document.getElementById('tabla');
    var cuerpo = document.getElementById('tbody');
    var btnGuardar = document.getElementById('btnGuardar');
    var iden = document.getElementById('id');
    var iden = document.getElementById('indicativo');
    var nombre = document.getElementById('nombre');
    var email = document.getElementById('mail');
    var puntos = document.getElementById('punt');
    var ubi = document.getElementById('ubi');
    var btnNombreAsc = document.getElementById('btnNombreAsc');
    var btnIdAsc = document.getElementById('btnIdAsc');
    var btnMailAsc = document.getElementById('btnMailAsc');
    var btnIdenAsc = document.getElementById('btnIdenAsc');
    var btnUbiAsc = document.getElementById('btnUbiAsc');
    var btnPuntAsc = document.getElementById('btnPuntAsc');
    var btnNombreDec = document.getElementById('btnNombreDec');
    var btnAp1Dec = document.getElementById('btnAp1Dec');
    var btnAp2Dec = document.getElementById('btnAp2Dec');
    var btnIdDec = document.getElementById('btnIdDec');
    var btnMailDec = document.getElementById('btnMailDec');
    var btnIdenDec = document.getElementById('btnIdenDec');
    var btnUbiDec = document.getElementById('btnUbiDec');
    var btnPuntDec = document.getElementById('btnPuntDec');

    clase = new Clase(cuerpo);
    btnGuardar.onclick = function () {
        clase.nuevocelda(new celda((nombre.value), (ap1.value), (ap2.value)));
        clase.ordena();
        clase.pintar();
        // Vaciamos los campos del formulario
        nombre.value="";
        ap1.value="";
        ap2.value="";
    }

    btnNombreAsc.onclick = function () {
        clase.orden.variable ="nombre";
        clase.orden.creciente = true;
        clase.ordena();
        clase.pintar();
    }
    btnNombreDec.onclick = function () {
        clase.orden.variable ="nombre";
        clase.orden.creciente = false;
        clase.ordena();
        clase.pintar();
    }

    btnIdenAsc.onclick = function () {
        clase.orden.variable ="Iden";
        clase.orden.creciente = true;
        clase.ordena();
        clase.pintar();
    }
    btnIdDec.onclick = function () {
        clase.orden.variable = "Iden";
        clase.orden.creciente = false;
        clase.ordena();
        clase.pintar();
    }
    btnIdAsc.onclick = function () {
        clase.orden.variable ="Id";
        clase.orden.creciente = true;
        clase.ordena();
        clase.pintar();
    }
    btnIdenDec.onclick = function () {
        clase.orden.variable = "Id";
        clase.orden.creciente = false;
        clase.ordena();
        clase.pintar();
    }

    btnMailAsc.onclick = function () {
        clase.orden.variable ="mail";
        clase.orden.creciente = true;
        clase.ordena();
        clase.pintar();
    }  
    btnMailDec.onclick = function () {
        clase.orden.variable = "mail";
        clase.orden.creciente = false;
        clase.ordena();
        clase.pintar();
    }
    btnUbiAsc.onclick = function () {
        clase.orden.variable ="ubi";
        clase.orden.creciente = true;
        clase.ordena();
        clase.pintar();
    }  
    btnUbiDec.onclick = function () {
        clase.orden.variable = "ubi";
        clase.orden.creciente = false;
        clase.ordena();
        clase.pintar();
    }
    btnPuntAsc.onclick = function () {
        clase.orden.variable ="punt";
        clase.orden.creciente = true;
        clase.ordena();
        clase.pintar();
    }  
    btnPuntDec.onclick = function () {
        clase.orden.variable = "punt";
        clase.orden.creciente = false;
        clase.ordena();
        clase.pintar();
    }
}