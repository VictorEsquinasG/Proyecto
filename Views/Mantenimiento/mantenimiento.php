<?php
$admin = Sesion::existe('user') && Sesion::leer('user')->getRol() === 'admin';
// Si es un administrador le dejamos entrar
if ((Sesion::existe('user')) && ($admin)) {
    echo ("<h1 class='g--font-size-5l'> Mantenimiento</h1>");
} else {
    // Si no es administrador, lo redireccionamos a la página principal
    header("Location:?menu=inicio");
}

?>
<article class="c-mantenimiento">
    <div class="l-bloque--m">
        <div id="mantModo" class="c-card c-card--mant" style="width: 20rem; height:15rem; margin-bottom:20px;">
            <img src="./images/ajustamiento.png" class="c-card__img c-card--mant__img" alt="...">
            <div class="c-card__body">
                <h5 class="c-card__title c-card--mant__title">Modos</h5>
                <p class="c-card__desc">
                    Edición de todos los modos
                </p>
                <!-- <a href="?menu=modo" class="c-card__btn c-card__btn--primary">Editar</a> -->
            </div>
        </div>
        <div id="mantBanda" class="c-card c-card--mant" style="width: 20rem; height:15rem; margin-bottom:20px;">
            <img src="./images/podcast.png" width="100px" class="c-card__img c-card--mant__img" alt="...">
            <div class="c-card__body">
                <h5 class="c-card__title c-card--mant__title">Bandas</h5>
                <p class="c-card__desc">
                    Edición de todas las bandas
                </p>
                <!-- <a href="?menu=banda" class="c-card__btn c-card__btn--primary">Editar</a> -->
            </div>
        </div>
    </div>
    <div class="l-bloque--m">
        <div id="mantQso" class="c-card c-card--mant" style="width: 20rem; height:15rem; margin-bottom:20px;">
            <img src="./images/conversacion.png" width="100px" class="c-card__img c-card--mant__img" alt="...">
            <div class="c-card__body">
                <h5 class="c-card__title c-card--mant__title">Mensajes</h5>
                <p class="c-card__desc">
                    Edición de todos los mensajes
                </p>
                <!-- <a href="?menu=mensaje" class="c-card__btn c-card__btn--primary">Editar</a> -->
            </div>
        </div>
        <div id="mantConcurso" class="c-card c-card--mant" style="width: 20rem; height:15rem; margin-bottom:20px;">
            <img src="./images/trophey.png" width="100px" class="c-card__img c-card--mant__img" alt="...">
            <div class="c-card__body">
                <h5 class="c-card__title c-card--mant__title">Concursos</h5>
                <p class="c-card__desc">
                    Edición de todos los concursos
                </p>
                <!-- <a href="?menu=concurso" class="c-card__btn c-card__btn--primary">Editar</a> -->
            </div>
        </div>
    </div>
</article>
<script src="./js/mantenimiento.js"></script>