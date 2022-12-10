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

    if ($valida->ValidacionPasada()) {
        # Ha mandado todos los datos
        $nombre = $_POST['nombre'];
        $descr = $_POST['desc'];
        $insc = $_POST['inicio'];
        $inscF = $_POST['fin'];
        $inicio = $_POST['inicioC'];
        $fin = $_POST['finC'];

        $compe = new Concurso();
        $compe->rellenaConcurso(null,$nombre,$descr,$insc,$inscF,$inicio,$fin);
        $r->update($id,$compe);
        
        # Lo mandamos de nuevo al listado
        header("Location:?menu=listadoconcursos");
    }
}

?>

<div style="display: flex;flex:1 1 100%;flex-direction:column;justify-content:center;   ">

    <form action="" method="POST" style="display:flex;width: 25%;margin:auto;justify-content:center;flex-direction:column;">
        <label for="nombre">Nombre del Concurso</label><br> 
        <?= '<input type="text" name="nombre" placeholder="'.$concur->getNombre().'"><br>' ?>
        <?= $valida->ImprimirError('nombre') ?>
        <label for="desc">Descripción</label><br>
        <?= '<textarea name="desc" placeholder="'.$concur->getDesc().'" cols="10" rows="5"></textarea><br>' ?>
        <?= $valida->ImprimirError('desc') ?>
        <label for="inicio">Fecha de Inscripción</label><br>
        <?= '<input type="text" placeholder="'.$concur->getFechInicioInsc()->format('d/m/Y').'" onfocus="(this.type=\'date\')"
        onblur="(this.type=\'text\')" name="inicio"><br>' ?>
        <?= $valida->ImprimirError('inicio') ?>
        <label for="fin">Fin del periodo de inscripción</label><br>
        <?= '<input type="text" placeholder="'.$concur->getFechFinInsc()->format('d/m/Y').'" onfocus="(this.type=\'date\')"
        onblur="(this.type=\'text\')" name="fin"><br>' ?>
        <?= $valida->ImprimirError('fin') ?>
        <label for="inicioC">Inicio del concurso</label><br>
        <?= '<input type="text" placeholder="'.$concur->getFechInicio()->format('d/m/Y').'" onfocus="(this.type=\'date\')"
        onblur="(this.type=`text`)" name="inicioC"><br>' ?>
        <?= $valida->ImprimirError('inicioC') ?>
        <label for="finC" >Fin del concurso</label><br>
        <?= '<input type="text" placeholder="'.$concur->getFechFin()->format('d/m/Y').'" onfocus="(this.type=\'date\')"
        onblur="(this.type=\'text\')" name="finC"><br>' ?>
        <?= $valida->ImprimirError('finC') ?>
    
        <input type="submit" name="submit" class="c-card__btn c-btn--primary" value="Guardar cambios">
    
    </form>
</div>