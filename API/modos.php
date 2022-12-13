<?php
require_once('../Chargers/autoloader.php');
 
Sesion::iniciar();
if (Sesion::existe('user') && Sesion::leer('user')->getRol('admin')) {
    # Sólo si tiene credenciales le permitimos utilizar la API
    $rp = new repConcurso(gbd::getConexion());
    
    $hecho = $rp->get_modos($_GET['id']);
    
    echo json_encode($hecho);
}