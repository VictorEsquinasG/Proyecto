<?php
require_once('../Chargers/autoloader.php');
    
$rp = new repConcurso(gbd::getConexion());

$hecho = $rp->get_bandas($_GET['id']);

echo json_encode($hecho);