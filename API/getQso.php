<?php

require_once('../Chargers/autoloader.php');
    
    $rp = new repQSO(gbd::getConexion());
    $rpP = new repParticipacion(gbd::getConexion());

    Sesion::iniciar();
  
    if (Sesion::existe('user') && Sesion::leer('user')->getRol('admin')) {
        # Sólo si tiene credenciales le permitimos utilizar la API
        $id = Sesion::leer('user')->getId();  
        $parti = $rpP->get($_GET['concurso'],$id)->getId();
        $msg = $rp->getMsg($_GET['concurso'],$parti);
        return json_encode($msg);
    }
