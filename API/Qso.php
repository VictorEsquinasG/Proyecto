<?php

require_once('../Chargers/autoloader.php');
    
    $rp = new repQSO(gbd::getConexion());
    $rpP = new repParticipacion(gbd::getConexion());

    Sesion::iniciar();
    $id = Sesion::leer('user')->getId();  
    $parti = $rpP->get($_POST['concurso'],$id)->getId();

    $msg = new QSO();
    $msg->rellenaQSO(null,$parti,$_POST['concurso'],$_POST['modo'],$_POST['banda'],$_POST['juez'],$_POST['time']);

    $hecho = $rp->set($msg);
