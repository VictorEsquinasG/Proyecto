<?php

class repParticipacion {

    private PDO $conexion;

    public function __construct($con)
    {
        $this->conexion = $con;
    }
    /**
     * Get el valor de conexion
     */
    public function getConexion()
    {   //Clonamos la variable a devolver
        $aux = $this->conexion;
        return $aux;
    }

    public function getParticipantes($id):array
    {
        # El array de participantes
        $participantes = [];
        $sql = "SELECT p.participante_id FROM concurso c 
        JOIN participacion p ON p.concurso_id = c.id
        WHERE c.id LIKE $id";
        try {
            $consulta = $this->conexion->query($sql);
            $dato = $consulta->fetchAll(PDO::FETCH_ASSOC);

            for ($i=0; $i < count($dato); $i++) { 
                # Añadimos
                $idParticipacion = $dato[$i]['participante_id'];
                $participantes[] = $idParticipacion;
            }
            
        } catch (PDOException $th) {
            echo "Error al obtener los participantes del concurso $id". $th;
        }
        return $participantes;
    }

    public function set(Participacion $part):int | false
    {
        $rol = $part->getRol();
        $concurso = $part->getId_concurso();
        $usuario = $part->getId_usuario(); 
        # Preparamos el insert
        $sql = "INSERT INTO participacion VALUES (null,'$rol',$concurso,$usuario)";

        try {
            // Realizamos la operación
            $result = $this->conexion->exec($sql);
            return $result;
        } catch (PDOException $th) {
            echo "Error al insertar Participación: " .$th;
        }
    }
    public function getById($id): Participacion
    {
        $sql = "select * FROM participacion 
        WHERE id = $id ";

        try {
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $id = $datos[0]['id'];
            $rol = $datos[0]['rol'];
            $concurso = $datos[0]['concurso_id'];
            $participante = $datos[0]['participante_id'];

            $participacion = new Participacion();
            $participacion->rellenaParticipacion($id, $rol, $concurso,$participante);

            return $participacion;
        } catch (PDOException $e) {
            throw new PDOException("Error leyendo por clave primaria: " . $e->getMessage());
        }
    }
}