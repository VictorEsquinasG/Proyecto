<?php
    require_once('../Chargers/autoloader.php');
    
    $rp = new repModo(gbd::getConexion());

    $hecho = $rp->set($_POST['nombre']);

    return json_encode($hecho);