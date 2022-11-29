<?php
    require_once('../Chargers/autoloader.php');

    $rp = new repConcurso(gbd::getConexion());
    $data = $rp->getAll();

    // var_dump($data);
   echo json_encode($data);  
?>