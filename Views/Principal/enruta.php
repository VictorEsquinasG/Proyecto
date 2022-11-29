<?php
if (isset($_GET['menu'])) {
    if ($_GET['menu'] == "inicio") {
        require_once './Views/default/body.php';
    }else if ($_GET['menu'] == "login") {
        require_once './Views/Login/autentifica.php';
    }else if ($_GET['menu'] == "cerrarsesion") {
        require_once './Views/Login/cerrarsesion.php';
    }else if ($_GET['menu'] == "mantenimiento") {
        require_once './Views/mantenimiento/mantenimiento.php';
    }else if ($_GET['menu'] == "listadoparticipantes") {
        // Nos lleva a listadoUsuarios => Si eres admin podrás ver TODOS los usuarios participantes o no
        // Si eres sólo un usuario normal => Podrás ver el listado de participantes del mismo concurso en el que estés
        require_once './Views/Mantenimiento/listadousuarios.php';
    }else if ($_GET['menu'] == "listadoconcursos") {
        require_once './Views/Mantenimiento/listadoconcursos.php';
    }else if ($_GET['menu'] == "regist") {
        require_once './Views/Login/registro.php';
    }

    

    
}

    
    //Añadir otras rutas
