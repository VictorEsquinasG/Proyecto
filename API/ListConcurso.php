<?php
    require_once('../Chargers/autoloader.php');

    Sesion::iniciar();
    if (Sesion::existe('user')) {
        # Sólo si tiene credenciales le permitimos utilizar la API
        $rp = new repConcurso(gbd::getConexion());
        $data = $rp->getAll();
    
        // var_dump($data);
       echo json_encode($data);  
    }
?>