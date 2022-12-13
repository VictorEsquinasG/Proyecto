<?php
    require_once('../Chargers/autoloader.php');
    $id = $_GET['id'];

    Sesion::iniciar();
    if (Sesion::existe('user') && Sesion::leer('user')->getRol('admin')) {
        # Sólo si tiene credenciales le permitimos utilizar la API
        $rep = new repBanda(gbd::getConexion());
        $devolver = json_encode($rep->delete($id));

        return $devolver;
    }
?>