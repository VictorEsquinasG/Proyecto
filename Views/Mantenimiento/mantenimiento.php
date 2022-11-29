<?php
// Entramos en la sesión
Sesion::iniciar();
// Si es un administrador le dejamos entrar
if ( (Sesion::existe('rol')) && (Sesion::leer('rol') === 'admin')) {
    echo ("<h1 class='g--font-size-5l'> Mantenimiento</h1>");
}else {
    // Si no es administrador, lo redireccionamos a la página principal
    Header("Location:?menu=inicio");
}

?>
<div class="c-panel">

</div>
