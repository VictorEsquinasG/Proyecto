<?php

class repDiploma
{
    /* PROPIEDADES */
    private PDO $conexion;

    /* CONSTRUCTOR */
    public function __construct($con)
    {
        $this->setConexion($con);
    }

    /* GETTERS & SETTERS */

    /**
     * Set el valor de conexion
     *
     * @return  self
     */
    public function setConexion($conexion)
    {   // Usamos una variable auxiliar para no asignar una direccion de memoria de un objeto manejable
        $aux = $conexion;
        $this->conexion = $aux;
        return $this;
    }

    /* MÉTODOS */
    /**
     * Devuelve el registro con clave primaria
     *
     * @param array $id valores de la id
     * @return void
     */
    public function getById($id)
    {
        $sql = "select * FROM diploma WHERE id = $id";

        try {
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $diplomaArray['id'] = $datos[0]['id'];
            $diplomaArray['concurso_id'] = $datos[0]['concurso_id'];
            $diplomaArray['nombre'] = $datos[0]['nombre'];
            $diplomaArray['min'] = $datos[0]['minimo'];
            $diplomaArray['categoria'] = $datos[0]['categoria'];
            $diplomaArray['imagen'] = $datos[0]['imagen'];

            $diploma = new Diploma();
            $diploma->rellenaDiplomaArray($diplomaArray);

            return $diploma;
        } catch (PDOException $e) {
            throw new PDOException("Error leyendo por clave primaria: " . $e->getMessage());
        }
    }

    /**
     * Devuelve el registro con clave primaria
     *
     * @param array $id valores de la id
     * @return void
     */
    public function getByIdConcurso($id)
    {
        $sql = "select * FROM diploma WHERE concurso_id = $id";

        try {
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $diplomaArray['id'] = $datos[0]['id'];
            $diplomaArray['concurso_id'] = $datos[0]['concurso_id'];
            $diplomaArray['nombre'] = $datos[0]['nombre'];
            $diplomaArray['min'] = $datos[0]['minimo'];
            $diplomaArray['categoria'] = $datos[0]['categoria'];
            $diplomaArray['imagen'] = $datos[0]['imagen'];

            $diploma = new Diploma();
            $diploma->rellenaDiplomaArray($diplomaArray);

            return $diploma;
        } catch (PDOException $e) {
            throw new PDOException("Error leyendo por clave primaria: " . $e->getMessage());
        }
    }

    
}
