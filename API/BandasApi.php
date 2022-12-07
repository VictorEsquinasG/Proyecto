<?php
    require_once('../Chargers/autoloader.php');
    
    $rp = new repBanda(gbd::getConexion());

    $banda = new Banda();
    $banda->rellenaBanda(null,$_POST['nombre'],$_POST['distancia'],$_POST['minimo'],$_POST['maximo']);

    $hecho = $rp->add($banda);

    return json_encode($hecho);