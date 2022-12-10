<?php
    require_once('../Chargers/autoloader.php');
    $id = $_GET['id'];

    $rep = new repModo(gbd::getConexion());
    echo json_encode($rep->delete($id));

?>