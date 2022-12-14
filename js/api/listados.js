
async function pintaUsuarios() {
    var tbody = document.getElementById("tbody");
    var data = await getParticipantes();
    // console.log(data);
    for (let i = 0; i < data.length; i++) {
        var tr = document.createElement("tr");
        var usuario = data[i];

        for (const clave in usuario) {
            var td = document.createElement("td");
            // Se concatena el nombre completo
            if (clave !== "id") {
                // La id no la pintaremos
                if (clave === "nombre") {
                    txt = "" + usuario[clave];
                } else if (clave === "ap1") {
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
                    // if (admin && clave == "gps") {
                    //     // Si es admin y es la última fila añadimos la de edición
                    //     td2 = document.createElement("td");
                    //     td2.innerHTML = usuario['rol'];
                    //     tr.appendChild(td2);
                    // }
                }
            }
        }
        tbody.appendChild(tr);
    }
}

async function getParticipantes() {
    let response = await fetch('./API/ListUsuario.php')
        // Éxito
        .then(function (response) {

            if (response.status == 200) {
                console.log("Operación realizada con éxito");
                return response.json(); // a JSON
            }else {
                console.log("Hubo un error en la operación (Listar usuarios)");
            }
        }
        )  
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
            var sel = document.createElement("select");
            // Agruparemos los 2 conjuntos de fechas
            if ((clave === "fechaInicioInscripcion") || (clave === "fechaFinInscripcion") ||
                (clave === "fechaInicioConcurso") || clave === "fechaFinConcurso") {
                // Las fechas de inicio y fin de inscripción (que van seguidas)
                txt += concurso[clave];
                fin = concurso[clave];
                if ((clave === "fechaInicioInscripcion") || (clave === "fechaInicioConcurso")) {
                    // Reiniciamos el valor de la variable TXT antes de concatenar
                    txt = concurso[clave];
                    // Si es la fecha de INICIO añadimos un separador
                    txt += " / ";
                    inicio = concurso[clave];
                }
                dif = fin - inicio;

            } else {
                txt = concurso[clave];
            }
            if (clave != "fechaInicioInscripcion" && clave != "fechaInicioConcurso") {
                // Nos aseguramos que las fechas de inicio solas no se escriban
                // el bucle de otra vuelta y de esta manera, solo aparezcan acompañadas de las
                // fechas de fin
                if (clave === "cartel") {
                    // Añadimos las columnas para bandas y modos antes del cartel
                    var td1 = document.createElement("td");
                    var opt1 = document.createElement("select");
                    var td2 = document.createElement("td");
                    var opt2 = document.createElement("select");
                    td1.className = "bandas";
                    td2.className = "modos";
                    td1.appendChild(opt1);
                    td2.appendChild(opt2);
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                }
                td.innerHTML = txt;
                tr.appendChild(td);
            }
            // for (let j = 0; j < dato.length; j++) {
            //     td.innerHTML = dato[j];
            // }

            // for (let j = 0; j < dato.length; j++) {
            //     td.innerHTML = dato[j];
            //     tr.appendChild(td);
            // }
            // if (dif>0) {
            // var td = document.createElement("td");
            // but = document.createElement("button");
            // but.addEventListener("click",()=>
            // {
            //     location("?concurso=" + concurso['id']);
            // }); 
            // td.appendChild(but);
            // tr.appendChild(td);
            // }
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
async function getBandas(id) {
    let response = await fetch('./API/bandas.php?id' + id)
        // Éxito
        .then(response => response.json())  // a JSON
        // ERROR
        .catch(err => console.log("Fallo al leer los concursos", err));

    let data = await JSON.parse(JSON.stringify(response));
    return data;

}