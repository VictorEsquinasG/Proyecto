<?php
    echo "<script src='./js/profpic.js'></script>";
    echo "<script src='./js/capturaGPS.js'></script>";
?>
<main id="registro">
    <div class="c-registro">
        <h2>Registrarse</h2>
        <form>
            <div class="c-registro__contenedor">
                <div class="c-registro__user">
                    <label for="usuario">Indicativo</label>
                    <input type="text" name="usuario">
                    <label for="mail">Correo electrónico</label>
                    <input type="text" name="mail">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" name="contrasena">
                </div>
                <div class="c-registro__img" id="btnImg" onclick="getFile()">
                    <label for="imagen" class="img">
                        <i class="fa fa-cloud-upload"></i> 
                        Imágen de perfil
                    </label>
                    <input type="file" name="imagen" id="inpFile">
                </div>
                <div class="c-registro__ubi">
                    <label for="lat">Latitud</label>
                    <input type="number" name="lat">
                    <label for="lon">Longitud</label>
                    <input type="number" name="lon">
                </div>
                <div class="c-registro__Contbtn">
                    <button class="c-registro__Contbtn__btn--submit" onclick="capturar()">Usar ubicación actual</button>
                </div>
                <!-- <hr> -->
                <div>
                    <a href="" class="c-registro__btn--submit">Crear cuenta</a>
                </div>
            </div>

        </form>
    </div>
</main>