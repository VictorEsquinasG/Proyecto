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
        $sql = "SELECT * FROM QSO 
        WHERE id LIKEw $id ";

        try {
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $id = $datos[0]['id'];
            $participante = $datos[0]['participacion_id'];
            $concurso = $datos[0]['concurso_id'];
            $banda = $datos[0]['banda_id'];
            $modo = $datos[0]['modo_id'];
            $hora = new DateTimeImmutable($datos[0]['hora']);
            $juez = $datos[0]['indicativo_juez'];

            $QSO = new QSO();
            $QSO->rellenaQSO($id, $participante, $concurso, $modo, $banda, $juez, $hora);

            return $QSO;
        } catch (PDOException $e) {
            throw new PDOException("Error leyendo por clave primaria: " . $e->getMessage());
        }
    }

    public function getMsg($idConcurso, $idParticipacion)
    {
        $mensajes = [];
        # buscamos los mensajes realizados por el concursante en dicho concurso
        $sql = "SELECT * FROM qso WHERE participacion_id LIKE $idParticipacion AND concurso_id LIKE $idConcurso";
        try {
            $this->conexion->beginTransaction();
            $consul = $this->conexion->query($sql);
            $data = $consul->fetchAll(PDO::FETCH_ASSOC);
            for ($i = 0; $i < count($data); $i++) {
                # formamos el mensaje
                $msg['id'] = $data[$i]['id'];
                $msg['id_participante'] = $data[$i]['participacion_id'];
                $msg['id_concurso'] = $data[$i]['concurso_id'];
                $msg['id_modo'] = $data[$i]['modo_id'];
                $msg['id_banda'] = $data[$i]['banda_id'];
                $msg['indicativo_juez'] = $data[$i]['indicativo_juez'];
                $msg['fecha'] = $data[$i]['hora'];
                $qso = new QSO();
                $qso->rellenaQSOArray($msg);
                # añadimos el mensaje al array
                $mensajes[] = $qso;
            }
            $this->conexion->commit();
            return $mensajes;
        } catch (PDOException $e) {
            echo "Error al buscar sus mensajes: " . $e->getMessage();
        }
    }

    public function getFrom($id_concurso)
    {
        $msgs = [];
        # todos los mensajes
        $sql = "SELECT * FROM qso WHERE concurso_id LIKE $id_concurso";

        try {
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            foreach ($datos as $msg) {
                # cada Mensaje se crea y se añade
                $qso = new QSO();
                $qso->rellenaQSO($msg['id'],$msg['participacion_id'],$msg['concurso_id'],$msg['modo_id'],$msg['banda_id'],$msg['indicativo_juez'],$msg['hora'],$msg['validado']);

                $msgs[] = $qso;
            }


            return $msgs;
        } catch (PDOException $e) {
            echo "Error leyendo mensajes de determinado concurso " . $e->getMessage();
        }
    }

    public function delete($id)
    {
        # borramos
        $sql = "DELETE FROM qso WHERE id LIKE $id";
        try {
            $this->conexion->beginTransaction();
            $return = $this->conexion->exec($sql);
            $this->conexion->commit();
            return $return;
        } catch (PDOException $e) {
            echo "Error al borrar mensaje " . $e->getMessage();
        }
    }
    public function set(QSO $QSO)
    {
        $us = $QSO->getId_participante(); #ID participacion -> no participante 
        $mod = $QSO->getId_modo();
        $band = $QSO->getId_banda();
        $juez = $QSO->getIndicativo_juez();
        $concurso = $QSO->getId_Concurso();
        $t = $QSO->getHora()->format('Y-m-d H:i:s');;
        # Creamos un mensaje que POR DEFECTO -> VALIDADO es falso (0)
        $sql = "INSERT INTO qso VALUES (null,$band,$us,'$juez',$concurso,'$t',$mod,0)";
        try {
            $this->conexion->beginTransaction();
            $this->conexion->exec($sql);
            $this->conexion->commit();
        } catch (PDOException $e) {
            echo "Error al añadir mensaje " . $e->getMessage();
        }
    }

    public function isValidado($id)
    {
        # Mira si está validado
        $sql = "SELECT validado FROM qso WHERE id LIKE $id";

        try {
            $c = $this->conexion->query($sql);
            $data = $c->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $validado) {
                # Devolvemos si está validado o no
                return (bool) $validado;
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function valida($idQSO)
    {
        # Según el ID del mensaje, lo validamos
        $sql = "UPDATE qso SET validado = 1 WHERE id LIKE $idQSO";
        try {
            $this->conexion->beginTransaction();
            $this->conexion->exec($sql);
            $this->conexion->commit();
        } catch (PDOException $e) {
            echo "Error al validar mensaje " . $e->getMessage();
        }
    }
    public function invalida($idQSO)
    {
        # Según el ID del mensaje, lo validamos
        $sql = "UPDATE qso SET validado = 0 WHERE id LIKE $idQSO";
        try {
            $this->conexion->beginTransaction();
            $this->conexion->exec($sql);
            $this->conexion->commit();
        } catch (PDOException $e) {
            echo "Error al invalidar mensaje " . $e->getMessage();
        }
    }
}
