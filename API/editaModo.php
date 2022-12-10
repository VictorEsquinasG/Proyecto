<?php
    require_once('../Chargers/autoloader.php');

    # TODO
    // if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    //     # quiere editar
    //     $body = file_get_contents("php://input");   
    // }

    $id = $_POST['id'];

    $rp = new repModo(gbd::getConexion());
    $modo = new Modo();

    $modo->rellenaModo(null,$_POST['nombre']);
    $rep = new repModo(gbd::getConexion());
    $devolver = json_encode($rep->update($id,$modo));

    return $devolver;
    
?>