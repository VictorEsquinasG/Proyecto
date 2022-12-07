<?php

class repBanda
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
     * Realiza un SELECT * FROM BANDAS
     * @return array Todas las bandas
     */
    public function getAll(): array
    {
        // El array de Bandas a devolver
        $bandas = [];
        $sql = "SELECT * FROM BANDA";

        $consulta = $this->conexion->query($sql);
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $tamanio = count($datos);
        for ($i = 0; $i < $tamanio; $i++) {
            # Creamos una nueva banda y la añadimos al array
            $banda = new Banda();
            $banda->rellenaBanda(
                $datos[$i]['id'],$datos[$i]['nombre'],$datos[$i]['distancia'],
                $datos[$i]['min-rango'],$datos[$i]['max-rango'],null);
            $bandas[] = $banda;
        }
        // $tamanio = count($datos);
        // $r = new repBanda($this->conexion);
        // for ($i=0; $i < $tamanio; $i++) { 
        //     $banda = $r->getById($i); 
        //     $bandas[] = $banda; 
        // }

        return $bandas;
    }

    public function delete($id)
    {
        # borramos según el id
        $sql = "DELETE FROM banda WHERE id LIKE $id";
        $this->conexion->beginTransaction();
        $devolveer = $this->conexion->exec($sql);
        $this->conexion->commit();
        return $devolveer;
    }

    // getFromConcurso
    // $sql = "SELECT * FROM BANDA_CONCURSO BC
        // INNER JOIN BANDA B ON B.ID = BC.BANDA_ID";

    /**
     * Devuelve el registro con clave primaria
     *
     * @param array $id valores de la id
     * @return void
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM BANDA_CONCURSO BC
        INNER JOIN BANDA B ON B.ID = BC.BANDA_ID 
        WHERE B.ID LIKE $id";

        try {
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $id = $datos[0]['banda_id'];
            $idConcurso = $datos[0]['concurso_id'];
            $nombre = $datos[0]['nombre'];
            $distancia = $datos[0]['distancia'];
            $min_rango = $datos[0]['min-rango'];
            $max_rango = $datos[0]['max-rango'];

            $banda = new Banda();
            $banda->rellenaBanda($id, $nombre, $distancia, $min_rango, $max_rango, $idConcurso);

            return $banda;
        } catch (PDOException $e) {
            throw new PDOException("Error leyendo por clave primaria: " . $e->getMessage());
        }
    }

    public function add(Banda $a): bool
    {
        // Obtenemos los parámetros de la banda dada
        $dist = $a->getDistancia();
        $nombre = $a->getNombre();
        $max = $a->getMax_rango();
        $min = $a->getMin_rango();
        // Preparamos y realizamos el insert
        $sql = "INSERT INTO banda VALUES (null,'$nombre',$dist,$min,$max)";
        try {
            // Ejecutamos la instrucción
            return $this->conexion->exec($sql);
        } catch (PDOException $e) {
            throw new PDOException("Error al insertar: " . $e->getMessage());
        }
    }
}
