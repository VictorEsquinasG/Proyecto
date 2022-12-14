window.addEventListener("load", function () {

    var nuevo = document.getElementById("annadir");
    var btnsEditado = document.querySelectorAll('.btnEd');

    btnsEditado.forEach(editado => {
        editado.onclick = function (ev) {
            // Evitamos que nos redireccione
            ev.preventDefault();
            let formulario = document.createElement("form");
            let id = document.createElement("input");
            let nombre = document.createElement("input");
            let dist = document.createElement("input");
            let min = document.createElement("input");
            let max = document.createElement("input");
            let boton = document.createElement("input");
            var idEditado = editado.getAttribute('idBanda');

            // Asignamos atributos al objeto formulario
            formulario.setAttribute('method', "POST");
            formulario.setAttribute('action', "");

            id.setAttribute('value', editado.getAttribute('idBanda'));
            id.setAttribute("name", "id");
            id.style.display = "none";

            // Asignamos atributos al input del nombre
            nombre.setAttribute('type', "text");
            nombre.setAttribute('id', "nombre");
            nombre.setAttribute('name', "nombre");
            nombre.setAttribute('placeholder', "Nombre");
            nombre.setAttribute('style', "width:80%;margin: 10px 0px;padding: 5px");

            // Asignamos atributos al input de la distancia
            dist.setAttribute('type', "text");
            dist.setAttribute('id', "distancia");
            dist.setAttribute('name', "distancia");
            dist.setAttribute('placeholder', "Distancia");
            dist.setAttribute('style', "width:80%;margin: 10px 0px;padding: 5px");
            // Asignamos atributos al input del mínimo
            min.setAttribute('type', "text");
            min.setAttribute('name', "minimo");
            min.setAttribute('id', "minimo");
            min.setAttribute('placeholder', "Mínimo");
            min.setAttribute('style', "width:80%;margin: 10px 0px;padding: 5px");
            // Asignamos atributos al input del máximo
            max.setAttribute('type', "text");
            max.setAttribute('id', "maximo");
            max.setAttribute('name', "maximo");
            max.setAttribute('placeholder', "Máximo");
            max.setAttribute('style', "width:80%;margin: 10px 0px;padding: 5px");

            // Asignamos atributos al boton
            boton.setAttribute('type', "submit");
            boton.setAttribute('value', "Guardar cambios");
            boton.setAttribute('class', "c-card__btn c-btn--primary");
            boton.setAttribute('style', "margin: 15px 10px;");
            // Todo al formulario
            formulario.appendChild(id);
            formulario.appendChild(nombre);
            formulario.appendChild(dist);
            formulario.appendChild(min);
            formulario.appendChild(max);
            formulario.appendChild(boton);
            //Agregamos el formulario a la etiqueta con el ID		
            document.getElementById('cuerpo').appendChild(formulario);

            formulario.onsubmit = function (e) {
                // Impedimos que nos redireccione
                e.preventDefault();
                // guardamos
                editar(formulario);
                location.reload();
            }
            async function editar(formulario) {
                // debugger;
                try {
                    const data = {
                        "id": formulario.id.value, 
                        "nombre": formulario.nombre.value,
                        "distancia": formulario.distancia.value, 
                        "minimo": formulario.minimo.value, 
                        "maximo": formulario.maximo.value
                    };
                    // const data = new FormData(formulario);
                    const respuesta = await fetch("./API/bandas.php", {
                        method: "PUT",
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(data)
                    })
                        .then(respuesta => console.log(respuesta));
                   
                        
                    //
                    /* await fetch("./API/editaBanda.php", {
                        // method: 'PUT',
                        method: 'POST',
                        mode: 'cors',
                        cache: 'no-cache',
                        body: data,
                        headers: new Headers()
                    })
                        .then(respuesta => console.log(respuesta))
                        .then(location.reload); //Recargamos la página */
                } catch (err) {
                    console.log("Ocurrió un error: " + err);
                }
            }
            modal(formulario, "edit");
        }

    })
    function modal(div, tipo) {
        var modal = this.document.createElement("div");
        // El 'bloqueador'
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
        caja.style.width = "600px";
        caja.style.height = "340px";
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
                titulo.innerHTML = "Nueva Banda";
                break;
            case "edit":
                titulo.innerHTML = "Editar Banda";
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

    nuevo.onclick = function (ev) {
        // Evitamos que nos redireccione
        ev.preventDefault();
        // Creamos el objeto formulario, titulo, input y boton
        let formulario = document.createElement("form");
        let nombre = document.createElement("input");
        let dist = document.createElement("input");
        let min = document.createElement("input");
        let max = document.createElement("input");
        let boton = document.createElement("input");

        // Asignamos atributos al objeto formulario
        formulario.setAttribute('method', "POST");
        formulario.setAttribute('action', "");
        // Asignamos atributos al input del nombre
        nombre.setAttribute('type', "text");
        nombre.setAttribute('id', "nombre");
        nombre.setAttribute('name', "nombre");
        nombre.setAttribute('placeholder', "Nombre");
        nombre.setAttribute('style', "width:100%;margin: 10px 0px;padding: 5px");

        // Asignamos atributos al input de la distancia
        dist.setAttribute('type', "text");
        dist.setAttribute('id', "distancia");
        dist.setAttribute('name', "distancia");
        dist.setAttribute('placeholder', "Distancia");
        dist.setAttribute('style', "width:100%;margin: 10px 0px;padding: 5px");
        // Asignamos atributos al input del mínimo
        min.setAttribute('type', "text");
        min.setAttribute('name', "minimo");
        min.setAttribute('id', "minimo");
        min.setAttribute('placeholder', "Mínimo");
        min.setAttribute('style', "width:100%;margin: 10px 0px;padding: 5px");
        // Asignamos atributos al input del máximo
        max.setAttribute('type', "text");
        max.setAttribute('id', "maximo");
        max.setAttribute('name', "maximo");
        max.setAttribute('placeholder', "Máximo");
        max.setAttribute('style', "width:100%;margin: 10px 0px;padding: 5px");
        // boton
        boton.setAttribute('type', "submit");
        boton.setAttribute('value', "Crear");
        boton.setAttribute('class', "c-card__btn c-btn--primary");
        boton.setAttribute('onclick', "location.reload()"); // Recargamos la página
        boton.setAttribute('style', "margin: 15px 10px;");
        // Todo al formulario
        formulario.appendChild(nombre);
        formulario.appendChild(dist);
        formulario.appendChild(min);
        formulario.appendChild(max);
        formulario.appendChild(boton);
        //Agregamos el formulario a la etiqueta con el ID		
        document.getElementById('cuerpo').appendChild(formulario);
        formulario.onsubmit = function (e) {
            // Impedimos que nos redireccione
            e.preventDefault();
            // guardamos
            guardar();
        }
        async function guardar() {
            try {
                const data = new FormData(formulario);
                //
                await fetch("./API/bandas.php", {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    body: data,
                    headers: new Headers()
                })
                    .then(respuesta => console.log(respuesta));
            } catch (err) {
                console.log("Ocurrió un error creando banda: " + err);
            }
        }
        modal(formulario, "new");
    }
});
