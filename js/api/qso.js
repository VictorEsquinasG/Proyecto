window.addEventListener("load", function () {

    var nuevo = document.getElementById("annadir");
    var idConcurso = nuevo.getAttribute("idConcurso");

    nuevo.onclick = function (ev) {
        // Evitamos que nos redireccione
        ev.preventDefault();

        // let modos = await getModos();
        let formulario = document.createElement("form");
        let ljuez = document.createElement("p");
        let juez = document.createElement("select");
        let lmodo = document.createElement("p");
        let modo = document.createElement("select");
        let lbanda = document.createElement("p");
        let banda = document.createElement("select");
        let ltime = document.createElement("p");
        let time = document.createElement("input");
        let boton = document.createElement("input");
        // El concurso 
        let conc = document.createElement("input");
        conc.setAttribute("name","concurso");
        conc.setAttribute("value",idConcurso);
        conc.setAttribute("style","display:none;");

        // El propio formulario
        formulario.setAttribute('method', "POST");
        formulario.setAttribute('action', "");

        // El input del juez
        ljuez.innerHTML = "JUEZ";
        ljuez.style.marginTop = "4px";

        juez.setAttribute('name', "juez");
        juez.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");

        // El input de la banda
        lbanda.innerHTML = "BANDA";

        banda.setAttribute('name', "banda");
        banda.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");
        // El input del modo
        lmodo.innerHTML = "MODO";

        modo.setAttribute('name', "modo");
        modo.setAttribute('style', "width:90%;margin: 10px 0px;padding: 5px");
        // El input de la hora
        ltime.innerHTML = "FECHA DE REALIZACIÓN";

        time.setAttribute('type', "date");
        time.setAttribute('name', "time");
        time.setAttribute('style', "width:87%;margin: 10px 0px;padding: 5px");

        // Asignamos sus atributos al boton
        boton.setAttribute('type', "submit");
        boton.setAttribute('value', "Registrar");
        boton.setAttribute('class', "c-card__btn c-btn--primary");
        boton.setAttribute('style', "margin: 15px 10px;");

        rellenaJueces(idConcurso, juez);
        rellenaBandas(idConcurso, banda);
        rellenaModos(idConcurso, modo);

        formulario.appendChild(ljuez);
        formulario.appendChild(juez);
        formulario.appendChild(lbanda);
        formulario.appendChild(banda);
        formulario.appendChild(lmodo);
        formulario.appendChild(modo);
        formulario.appendChild(ltime);
        formulario.appendChild(time);
        formulario.appendChild(conc);
        formulario.appendChild(boton);
        document.getElementById('cuerpo').appendChild(formulario);//Agregar el formulario a la etiqueta con el ID		
        //debugger;
        formulario.onsubmit = function (e) {
            e.preventDefault();
            if (mensajeValidado(formulario)) {
                // Si pasa la validación se guarda
                guardar();
            }
            // Después redireccionamos (recargamos)
            location.reload()
        }
        async function guardar() {
            try {
                const data = new FormData(formulario);
                // Lo mandamos a la bd mediante la API
                await fetch("./API/Qso.php", {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    body: data,
                    headers: new Headers()   

                })
                .catch(err => console.log("Fallo al guardar los mensajes ", err));

            } catch (err) {
                console.log("Ocurrió un error: " + err);
            }
        }

        modal(formulario);
    }

})

/**
 * Validamos que el mensaje sea en un modo o banda nueva 
 * o que el juez sea distinto
 * @param {*} form 
 * @returns 
 */
function mensajeValidado (form) {
    // Consultamos si el mensaje existe exactamente igual
    var tabla = document.getElementById("mensajes");
    var filas = tabla.rows
    // Cogemos el resultado del formulario en cada uno de los campos
    var fecha = form.time.value;
    var juez =  form.juez.value;
    var modo = form.modo.value;
    var banda = form.banda.value;

    for (let i = 0; i < filas.length; i++) {
        var fila = filas.item(i);
        fila.innerHTML;
        
    }
    fetch("./API/getQso.php?concurso="+idConcurso);

}

async function rellenaJueces(idConcurso, juez) {
    // Obtenemos los jueces y otro contenido para SELECT
    let jueces = await getJueces(idConcurso);// Rellenamos los SELECT
    console.log(jueces);
    for (let i = 0; i < jueces.length; i++) {
        var jue = document.createElement("option");
        // Ponemos tanto value como entre la etiqueta el valor
        jue.value = jueces[i].identificativo;
        jue.innerHTML = jueces[i].identificativo;
        juez.appendChild(jue);
    }
}
async function rellenaBandas(id, banda) {
    // Obtenemos las banda para el SELECT
    let bandas = await getBandas(id);
    console.log(bandas);
    // Rellenamos los SELECT
    for (let i = 0; i < bandas.length; i++) {
        var opt = document.createElement("option");
        // Ponemos tanto value como entre la etiqueta el valor
        opt.value = bandas[i].id;
        opt.innerHTML = bandas[i].nombre;
        banda.appendChild(opt);
    }
}
async function rellenaModos(id, modo) {
    // Obtenemos las banda para el SELECT
    let modos = await getModos(id);
    console.log(modos);
    // Rellenamos los SELECT
    for (let i = 0; i < modos.length; i++) {
        var opt = document.createElement("option");
        // Ponemos tanto value como entre la etiqueta el valor
        opt.value = modos[i].id;
        opt.innerHTML = modos[i].nombre;
        modo.appendChild(opt);
    }
}
async function getJueces(concurso_id) {
    try {
        // Lo mandamos a la bd mediante la API
        const respuesta = await fetch("./API/jueces.php?id=" + concurso_id)
        const jueces = await respuesta.json();
        return jueces;
    } catch (err) {
        console.log("Ocurrió un error: " + err);
    }
}
async function getBandas(concurso_id) {
    try {
        // Lo mandamos a la bd mediante la API
        const respuesta = await fetch("./API/bandas.php?id=" + concurso_id)
        const bandas = await respuesta.json();
        return bandas;
    } catch (err) {
        console.log("Ocurrió un error: " + err);
    }
}
async function getModos(concurso_id) {
    try {
        // Lo mandamos a la bd mediante la API
        const respuesta = await fetch("./API/modos.php?id=" + concurso_id)
        const modos = await respuesta.json();
        return modos;
    } catch (err) {
        console.log("Ocurrió un error: " + err);
    }
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
    // Calculamos el tamaño de la pantalla para centrarlo
    var left = parseInt((window.innerWidth - 400) / 2) + "px";
    var top = parseInt((window.innerHeight - 300) / 2) + "px";

    caja.style.position = "fixed";
    caja.style.background = "white";
    caja.style.top = top;
    caja.style.left = left;
    caja.style.width = "400px";
    caja.style.height = "370px";
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
    titulo.innerHTML = "Nuevo mensaje";
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
    contenido.style.top = "40px";
    contenido.style.position = "absolute";
    contenido.style.height = "370px";
    contenido.style.width = "100% ";
    // contenido.style.width="fit-content";
    contenido.style.padding = "15px";
    contenido.style.overflowY = "scroll";
    caja.appendChild(contenido);
    contenido.appendChild(div);
}