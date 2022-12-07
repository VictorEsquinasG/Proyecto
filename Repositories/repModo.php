<?php

class repModo
{
    /* PROPIEDADES */
    private PDO $conexion;

    /* CONSTRUCTOR */
    public function __construct($con)
    {
        $this->conexion = $con;
    }

    public function set($nombre)
    {
        # sql
        $sql = "INSERT INTO MODO VALUES (null,'$nombre')";
        try {
            return $this->conexion->exec($sql);
        } catch (PDOException $e) {
            echo "Error al insertar modo: ".$e->getMessage();
        }
    }
    public function delete($id)
    {
        # borramos según el id
        $sql = "DELETE FROM modo WHERE id LIKE $id";
        $this->conexion->beginTransaction();
        $devolveer = $this->conexion->exec($sql);
        $this->conexion->commit();
        return $devolveer;
    }
}