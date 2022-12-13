<?php
class Sesion

{   /**
        Devuelve true si se ha efectuado con éxito
        Y false en caso contrario
    */
    public static function iniciar():bool
    {
        return session_start();
    }

    /**
     * @param string Nombre del campo del array asociativo de SESION
     * @return any Valor del campo solicitado
     */
    public static function leer(string $clave)
    {
        return $_SESSION[$clave]; 
    }

    /**
     * @param string $clave Nombre o ID de la sesión
     * @return bool $existe Si existe=>TRUE, si NO=>FALSE
     */
    public static function existe(string $clave):bool
    {
        // A priori no existe
        $existe = false;
        // Si existe 
        if (isset($_SESSION[$clave])) {
            $existe = true;
        }
        return $existe;
    }

    /**
     * Escribe una propiedad en Sesion
     * La reescribe si ya existia
     * @param mixed clave: el indice (nombre de la propiedad)
     * @param mixed valor: el valor que queremos asignarle  
     */
    public static function escribir($clave,$valor):void
    {
        $_SESSION[$clave] = $valor;
    }

    public static function eliminar($clave)
    {
        // BORRAMOS LA SESIÓN
        unset($_SESSION[$clave]);        
    }
    public static function destruir():bool
    {
        // DESTRUIMOS LA SESIÓN
        return session_destroy();
    }
}