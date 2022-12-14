<?php

$admin = Sesion::existe('user') && Sesion::leer('user')->getRol() === 'admin';
if (!$admin) {
    # No está autorizado
    header("Location:?menu=registrate");
}

if (isset($_POST['submit'])) {
    # lo mandamos a crear un concurso al listado
    header('Location:?menu=listadoconcursos');
}
?>
<section>
    <article class="c-centrado">
        <div class="tablas" style="display:flex; justify-content:center;margin-left:90px;">
            <table class="editable">
                <thead>
                    <tr>
                        <th>ID <span id="btnAsc">▲▼</span></th>
                        <th>Nombre <span id="btnAsc">▲▼</span></th>
                        <th>Descripción <span id="btnAsc">▲▼</span></th>
                        <th>Inicio Inscripción <span id="btnAsc">▲▼</span></th>
                        <th>Fin Inscripción <span id="btnAsc">▲▼</span></th>
                        <th>Inicio Concurso <span id="btnAsc">▲▼</span></th>
                        <th>Fin Concurso <span id="btnAsc">▲▼</span></th>
                        <th>Letrero <span id="btnAsc">▲▼</span></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <!-- La primera fila servirá para que los administradores creen nuevos concursos -->
                    <?php
                    $crear = <<<EOD
                        <form action="" method="POST">
                            <input type="submit" name="submit" class="c-card__btn c-btn--primary" value="+">
                        </form>
                        EOD;
                    if ($admin) {
                        # es admin -> crea
                        echo $crear;
                    }

                    # EL RESTO DEL LISTADO 

                    $rep = new repConcurso(gbd::getConexion());
                    $concurso = $rep->getAll();
                    $tamanio = count($concurso);
                    for ($i = 0; $i < $tamanio; $i++) {
                        $competicion = $concurso[$i];
                        # Cogemos la banda que toque
                        // $competicion->rellenaConcursoArray($concurso[$i]);
                        # Filas + columnas
                        echo "<tr>";
                        echo "<td>" . $competicion['id'] . "</td>";
                        echo "<td>" . $competicion['nombre'] . "</td>";
                        echo "<td>" . $competicion['descripcion'] . "</td>";
                        echo "<td>" . $competicion['fechaInicioInscripcion'] . "</td>";
                        echo "<td>" . $competicion['fechaFinInscripcion'] . "</td>";
                        echo "<td>" . $competicion['fechaInicioConcurso'] . "</td>";
                        echo "<td>" . $competicion['fechaFinConcurso'] . "</td>";
                        echo "<td>";
                        echo isset($competicion['cartel']) && $competicion['cartel'] != null ?
                            "<img width='50' src='data:image/png;base64," . $competicion['cartel'] . "'>" : "";
                        echo "</td>";
                        echo "<td class='btnEd' idConcurso='" . $competicion['id'] . "'> <img width='20px' src='./images/paint-brush.png'>&nbsp;<img width='20px' src='./images/trash.png'></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>

        <script src="./js/api/listados.js"></script>
        <script src="./js/clases/tabla.js"></script>
        <script>
            window.addEventListener("load", () => {
                // Haremos que el doble click a cualquiera de las filas lleve a EDITAR
                var btnes = document.querySelectorAll('.btnEd');
                btnes.forEach(boton => {
                    boton.addEventListener("click", () => {
                        // Obtenemos el id
                        var id = boton.getAttribute("idConcurso");
                        // Abrimos la página de edición
                        location.href = "?menu=editar&id=" + id;
                    });
                });
            });
        </script>
    </article>
</section>