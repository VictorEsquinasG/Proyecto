<?php
    require_once('../Chargers/autoloader.php');

    # TODO
    // if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    //     # quiere editar
    //     $body = file_get_contents("php://input");   
    // }

    $id = $_POST['id'];

    $rp = new repBanda(gbd::getConexion());
    $banda = new Banda();

    $banda->rellenaBanda(null,$_POST['nombre'],$_POST['distancia'],$_POST['minimo'],$_POST['maximo']);
    $rep = new repBanda(gbd::getConexion());
    echo json_encode($rep->update($id,$banda));
    
?>