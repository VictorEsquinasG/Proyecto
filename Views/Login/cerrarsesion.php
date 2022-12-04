<?php
if (isset($_COOKIE['recuerdame'])) {
    # Eliminamos la cookie
    setcookie('recuerdame',Sesion::leer('user')->getRol(),time()-10);
    setcookie('recuerdame',Sesion::leer('pass'),time()-10);
    setcookie('recuerdame',Sesion::leer('bool'),time()-10);
}
Sesion::eliminar('user');
header("location:?menu=inicio");
?>