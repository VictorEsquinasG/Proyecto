<?php
require_once('../Chargers/autoloader.php');
    
Sesion::iniciar();
if (Sesion::existe('user')) {
    # Sólo si tiene credenciales le permitimos utilizar la API
    $rp = new repConcurso(gbd::getConexion());
    
    $hecho = $rp->getJueces($_GET['id']);
    
    echo json_encode($hecho);
}