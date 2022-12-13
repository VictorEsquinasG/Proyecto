<?php
    require_once('../Chargers/autoloader.php');

    Sesion::iniciar();
    if (Sesion::existe('user') && Sesion::leer('user')->getRol('admin')) {
        # Sólo si tiene credenciales le permitimos utilizar la API
        $rp = new repConcurso(gbd::getConexion());
        $data = $rp->get_bandas($_GET['id']);
    
        // var_dump($data);
       echo json_encode($data);  
    }
?>