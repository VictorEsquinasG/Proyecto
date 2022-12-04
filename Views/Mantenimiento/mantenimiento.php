<?php
// Entramos en la sesión
Sesion::iniciar();
// Si es un administrador le dejamos entrar
if ((Sesion::existe('user')) && (Sesion::leer('user')->getRol() === 'admin')) {
    echo ("<h1 class='g--font-size-5l'> Mantenimiento</h1>");
} else {
    // Si no es administrador, lo redireccionamos a la página principal
    header("Location:?menu=inicio");
}

?>
<article class="c-mantenimiento">
    <div class="c-card" style="width: 18rem;">
        <img src="./images/perfil.png" width="100px" class="c-card__img" alt="...">
        <div class="c-card__body">
            <h5 class="c-card__title">Modos</h5>
            <p class="c-card__desc">
                Edición de todos los modos
            </p>
            <a href="?menu=modo" class="c-card__btn c-card__btn--primary">Editar</a>
        </div>
    </div>
    <div class="c-card" style="width: 18rem;">
        <img src="./images/perfil.png" width="100px" class="c-card__img" alt="...">
        <div class="c-card__body">
            <h5 class="c-card__title">Bandas</h5>
            <p class="c-card__desc">
                Edición de todas las bandas
            </p>
            <a href="?menu=banda    " class="c-card__btn c-card__btn--primary">Editar</a>
        </div>
    </div>
    <div class="c-card" style="width: 18rem;">
        <img src="./images/perfil.png" width="100px" class="c-card__img" alt="...">
        <div class="c-card__body">
            <h5 class="c-card__title">Mensajes</h5>
            <p class="c-card__desc">
                Edición de todos los mensajes
            </p>
            <a href="?menu=mensaje    " class="c-card__btn c-card__btn--primary">Editar</a>
        </div>
    </div>
    <div class="c-card" style="width: 18rem;">
        <img src="./images/perfil.png" width="100px" class="c-card__img" alt="...">
        <div class="c-card__body">
            <h5 class="c-card__title">Concursos</h5>
            <p class="c-card__desc">
                Edición de todos los concursos
            </p>
            <a href="?menu=concurso    " class="c-card__btn c-card__btn--primary">Editar</a>
        </div>
    </div>
</article>