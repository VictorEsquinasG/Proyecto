<?php
/* Cargamos los scripts */
echo "<script src='./js/helper/profpic.js'></script>";
echo "<script src='./js/helper/camara.js'></script>";
echo "<script src='./js/helper/capturaGPS.js'></script>";

if (isset($_COOKIE['recuerdame'])) {
    # Si ya se logueó
    header("Location:?menu=inicio");
}
$valida = new Validacion();
// Si el formulario se ha enviado
if (isset($_POST['submit'])) {
    $valida->Requerido('usuario');
    $valida->Patron('usuario',"/^[A-Z]{1,2}[0-9][A-Z]{1,3}$/");
    $valida->Requerido('mail');
    $valida->Email('mail');
    $valida->Requerido('contrasena');
    $valida->Requerido('lat');
    $valida->RealRango('lat',-90,90);
    $valida->RealRango('lon',-180,180);
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
           
            if (isset($_FILES['imagen']) && !empty($_FILES['imagen'])) {
                # le añadimos la imagen
                $imagen=file_get_contents($_FILES['imagen']['tmp_name']);
                $imagen=base64_encode($imagen);
                $user['img'] = $imagen;
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
            $rep->addUser($us) ;
            // iniciamos la sesion
            if (Login::Identifica($_POST['usuario'],$_POST['contrasena'],false)){
                // lo redireccionamos a la página principal
                header("Location:?menu=inicio") ;                
            }
            
        } catch (Exception $e) {
            echo "Error durante la creación del usuario: " . $e->getMessage();
        }
    }
    // echo "<script>console.log(".var_dump($user).")</script>";
}
// var_dump($user);

?>
<section id="registro">
    <div class="c-registro">
        <h2>Registrarse</h2>
        <form action="" method="POST" enctype="multipart/form-data">
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
                <!-- <div class="c-registro__img">
                    Hacer foto
                </div> -->
                <div class="c-registro__img">
                    <?php 
                        if (true) {
                            #TODO Si tiene cámara
                            print '<video id="video" width="220" height="140" autoplay></video>';
                            print '<canvas id="canvas" width="220" height="140"></canvas>';
                            print '<button id ="btnFoto">Echar Foto</button>';
                        }
                    ?>
                    <div id="btnImg">
                        <label for="imagen" class="img">
                            <i class="fa fa-cloud-upload"></i>
                            Imagen de perfil
                        </label>
                        <input type="file" name="imagen" id="inpFile">
                    </div>
                </div>
                <div class="c-registro__Contubi">
                    <div class="c-registro__ContUbi__ubi">
                        <!-- TODO si es detectable -->
                        <div id="btnCaptura">Usar mi ubicación</div>
                        <label for="lat">Latitud</label>
                        <input type="number" step=0.000000001 placeholder="0" id="lat" name="lat">
                        <?= $valida->ImprimirError('lat') ?>
                        <label for="lon">Longitud</label>
                        <input type="number" step=0.000000001 placeholder="0" id="lon" name="lon">
                        <?= $valida->ImprimirError('lon') ?>
                    </div>  
                    
                </div>
                <!-- <hr> -->
                <div style="grid-column:span 3"> <!-- Ocupa las 3 columnas para estar centrado -->
                    <input type="submit" name="submit" class="c-registro__btn--submit" id='btnCaptura' value="Crear Cuenta">
                </div>
            </div>

        </form>
    </div>
</section>