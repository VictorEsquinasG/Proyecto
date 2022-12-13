<?php
class GBD
{
    /* La variable CONEXION */
    private static $con;

    /**
     * Devuelve la conexión 
     * si no existe, la crea primero
     *
     * @return PDO conexión
     */
    public static function getConexion(): PDO
    {
        if (!isset($con)) {
            // Nuestra Base de Datos
            $dsn = "mysql" . ":host=" . 'localhost' . ";dbname=" . 'Proyecto1' . ";charset=utf8";
            // Nuestro usuario y contraseña
            $user = 'root';
            $pass = '';
            try {
                self::$con = new PDO(
                    $dsn,
                    $user,
                    $pass,
                    array(
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                    )
                );
            } catch (PDOException $e) {
                throw new PDOException("Error en la conexión: " . $e->getMessage());
            }
        }
        return self::$con;
    }
}
