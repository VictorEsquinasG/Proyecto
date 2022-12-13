<?php
//  PHP genérico que según qué queramos borrar

$admin = Sesion::existe('user') && Sesion::leer('user')->getRol() === 'admin';
if (!$admin) {
    # No está autorizado
    header("Location:?menu=registrate");
}

$que = $_GET['q'];
$id = $_GET['id'];
// $sql = "DELETE FROM ? WHERE id LIKE ?";

switch ($que) {
        # le asignamos la tabla de la que borrar
    case 'concurso':
        $r = new repConcurso(gbd::getConexion());
        $r->delete($id);
        $url = "?menu=listadoconcursos";
        break;
        case 'mensaje':
            $r = new repQSO(gbd::getConexion());
            $r->delete($id);
            $url = "?menu=  mensajes";
        break;
    default:
        // Vuelve a la página principal
        $url = "?menu=inicio";
        break;
}

header("Location:".$url);