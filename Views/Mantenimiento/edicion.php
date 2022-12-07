<?php
if (!is_null(Sesion::leer('user'))) {
    # cogemos el usuario
    $usuario = Sesion::leer('user');

    print "<div class='c-contConcurso'>";
    print "<div class='c-contConcurso__h'>";
    echo "<h1 class='g--font-size-4l'>Usuario: " . $usuario->getNombreCompleto() . "</h1>";
    if ($usuario->getImg() != null) {
        # Si tiene imagen se la imprimimos
        echo "<img src='data:image/png;base64," . $usuario->getImg() . "'>";
    }
} else {
    #Si no está logeado lo mandamos al index
    header("Location:?menu=inicio");
}
?>
<section id="registro">
    <div class="c-registro">
        <form action="">
            <div class="c-registro__contenedor">
                <div class="c-registro__img">
                    <?php
                        #TODO si tiene cámara
                        print '<video id="video" width="220" height="140" autoplay></video>';
                        print '<canvas id="canvas" width="220" height="140"></canvas>';
                        print '<button id="btnFoto">Echar Foto</button>';
                    ?>
                    <img id="foto" width="150">
                    <div id="btnImg">
                        <label for="imagen" class="img">
                            <i class="fa fa-cloud-upload"></i>
                            Imagen de perfil
                        </label>
                        <input type="file" name="imagen" id="inpFile">
                    </div>
                    <input type="submit" value="Cambiar imágen" class="c-card__btn c-btn--primary__form">
                </div>
            </div>
        </form>
    </div>
</section>
<script src="./js/camara.js"></script>
<script src="./js/profpic.js"></script>