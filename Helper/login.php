<?php
class Login
{
    /**
     * Comprueba si existe un usuario e inicia su sesión
     * @return bool Devuelve true si existe y false si no existe
     */
    public static function Identifica(string $usuario,string $contrasena,bool $recuerdame):bool
    {
        $user = Login::ExisteUsuario($usuario, $contrasena);
        if (!is_null($user)) {
            # 
            if ($recuerdame) //Si ha marcado RECUERDAME le guardamos sus credenciales en una COOKIE
            {
                setcookie("recuerdame[bool]",true,time()+2630000); //Caducidad = 30 días
                setcookie("recuerdame[user]",$usuario,time()+2630000);
                setcookie("recuerdame[pass]",$contrasena,time()+2630000);
            } 
            // Guardamos su mail y su rol
            Sesion::escribir('user', $user);
            Sesion::escribir('rol', $user->getRol());
            return true;
        }else{
            return false;
        }
    }

    private static function ExisteUsuario(string $usuario,string $contrasena=null):Usuario | null
    {
        # A priori no existe el usuario
        $existe = null;
        # Pasamos las comprobaciones
        $rp = new repUsuarios(gbd::getConexion());
        # Preparamos el Array asociativo que necesita el FindByOne => array[nombreCol] = valor;
        $nombre['email'] = $usuario;
        $iden['indicativo'] = $usuario;

        if (!is_null($us = $rp->findByOne($nombre))) {
            $user = $us;
        }else {
            $us2 = $rp->findByOne($iden);
            $user = $us2;
        }
        
         
        # Si el usuario existe con el mismo identificativo/mail y la misma contraseña
        if (
            (!is_null($user) && (($user->getPssword() === $contrasena)))
        ) {
            $existe = $user;
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