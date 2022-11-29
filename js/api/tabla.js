/* CONVERTIMOS TABLAS A TABLAS EDITABLES */

// POR DEFECTO LA TABLA ESTÁ CON LA EDICIÓN DESACTIVADA
HTMLTableElement.prototype.edicionActivada = false;
// POR DEFECTO UNA CELDA NO ESTÁ EN ESTADO DE EDICIÓN
HTMLTableCellElement.prototype.enEdicion = false;

HTMLTableElement.prototype.editable = function () {
    // COGEMOS LOS ELEMENTOS DE LA TABLA
    var tabla = this;
    var thead = tabla.querySelector('thead');

    // var tfoot = tabla.querySelector('tfoot');

    //AL HACER DOBLE CLICK SE ACTIVA LA EDICIÓN
    thead.addEventListener('dblclick', function () {
        if (!tabla.edicionActivada) {
            tabla.editar();
        } else {
            tabla.desEditar();
        }
        //Pase lo que pase, el estado cambia
        tabla.edicionActivada = !tabla.edicionActivada;
        // AÑADIMOS LOS CAMPOS QUE SE ENCUENTREN EN LOCAL_STORAGE 
    })
}

HTMLTableElement.prototype.guardar = function () {
    const datosFila = [];
    var tBody = this.getElementsByTagName("tbody")[0];
    var filas = tBody.rows;

    for (let i = 0; i < filas.length; i++) {

        const alumnos = [];
        for (let j = 0; j < filas[i].cells.length; j++) {
            // LOS TDS
            if (filas[i].cells[j].className !== "AutomaticoByTablaEditable") {
                alumnos.push(filas[i].cells[j].innerHTML);
            }
        }
        datosFila.push(alumnos);

    }

    localStorage.setItem("Datos", JSON.stringify(datosFila));
}


// MÉTODO DE UNA CELDA (TD) QUE LA HACE EDITABLE
HTMLTableCellElement.prototype.editar = function () {
    if (!this.enEdicion) {
        this.enEdicion = true;
        var txt = document.createElement('input');
        txt.type = "text";
        txt.value = this.innerHTML;
        txt.addEventListener('keypress', function (evento) {
            if (evento.key === "Enter") {
                this.parentElement.enEdicion = false;
                this.parentElement.innerHTML === this.value;
            }
        })
        this.innerHTML = "";
        this.appendChild(txt);
    }
}

