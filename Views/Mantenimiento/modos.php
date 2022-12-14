<?php
/* SI ES ADMIN */
$admin = Sesion::existe('user') && Sesion::leer('user')->getRol() === 'admin';
if (!$admin) {
    # No está autorizado
    header("Location:?menu=registrate");
}
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
                        <th>Nombre <span id="btnAsc">▲▼</span></th>
                        <th></th> <!-- Cabecera vacía para editar y borrar -->
                    </tr>
                </thead>
                <tbody id="tbody">
                    <!-- La primera fila servirá para que los administradores creen nuevos concursos -->
                   <?php 
                    $crear = <<<EOD
                        <form action="" method="POST">
                            <input class="c-card__btn c-btn--primary" id="annadir" type="submit" name="annadir" value="+">
                        </form>
                        <!-- El modal que añade las bandas -->
                        <script src="./js/api/modos.js"></script>
                    EOD;
                    echo $admin ? $crear : "<script>console.log('No tiene acceso a este sitio web')</script>";
                    ?>
                    <!-- <tr id="crear">
                        <td></td>
                        <td><input type="text" name="nombre" id="nombre" placeholder="Nombre"></td>
                        <td> <input type="submit" id="btnGuardar" value="Guardar"></td>
                    </tr> -->

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
                        // echo "<td>" . $modo->getId() . "</td>";
                        echo "<td>" . $modo->getNombre() . "</td>";
                        echo $admin ? "<td>".'<div><img src="./images/trash.png" height="20px" idModo="' . $modo->getId() . '" class="btnBorrar" alt="borrar"><img height="20px" idModo="' . $modo->getId() . '" src="./images/paint-brush.png" class="btnEd" alt="editar"></div>'."</td>" : "";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
        <script src="./js/api/modos.js"></script>
        <script src="./js/api/listados.js"></script>
        <script src="./js/clases/tabla.js"></script>

        <!-- <script>
            window.addEventListener("load",()=>{
                // Captaremos los botones
                var btns = document.querySelectorAll('.btnBorrar');

                //PARA BORRAR LOS MODOS
                btns.forEach(boton => {
                    boton.onclick = async function () {
                        // Cogemos la ID
                        var id = boton.getAttribute('idModo');
                        const data = {
                            "id" : id,
                        };
                        const respuesta = await fetch("./API/modos.php", {
                            method: "DELETE",
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(data)
                        })
                        // .then(console.log(respuesta))
                        .then(response => location.reload())
                        .catch(err => console.log("Error al borrar modo de id "+id, err));

                        // location.reload();
                    }
                });
            });
        </script> -->
    </article>
</section>