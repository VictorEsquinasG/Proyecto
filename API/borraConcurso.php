<?php
    require_once('../Chargers/autoloader.php');
    $id = $_POST['id'];

    $rep = new repConcurso(gbd::getConexion());
    $devolver = json_encode($rep->delete($id));

    return $devolver;
?>