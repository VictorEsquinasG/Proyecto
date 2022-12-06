<?php
echo ("<h1 class='g--font-size-5l'>PARTICIPANTES</h1>");
echo "<br/>";
?>
<!-- INSERTAMOS LA TABLA -->
<section class="tablas">
    <table class="editable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Identificador</th>
                <th>Nombre Completo</th>
                <th>Correo</th>
                <th>Ubicación</th>
            </tr>
        </thead>
        <tbody id="tbody">
            <!-- La primera fila servirá para que los administradores creen nuevos concursos -->
            <?php
            if (Sesion::existe('user') && Sesion::leer('user')->getRol() === 'admin') {
                # Escribimos la fila de adición
                $fila = <<<EOD
                <tr id="crear">
                <td><input type="text" name="id" id="id" placeholder="ID"></td>
                <td><input type="text" name="indicativo" id="indicativo" placeholder="Indicativo"></td>
                <td><input type="text" name="nombre" id="nombre" placeholder="Nombre completo"></td>
                <td><input type="text" name="mail" id="mail" placeholder="email"></td>
                <td><input type="text" name="ubi" id="ubi" placeholder="Ubicación"></td>
                <td><input type="text" name="punt" id="punt" placeholder="Puntuación"></td>
                    <td> <input type="submit" name="submit" id="btnGuardar" value="Guardar"></td>    
                </tr>
                <tr id="editar" style="display: none;">
                    <td><input type="text" name="id" id="edId" placeholder="Id"></td>
                    <td><input type="text" name="indicativo" id="edIndicativo" placeholder="Identificador"></td>
                    <td><input type="text" name="edNombre" id="edNombre" placeholder="Nombre completo"></td>
                    <td><input type="text" name="mail" id="edMail" placeholder="email"></td>
                    <td><input type="text" name="ubi" id="edUbi" placeholder="Ubicación"></td>
                    <td><input type="text" name="punt" id="edPunt" placeholder="Puntuación"></td>

                    <td><input type="submit" name="submit" id="btnEditar" value="Modificar"></td>    
                </tr>
            EOD;
            $fila = <<<EOD
                <form action="" method="POST">
                    <input class="c-card__btn c-btn--primary" id="annadir" type="submit" name="annadir" value="+">
                </form>
                <!-- El modal que añade usuarios -->
                <script src="./js/api/participante.js"></script>
            EOD;
            echo $fila;
            }
            ?>
            <!-- EL RESTO DEL LISTADO -->
        </tbody>
        <tfoot>
        </tfoot>
    </table>
</section>

<!-- Enlazamos con la tabla inteligente -->
<script src="./js/api/tabla.js"></script>
<!-- Obtenemos los concursos existentes -->
<script src="./js/api/listados.js"></script>
<!-- Rellenamos la tabla según los datos -->
<script>
    window.addEventListener("load", () => {
        pintaUsuarios();
    });
</script>