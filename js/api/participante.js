window.addEventListener("load", function () {

    var nuevo = document.getElementById("annadir");

    nuevo.onclick = function (ev) {
        // Evitamos que nos redireccione
        ev.preventDefault();
        // Creamos los objetos formulario, titulo, input y boton
        let formulario = document.createElement("form");
        let nombre = document.createElement("input");
        let ap1 = document.createElement("input");
        let ap2 = document.createElement("input");
        let contrasena = document.createElement("input");
        let mail = document.createElement("input");
        let indicativo = document.createElement("input");
        let ubi2 = document.createElement("input");
        let ubi1 = document.createElement("input");
        let ubi3 = document.createElement("div");
        let imagen = document.createElement("input");
        let Rol = document.createElement("select");
        let boton = document.createElement("input");

        // El objeto formulario
        formulario.setAttribute('method', "post");
        formulario.setAttribute('action', "");

        // El input del nombres
        nombre.setAttribute('type', "text");
        nombre.setAttribute('id', "nombre");
        nombre.setAttribute('name', "nombre");
        nombre.setAttribute('placeholder', "Nombre");
        nombre.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");
        
        ap1.setAttribute('type', "text");
        ap1.setAttribute('id', "ap1");
        ap1.setAttribute('name', "ap1");
        ap1.setAttribute('placeholder', "Primer Apellido");
        ap1.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");
        
        ap2.setAttribute('type', "text");
        ap2.setAttribute('id', "ap2");
        ap2.setAttribute('name', "ap2");
        ap2.setAttribute('placeholder', "Segundo apellido");
        ap2.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");

        // El input de la contraseña
        contrasena.setAttribute('type', "password");
        contrasena.setAttribute('id', "contrasena");
        contrasena.setAttribute('name', "contrasena");
        contrasena.setAttribute('placeholder', "Contraseña");
        contrasena.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");

        // El input del correo
        mail.setAttribute('type', "email");
        mail.setAttribute('name', "email");
        mail.setAttribute('id', "email");
        mail.setAttribute('placeholder', "Email");
        mail.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");

        // El input del INDICATIVO
        indicativo.setAttribute('type', "text");
        indicativo.setAttribute('id', "indicativo");
        indicativo.setAttribute('name', "indicativo");
        indicativo.setAttribute('placeholder', "Indicativo");
        indicativo.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");

        // El input de la ubicación
        ubi1.setAttribute('type', "number");
        ubi1.setAttribute('name', "lon");
        ubi1.setAttribute('id', "lon");
        ubi1.setAttribute('step', "0.000000001");
        ubi1.setAttribute('placeholder', "Longitud");
        ubi1.setAttribute('style', "width:30%;margin: 10px 0px;padding: 5px");

        ubi2.setAttribute('type', "number");
        ubi2.setAttribute('name', "lat");
        ubi2.setAttribute('id', "lat");
        ubi2.setAttribute('step', "0.000000001");
        ubi2.setAttribute('placeholder', "Latitud");
        ubi2.setAttribute('style', "width:30%;margin: 10px 10px;padding: 5px");

        // ubi3.style.display = "none";
        ubi3.setAttribute('id', "btnCaptura");
        ubi3.setAttribute('style', "visibility:hidden");
        var p = document.createElement("p");
        p.innerHTML = "boton :v";
        ubi3.appendChild(p);

        // La IMAGEN
        imagen.setAttribute('type', "file");
        imagen.setAttribute('id', "imagen");
        imagen.setAttribute('name', "imagen");
        imagen.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");

        // Asignamos atributos al select de ROL
        var mindundi = document.createElement('option');
        var admin = document.createElement('option');
        mindundi.innerHTML = "Participante";
        mindundi.value = "user";
        admin.innerHTML = "Administrador";
        admin.value = "admin";

        Rol.setAttribute('id', "rol");
        Rol.setAttribute('name', "rol");
        Rol.setAttribute('placeholder', "Rol");
        Rol.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");
        Rol.appendChild(mindundi);
        Rol.appendChild(admin);

        // Asignamos atributos al objeto boton
        boton.setAttribute('type', "submit");
        boton.setAttribute('value', "Crear");
        boton.setAttribute('class', "c-card__btn c-btn--primary");
        boton.setAttribute('style', "width:100px;margin: 10px 0px;padding: 10px;");
        //boton.setAttribute('onclick', "alert('Se ha añadido un nuevo participante')");

        formulario.appendChild(nombre);
        formulario.appendChild(ap1);
        formulario.appendChild(ap2);
        formulario.appendChild(mail);
        formulario.appendChild(contrasena);
        formulario.appendChild(indicativo);
        formulario.appendChild(ubi2);
        formulario.appendChild(ubi1);
        formulario.appendChild(ubi3);
        formulario.appendChild(imagen);
        formulario.appendChild(Rol);
        formulario.appendChild(boton);
        document.getElementById('cuerpo').appendChild(formulario);//Agregar el formulario a la etiqueta con el ID		
        ubi3.click();

        //debugger;
        formulario.onsubmit = function (e) {
            e.preventDefault();
            //alert("hola");
            guardar();
            location.reload();
        }
        async function guardar() {
            //TODO validar 
             /* var indicativo = document.getElementById("indicativo").value;
             var email = document.getElementById("email").value;
             var localizacion = document.getElementById("localizacion").value;
             var imagen = document.getElementById("imagen").value;
             var nombre = document.getElementById("nombre").value;
             var contrasena = document.getElementById("contrasena").value;
             var rol = document.getElementById("rol").value;
     
           if(indicativo == "" || email == "" || localizacion == "" || imagen == "" || nombre == "" || contrasena == "" || rol == ""){
                 alert("todos los campos son obligatorios");
                 
             }*/
            try {
                const data = new FormData(formulario);
                //
                var respuesta = await fetch("./API/creaParticipante.php", {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    body: data,
                    headers: new Headers()

                })
                    .then(respuesta => respuesta.json());
                    // .then(location.reload());
                console.log(respuesta);
                //    alert ("Nuevo participante creado");

            } catch (err) {
                console.log("Ocurrió un error: " + err);
            }
        }
        modal(formulario);
    }

})

