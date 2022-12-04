<?php
/* Cargamos los scripts */
echo "<script src='./js/profpic.js'></script>";
echo "<script src='./js/capturaGPS.js'></script>";

if (isset($_COOKIE['recuerdame'])) {
    # Si ya se logueó
    header("Location:?menu=inicio");
}
$valida = new Validacion();

// Si el formulario se ha enviado
if (isset($_POST['submit'])) {
    $valida->Requerido('usuario');
    $valida->Patron('usuario',"[A-Z]{1,2}[0-9][A-Z]{1,3}");
    $valida->Requerido('mail');
    $valida->Email('mail');
    $valida->Requerido('contrasena');
    $valida->Requerido('lat');
    $valida->EnteroRango('lat','-90','90');
    $valida->EnteroRango('lon','-180','180');
    $valida->Requerido('lon');
    $valida->Requerido('nombre');
    $valida->Requerido('ap1');
    $valida->Requerido('ap2');

    if ($valida->ValidacionPasada()) {
        try {
            //Creamos el repositorio
            $rep = new repUsuarios(gbd::getConexion());
            //Recogemos los datos del formulario
            $user['id'] = null;
            $user['identificativo'] = $_POST['usuario'];
            $user['email'] = $_POST['mail'];
            $user['pssword'] = $_POST['contrasena'];
            $user['rol'] = 'user'; // Por defecto
            if (isset($_POST['inpFile']) && $_POST['inpFile'] != '') {
                # le añadimos la imagen
                $imagen=file_get_contents($_FILES['inpFile']['tmp_name']);
                $imagen=base64_encode($imagen);
                $user['img'] = $_POST['img'];
            } else {
                # la imagen es Null
                $user['img'] = null;
            }
            $user['gps'] = new Gps($_POST['lat'], $_POST['lon']);
            $user['nombre'] = $_POST['nombre'];
            $user['ap1'] = $_POST['ap1'];
            $user['ap2'] = $_POST['ap2'];
            //Creamos el usuario
            $us = new Usuario();
            $us->rellenaUsuarioArray($user);
            //Realizamos el insert
            if ($rep->addUser($us)) {
                Sesion::iniciar();
                Sesion::escribir("usuario", "$us");
                header("Location:?menu=inicio");
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
// var_dump($user);
echo "<script>console.log($user)</script>";

?>
<section id="registro">
    <div class="c-registro">
        <h2>Registrarse</h2>
        <form action="" method="POST">
            <div class="c-registro__contenedor">
                <div class="c-registro__txt">
                    <div class="c-registro__txt__user">
                        <label for="usuario">Indicativo</label>
                        <input type="text" placeholder='por ejemplo: "EA1SLD"' id="IdentificativoUsuario" name="usuario">
                        <?= $valida->ImprimirError('usuario') ?>
                        <label for="mail">Correo electrónico</label>
                        <input type="email" id="emailUsuario" name="mail">
                        <?= $valida->ImprimirError('mail') ?>
                        <label for="contrasena">Contraseña</label>
                        <input type="password" id="contrasenaUsuario" name="contrasena">
                        <?= $valida->ImprimirError('contrasena') ?>
                    </div>
                    <div class="c-registro__txt__user">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre">
                        <?= $valida->ImprimirError('nombre') ?>
                        <label for="ap1">1er apellido</label>
                        <input type="text" name="ap1">
                        <?= $valida->ImprimirError('ap1') ?>
                        <label for="ap2">2do apellido</label>
                        <input type="text" name="ap2">
                        <?= $valida->ImprimirError('ap2') ?>
                    </div>
                </div>
                <div class="c-registro__img">
                    Hacer foto
                </div>
                <div class="c-registro__img" id="btnImg" onclick="getFile()">
                    <label for="imagen" class="img">
                        <i class="fa fa-cloud-upload"></i>
                        Imagen de perfil
                    </label>
                    <input type="file" name="imagen" id="inpFile">
                </div>
                <div class="c-registro__Contubi">
                    <div class="c-registro__ContUbi__ubi">
                        <label for="lat">Latitud</label>
                        <input type="number" placeholder="0" id="newLatitud" name="lat">
                        <?= $valida->ImprimirError('lat') ?>
                        <label for="lon">Longitud</label>
                        <input type="number" placeholder="0" id="newLongitud" name="lon">
                        <?= $valida->ImprimirError('lon') ?>
                    </div>  
                    
                </div>
                <!-- <hr> -->
                <div style="grid-column:span 3"> <!-- Ocupa las 3 columnas para estar centrado -->
                    <input type="submit" class="c-registro__btn--submit" id='btnCaptura' value="Crear Cuenta">
                </div>
            </div>

        </form>
    </div>
</section>