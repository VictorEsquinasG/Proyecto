<?php
require_once('../Chargers/autoloader.php');

Sesion::iniciar();
if (Sesion::existe('user')) {
    # Sólo si tiene credenciales le permitimos utilizar la API
    
    $rp = new repQSO(gbd::getConexion());

    // Cogemos el que hay que validar
    $id = $_POST['id'];
    // Ejecutamos
    $rp->invalida($id);
    
}