function validaIndicativo($id) {
    /* DEVOLVEMOS SI CUMPLE EL PATRON */
    return "/^[A-Z]{1,2}[0-9][A-Z]{1,3}$/".test($id);
}
function modal(div) {
    var modal = this.document.createElement("div");
    modal.style.position = "fixed";
    modal.style.background = "grey";
    modal.style.opacity = 0.5;
    modal.style.top = 0;
    modal.style.left = 0;
    modal.style.width = "100%";
    modal.style.height = "100%";
    modal.style.zIndex = 100;
    document.body.appendChild(modal, titulo);

    var caja = document.createElement("div");
    var left = parseInt((window.innerWidth - 400) / 2) + "px";
    var top = parseInt((window.innerHeight - 640) / 2) + "px";

    caja.style.position = "fixed";
    caja.style.background = "white";
    caja.style.top = top;
    caja.style.left = left;
    caja.style.width = "400px";
    caja.style.height = "600px";
    caja.style.borderRadius = "10px";
    caja.style.zIndex = 101;
    document.body.appendChild(caja);

    var titulo = document.createElement("div");
    titulo.style.position = "absolute";
    titulo.style.background = "#FF8F35";
    titulo.style.fontFamily = '-apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif';
    titulo.style.color = "white";
    titulo.style.height = "20px";
    titulo.style.width = "100%";
    titulo.style.padding = "10px";
    titulo.innerHTML = "Nuevo Participante";
    caja.appendChild(titulo);

    var cerrar = document.createElement("span");
    cerrar.innerHTML = "X";
    cerrar.style.backgroundColor = "red";
    cerrar.style.cursor = "pointer";
    cerrar.style.borderRadius = "35px";
    cerrar.style.color = "white";
    cerrar.style.fontWeight = "bold";
    cerrar.style.position = "absolute";
    cerrar.style.width = "20px";
    cerrar.style.top = 0;
    cerrar.style.right = "20px";
    cerrar.style.margin = "5px";
    cerrar.style.padding = "5px";
    caja.style.overflow = "hidden";
    cerrar.onclick = function () {
        var caja = this.parentElement.parentElement;
        caja.parentElement.removeChild(caja);
        modal.parentElement.removeChild(modal);
        location.reload();
    }
    titulo.appendChild(cerrar);

    var contenido = document.createElement("div");
    contenido.style.top = "22px";
    contenido.style.position = "absolute";
    contenido.style.width = "100%";
    contenido.style.padding = "15px";
    contenido.style.overflowY = "scroll";
    caja.appendChild(contenido);
    contenido.appendChild(div)
}