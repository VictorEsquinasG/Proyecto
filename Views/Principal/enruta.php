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
    }else if ($_GET['menu'] == "modo") {
        require_once './Views/Mantenimiento/modos.php';
    }else if ($_GET['menu'] == "banda") {
        require_once './Views/Mantenimiento/bandas.php';
    }else if ($_GET['menu'] == "concurso") {
        require_once './Views/Mantenimiento/concursos.php';
    }else if ($_GET['menu'] == "edicion") {
        require_once './Views/Mantenimiento/edicion.php';
    }else if ($_GET['menu'] == "bconcurso") {
        require_once     './Views/Mantenimiento/borrado.php'; //?id='.$_GET['id'].'&q=concurso';
    }else if ($_GET['menu'] == "bmensaje") {
        require_once './Views/Mantenimiento/borrado.php'; //?id='.$_GET['id'].'&q=mensaje';
    }else if ($_GET['menu'] == "mensaje") {
        require_once './Views/Mantenimiento/mensaje.php';
    }else if ($_GET['menu'] == "editar") {
        require_once './Views/Mantenimiento/editaConcurso.php';
    }else if ($_GET['menu'] == "registrate") {
        require_once './Views/default/registra.php';
    }else if ($_GET['menu'] == "alta") {
        require_once './Views/Mantenimiento/alta.php';
    }else if ($_GET['menu'] == "creaConcurso") {
        require_once './Views/Mantenimiento/creaConcurso.php';
    }
    
    
}else if (isset($_GET['concurso'])) {
    # Cargamos el concurso que sea
    // setcookie('id',$_GET['concurso']);
    require_once './Views/Mantenimiento/concurso.php';#.'?id='.$_GET['concurso'];
}else if (isset($_GET['mail'])) {
    # Le mandamos el correo
    require_once './mail/mail.php';
}
else {
    # Si no ha introducido ninguna ruta lo enviaremos a Index
    require_once './Views/default/body.php';
}

    
    //Añadir otras rutas
