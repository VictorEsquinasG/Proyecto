<?php
/* VALIDADOR */
$valida = new Validacion();
/* SI ES ADMIN */
$admin = Sesion::existe('user') && Sesion::leer('user')->getRol() === 'admin';
# SI SE MANDÓ EL FORMULARIO
// if (isset($_POST['submit'])) {
//     $valida->Requerido('nombre');
//     $valida->Requerido('dist');
//     $valida->Requerido('min');
//     $valida->EnteroRango('min');
//     $valida->Requerido('max');
//     $valida->EnteroRango('max');
//     //Comprobamos validacion
//     if ($valida->ValidacionPasada()) {
//         # Cogemos los valores de los campos 
//         $name = $_POST['nombre'];
//         $distance = $_POST['dist'];
//         $min = $_POST['min'];
//         $max = $_POST['max'];
//         # Creamos la BANDA
//         $banda = new Banda();
//         $banda->rellenaBanda(null,$name,(int)$distance,(int)$min,(int)$max);
//         # La insertamos
//         $rp = new repBanda(gbd::getConexion());
//         if (!$rp->add($banda)){
//             #si no pudo insertar
//             throw new Exception("Error al insertar nueva banda");

//         }
//     }
// }
?>
<section class="c-forMantenimiento">
    <article class="c-login c-forMantenimiento__formu">
        <h1 style="margin-left:10.5rem;" class="g--font-size-5l">
            BANDAS
        </h1>
        <!-- <form action="" method="POST">
            <h5 class="g--font-size-3l">Nueva banda</h5>
            <div class="c-forMantenimiento__input">
                <!-- El id no lo pedimos porque se autogenera -->
        <!-- <div>
                    <input type="text" name="nombre">
                    <label for="nombre">Nombre</label>
                </div>
                <div>
                    <input type="number" name="dist">
                    <label for="dist">Distancia</label>
                </div>
            </div>  
            <div class="c-forMantenimiento__input">
                <h5>Rango</h5>
                <div>
                    <input type="number" name="min">
                    <label for="min">Mínimo</label>
                </div>
                <div>
                    <input type="number" name="max">
                    <label for="max">Máximo</label>
                </div>
            </div>
            <div>
                <input type="submit" name="submit" class="c-btn--primary__form c-login__btn--submit" value="Crear">
            </div>
        </form> -->
    </article>
    <article class="c-forMantenimiento__tabla">
        <div class="tablas">
            <table class="editable">
                <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Nombre</th>
                        <th>Distancia</th>
                        <th>Mínimo</th>
                        <th>Máximo</th>
                        <?= $admin ? '<th></th>':'' ?>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <!-- La primera fila servirá para que los administradores creen nuevos concursos -->
                    <!-- <tr id="crear">
                        <td><input type="number" name="id" placeholder="Id"></td>
                        <td><input type="text" name="nombre" placeholder="Nombre"></td>
                        <td><input type="number" name="dist" placeholder="Distancia"></td>
                        <td><input type="number" name="min" placeholder="Mínimo"></td>
                        <td><input type="number" name="max" placeholder="Máximo"></td>
                        <td> <input type="submit" id="btnGuardar" value="Guardar"></td>
                    </tr> -->
                    <?php
                    if ($admin) {
                        # CREAR
                        $fila = <<<EOD
                        <form action="" method="POST">
                            <input class="c-card__btn c-btn--primary" id="annadir" type="submit" name="annadir" value="+">
                        </form>
                        <!-- El modal que añade las bandas -->
                        EOD;
                        echo $fila;
                    }
                    ?>

                    <!-- EL RESTO DEL LISTADO -->
                    <?php
                    $rep = new repBanda(gbd::getConexion());
                    $bandas = $rep->getAll();
                    $tamanio = count($bandas);
                    for ($i = 0; $i < $tamanio; $i++) {
                        # Cogemos la banda que toque
                        $banda = $bandas[$i];
                        # Filas + columnas
                        echo "<tr>";
                        // echo "<td>" . $banda->getId() . "</td>";
                        echo "<td>" . $banda->getNombre() . "</td>";
                        echo "<td>" . $banda->getDistancia() . "</td>";
                        echo "<td>" . $banda->getMin_rango() . "KHz</td>";
                        echo "<td>" . $banda->getMax_rango() . "KHz</td>";
                        # La última columna será de borrado y edición si es admin
                        echo $admin ? "<td>".'<div><img src="./images/trash.png" height="20px" idBanda="' . $banda->getId() . '" class="btnBorrar" alt="borrar"><img height="20px" idBanda="' . $banda->getId() . '" src="./images/paint-brush.png" class="btnEd" alt="editar"></div>'."</td>" : "";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
        
        <script src="./js/api/bandas.js"></script>
        <script>
            window.addEventListener("load",()=>{
                // Captaremos los botones
                var btns = document.querySelectorAll('.btnBorrar');
                // var btnsEd = document.querySelectorAll('.btnEd');

                //PARA BORRAR LAS BANDAS
                btns.forEach(boton => {
                    boton.onclick = function () {
                        var id = boton.getAttribute('idBanda');
                        fetch("./API/borraBanda.php?id="+id)
                        .then(response => location.reload())
                        .catch(err => console.log("Error al borrar banda de id "+id, err));
                    }
                });
                // PARA EDITAR
                // btns.forEach(boton => {
                //     boton.onclick = function () {
                //         var id = boton.getAttribute('idBanda');
                //         fetch("./API/editaBanda.php?id="+id)
                //         .then(response => location.reload())
                //         .catch(err => console.log("Error al editar banda de id "+id, err));
                //     }
                // });     
            });
        </script>
    </article>
</section>