<?php
    if (!is_null(Sesion::leer('user'))) {
        # cogemos el usuario
        $usuario = Sesion::leer('user');
        echo $usuario->getNombreCompleto();
    }else {
        #Si no está logeado lo mandamos al index
        header("Location:?menu=inicio");
    }
?>