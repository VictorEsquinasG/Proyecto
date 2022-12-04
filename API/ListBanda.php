<?php
    require_once('../Chargers/autoloader.php');

    $rp = new repConcurso(gbd::getConexion());
    $data = $rp->get_bandas($_GET['id']);

    // var_dump($data);
   echo json_encode($data);  
?>