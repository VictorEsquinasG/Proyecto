<?php
$admin = false; // Suponemos que no es admin
echo ("<h1 class='g--font-size-5l'>CONCURSOS</h1>");

$valida = new Validacion();
$rp = new repConcurso(gbd::getConexion());
# Primero comprobamos si es admin
if ((Sesion::existe('user') && Sesion::leer('user')->getRol() === 'admin')) {
    $admin = true;
    // Si ha creado (y es admin)
    if (isset($_POST['submit'])) {
        $valida->Requerido('nombre');
        $valida->Requerido('desc');
        $valida->Requerido('inicioInsc');
        $valida->Requerido('inicio');
        $valida->Requerido('finInsc');
        $valida->Requerido('fin');
    
        if ($valida->ValidacionPasada()) {
            # El concurso creado
            $concurso = new Concurso();
            # Cogemos los valores y validamos
            $con['id'] = null;
            $con['nombre'] = $_POST['nombre'];
            $con['desc'] = $_POST['desc'];
            $con['fechaInicioInsc'] = $_POST['inicioInsc'];
            $con['fechaFinInsc'] = $_POST['finInsc'];
            $con['fechInicio'] = $_POST['inicio'];
            $con['fechFin'] = $_POST['fin'];
            if ($_POST['img'] != null) {
                # Asignamos el cartel
                $con['cartel'] = base64_encode($_POST['img']);
            } else {
                $con['cartel'] = null;
            }
            
            $con['bandas'] = $_POST['bandas'];
            $con['modos'] = $_POST['modos'];
    
            # Rellenamos el concurso
            $concurso->rellenaConcursoArray($con);
            # Lo insertamos
            $rp->set($concurso);
            # Recargamos 
            header("Location:?menu=listadoconcursos");
        }
    }
}

