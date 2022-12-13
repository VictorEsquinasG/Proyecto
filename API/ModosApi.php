<?php
    require_once('../Chargers/autoloader.php');
    
    Sesion::iniciar();
    if (Sesion::existe('user') && Sesion::leer('user')->getRol('admin')) {
        # Sólo si tiene credenciales le permitimos utilizar la API
        $rp = new repModo(gbd::getConexion());
    
        $hecho = $rp->set($_POST['nombre']);
    
        return json_encode($hecho);
    }