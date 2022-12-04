<?php
/* VALIDADOR */
$valida = new Validacion();
# SI SE MANDÓ EL FORMULARIO
if (isset($_POST['submit'])) {
    $valida->Requerido('nombre');
    $valida->Requerido('desc');
    $valida->Requerido('inicioInsc');
    $valida->Requerido('finInsc');
    $valida->Requerido('inicio');
    $valida->Requerido('fin');
    $valida->Requerido('cartel');
    //Comprobamos validacion
    if ($valida->ValidacionPasada()) {
        # Cogemos los valores de los campos 
        $name = $_POST['nombre'];
        $desc = $_POST['desc'];
        $inicioIsnc = $_POST['inicioInsc'];
        $finIsnc = $_POST['finInsc'];
        $inicio = $_POST['inicio'];
        $fin = $_POST['fin'];
        if (!is_null($_POST['cartel'][0])) {
            # si no es null
            $cartel = $_POST['cartel'];
        }else {
            $cartel = null;
        }
        # Creamos el Concurso
        $concurso = new Concurso();
        $concurso->rellenaConcurso(null,$name,$desc,$inicioInsc,$finIsnc,$inicio,$fin,$cartel);
        # La insertamos
        $rp = new repConcurso(gbd::getConexion());
        if (!$rp->set($concurso)){
            #si no pudo insertar
            throw new Exception("Error al insertar nuevo concurso");
            
        }
    }
}
?>
<section>
    <article>
        <div class="tablas" style="display:flex; justify-content:center;margin-left:90px;">
            <table class="editable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Inicio Inscripción</th>
                        <th>Fin Inscripción</th>
                        <th>Inicio Concurso</th>
                        <th>Fin Concurso</th>
                        <th>Letrero</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <!-- La primera fila servirá para que los administradores creen nuevos concursos -->
                    <tr id="crear">
                        <!-- <td><input type="number" name="id"></td> -->
                        <td></td>
                        <td><input type="text" name="nombre"></td>
                        <td><input type="text" name="desc"></td>
                        <td><input type="date" name="inicioInsc"></td>
                        <td><input type="date" name="finInsc"></td>
                        <td><input type="date" name="inicio"></td>
                        <td><input type="date" name="fin"></td>
                        <td><input type="file" name="cartel"></td>
                        <td> <input type="submit" id="btnGuardar" value="Guardar"></td>
                    </tr>
                    
                    <!-- EwL RESTO DEL LISTADO -->
                    <?php
                    $rep = new repConcurso(gbd::getConexion());
                    $concurso = $rep->getAllConcursos();
                    $tamanio = count($concurso);
                        for ($i=0; $i < $tamanio; $i++) { 
                            $competicion = new Concurso();
                            # Cogemos la banda que toque
                            $competicion->rellenaConcursoArray($concurso[$i]);
                            # Filas + columnas
                            echo "<tr>";
                            echo "<td>".$competicion->getId()."</td>";
                            echo "<td>".$competicion->getNombre()."</td>";
                            echo "<td>".$competicion->getDesc()."</td>";
                            echo "<td>".$competicion->getFechInicioInsc()."</td>";
                            echo "<td>".$competicion->getFechFinInsc()."</td>";
                            echo "<td>".$competicion->getFechInicio()."</td>";
                            echo "<td>".$competicion->getFechFin()."</td>";
                            echo "<td>".$competicion->getCartel()."</td>";
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