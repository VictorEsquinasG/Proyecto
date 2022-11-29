<?php

class repQSO
{
    /* PROPIEDADES */
    private PDO $conexion;


    /* CONSTRUCTOR */
    public function __construct($con)
    {
        $this->conexion = $con;
    }

    /* GETTERS & SETTERS */
    /**
     * Get el valor de conexion
     */
    public function getConexion()
    {   //Clonamos la variable a devolver
        $aux = $this->conexion;
        return $aux;
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
        $sql = "select * FROM QSO 
        WHERE id = $id ";

        try {
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $id = $datos[0]['id'];
            $participante = $datos[0]['participacion_id'];
            $banda = $datos[0]['banda_id'];
            $modo = $datos[0]['modo_id'];
            $hora = new DateTimeImmutable($datos[0]['hora']);
            $juez = $datos[0]['indicativo_juez'];          
            
            $QSO = new QSO();
            $QSO->rellenaQSO($id,$participante,$modo,$banda,$juez,$hora);

            return $QSO;
        } catch (PDOException $e) {
            throw new PDOException("Error leyendo por clave primaria: " . $e->getMessage());
        }
    }

}
