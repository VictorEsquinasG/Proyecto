<?php
?>
<section class="c-forMantenimiento">
    <article class="c-forMantenimiento__formu">
        <!--  -->
          <h1 class="g--font-size-5l">
            MODOS
          </h1>
        <!-- <form action="" method="POST">
            <label for="id">Id</label>
            <input type="text" name="id">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre">
            <div>
                <input type="submit" value="Crear modo">
            </div>
        </form> -->
    </article>
    <article class="c-forMantenimiento__tabla">
        <div class="tablas">
            <table class="editable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <!-- La primera fila servirá para que los administradores creen nuevos concursos -->

                    <tr id="crear">
                        <td><input type="text" name="id" id="id" placeholder="Id"></td>
                        <td><input type="text" name="nombre" id="nombre" placeholder="Nombre"></td>
                        <td> <input type="submit" id="btnGuardar" value="Guardar"></td>
                    </tr>

                    <!-- EL RESTO DEL LISTADO -->
                    <?php
                    $rep = new repConcurso(gbd::getConexion());
                    $modos = $rep->get_modos();
                    $tamanio = count($modos);
                    for ($i = 0; $i < $tamanio; $i++) {
                        # cogemos el modo que toque
                        $modo = $modos[$i];
                        # creamos las filas y columnas
                        echo "<tr>";
                        echo "<td>" . $modo->getId() . "</td>";
                        echo "<td>" . $modo->getNombre() . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
        <script src="./js/api/listados.js"></script>
        <script src="./js/api/tabla.js"></script>
    </article>
</section>