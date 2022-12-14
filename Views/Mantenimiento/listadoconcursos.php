<?php
$admin = Sesion::existe('user') && Sesion::leer('user')->getRol() === 'admin'; // es admin
echo ("<h1 class='g--font-size-5l'>CONCURSOS</h1>");

$valida = new Validacion();
$rp = new repConcurso(gbd::getConexion());
# Primero comprobamos si es admin
if ((Sesion::existe('user') && Sesion::leer('user')->getRol() === 'admin')) {
    $admin = true;
}

?>
<script src="./js/mantenimientoConcursos.js"></script>
<section class="tablas">
    <!-- INSERTAMOS LA TABLA -->
        <table class="editable">
            <thead>
                <tr>
                    <!-- Cuando es admin le añadimos la columna de borrado -->
                    <?= $admin ? "<th></th>" : null ?>
                    <!-- <th>ID</th> -->
                    <th>NOMBRE <span id="btnAsc">▲▼</span></th>
                    <th>Descripción <span id="btnAsc">▲▼</span></th>
                    <th>Periodo de inscripción <span id="btnAsc">▲▼</span></th>
                    <th>Periodo de participación <span id="btnAsc">▲▼</span></th>
                    <th>Bandas <span id="btnAsc">▲▼</span></th>
                    <th>Modos <span id="btnAsc">▲▼</span></th>
                    <!-- <th>Cartel <span id="btnAsc">▲▼</span></th> -->
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbody">
                <!-- La primera fila servirá para que los administradores creen nuevos concursos -->

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
                        if ($admin) {
                            # Si es admin le sale la columna de borrado y edición
                            if ($clave === 'id') {
                                # La primera columna 
                                echo '<td class="del" idConcurso="' . $concurso[$clave] . '"><div><a href="?menu=bconcurso&id=' . $concurso[$clave] . '&q=concurso"><img src="./images/trash.png" height="20px" class="btnBorrar" alt="borrar"></a><a href="?menu=editar&id=' . $concurso[$clave] . '"><img height="20px" src="./images/paint-brush.png"></a></div></td> <!-- Borrar -->';
                            }
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
                                // echo "<td class='cambiaImg' onclick='cambiaImg()'>";
                                // if ($concurso['cartel'] != null) {
                                    # la imagen la sacamos de base de datos
                                    // echo "<img width='25px' src='data:image/png;base64," . $concurso['cartel'] . "'>";
                                // } else {
                                    // echo "<img class='cambiaImg__img' src='./images/editar.png'>";
                                // }
                                // echo "</td>";

                            } else {
                                # Cuando no es cartel ni ID
                                echo $clave != 'id' ? "<td>" . $txt : "";
                            }
                        }
                        echo "</td>";
                    }
                    $hoy = date("Y-m-d H:i:s");
                    $date = date("Y-m-d H:i:s", (int)$concurso['fechaFinInscripcion']);

                    # Mostramos la página del concurso
                    echo "<td id='entraConcurso'>" . "<a href='?concurso=" . $concurso['id'] . "' class='c-login__btn--submit'>Ver</a>" . "</td>";

                    echo "</tr>";
                }
                // Rellenamos los modos y las bandas

                # Ponemos la columna de edición
                // if ($admin) {
                //     # Podrá ver la edición
                //     echo "<script>";
                //     echo "window.addEventListener('load', () => {" .
                //         "editarAdmin();" .
                //         "});";
                //     echo "</script>";
                // }
                // 
            ?>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
        <?php
        # Escribimos el boton de adición
        if ($admin) {
            $fila = <<<EOD
                <a href="?menu=creaConcurso" class="c-card__btn c-btn--primary" style="margin-left:0%">+</a>
            EOD;
            echo $fila;
        }
        ?>
</section>

<!-- El input para la imagen -->
<script src="./js/helper/profpic.js"></script>
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