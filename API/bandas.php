<?php
// El autocargador
require_once('../Chargers/autoloader.php');

// Iniciamos sesión y vemos si es admin (será necesario para ciertas funciones)
Sesion::iniciar();
$admin = Sesion::existe('user') && Sesion::leer('user')->getRol('admin');

// Los repositorios que usaremos
$rp = new repBanda(gbd::getConexion());
$rpC = new repConcurso(gbd::getConexion());

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    # Si viene por GET quiere leer
    if ($admin) {
        # Sólo si tiene credenciales le permitimos utilizar la API
        $hecho = $rpC->get_bandas($_GET['id']);

        echo json_encode($hecho);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    # quiere editar
    $data = file_get_contents("php://input","r");
    $info = json_decode($data);
    
    if ($admin) {
        # Sólo si tiene credenciales le permitimos utilizar la API
        $id = $info->id;

        $banda = new Banda();

        $banda->rellenaBanda(null, $info->nombre, $info->distancia, $info->minimo, $info->maximo);
        $rp->update($id, $banda);
    }
} else if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    # Quiere borrar
    $data = file_get_contents("php://input","r");
    $info = json_decode($data);
    $id = $info->id;

    if ($admin) {
        # Sólo si tiene credenciales le permitimos utilizar la API
        $rp->delete($id);
    }
} else if ($_SERVER['REQUEST_METHOD'] === "POST") {
    # Quiere crear
    if ($admin) {
        # Sólo si tiene credenciales le permitimos utilizar la API
        $banda = new Banda();
        $banda->rellenaBanda(null, $_POST['nombre'], $_POST['distancia'], $_POST['minimo'], $_POST['maximo']);

        $rp->add($banda);
    }
}
