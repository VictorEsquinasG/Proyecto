<?php
    require_once('../Chargers/autoloader.php');

    $rp = new repUsuarios(gbd::getConexion());
    // $data = $rp->getPage(10,1);
    $data = $rp->getAll();

    // var_dump($data);    
   echo (json_encode($data, JSON_INVALID_UTF8_IGNORE));  
?>