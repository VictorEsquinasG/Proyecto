<?php

require_once('../Chargers/autoloader.php');
    
    $rp = new repQSO(gbd::getConexion());
    $rpP = new repParticipacion(gbd::getConexion());

    $parti = $rpP->get($_POST['concurso'],$_POST['usuario'])->getId();

    $msg = new QSO();
    $msg->rellenaQSO(null,$parti,$_POST['concurso'],$_POST['modo'],$_POST['banda'],$_POST['juez'],$_POST['time']);

    $rp->set($msg);
