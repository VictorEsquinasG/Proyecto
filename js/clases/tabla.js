/* CONVERTIMOS TABLAS A TABLAS EDITABLES */


HTMLTableElement.prototype.editable = function () {
    // COGEMOS LOS ELEMENTOS DE LA TABLA
    var tabla = this;
    this.creciente = { variable: 0, creciente: true };

    // var tfoot = tabla.querySelector('tfoot');

    //AL SER ADMIN SE LLAMARÁ A ESTA FUNCIÓN QUE ACTIVA LA EDICIÓN
    function editarAdmin() {
        tabla.editar();
        //Pase lo que pase, el estado cambia
    }

}

HTMLTableElement.prototype.guardar = function () {
    const datosFila = [];
    var tBody = this.getElementsByTagName("tbody")[0];
    var filas = tBody.rows;

    for (let i = 0; i < filas.length; i++) {

        const datos = [];
        for (let j = 0; j < filas[i].cells.length; j++) {
            // LOS TDS
            if (filas[i].cells[j].className !== "AutomaticoByTablaEditable") {
                datos.push(filas[i].cells[j].innerHTML);
            }
        }
        datosFila.push(datos);

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
    // var th = document.createElement('th');

    // th.setAttribute("rowspan", thead.rows.length); // MIDA LO QUE MIDA LA TABLA
    // th.className = "AutomaticoByTablaEditable"; // TOS LOS TH QUE SE CREAN SE LES PONE UNA CLASE IDENTIFICADORA
    // th.innerHTML = "⚙";
    // thead.querySelector('tr').appendChild(th);
    for (let i = 1; i < tbody.rows.length; i++) {
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

/**
 * Método que ordena la tabla de alumnos según la propiedad que queramos.
 */
HTMLTableElement.prototype.ordena = function () {
    var Nombrecol = this.orden.variable;
    orden1 = (this.orden.creciente) ? 1 : -1;

    var tBody = this.tBody;
    var filas = tBody.rows;

    for (let i = 0; i < filas.length; i++) {
        // Metemos al array las filas de la tabla
        array.push(filas[i]);
    }

    // Ordenamos las filas
    array.sort(function (a, b) {
        return (a.cells[Nombrecol].innerHTML.localeCompare(b.cells[Nombrecol].innerHTML) * orden1);
    })
    this.orden[Nombrecol] = !this.orden[Nombrecol]; //Cambiamos el valor
}

/**
 * Método que imprime el array 
 * en un tBody dado (Una tabla).
 */
HTMLTableElement.prototype.pintar = function () {
    //TODO
    var tbodyHTML = "";
    var tBody = this.tBody;
    var filas = tBody.rows;
    this.tbody.innerHTML = ""; //Vaciamos

    for (let i = 0; i < filas.length; i++) {
        // Metemos al array las filas de la tabla
        array.push(filas[i]);
    }

    for (let i = 0; i < array.length; i++) {
        tbodyHTML += this.alumnos[i].toFila(i);
    }
    this.cuerpo.innerHTML = tbodyHTML;
}
/* 
// Esto ordena los datos(que los tengo guardados como una propiedad de la tabla, array)
HTMLTableElement.prototype.ordenar = function () {
    let numColum = this.orden['variable'];
    let orden = (this.orden['creciente']) ? 1 : -1;
    let array = [];
    var tBody = this.tBody;
    var filas = tBody.rows;

    for (let i = 0; i < filas.length; i++) {
        array.push(filas[i]);
    }

    array.sort(function (a, b) {
        return (a.cells[numColum].innerHTML).localeCompare(b.cells[numColum].innerHTML) * orden;
    });

    array.forEach(element => {
        this.tBody.appendChild(element);
    });
    this.orden.creciente = !(this.orden.creciente);
}

// creamos el thead, que tiene el evento de ordenarse
HTMLTableElement.prototype.creaTHead = function (nombreColum, obj = this) {
    let tHead = document.createElement("thead");
    let tr = document.createElement("tr");

    for (let i = 0; i < nombreColum.length; i++) {
        let th = document.createElement("th");
        th.innerHTML = nombreColum[i] + ' ▼';
        tr.appendChild(th);
    }

    tHead.addEventListener('click', function (ev) {
        obj.orden['variable'] = ev.target.cellIndex;
        obj.indice = 1;
        // document.getElementById('pagActual').value = obj.indice;
        // document.getElementById('btnRetrocede').disabled = true;
        // document.getElementById('btnAvanza').disabled = false;
        // obj.actualizaPagina();
        obj.ordenar();
        //obj.pintar();
    })

    tHead.appendChild(tr);
    return tHead;
} */




window.onload = function () {
    var tablas = this.document.querySelectorAll('table.editable');
    var long = tablas.length;
    for (let i = 0; i < long; i++) {
        tablas[i].editable();
    }

    var btnGuardar = document.getElementById('btnGuardar');
    if (typeof (btnGuardar) != 'undefined' && btnGuardar != null) {
        // Si el btnGuardar existe en la tabla
        btnGuardar.addEventListener('click', () => {
            const datosFila = [];
            var tBody = document.getElementsByTagName("tbody")[0];
            var filas = tBody.rows;

            for (let i = 0; i < filas.length; i++) {

                const datos = [];
                for (let j = 0; j < filas[i].cells.length; j++) {
                    // LOS TDS
                    if (filas[i].cells[j].className !== "AutomaticoByTablaEditable") {
                        datos.push(filas[i].cells[j].innerHTML);
                    }
                }
                datosFila.push(datos);

            }
            localStorage.setItem("Datos", JSON.stringify(datosFila));
        });
    }

    var cuerpo = document.getElementById('tbody');

    var btnAsc = document.getElementById('btnAsc');


    btnAsc.addEventListener("load", function (ev) {
        this.orden['variable'] = ev.target.cellIndex;
        cuerpo = this.tBody;
        array = [];
        filas = cuerpo.rows;
        for (let i = 0; i < filas.length; i++) {
            array.push(filas[i]);
        }
        clase.ordena(array);
        array.forEach(element => {
            this.tBody.appendChild(element);
        });
        this.orden = !this.orden;
    });

    // ordena = function (array) {
    //     var Nombrecol = this.orden.variable;
    //     orden1 = (this.orden.creciente) ? 1 : -1;
    //     array.sort(function (a, b) {
    //         // Comparamos como string por norma general
    //         return (a[Nombrecol].innerHTML.localeCompare(b[Nombrecol].innerHTML) * orden1);
    //     })
    //     this.orden[Nombrecol] = !this.orden[Nombrecol]; //Cambiamos el valor
    // }
    /*  btnAp1Asc.onclick = function () {
        array = []
        for (let i = 0; i < array.length; i++) {
         const element = array[i];
         
        }
        array.push(this.tBody.rows[i])
         clase.orden.variable ="apellido1";
         clase.orden.creciente = true;
         clase.ordena();
         array.forEach(element => {
             this.tBody.appendChild(element);
         });
     } */
    // btnAp1Dec.onclick = function () {
    //     array = []

    // }

    // btnAp2Asc.onclick = function () {
    //     array = []
    // }  
    // btnAp2Dec.onclick = function () {
    //     array = []
    //     clase.orden.variable = "apellido2";
    //     clase.orden.creciente = false;
    //     clase.ordena();

    // }




    //     function () {
    //         const datosFila = [];
    //         var tBody = document.getElementsByTagName("tbody")[0];
    //         var filas = tBody.rows;

    //         for (let i = 0; i < filas.length; i++) {

    //             const datos = [];
    //             for (let j = 0; j < filas[i].cells.length; j++) {
    //                 // LOS TDS
    //                 if (filas[i].cells[j].className !== "AutomaticoByTablaEditable") {
    //                     datos.push(filas[i].cells[j].innerHTML);
    //                 }
    //             }
    //             datosFila.push(datos);

    //         }

    //         localStorage.setItem("Datos", JSON.stringify(datosFila));
    //     });

}


