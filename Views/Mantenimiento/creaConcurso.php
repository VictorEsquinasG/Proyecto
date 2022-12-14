<?php
$valida = new Validacion();
$rp = new repConcurso(gbd::getConexion());
# Primero comprobamos si es admin
$admin = (Sesion::existe('user') && Sesion::leer('user')->getRol() === 'admin');
if ($admin) {
    // Si ha creado (y es admin)
    if (isset($_POST['submit'])) {
        $valida->Requerido('nombre');
        $valida->Requerido('descripcion');
        $valida->Requerido('inicioInsc');
        $valida->Requerido('finInsc');
        $valida->fechaPosterior($_POST['inicioInsc'], $_POST['finInsc'], 'inicioInsc',true);
        $valida->Requerido('inicio');
        $valida->Requerido('fin');
        $valida->fechaPosterior($_POST['inicio'], $_POST['fin'], 'inicio',true);

        if ($valida->ValidacionPasada()) {
            # El concurso creado
            $concurso = new Concurso();
            # Cogemos los valores y validamos
            $con['id'] = null;
            $con['nombre'] = $_POST['nombre'];
            $con['desc'] = $_POST['descripcion'];
            $con['fechaInicioInsc'] = $_POST['inicioInsc'];
            $con['fechaFinInsc'] = $_POST['finInsc'];
            $con['fechInicio'] = $_POST['inicio'];
            $con['fechFin'] = $_POST['fin'];

            if (isset($_FILES['img']) && !empty($_FILES['img'])) {
                # la imagen es Null
                $imagen = file_get_contents($_FILES['img']['tmp_name']);
                $imagen = base64_encode($imagen);
                $con['cartel'] = $imagen;
            } else {
                # la imagen es Null
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
} else {
    header("Location:?menu=inicio");
}

# es admin

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
# Errores
$erNombre = $valida->ImprimirError('nombre');
$erDesc = $valida->ImprimirError('descripcion');
$erFinins = $valida->ImprimirError('inicioInsc');
$erFfinsc = $valida->ImprimirError('finInsc');
$erFinC = $valida->ImprimirError('inicio');
$erFfinC = $valida->ImprimirError('fin');
$erBandas = $valida->ImprimirError('bandas');
$erModos = $valida->ImprimirError('modos');
# Escribimos la fila de adición
$fila = <<<EOD
    <article id="crear">
        <form action="" method="POST">
        <div>
            <h1 class='g--font-size-4l' style='color:darkorange;font-weight:bold;font-family:Segoe UI'> Nuevo Concurso </h1>
        </div>
        <div>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre del nuevo concurso">
        </div>
            $erNombre
        <div>
            <textarea name="descripcion" id="desc" cols="30" placeholder="Descripción" rows="2"></textarea>
            $erDesc
        <div> <!-- Title creará un tooltip -->
            <label>Fechas de inicio y finalización (de inscripción)</label><br><br>
            <input type="date" name="inicioInsc" title="Fecha Inicio">
            <input type="date" name="finInsc" title="Fecha Fin">
            $erFinins
            $erFfinsc
        </div><br>
        <div>
            <label>Fechas de inicio y finalización</label><br><br>
            <input type="date" name="inicio" title="Fecha Inicio">
            <input type="date" name="fin" title="Fecha Fin">
            $erFinC
            $erFfinC
        </div><br>
        <div>
            <select name="bandas[]" multiple>
                
                $optBandas
                
            </select>
            $erBandas
        </div>   <br>
        <div>
            <select name="modos[]" multiple>
                
                $optModos
                
            </select>
            $erModos
        </div>   
        <div class="c-add__img" id="btnImg" onclick="getFile()">
                <label for="img" class="img">Subir foto</label>
                <input type="file" name="img" id="inpFile">
        </div>
        
        <div> <input type="submit" name='submit' id="btnGuardar" class='c-card__btn c-btn--primary' style='width:75%' value="Guardar"></div>
        </form>
    </article>
EOD;
echo $fila;
?>
<style>
    #crear>form {
        height: fit-content;
        display: flex;
        flex: 1 1 100%;
        flex-direction: column;
        justify-content: center;
        margin: 0 25%;
        border-radius: 5px;
        padding: 20px;
        background: rgba(223, 223, 223, 0.703);
        box-shadow: 0 15px 25px rgba(86, 62, 35, 0.7);
    }
    
    #crear>form>div {
        margin: auto;
        text-align: center;
        margin-top: 15px;
    }

   #crear>form>div label {
        margin: 10px;
   }

    #crear>form>div input:not([type="date"],.c-card__btn), textarea {
        position: relative;
        padding: 2px 0;
        /* margin: 5px 0; */
        font-size: 15px;
        text-align: start ;
        border: none;
        outline: none;
        background: transparent;
    }
    #nombre {
        width: 265px;
    }
</style>
<!-- <script src="./js/mantenimientoConcursos.js"></script> -->
<script src="./js/helper/profpic.js"></script>