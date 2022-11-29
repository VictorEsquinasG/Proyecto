<?php
/* SI PULSÓ RECUERDAME EN ESTE DISPOSITIVO HACE MÁX 30 DÍAS */

if (isset($_COOKIE['recuerdame'])) {
    Login::Identifica($_COOKIE['recuerdame']['user'],$_COOKIE['recuerdame']['pass'],true);
    header("Location:?menu=inicio");
}
$valida = new Validacion();
if (isset($_POST['submit'])) {
    $valida->Requerido('usuario');
    $valida->Requerido('contrasena');
    //Comprobamos validacion
    if ($valida->ValidacionPasada()) {
        if (Login::Identifica(
            $_POST['usuario'],
            $_POST['contrasena'],
            isset($_POST['recuerdame']) ? $_POST['recuerdame'] : false
        )) {
            $url = $_GET['returnurl'];
            header("location:?menu=" . $url);
        }
    }
}

?>

        <!-- HECHO DE 0 -->
        <div class="c-login__cajaLogin">
            <h2 class="">ENTRAR</h2>
            <form action="">
                <div class="c-login__user">
                    <input type="text" required="" name="usuario">
                    <label for="usuario">Identificativo / mail</label>
                    <?= $valida->ImprimirError('usuario') ?>    
                </div>
                <div class="c-login__user">
                    <input type="password" name="contrasena" id="" required="">
                    <label for="contrasena">Contraseña</label>
                    <?= $valida->ImprimirError('contrasena') ?>
                </div>
                <div class="c-login__recuerdame">
                    <input type="checkbox" name="recuerdame" id="">
                    <label for="recuerdame">RECORDAR ESTE DISPOSITIVO</label>
                </div> <br>

                <div class="c-login__btn">

                    <a href="#" class="c-login__btn--submit">Iniciar Sesión</a>

                    <div class="c-login__Registrarse">
                        ¿No tienes una cuenta? 
                        <!-- Para registrarse por primera vez -->
                        <a href="index.php?menu=regist">Registrarme</a>
                    </div>

                </div>
            </form>
        </div>

        <!-- YA DADO -->
        <!-- <div class='login-form'>
            <form action='' method='post' novalidate>
                <h2 class='text-center'>Identificate</h2>
                <div class='form-group'>
                    <input type='text' class='form-control' name='usuario' placeholder='Usuario' required='required'>
                </div>
                <div class='form-group'>
                    <input type='password' class='form-control' name='contrasena' placeholder='Contraseña' required='required'>
                </div>
                <div class='form-group'>
                    <button type='submit' name='submit' class='btn btn-primary btn-block'>Logueate</button>
                </div>
                <div class='clearfix'>
                    <label class='pull-left checkbox-inline'>
                        <input type='checkbox' name='recuerdame'> Recuerdame</label>
                </div>
            </form>
            <p class='text-center'><a href='#'>Crear una Cuenta</a></p>
        </div> -->
        <div>

        </div>
