<?php
// Autocargador (para utilizar clases y repositorios)
require_once('../Chargers/autoloader.php');

// Iniciamos sesión y vemos si es admin (será necesario para ciertas funciones)
Sesion::iniciar();
$admin = Sesion::existe('user') && Sesion::leer('user')->getRol('admin');

# Repositorios para utilizar
$rp = new repModo(gbd::getConexion());
$rpC = new repConcurso(gbd::getConexion());

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    # Le devolvemos los MODOS
    if ($admin) {
        # Sólo si tiene credenciales le permitimos utilizar la API

        $hecho = $rpC->get_modos($_GET['id']);

        echo json_encode($hecho);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    # quiere editar
    if ($admin) {
        # Sólo si tiene credenciales le permitimos utilizar la API
        $data = file_get_contents("php://input", "r");
        $info = json_decode($data);

        $id = $info->id;
        $nombre = $info->nombre;

        $modo = new Modo();
        $modo->rellenaModo(null, $nombre);

        $rp->update($id, $modo);

    }
} else if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    # Quiere borrar
    $data = file_get_contents("php://input", "r");
    $info = json_decode($data);

    // El id
    $id = $info->id;
 
    if ($admin) {
        # Sólo si tiene credenciales le permitimos utilizar la API
        $rp->delete($id);
    }
} else if ($_SERVER['REQUEST_METHOD'] === "POST") {
    # Quiere crear
    if ($admin) {
        # Sólo si tiene credenciales le permitimos utilizar la API
        $rp->set($_POST['nombre']);
    }
}
