<?php

require_once('../Chargers/autoloader.php');
    
    $rp = new repQSO(gbd::getConexion());
    $rpP = new repParticipacion(gbd::getConexion());

    Sesion::iniciar();
    $id = Sesion::leer('user')->getId();  
    $parti = $rpP->get($_GET['concurso'],$id)->getId();
    $msg = $rp->getMsg($_GET['concurso'],$parti);

return json_encode($msg);