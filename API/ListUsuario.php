<?php
    require_once('../Chargers/autoloader.php');

    Sesion::iniciar();
    if (Sesion::existe('user') && Sesion::leer('user')->getRol('admin')) {
        # Sólo si tiene credenciales le permitimos utilizar la API
        $rp = new repUsuarios(gbd::getConexion());
        // $data = $rp->getPage(10,1);
        $data = $rp->getAll();
    
        // var_dump($data);    
        # Le ponemos JSON_INVALID_UTF8_IGNORE para que nos permita utilizar @ en el correo
       echo (json_encode($data, JSON_INVALID_UTF8_IGNORE));  
    }
?>