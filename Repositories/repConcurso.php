<?php

class repConcurso
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
     * Lee todos los registros de la tabla CONCURSO pudiendo seleccionar los campos
     *
     * @param array $campos campos a leer o null para todos
     */
    public function get_bandas($id)
    {
        $sql = "SELECT * FROM BANDA_CONCURSO BC
        INNER JOIN BANDA B ON B.ID = BC.BANDA_ID 
        WHERE BC.CONCURSO_ID LIKE $id";
        try {
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $bandas['id_concurso'] = $datos[0]['concurso_id'];
            $bandas['id'] = $datos[0]['banda_id'];
            $bandas['nombre'] = $datos[0]['nombre'];
            $bandas['distancia'] = $datos[0]['distancia'];
            $bandas['min'] = $datos[0]['min-rango'];
            $bandas['max'] = $datos[0]['max-rango'];

            $banda = new Banda();
            $banda->rellenaBandaArray($bandas);
        } catch (PDOException $e) {
            throw new PDOException("Error de lectura de datos: " . $e->getMessage());
        }
    }

    public function getPage($cuantas,$tamanio)
    {
        $cuantas = (($cuantas-1)*5);
        $concursos = [];
        $sql = "SELECT * FROM concurso ORDER BY id DESC LIMIT $cuantas,$tamanio";
        $consulta = $this->conexion->query($sql);
        $concursos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $concursos;
    }
    public function getAll()
    {
        $concursos = [];
        $sql = "SELECT * FROM concurso";
        $consulta = $this->conexion->query($sql);
        $concursos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        // while ($datos = $consulta->fetch()) {
        //     $concurso = new Concurso();
        //     $concursos[] = $concurso->rellenaConcurso($datos[0], $datos[1], $datos[2], new DateTimeImmutable($datos[3]), new DateTimeImmutable($datos[4]), new DateTimeImmutable($datos[5]), new DateTimeImmutable($datos[6]), $datos[7]);
        // }
        return $concursos;
    }

    public function set(Concurso $concurso):int|false
    {
        $id = $concurso->getId();
        $nombre = $concurso->getNombre();
        $desc = $concurso->getDesc();
        $fechaInInsc = $concurso->getFechInicioInsc();
        $fechaFInsc = $concurso->getFechFinInsc();
        $fechaInicio = $concurso->getFechInicio();
        $fechaFin = $concurso->getFechFin();
        $poster = $concurso->getCartel();

        $sql = "INSERT INTO concurso VALUES " .
        "($id,$nombre,$desc,$fechaInInsc,$fechaFInsc," .
        "$fechaInicio,$fechaFin,$poster)";
        
        return $this->conexion->exec($sql);
    }

    /**
     * Devuelve el registro con clave primaria
     *
     * @param array $id valores de la id
     * @return void
     */
    public function getById($id)
    {
        $sql = "select * FROM concurso 
        WHERE id = $id ";

        try {
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $id = $datos[0]['id'];
            $nombre = $datos[0]['nombre'];
            $desc = $datos[0]['descripcion'];
            $fechaInicioInscripcion = new DateTimeImmutable($datos[0]['fechaInicioInscripcion']);
            $fechaFinInscripcion = new DateTimeImmutable($datos[0]['fechaFinInscripcion']);
            $fechaInicioConcurso = new DateTimeImmutable($datos[0]['fechaInicioConcurso']);
            $fechaFinConcurso = new DateTimeImmutable($datos[0]['fechaFinConcurso']);
            $cartel = $datos[0]['cartel'];

            $bandas = null;
            $modos = null;
            try {  # TODO qué hacemos si no tiene bandas .. ?
                $bandas = $this->get_bandas($id);
                $modos = $this->get_modos($id);
            } catch (PDOException $e) {
                throw new PDOException("Error de lectura de datos(Bandas/Modos): " . $e->getMessage());
            }

            $concurso = new Concurso();
            $concurso->rellenaConcurso($id, $nombre, $desc, $fechaInicioInscripcion, $fechaFinInscripcion, $fechaInicioConcurso, $fechaFinConcurso, $bandas, $modos, $cartel);

            return $concurso;
        } catch (PDOException $e) {
            throw new PDOException("Error leyendo por clave primaria: " . $e->getMessage());
        }
    }

    public function get_modos($id)
    {
        $sql = "SELECT * FROM PREMIO P
        INNER JOIN MODO M ON M.ID = P.MODO_ID 
        WHERE P.CONCURSO_ID LIKE $id";
        try {
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $modos['id_concurso'] = $datos[0]['concurso_id'];
            $modos['id'] = $datos[0]['modo_id'];
            $modos['nombre_premio'] = $datos[0]['nombre_premio'];
            $modos['indicativo_participante'] = $datos[0]['indicativo_participante'];
            $modos['desc'] = $datos[0]['desc'];
            $modos['nombre_modo'] = $datos[0]['nombre'];

            $modo = new Modo();
            $modo->rellenaModoArray($modos);
        } catch (PDOException $e) {
            throw new PDOException("Error de lectura de datos: " . $e->getMessage());
        }
    }

    /**
     * 
     * @param $campovalor un array con el nombre de la columna y el dato que se buscan
     * @example ['nombre','Diego']
     * @return array El resultado de la consulta (Usuario con dichos parámetros)
     */
    public function findByOne($campovalor)
    {
        $sql = "SELECT * FROM concurso WHERE " . array_keys($campovalor)[0] . " LIKE ?"; // La instrucción LIKE es más rápida que =
        try {
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, array_values($campovalor)[0]); // Si es String le pondrá las comillas automáticamente
            $consulta->execute();
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $id = $datos[0]['id'];
            $nombre = $datos[0]['nombre'];
            $desc = $datos[0]['descripcion'];
            $fechaInicioInscripcion = new DateTimeImmutable($datos[0]['fechaInicioInscripcion']);
            $fechaFinInscripcion = new DateTimeImmutable($datos[0]['fechaFinInscripcion']);
            $fechaInicioConcurso = new DateTimeImmutable($datos[0]['fechaInicioConcurso']);
            $fechaFinConcurso = new DateTimeImmutable($datos[0]['fechaFinConcurso']);
            $cartel = $datos[0]['cartel'];

            $concurso = new Concurso();
            $concurso->rellenaConcurso($id, $nombre, $desc, $fechaInicioInscripcion, $fechaFinInscripcion, $fechaInicioConcurso, $fechaFinConcurso, $cartel);

            return $concurso;
        } catch (PDOException $e) {
            throw new PDOException("Error leyendo por clave primaria: " . $e->getMessage());
        }
    }
}
