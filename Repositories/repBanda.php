<?php 

class repBanda {

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
    public function getAll():array
    {
        // El array de Bandas a devolver
        $bandas = [];
        $sql = "SELECT * FROM BANDA_CONCURSO BC
        INNER JOIN BANDA B ON B.ID = BC.BANDA_ID";
        
        $consulta = $this->conexion->query($sql);
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $tamanio = count($datos);
        $r = new repBanda($this->conexion);
        for ($i=0; $i < $tamanio; $i++) { 
            $banda = $r->getById($i); 
            $bandas[] = $banda; 
        }

        return $bandas;
    }

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
            $banda->rellenaBanda($id,$nombre,$distancia,$min_rango,$max_rango,$idConcurso);

            return $banda;
        } catch (PDOException $e) {
            throw new PDOException("Error leyendo por clave primaria: " . $e->getMessage());
        }
    }


}