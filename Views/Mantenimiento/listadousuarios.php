<?php
echo ("<h1 class='g--font-size-5l'>PARTICIPANTES</h1>");
echo "<br/>";
$admin = Sesion::existe('user') && Sesion::leer('user')->getRol() === 'admin';
?>
<!-- INSERTAMOS LA TABLA -->
<section class="tablas">
    <table class="editable">
        <thead>
            <tr>
                <th>Identificador <span id="btnAsc">▲▼</span></th>
                <th>Nombre Completo <span id="btnAsc">▲▼</span></th>
                <th>Correo <span id="btnAsc">▲▼</span></th>
                <th>Ubicación <span id="btnAsc">▲▼</span></th>
                <!-- La línea de abajo no se ejecuta => cambiar PHP por = -->
                <?php $admin ? "<th></th>" : "" ?>
            </tr>
        </thead>
        <tbody id="tbody">
            <!-- La primera fila servirá para que los administradores creen nuevos concursos -->
            <?php
            if ($admin) {
                # Escribimos la fila de adición
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
<script src="./js/clases/tabla.js"></script>
<!-- Obtenemos los concursos existentes -->
<script src="./js/api/listados.js"></script>
<!-- Rellenamos la tabla según los datos -->
<script>
    window.addEventListener("load", () => {
        pintaUsuarios();
    });
</script>