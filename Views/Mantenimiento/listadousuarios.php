<?php
echo ("<h1 class='g--font-size-5l'>PARTICIPANTES</h1>");
echo "<br/>";
?>
<!-- INSERTAMOS LA TABLA -->
<table class="editable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Identificador</th>
            <th>Nombre Completo</th>
            <th>Correo</th>
            <th>Ubicación</th>
            <th>Puntuación</th>
        </tr>
    </thead>
    <tbody id="tbody">
        <!-- La primera fila servirá para que los administradores creen nuevos concursos -->
        <tr id="crear" style="display: none;">
            <td><input type="text" name="id" id="id" placeholder="Id"></td>
            <td><input type="text" name="nombre" id="nombre" placeholder="Nombre"></td>
            <td><input type="text" name="desc" id="desc" placeholder="Descripción"></td>
            <td><input type="text" name="" id="" placeholder="Fecha Inicio"></td>
            <td> <input type="submit" id="btnGuardar" value="Guardar"></td>
        </tr>
        <!-- EL RESTO DEL LISTADO -->

    </tbody>
    <tfoot>

    </tfoot>
</table>

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