    // Class clase

    /**
     * Constructor que pasandole el puntero al tBody crea
     * una instancia del objeto clase
     * @param {*} cuerpo El puntero del tbody
     * 
     */
     function Clase(cuerpo,alumnos) {
        this.cuerpo = cuerpo || "";
        this.alumnos = alumnos || [];
        // Para ordenar creciente / decreciente
        this.orden = {variable:"nombre",creciente:true};
    }
    
    /**
     * Método que imprime el array de alumnos 
     * en un tBody dado (Una tabla).
     */
    Clase.prototype.pintar = function () {
        this.cuerpo.innerHTML = ""; //Vaciamos
        var tbodyHTML = "";
    
            // this.alumnos.forEach(alumno =>  this.cuerpo.innerHTML += alumno.toFila())    ; 
        for (let i = 0; i < this.alumnos.length; i++) {
            tbodyHTML += this.alumnos[i].toFila(i);
        }
        this.cuerpo.innerHTML = tbodyHTML;
    }
    
    /**
     * Añade un nuevo alumno al final del array Alumnos
     * @param {*} alumno El alumno a añadir
     */
    Clase.prototype.nuevoAlumno = function (alumno) {
        this.alumnos.push(alumno);
    }
    
    /**
     * Método que ordena la tabla de alumnos según la propiedad que queramos.
     */
    Clase.prototype.ordena = function () {
        var Nombrecol = this.orden.variable;
        orden1 = (this.orden.creciente)?1:-1;
        this.alumnos.sort(function (a,b) {
            return (a[Nombrecol].localeCompare(b[Nombrecol]) * orden1);
        })
        this.orden[Nombrecol] = !this.orden[Nombrecol]; //Cambiamos el valor
    }
    
    /**
     * Método que permite eliminar un alumno de la clase
     * @param {*} posicion El índice donde se encuentra el alumno
     */
    Clase.prototype.borra = function (posicion) {
        this.alumnos.splice(posicion,1);
    }
    