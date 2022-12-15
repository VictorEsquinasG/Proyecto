window.addEventListener("load", function () {

    // Captaremos los botones
    var btns = document.querySelectorAll('.btnBorrar');
    var nuevo = document.getElementById("annadir");
    var btnsEditado = document.querySelectorAll('.btnEd');
    
    btnsEditado.forEach(editado => {
        editado.onclick = function (ev) {
            // Evitamos que nos redireccione
            ev.preventDefault();
            let formulario = document.createElement("form");
            let id = document.createElement("input");
            let nombre = document.createElement("input");
            let boton = document.createElement("input");

            // Asignamos atributos al objeto formulario
            formulario.setAttribute('method', "POST");
            formulario.setAttribute('action', "");

            id.setAttribute('value', editado.getAttribute('idModo'));
            id.setAttribute("name", "id");
            id.style.display = "none"; // No se muestra al usuario

            // Asignamos atributos al input del nombre
            nombre.setAttribute('type', "text");
            nombre.setAttribute('id', "nombre");
            nombre.setAttribute('name', "nombre");
            nombre.setAttribute('placeholder', "Nombre");
            nombre.setAttribute('style', "width:80%;margin: 10px 0px;padding: 5px");

            // Asignar atributos al boton
            boton.setAttribute('type', "submit");
            boton.setAttribute('value', "Guardar cambios");
            boton.setAttribute('class', "c-card__btn c-btn--primary");
            // Todo al formulario
            formulario.appendChild(id);
            formulario.appendChild(nombre);
            formulario.appendChild(boton);
            //Agregamos el formulario a la etiqueta con el ID		
            document.getElementById('cuerpo').appendChild(formulario);
            formulario.onsubmit = function (ev) {
                // Impedimos que nos redireccione
                ev.preventDefault();
                if (validado(formulario)) {
                    // guardamos
                    editar(formulario);
                    location.reload();
                }
            }

            modal(formulario, "edit");
        }

    })

    nuevo.onclick = function (ev) {
        // Evitamos que nos redireccione
        ev.preventDefault();
        let formulario = document.createElement("form");
        let nombre = document.createElement("input");
        let boton = document.createElement("input");

        // El objeto formulario
        formulario.setAttribute('method', "POST");
        formulario.setAttribute('action', "");

        // El input del nombre
        nombre.setAttribute('type', "text");
        nombre.setAttribute('id', "nombre");
        nombre.setAttribute('name', "nombre");
        nombre.setAttribute('placeholder', "Nombre");
        nombre.setAttribute('style', "width:80%;margin: 10px 0px;padding: 5px");

        // Asignar atributos al boton
        boton.setAttribute('type', "submit");
        boton.setAttribute('value', "Crear");
        boton.setAttribute('class', "c-card__btn c-btn--primary");
        boton.setAttribute('style', "margin: 15px 10px;");

        formulario.appendChild(nombre);
        formulario.appendChild(boton);
        document.getElementById('cuerpo').appendChild(formulario);//Agregar el formulario a la etiqueta con el ID		
        //debugger;
        formulario.onsubmit = function (ev) {
            ev.preventDefault();
            if (validado(formulario)) {
                // Guardamos
                guardar(formulario);
            }
        }
        modal(formulario, "new");
    }

    //PARA BORRAR LOS MODOS
    btns.forEach(boton => {
        boton.onclick = async function () {
            // Cogemos la ID
            var id = boton.getAttribute('idModo');
            const data = {
                "id" : id,
            };
            const respuesta = await fetch("./API/modos.php", {
                method: "DELETE",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            // .then(console.log(respuesta))
            .then(response => location.reload())
            .catch(err => console.log("Error al borrar modo de id "+id, err));

            // location.reload();
        }
    });

})
function validado(formu) {
    var errores = [];
    if (formu.nombre.value === '') {
        errores['nombre'] = 'El nombre no puede estar vacío';
    }

    if (errores.length == 0) {
        return true;
    } else {
        return false;
    }
}

async function guardar(formulario) {
    try {
        const data = new FormData(formulario);
        // Lo mandamos a la bd mediante la API
        var respuesta = await fetch("./API/modos.php", {
            method: 'POST',
            body: data
        })
            .then(respuesta => console.log(respuesta))
            .then(location.reload()) //Recargamos la página
            .then(location.reload()); //Recargamos la página
        // .catch(err => console.log("Fallo al leer los concursos", err));

    } catch (err) {
        console.log("Ocurrió un error: " + err);
    }
}

async function editar(formulario) {
    try {
        const data = { 
            "id" : formulario.id.value,
            "nombre" : formulario.nombre.value 
        };
        //

        const respuesta = await fetch("./API/modos.php", {
            method: "PUT",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
            .then(respuesta => console.log(respuesta));
        // .then(location.reload()) //Recargamos la página
        // .then(location.reload()); //Recargamos la página
    } catch (err) {
        console.log("Ocurrió un error: " + err);
    }
}

function modal(div, tipo) {
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
    // Calculamos el tamaño de la pantalla para centrarlo
    var left = parseInt((window.innerWidth - 400) / 2) + "px";
    var top = parseInt((window.innerHeight - 300) / 2) + "px";

    caja.style.position = "fixed";
    caja.style.background = "white";
    caja.style.top = top;
    caja.style.left = left;
    caja.style.width = "400px";
    caja.style.height = "160px";
    caja.style.borderRadius = "10px";
    caja.style.zIndex = 101;
    document.body.appendChild(caja);

    var titulo = document.createElement("div");
    titulo.style.position = "absolute";
    titulo.style.background = "#FF8F35";
    titulo.style.fontFamily = '-apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif';
    titulo.style.color = "white";
    titulo.style.height = "40px";
    titulo.style.width = "100%";
    titulo.style.padding = "10px";
    switch (tipo) {
        case "new":
            titulo.innerHTML = "Nuevo Modo";
            break;
        case "edit":
            titulo.innerHTML = "Editar Modo";
            break;
        default:
            break;
    }
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
    // La ventana flotante
    var contenido = document.createElement("div");
    contenido.style.top = "40px";
    contenido.style.position = "absolute";
    contenido.style.height = "370px";
    contenido.style.width = "100% ";
    // contenido.style.width="fit-content";
    contenido.style.padding = "15px";
    contenido.style.overflowY = "scroll";
    caja.appendChild(contenido);
    contenido.appendChild(div)
}
