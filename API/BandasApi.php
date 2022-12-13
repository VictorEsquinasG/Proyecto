<?php
    require_once('../Chargers/autoloader.php');
    
    $rp = new repBanda(gbd::getConexion());

    Sesion::iniciar();
if (Sesion::existe('user') && Sesion::leer('user')->getRol('admin')) {
    # Sólo si tiene credenciales le permitimos utilizar la API
    $banda = new Banda();
    $banda->rellenaBanda(null,$_POST['nombre'],$_POST['distancia'],$_POST['minimo'],$_POST['maximo']);

    $hecho = $rp->add($banda);

    return json_encode($hecho);
}