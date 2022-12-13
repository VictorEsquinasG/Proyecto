<?php
    require_once('../Chargers/autoloader.php');

    # TODO
    // if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    //     # quiere editar
    //     $body = file_get_contents("php://input");   
    // }

    Sesion::iniciar();
    if (Sesion::existe('user') && Sesion::leer('user')->getRol('admin')) {
        # Sólo si tiene credenciales le permitimos utilizar la API
        $id = $_POST['id'];
    
        $rp = new repModo(gbd::getConexion());
        $modo = new Modo();
    
        $modo->rellenaModo(null,$_POST['nombre']);
        $rep = new repModo(gbd::getConexion());
        $devolver = json_encode($rep->update($id,$modo));
    
        return $devolver;
    }
    
?>