// MÉTODO QUE AÑADE LA COLUMNA DE EDICIÓN
HTMLTableElement.prototype.editar = function () {
    // COGEMOS LOS ELEMENTOS DE LA TABLA
    var tabla = this;
    var thead = tabla.querySelector('thead');
    var tbody = tabla.querySelector('tbody');
    var tfoot = tabla.querySelector('tfoot');
    var th = document.createElement('th');

    th.setAttribute("rowspan", thead.rows.length); // MIDA LO QUE MIDA LA TABLA
    th.className = "AutomaticoByTablaEditable"; // TODOS LOS TH QUE SE CREAN SE LES PONE UNA CLASE IDENTIFICADORA
    th.innerHTML = "⚙";
    thead.querySelector('tr').appendChild(th);
    for (let i = 0; i < tbody.rows.length; i++) {
        let td = document.createElement('td');
        td.className = "AutomaticoByTablaEditable";
        tbody.rows[i].appendChild(td);

        // Opciones de edición y borrado
        let borrar = document.createElement('span');
        let editar = document.createElement('span');
        let mvUp = document.createElement('span');
        let mvDown = document.createElement('span');

        // Botones de forma gráfica
        borrar.innerHTML = "🗑️";
        editar.innerHTML = "✏️";
        mvUp.innerHTML = "▲";
        mvDown.innerHTML = "▼";

        // Funcionalidades
        borrar.onclick = function () {
            this.parentElement.parentElement.eliminar();
        }
        editar.onclick = function () {
            this.parentElement.parentElement.editar();
        }
        mvUp.onclick = function () {
            this.parentElement.parentElement.subir();
        }
        mvDown.onclick = function () {
            this.parentElement.parentElement.bajar();
        }

        // Asignamos
        td.appendChild(editar);
        td.appendChild(borrar);
        td.appendChild(mvDown);
        td.appendChild(mvUp);
        // MÉTODO QUE SUBE UNA POSICIÓN LA FILA
        HTMLTableRowElement.prototype.subir = function () {
            var fila = this;
            var tbody = tabla.querySelector('tbody');
            var anterior = fila.previousElementSibling;

            if (anterior === null) {   // SI ES NULL, ES EL PRIMERO
                var ultimo = tbody.querySelectorAll('tr')[tbody.querySelectorAll('tr').length - 1];
                this.parentElement.insertBefore(ultimo, fila);
            } else {
                // LO SUBIMOS 1 POSICIÓN
                this.parentElement.insertBefore(fila, anterior);
            }
        }

        // MÉTODO QUE BAJA UNA POSICIÓN LA FILA 
        HTMLTableRowElement.prototype.bajar = function () {
            var fila = this;
            var tbody = tabla.querySelector('tbody');
            var siguiente = fila.nextElementSibling;

            if (siguiente === null) {   // SI ES NULL, ES EL PRIMERO
                var primero = tbody.querySelector('tr');
                this.parentElement.insertBefore(fila, primero);
            } else {
                // LO SUBIMOS 1 POSICIÓN
                this.parentElement.insertBefore(siguiente, fila);
            }
        }

        // MÉTODO QUE ELIMINA UNA FILA
        HTMLTableRowElement.prototype.eliminar = function () {
            this.parentNode.removeChild(this);
        }

        // MÉTODO QUE EDITA UNA FILA
        HTMLTableRowElement.prototype.editar = function () {
            var tds = this.querySelector('td');
            var long = tds.length;
            for (let i = 0; i < long; i++) {
                if (tds[i].className !== "AutomaticoByTablaEditable") {
                    tds[i].editar();
                }
            }

        }
    }

    // FOOT
    // tfoot.innerHTML = '<tr id="crear">' +
    //     '<td><input type="text" name="" id="inpId"></td>' +
    //     '<td rowspan="2" ><input type="text" name="" id="inpNombre"></td>' +
    //     '<td><button id="btnCrear">CREAR</button></td>' +
    //     '</tr>'

    // CREACIÓN DE NUEVOS ELEMENTOS PARA LA TABLA
    // var $btnCrear = document.getElementById('btnCrear');
    // $btnCrear.addEventListener('click', function () {
    //     $nombre = document.getElementById('inpNombre');
    //     $identificador = document.getElementById('inpId');
    //     annadir($identificador, $nombre);
    //     guardar();

    // })

    // function annadir(dni = null, nombre = null) {
    //     // if (dni == null) // SI NO SE NOS PASA EL DNI, SE QUIERE COGER DE LOCAL_STORAGE
    //     // {
    //     //     dni = localStorage.getItem('alumnos')[0][0];
    //     //     nombre = localStorage.getItem('alumnos')[0][1];
    //     // } else {
    //     dni = dni.value;
    //     nombre = nombre.value;
    //     // VACIAMOS LOS CAMPOS
    //     nombre.innerHTML = ""; dni.innerHTML = "";
    //     // }
    //     tbody.innerHTML += "<tr><td>" + dni + "</td><td class='editable'>" + nombre + "</td></tr>";
    //     // AÑADIMOS EL BOTON DE EDICIÓN
    //     tabla.desEditar();
    //     tabla.editar();
    // }

}

// MÉTODO QUE ELIMINA LA COLUMNA DE EDICIÓN DEVOLVIENDO LA TABLA A SU ESTADO ORIGINAL
HTMLTableElement.prototype.desEditar = function () {
    var tabla = this;
    var misTds = tabla.getElementsByClassName("AutomaticoByTablaEditable");
    var longitud = misTds.length; // Metemos la longitud en una variable para que no varíe

    for (let i = 0; i < longitud; i++) {
        // Borramos el que va siendo el primero
        misTds[0].parentElement.removeChild(misTds[0]);
    }
}




window.onload = function () {
    var tablas = this.document.querySelectorAll('table.editable');
    var long = tablas.length;
    for (let i = 0; i < long; i++) {
        tablas[i].editable();
    }

    // var btnGuardar = document.getElementById('btnGuardar');
    // btnGuardar.addEventListener('click',
    
    //     function () {
    //         const datosFila = [];
    //         var tBody = document.getElementsByTagName("tbody")[0];
    //         var filas = tBody.rows;

    //         for (let i = 0; i < filas.length; i++) {

    //             const alumnos = [];
    //             for (let j = 0; j < filas[i].cells.length; j++) {
    //                 // LOS TDS
    //                 if (filas[i].cells[j].className !== "AutomaticoByTablaEditable") {
    //                     alumnos.push(filas[i].cells[j].innerHTML);
    //                 }
    //             }
    //             datosFila.push(alumnos);

    //         }

    //         localStorage.setItem("Datos", JSON.stringify(datosFila));
    //     });

}


