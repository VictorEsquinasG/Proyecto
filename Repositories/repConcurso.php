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
     * @param id el id del concurso
     */
    public function get_bandas($id)
    {
        $todas = [];
        $sql = "SELECT * FROM BANDA_CONCURSO BC
        INNER JOIN BANDA B ON B.ID = BC.BANDA_ID 
        WHERE BC.CONCURSO_ID LIKE $id";
        try {
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $cuantos = count($datos);
            for ($i = 0; $i < $cuantos; $i++) {
                # Rellenamos la banda que toque y la añadimos al array
                $bandas['id_concurso'] = $datos[$i]['concurso_id'];
                $bandas['id'] = $datos[$i]['banda_id'];
                $bandas['nombre'] = $datos[$i]['nombre'];
                $bandas['distancia'] = $datos[$i]['distancia'];
                $bandas['min'] = $datos[$i]['min-rango'];
                $bandas['max'] = $datos[$i]['max-rango'];

                $banda = new Banda();
                $banda->rellenaBandaArray($bandas);
                $todas[] = $banda;
            }

            return $todas;
        } catch (PDOException $e) {
            throw new PDOException("Error de lectura de datos: " . $e->getMessage());
        }
    }


    public function getPage($cuantas, $tamanio)
    {
        $cuantas = (($cuantas - 1) * 5);
        $concursos = [];
        $sql = "SELECT * FROM concurso ORDER BY id DESC LIMIT $cuantas,$tamanio";
        $consulta = $this->conexion->query($sql);
        $concursos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $concursos;
    }
    public function getAll()
    {
        $concursos = [];
        # Los concursos con bandas y modos
        $sql = "SELECT * FROM concurso";
        // $sql = "SELECT * FROM concurso c 
        // JOIN banda_concurso b ON b.concurso_id = c.id 
        // JOIN premio m ON m.concurso_id = c.id";
        $consulta = $this->conexion->query($sql);
        $concursos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        // while ($datos = $consulta->fetch()) {
        //     $concurso = new Concurso();
        //     $concursos[] = $concurso->rellenaConcurso($datos[0], $datos[1], $datos[2], new DateTimeImmutable($datos[3]), new DateTimeImmutable($datos[4]), new DateTimeImmutable($datos[5]), new DateTimeImmutable($datos[6]), $datos[7]);
        // }
        return $concursos;
    }
    public function getAllConcursos()
    {
        $concursos = [];
        $sql = "SELECT * FROM concurso";
        $consulta = $this->conexion->query($sql);
        $concursos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        // $tamanio = count($concursoss);
        // for ($i = 0; $i < $tamanio; $i++) {
        //     # creamos el concurso y lo añadimos
        //     $concurso = new Concurso();
        //     $concursos[] = $concurso->rellenaConcurso(
        //         $concursos[$i]['id'],
        //         $concursos[$i]['nombre'],
        //         $concursos[$i]['descripcion'],
        //         new DateTimeImmutable($concursos[$i]['fechaInicioInscripcion']),
        //         new DateTimeImmutable($concursos[$i]['fechaFinInscripcion']),
        //         new DateTimeImmutable($concursos[$i]['fechaInicioConcurso']),
        //         new DateTimeImmutable($concursos[$i]['fechaFinConcurso']),
        //         $concursos[$i]['cartel']
        //     );
        // }

        return $concursos;
    }

    public function getJueces($id):array
    {
        $jueces = [];
        $r = new repUsuarios(gbd::getConexion());
        #Jueces del concurso
        $sql = "SELECT P.participante_id FROM concurso C ".
        "JOIN participacion P WHERE c.id LIKE $id";
        try {
            #Conseguimos el id del participante que es juez
            $consulta = $this->conexion->query($sql);
            $participante = $consulta->fetchAll(PDO::FETCH_ASSOC);

            for ($i=0; $i < count($participante); $i++) { 
                # devolveremos a los usuarios que son jueces
                $id_usuario = $participante[$i]['participante_id'];
                $juez_dred = $r->getById($id_usuario);
                $jueces[]= $juez_dred;
            }
            return $jueces;
        } catch (PDOException $e) {
            echo "Error al leer los jueces del concurso ".$e->getMessage();
        }
    }

    public function set(Concurso $concurso)
    {
        $nombre = $concurso->getNombre();
        $desc = $concurso->getDesc();
        $fechaInInsc = $concurso->getFechInicioInsc()->format('Y-m-d H:i:s');
        $fechaFInsc = $concurso->getFechFinInsc()->format('Y-m-d H:i:s');
        $fechaInicio = $concurso->getFechInicio()->format('Y-m-d H:i:s');
        $fechaFin = $concurso->getFechFin()->format('Y-m-d H:i:s');
        $poster = $concurso->getCartel();

        $sql = "INSERT INTO concurso VALUES (null,'$nombre','$desc','$fechaInInsc','$fechaFInsc','$fechaInicio','$fechaFin','$poster')";
        // $sql = "INSERT INTO concurso VALUES (null,'$nombre','$desc','DATE_FORMAT($fechaInInsc,\"yyyy-mm-dd\")',`DATE_FORMAT($fechaFInsc,'yyyy-mm-dd')`,`DATE_FORMAT($fechaInicio,'yyyy-mm-dd')`,`DATE_FORMAT($fechaFin,'yyyy-mm-dd')`,$poster)";
        try {
            $this->conexion->beginTransaction();
            $res = $this->conexion->exec($sql);
            # Cogemos el id del concurso que acabamos de insertar
            $sql = "SELECT id FROM concurso WHERE nombre LIKE '$nombre'";
            $sele = $this->conexion->query($sql);
            $cons = $sele->fetchAll(PDO::FETCH_ASSOC);
            $id = $cons[0]['id'];
            # Las bandas del concurso
            $banda = $concurso->getBandas();
            # Los modos
            $modo = $concurso->getModos();
            $cuantas = count($banda);
            $cuantos = count($modo);
            if ($cuantas > 0) {
                # si tiene al menos una banda la insertamos
                for ($i = 0; $i < $cuantas; $i++) {
                    $sql = "INSERT INTO banda_concurso VALUES(null," . $banda[$i] . "," . $id . ")";
                    $this->conexion->exec($sql);
                }
            }
            if ($cuantos > 0) {
                # si tiene al menos un modo la insertamos
                for ($i = 0; $i < $cuantos; $i++) {
                    $sql = "INSERT INTO premio VALUES(null," . $id . "," . $modo[$i] . ",null,null,null)";
                    $this->conexion->exec($sql);
                }
            }
            $this->conexion->commit();
            return $res;
        } catch (PDOException $e) {
            echo "Error en la inserción de concurso  ".$e->getMessage();
        }
    }
    public function delete($id)
    {
        # borramos según el id
        $sql = "DELETE FROM concurso WHERE id LIKE $id";
        $this->conexion->beginTransaction();
        $devolveer = $this->conexion->exec($sql);
        $this->conexion->commit();
        return $devolveer;
    }

    public function getConcursosDisponibles(): array
    {
        # El array
        $concursos = [];
        # Preguntamos por concursos que nos podamos inscribir
        $sql = "SELECT * FROM concurso WHERE fechaFinInscripcion>=curdate()";
        try {
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $tamanio = count($datos);
            for ($i = 0; $i < $tamanio; $i++) {
                # Preguntaremos por todos los concursos
                $id = $datos[$i]['id'];
                $nombre = $datos[$i]['nombre'];
                $desc = $datos[$i]['descripcion'];
                $fechaInicioInscripcion = new DateTimeImmutable($datos[$i]['fechaInicioInscripcion']);
                $fechaFinInscripcion = new DateTimeImmutable($datos[$i]['fechaFinInscripcion']);
                $fechaInicioConcurso = new DateTimeImmutable($datos[$i]['fechaInicioConcurso']);
                $fechaFinConcurso = new DateTimeImmutable($datos[$i]['fechaFinConcurso']);
                # Si el cartel es null lo seteamos como tal
                $datos[$i]['cartel'] != null ? $cartel = $datos[$i]['cartel'] : $cartel = null;

                $bandas = null;
                $modos = null;
                try {  # TODO qué hacemos si no tiene bandas .. ?
                    $bandas = $this->get_bandas($i);
                    $modos = $this->get_modos($i);
                } catch (PDOException $e) {
                    throw new PDOException("Error de lectura de datos(Bandas/Modos): " . $e->getMessage());
                }

                $concurso = new Concurso();
                $concurso->rellenaConcurso($id, $nombre, $desc, $fechaInicioInscripcion, $fechaFinInscripcion, $fechaInicioConcurso, $fechaFinConcurso, $cartel);
                $concurso->setBandas($bandas);
                $concurso->setModos($modos);
                # Lo añadimos al array
                $concursos[] = $concurso;
            }
        } catch (PDOException $e) {
            echo "Error de lectura al buscar concursos disponibles " . $e->getMessage();
        }

        return $concursos;
    }

    public function getConcursosActivos(): array
    {
        # El array
        $concursos = [];
        # Preguntamos por concursos que no hayan acabado aún
        $sql = "SELECT * FROM concurso WHERE fechaFinConcurso>curdate()";
        try {
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $tamanio = count($datos);
            for ($i = 0; $i < $tamanio; $i++) {
                # Preguntaremos por todos los concursos
                $id = $datos[$i]['id'];
                $concurso = $this->getById($id);
                # Lo añadimos al array
                $concursos[] = $concurso;
            }
        } catch (PDOException $e) {
            echo "Error de lectura al buscar concursos activos " . $e->getMessage();
        }

        return $concursos;
    }

    /**
     * Devuelve el registro con clave primaria
     *
     * @param array $id valores de la id
     * @return Concurso
     */
    public function getById($id): Concurso
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
            $concurso->rellenaConcurso($id, $nombre, $desc, $fechaInicioInscripcion, $fechaFinInscripcion, $fechaInicioConcurso, $fechaFinConcurso, $cartel);
            $concurso->setBandas($bandas);
            $concurso->setModos($modos);

            return $concurso;
        } catch (PDOException $e) {
            throw new PDOException("Error leyendo por clave primaria: " . $e->getMessage());
        }
    }

    /**
     * Devuelve los modos de un determinado concurso (id)
     * o en su defecto todos los modos existentes.
     */
    public function get_modos($id = null): array
    {
        #los modos a devolver
        $todos = [];
        $nulId = false;

        if (!is_null($id)) {
            $sql = "SELECT * FROM PREMIO P
            INNER JOIN MODO M ON M.ID = P.MODO_ID 
            WHERE P.CONCURSO_ID LIKE $id";
        } else {
            $sql = "SELECT * FROM modo";
            $nulId = true;
        }
        try {
            # Realizamos la consulta
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $cuantos = count($datos);
            if ($nulId) {
                # Si nos ha pedido hacer SELECT *
                for ($i = 0; $i < $cuantos; $i++) {
                    # cogemos todos los modos
                    $modos['id'] = $datos[$i]['id'];
                    $modos['nombre_modo'] = $datos[$i]['nombre'];
                    # creamos el modo
                    $modo = new Modo();
                    $modo->rellenaModoArray($modos);
                    $todos[] = $modo; # lo añadimos al final
                }
            } else {
                # Hicimos SELECT JOIN
                for ($i = 0; $i < $cuantos; $i++) {
                    # cogemos todos los modos
                    $modos['id_concurso'] = $datos[$i]['concurso_id'];
                    $modos['id'] = $datos[$i]['modo_id'];
                    $modos['nombre_premio'] = $datos[$i]['nombre_premio'];
                    $modos['indicativo_participante'] = $datos[$i]['indicativo_participante'];
                    $modos['desc'] = $datos[$i]['desc'];
                    $modos['nombre_modo'] = $datos[$i]['nombre'];
                    # creamos el modo
                    $modo = new Modo();
                    $modo->rellenaModoArray($modos);
                    $todos[] = $modo; # lo añadimos al final
                }
            }
            return $todos;
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
