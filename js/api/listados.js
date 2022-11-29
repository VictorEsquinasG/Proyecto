
async function pintaUsuarios() {
    var tbody = document.getElementById("tbody");
    var data = await getParticipantes();
    // console.log(data);
    for (let i = 0; i < data.length; i++) {
        var tr = document.createElement("tr");
        var usuario = data[i];

        for (const clave in usuario) {
            var td = document.createElement("td");
            if (clave === "nombre") {
                txt = "" + usuario[clave];    
            }else if (clave === "ap1") {
                txt += " " + usuario[clave]; 
            } else if (clave === "ap2") {
                txt += " " + usuario[clave]; 
            } else {
                txt = usuario[clave];
            }
            // Tanto ap2 como el resto de parámetros que no sean nombre ni apellido1 se escribirán
            if ((clave != "nombre") && (clave != "ap1")) {
                td.innerHTML = txt;
                tr.appendChild(td);
            }
        }
        tbody.appendChild(tr);
    }
}

async function getParticipantes() {
    let response = await fetch('./API/ListUsuario.php')
        // Éxito
        .then(response => response.json())  // a JSON
        // ERROR
        .catch(err => console.log("Fallo al leer los participantes", err));

    let data = await JSON.parse(JSON.stringify(response));
    return data;
}

async function pintaConcursos() {
    var tbody = document.getElementById("tbody");
    var data = await getConcursos();
    // console.log(data);
    // data.then(val=>console.log(val[0][0]));
    for (let i = 0; i < data.length; i++) {
        var tr = document.createElement("tr");
        var concurso = data[i];

        for (const clave in concurso) {
            var txt;
            var td = document.createElement("td");
            // Agruparemos los 2 conjuntos de fechas
            if ((clave === "fechaInicioInscripcion") || (clave === "fechaFinInscripcion") ||
                (clave === "fechaInicioConcurso") || clave === "fechaFinConcurso") {
                // Las fechas de inicio y fin de inscripción (que van seguidas)
                txt += concurso[clave];
                if ((clave === "fechaInicioInscripcion") || (clave === "fechaInicioConcurso")) {
                    // Reiniciamos el valor de la variable TXT antes de concatenar
                    txt = concurso[clave];
                    // Si es la fecha de INICIO añadimos un separador
                    txt += " | ";
                }
            } else {
                txt = concurso[clave];
            }
            if (clave != "fechaInicioInscripcion" && clave != "fechaInicioConcurso") {
                // Nos aseguramos que las fechas de inicio solas no se escriban
                // el bucle de otra vuelta y de esta manera, solo aparezcan acompañadas de las
                // fechas de fin
                td.innerHTML = txt;
                tr.appendChild(td);
            }
        }
        tbody.appendChild(tr);
    }
}

async function getConcursos() {
    let response = await fetch('./API/ListConcurso.php')
        // Éxito
        .then(response => response.json())  // a JSON
        // ERROR
        .catch(err => console.log("Fallo al leer los concursos", err));

    let data = await JSON.parse(JSON.stringify(response));
    return data;

}