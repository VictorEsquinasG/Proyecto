<?php

$valida = new Validacion();
$id = $_GET['id'];
$rp = new repConcurso(gbd::getConexion());
$concur = $rp->getById($id);

$r = new repConcurso(gbd::getConexion());
if (isset($_POST['submit'])) {
    # Ha mandado el formulario
    $valida->Requerido('nombre');
    $valida->Requerido('desc');
    $valida->Requerido('inicio');
    $valida->Requerido('fin');
    $valida->Requerido('inicioC');
    $valida->Requerido('finC');
    // $valida->Requerido('imagen');

    if ($valida->ValidacionPasada()) {
        # Ha mandado todos los datos
        $nombre = $_POST['nombre'];
        $descr = $_POST['desc'];
        $insc = $_POST['inicio'];
        $inscF = $_POST['fin'];
        $inicio = $_POST['inicioC'];
        $fin = $_POST['finC'];
        if (isset($_FILES['imagen']) && !empty($_FILES['imagen'])) {
            # le añadimos la imagen
            $poster = base64_encode(file_get_contents($_FILES['imagen']['tmp_name']));
        } else {
            # la imagen es Null
            $poster = null;
        }

        $compe = new Concurso();
        $compe->rellenaConcurso(null, $nombre, $descr, $insc, $inscF, $inicio, $fin, $poster);
        $r->update($id, $compe);

        # Lo mandamos de nuevo al listado
        header("Location:?menu=listadoconcursos");
    }
}

?>

<div style="display: flex;flex:1 1 100%;flex-direction:column;justify-content:center;   ">

    <form action="" method="POST" enctype="multipart/form-data" style="display:flex;width: 25%;margin:auto;justify-content:center;flex-direction:column;">
        <label for="nombre">Nombre del Concurso</label><br>
        <?= '<input type="text" name="nombre" value="' . $concur->getNombre() . '"><br>' ?>
        <?= $valida->ImprimirError('nombre') ?>
        <label for="desc">Descripción</label><br>
        <?= '<textarea name="desc" cols="10" rows="5">' . $concur->getDesc() . '</textarea><br>' ?>
        <?= $valida->ImprimirError('desc') ?>
        <label for="inicio">Fecha de Inscripción</label><br>
        <?= '<input type="text" value="' . $concur->getFechInicioInsc()->format('Y-m-d') . '" onfocus="(this.type=\'date\')"
        onblur="(this.type=\'text\')" name="inicio"><br>' ?>
        <?= $valida->ImprimirError('inicio') ?>
        <label for="fin">Fin del periodo de inscripción</label><br>
        <?= '<input type="text" value="' . $concur->getFechFinInsc()->format('Y-m-d') . '" onfocus="(this.type=\'date\')"
        onblur="(this.type=\'text\')" name="fin"><br>' ?>
        <?= $valida->ImprimirError('fin') ?>
        <label for="inicioC">Inicio del concurso</label><br>
        <?= '<input type="text" value="' . $concur->getFechInicio()->format('Y-m-d') . '" onfocus="(this.type=\'date\')"
        onblur="(this.type=`text`)" name="inicioC"><br>' ?>
        <?= $valida->ImprimirError('inicioC') ?>
        <label for="finC">Fin del concurso</label><br>
        <?= '<input type="text" value="' . $concur->getFechFin()->format('Y-m-d') . '" onfocus="(this.type=\'date\')"
        onblur="(this.type=\'text\')" name="finC"><br>' ?>
        <?= $valida->ImprimirError('finC') ?>

        <img id="foto" width="150" style="margin:auto">
        <div class="c-add__img" style="margin: 10px;" id="btnImg">
            <label for="imagen" class="img">
                <i class="fa fa-cloud-upload"></i>
                Imagen del concurso
            </label>
            <input type="file" name="imagen" id="inpFile">
        </div>

        <input type="submit" name="submit" class="c-card__btn c-btn--primary" value="Guardar cambios">

    </form>
    <br><br>    
</div>
<script src="./js/helper/camara.js"></script>
<script src="./js/helper/profpic.js"></script>