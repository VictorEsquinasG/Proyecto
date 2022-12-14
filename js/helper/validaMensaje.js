/*
    Archivo JS para validar mensajes QSO siendo un juez o un administrador
*/
window.addEventListener("load", () => {
    // Cogemos los botones de la tabla
    var btns = document.querySelectorAll('.btnMsg');
    var btnsBorrar = document.querySelectorAll('.btnBMsg');
    // Les ponemos un CLICK -> Validar
    btns.forEach(btn => {

        // Cogemos el id del mensaje
        var idMsg = btn.getAttribute("idQso");

        //Creamos el formulario
        var formulario = document.createElement("form");
        var id = document.createElement("input");

        formulario.setAttribute("method", "POST");
        formulario.setAttribute("action", "");

        id.setAttribute("type", "number")
        id.style.display = "none";
        id.setAttribute('name', "id");
        id.setAttribute("value", idMsg)
        formulario.appendChild(id);

        // Programamos el evento del botón
        btn.addEventListener("click", (ev) => {
            // Impedimos que se ejecute
            ev.preventDefault();
            // Lo mandamos a actualizar
            validar(formulario);
        });
    });

    // Desvalidaremos el mensaje en caso de error
    btnsBorrar.forEach(btnInvalidar => {

        // Cogemos el id del mensaje
        var idMsg = btnInvalidar.getAttribute("idQso");

        //Creamos el formulario
        var formulario = document.createElement("form");
        var id = document.createElement("input");

        formulario.setAttribute("method", "POST");
        formulario.setAttribute("action", "");

        id.setAttribute("type", "number")
        // id.style.display = "none";
        id.setAttribute('name', "id");
        id.setAttribute("value", idMsg)
        formulario.appendChild(id);

        btnInvalidar.addEventListener("click", (ev) => {
            // Impedimos que se ejecute
            ev.preventDefault();
            // Lo mandamos a actualizar
            desvalidar(formulario);
        });
    });
});


async function validar(formulario) {
    try {
        debugger;
        const data = new FormData(formulario);
        // Lo mandamos a la bd mediante la API
        var respuesta = await fetch("./API/validaMensaje.php", {
            method: 'POST',
            body: data
        })
            .then(respuesta => console.log(respuesta))
            .then(location.reload()); //Recargamos la página
        // .catch(err => console.log("Fallo al validar", err));

    } catch (err) {
        console.log("Ocurrió un error: " + err);
    }
}
async function desvalidar(formulario) {
    try {
        const data = new FormData(formulario);
        
        // Lo mandamos a la bd mediante la API
        var respuesta = await fetch("./API/invalidaMensaje.php", {
            method: 'POST',
            body: data
        })
            .then(respuesta => console.log(respuesta))
            .then(location.reload()); //Recargamos la página

    } catch (err) {
        console.log("Ocurrió un error: " + err);
    }
}