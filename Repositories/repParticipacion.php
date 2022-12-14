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
    public function getJueces($id):array
    {
        # El array de participantes
        $participantes = [];
        $sql = "SELECT p.participante_id FROM concurso c 
        JOIN participacion p ON p.concurso_id = c.id
        WHERE p.rol LIKE 'juez' AND c.id LIKE $id";
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

    public function get($idConcurso,$idParticipante)
    {
        $par = new Participacion();
        # Encontramos la participación
        $sql = "SELECT * FROM participacion WHERE concurso_id LIKE $idConcurso AND participante_id LIKE $idParticipante";
        try {
            $consulta = $this->conexion->query($sql);
            $data = $consulta->fetchAll(PDO::FETCH_ASSOC);
            # cogemos todas las columnas
            foreach ($data as $dat) {
                # Nos quitamos de poner $data[0]
                $id = $dat['id'];
                $rol = $dat['rol'];
                $con = $dat['concurso_id'];
                $part = $dat['participante_id'];
                $par->rellenaParticipacion($id,$rol,$con,$part);
            }
            return $par;
        } catch (PDOException $e) {
            echo "Error al buscar participación ".$e->getMessage();
        }
    }

    public function getNumJueces($id)
    {
        # Cogemos los jueces del concurso con ID dada
        $sql = "SELECT COUNT(id) FROM PARTICIPACION WHERE concurso_id LIKE $id AND rol LIKE 'juez'";
        try {
            $consulta = $this->conexion->query($sql);
            $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
            return $result[0];
        } catch (PDOException $e) {
            echo "Error al contar el nº de jueces de base de datos: ".$e->getMessage();
        }
    } 

    public function cuantos($id)
    {
        $sql = "SELECT COUNT(id) FROM PARTICIPACION WHERE concurso_id LIKE $id";
        try {
            $consulta = $this->conexion->query($sql);
            $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
            return $result[0];
        } catch (PDOException $e) {
            echo "Error al contar el nº de participantes de base de datos: ".$e->getMessage();
        }
    }

    public function delete($id)
    {
        # borramos según el id
        $sql = "DELETE FROM participacion WHERE id LIKE $id";
        $this->conexion->beginTransaction();
        $devolveer = $this->conexion->exec($sql);
        $this->conexion->commit();
        return $devolveer;
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