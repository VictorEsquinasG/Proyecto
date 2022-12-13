<?php
    require_once('../Chargers/autoloader.php');
    $id = $_GET['id'];

    Sesion::iniciar();
    if (Sesion::existe('user') && Sesion::leer('user')->getRol('admin')) {
    # Sólo si tiene credenciales le permitimos utilizar la API
        $rep = new repModo(gbd::getConexion());
        echo json_encode($rep->delete($id));
    }

?>