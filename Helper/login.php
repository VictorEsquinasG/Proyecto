<?php
class Login
{
    public static function Identifica(string $usuario,string $contrasena,bool $recuerdame)
    {
        $valida = new Validacion();
        $valida->Requerido($usuario);
        $valida->Requerido($contrasena);

        if ( Login::ExisteUsuario($usuario, $contrasena)) {
            
            # 
            if ($recuerdame) //Si ha marcado RECUERDAME le guardamos sus credenciales en una COOKIE
            {
                setcookie("recuerdame[bool]",true,time()+2630000); //Caducidad = 30 días
                setcookie("recuerdame[user]",$usuario,time()+2630000);
                setcookie("recuerdame[pass]",$contrasena,time()+2630000);
            } 
            Sesion::iniciar();
            // Encontramos al usuario
            $rp = new repUsuarios(gbd::getConexion());
            $campovalor = ['email',$usuario];
            $user = $rp->findByOne($campovalor);
            // Guardamos su mail y su rol
            Sesion::escribir('user', $user['email']);
            Sesion::escribir('rol', $user['rol']);
        }
    }

    private static function ExisteUsuario(string $usuario,string $contrasena=null):bool
    {
        # A priori no existe el usuario
        $existe = false;
        # Pasamos las comprobaciones
        $rp = new repUsuarios(gbd::getConexion());
        # Preparamos el Array asociativo que necesita el FindByOne => array[nombreCol] = valor;
        $nombre['Nombre'] = $usuario;
        $us = $rp->findByOne($nombre);
        # Si el usuario existe con el mismo nombre y la misma contraseña
        if (!is_null($us) && $us->getPssword() === $contrasena) {
            $existe = true;
        }
        return $existe;
    }

    public static function UsuarioEstaLogueado()
    {
        if ($_COOKIE['recuerdame']) {
            Sesion::iniciar();
            Sesion::escribir('login',$_COOKIE['recuerdame[user]']);
        }
    }
}