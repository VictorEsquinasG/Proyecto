<?php
require_once('../Chargers/autoloader.php');
    
$rp = new repConcurso(gbd::getConexion());

$hecho = $rp->getJueces($_GET['id']);

echo json_encode($hecho);