?>
<script src="./js/mantenimientoConcursos.js"></script>
<section class="tablas">
    <!-- INSERTAMOS LA TABLA -->
    <form action="" method="POST">
        <table class="editable">
            <thead>
                <tr>
                    <!-- Cuando es admin le añadimos la columna de borrado -->
                    <?= $admin?"<th></th>":null ?> 
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>Descripción</th>
                    <th>Periodo de inscripción</th>
                    <th>Periodo de participación</th>
                    <th>Bandas</th>
                    <th>Modos</th>
                    <th>Cartel</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbody">
                <!-- La primera fila servirá para que los administradores creen nuevos concursos -->
                <?php
                if (Sesion::existe('user') && Sesion::leer('user')->getRol() === 'admin') {
                    $admin = true; # es admin
                    # Las bandas
                    $rpB = new repBanda(gbd::getConexion());
                    $bandas = $rpB->getAll();
                    # Los modos
                    $modos = $rp->get_modos();
                    $optBandas = '';
                    $optModos = '';

                    for ($i = 0; $i < count($bandas); $i++) {
                        # Rellenamos el SELECT
                        $optBandas .= '<option value="' . $bandas[$i]->getId() . '">' . $bandas[$i]->getNombre() . '</option>';
                    }
                    for ($i = 0; $i < count($modos); $i++) {
                        # Rellenamos el SELECT
                        $optModos .= '<option value="' . $modos[$i]->getId() . '">' . $modos[$i]->getNombre() . '</option>';
                    }
                    # Escribimos la fila de adición
                    $fila = <<<EOD
                    <tr id="crear">
                        <td></td> <!-- Borrar tampoco tiene sentido -->
                        <td></td> <!-- El campo del id no se define -->
                        <td>
                            <input type="text" name="nombre" id="nombre" placeholder="Nombre"></td>
                            
                        <td>
                            <input type="text" name="desc" id="desc" placeholder="Descripción"></td>
                            
                        <td> <!-- Title creará un tooltip -->
                            <input type="date" name="inicioInsc" title="Fecha Inicio">
                            
                            <input type="date" name="finInsc" title="Fecha Fin">
                            
                        </td>
                        <td>
                            <input type="date" name="inicio" title="Fecha Inicio">
                           
                            <input type="date" name="fin" title="Fecha Fin">
                            
                        </td>
                        <td>
                            <select name="bandas[]" multiple>
                                
                                $optBandas
                                
                            </select>
                            
                        </td>   
                        <td>
                            <select name="modos[]" selected="-1" multiple>
                                
                                $optModos
                                
                            </select>
                            
                        </td>   
                        <td><div class="c-add__img"id="btnImg" onclick="getFile()">
                                <label for="img" class="img">Subir foto</label>
                                <input type="file" name="img" id="inpFile">
                            </div>
                        </td>
                        <td> <input type="submit" name='submit' id="btnGuardar" value="Guardar"></td>
                        </tr>
            EOD;
                    echo $fila;
                }
                ?>
                <!-- EL RESTO DEL LISTADO -->
                <?php
                // Conseguimos los datos
                $data = $rp->getAll();
                if ($data != false) {
                    $tamanno = count($data);
                } else {
                    $tamanno = 0;
                }
                //Listamos 
                for ($i = 0; $i < $tamanno; $i++) {
                    echo "<tr>";
                    $concurso = $data[$i];
                    
                    foreach ($concurso as $clave => $valor) {
                        if ($clave === 'id' ) {
                            # La primera columna 
                            echo '<td class="del" idConcurso="'.$concurso[$clave].'"><div><a href="?menu=bconcurso&id='.$concurso[$clave].'&q=concurso"><img src="./images/trash.png" height="20px" class="btnBorrar" alt="borrar"></a><a href="?menu=editar"><img height="20px" src="./images/paint-brush.png"></a></div></td> <!-- Borrar -->';
                        }
                        // Agruparemos los 2 conjuntos de fechas
                        if (($clave === "fechaInicioInscripcion") || ($clave === "fechaFinInscripcion") ||
                            ($clave === "fechaInicioConcurso") || $clave === "fechaFinConcurso"
                        ) {
                            // Las fechas de inicio y fin de inscripción (que van seguidas)
                            $txt .= $concurso[$clave];
                            $fin = $concurso[$clave];
                            if (($clave === "fechaInicioInscripcion") || ($clave === "fechaInicioConcurso")) {
                                // Reiniciamos el valor de la variable TXT antes de concatenar
                                $txt = $concurso[$clave];
                                // Si es la fecha de INICIO añadimos un separador
                                $txt .= " / ";
                                // $inicio = $concurso[$clave];
                            }
                            // $dif = $fin - $inicio;

                        } else {
                            $txt = $concurso[$clave];
                        }
                        if ($clave != "fechaInicioInscripcion" && $clave != "fechaInicioConcurso") {
                            // Nos aseguramos que las fechas de inicio solas no se escriban
                            // el bucle de otra vuelta y de esta manera, solo aparezcan acompañadas de las
                            // fechas de fin
                            if ($clave === "cartel") {
                                // Añadimos las columnas para bandas y modos antes del cartel
                                $bandass = $rp->get_bandas($concurso['id']);
                                $modoss = $rp->get_modos($concurso['id']);
                                echo "<td>";
                                echo "<ul>";
                                for ($z = 0; $z < count($bandass); $z++) {
                                    # cada banda
                                    echo "<li>" . $bandass[$z]->getNombre() . "</li>";
                                }
                                echo "</ul>";
                                echo "</td>";
                                # Modos
                                echo "<td>";
                                echo "<ul>";
                                for ($z = 0; $z < count($modoss); $z++) {
                                    # cada modo
                                    echo "<li>" . $modoss[$z]->getNombre() . "</li>";
                                }
                                echo "</ul>";
                                echo "</td>";
                                # Ahora añadimos el cartel, con img y onclick cambiar imagen
                                echo "<td class='cambiaImg' onclick='cambiaImg()'>";
                                if ($concurso['cartel'] != null) {
                                    # la imagen la sacamos de base de datos
                                    echo "<img src='data:image/png;base64," . $concurso['cartel'] . "'>";
                                } else {
                                    echo "<img class='cambiaImg__img' src='./images/editar.png'>";
                                }
                                echo "</td>";
                            } else {
                                # Cuando no es cartel
                                echo "<td>";
                                echo $txt;
                            }
                        }
                        echo "</td>";
                    }
                    $hoy = date("Y-m-d H:i:s");
                    $date = date("Y-m-d H:i:s", (int)$concurso['fechaFinInscripcion']);

                    // if ($date > $hoy) # Si la fecha es mayor a hoy no ha pasado aún
                    {
                        # Si todavía se puede inscribir
                        echo "<td id='entraConcurso'>" . "<a href='?concurso=" . $concurso['id'] . "' class='c-login__btn--submit'>Unirme</a>" . "</td>";
                    }
                    echo "</tr>";
                }
                // Rellenamos los modos y las bandas

                # Ponemos la columna de edición
                if ($admin) {
                    # Podrá ver la edición
                    echo "<script>";
                    echo "window.addEventListener('load', () => {" .
                        "editarAdmin();" .
                        "});";
                    echo "</script>";
                }
                ?>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
    </form>
</section>

<!-- El input para la imagen -->
<script src="./js/profpic.js"></script>
<script>

    window.addEventListener("load", () => {
        // var unir = document.getElementById('entraConcurso');

        // unir.addEventListener("click", function () {
        //     redireccion(this);
        // });

        function redireccion(x) {
            alert(x);
            location.href = "?concurso=" + x.rowIndex;
        }
        //     // pintaConcursos();
        //     var crear = document.querySelector('#btnGuardar');
        //     crear.addEventListener("click", function() {
        //         // Guardamos los valores y lo pasamos a base de datos

        //         // Recargamos la página

        //         location.href = "?menu=listadoconcursos";
    });
    // });
    function cambiaImg() {
        var inp = document.createElement("input");
        inp.type = "file";
        inp.click();
    }
</script>