<?php
    require_once('../Chargers/autoloader.php');
    $id = $_GET['id'];

    $rep = new repBanda(gbd::getConexion());
    $devolver = json_encode($rep->delete($id));

    return $devolver;
?>