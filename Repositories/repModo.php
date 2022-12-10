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
        try {
            // Intentamos borrar
            $this->conexion->beginTransaction();
            $devolveer = $this->conexion->exec($sql);
            $this->conexion->commit();
        } catch (PDOException $e) {
            echo "Error borrando modo de Base de datos ".$e->getMessage();
        }
        return $devolveer;
    }

    public function getById($id): Modo
    {
        $sql = "select * FROM modo 
        WHERE id = $id ";

        try {
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $nombre = $datos[0]['nombre'];

            $modo = new Modo();
            $modo->rellenaModo($id, $nombre);

            return $modo;
        } catch (PDOException $e) {
            throw new PDOException("Error leyendo por clave primaria: " . $e->getMessage());
        }
    }

    public function update($id, Modo $modo)
    {
        // # Cogemos el modo a editar
        // $mod = $this->getById($id);

        $nombre = $modo->getNombre();
        # Cambiamos sus campos
        $sql = "UPDATE modo SET `nombre`='$nombre' WHERE id LIKE $id";
        try {
            $this->conexion->beginTransaction();
            $this->conexion->exec($sql);
            $this->conexion->commit();
        } catch (PDOException $e) {
            echo "Error al actualizar modo en base de datos ".$e->getMessage();
        }
    }
}