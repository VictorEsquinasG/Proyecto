<?php
//repositorioUsuarios
class repUsuarios
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
     * Lee todos los registros de la tabla PARTICIPANTE pudiendo seleccionar los campos
     *
     * @param array $campos campos a leer o null para todos
     */
    public function get_participantes($campos = null)
    {
        $otroscampos = null;
        if (is_null($campos)) {
            $otroscampos = "*";
        } else {
            $otroscampos = implode(",", $campos);
        }
        $sql = "select " . $otroscampos . " FROM participante";
        try {
            $consulta = $this->conexion->prepare($sql);
            $consulta->execute();
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (PDOException $e) {
            throw new PDOException("Error de lectura de datos: " . $e->getMessage());
        }
    }

    /**
     * Devuelve el registro con clave primaria
     *
     * @param array $id valores de la id
     * @return void
     */
    public function getById($id)
    {
        $sql = "select id,indicativo,email,password,". 
        "rol,ST_X(gps) as lat,ST_Y(gps) as lon,imagen,nombre,ap1,ap2" .
        "FROM participante WHERE id = $id";

        try {
            $consulta = $this->conexion->query($sql);
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $id = $datos[0]['id'];
            $indicativo = $datos[0]['indicativo'];
            $mail = $datos[0]['email'];
            $passwd = $datos[0]['password'];
            $rol = $datos[0]['rol'];
            $gps = new Gps($datos[0]['lat'],$datos[0]['lon']);
            $img = $datos[0]['imagen'];
            $nombre = $datos[0]['nombre'];
            $ap1 = $datos[0]['ap1'];
            $ap2 = $datos[0]['ap2'];

            $usuario = new Usuario();
            $usuario->rellenaUsuario($id, $indicativo, $mail, $passwd, $nombre, $ap1, $ap2, $gps, $rol, $img);

            return $usuario;
        } catch (PDOException $e) {
            throw new PDOException("Error leyendo por clave primaria: " . $e->getMessage());
        }
    }

    public function getPage($cuantas,$tamanio)
    {
        $cuantas = (($cuantas-1)*5);
        $participantes = [];
        $sql = "SELECT * FROM participante ORDER BY id DESC LIMIT $cuantas,$tamanio";
        $consulta = $this->conexion->query($sql);
        $participantes = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $participantes;
    }

    public function getAll()
    {
        $usuarios = [];        
        // Consultamos
        $sql = "SELECT P.id,P.indicativo,P.nombre,P.ap1,P.ap2,P.email,CONCAT('Lat: ',ST_X(P.gps),' Lon: ',ST_Y(P.gps)) FROM participante P";// JOIN concurso C
        //ON P.id = C.participante_id";// WHERE indicativo='LU6LPZ'";
        $consulta = $this->conexion->query($sql);
        $usuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);
        // $coor = unpack('x/y', $usuarios['gps']);
        // $usuarios['gps'] = $coor['lat'] . '/' . $coor['lon'];
        return $usuarios;
    }

    /**
     * 
     * @param array $campovalor un array con el nombre de la columna y el dato que se buscan
     * @example ['nombre','Diego']
     * @return Usuario El resultado de la consulta (Usuario con dichos parámetros)
     */
    public function findByOne($campovalor): Usuario
    {
        $sql = "select * from participante where " . 
        array_keys($campovalor)[0] . " = '" . array_values($campovalor)[0] . "'";
        try {
            $consulta = $this->conexion->prepare($sql);
            $consulta->execute();
            $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            $id = $datos[0]['id'];
            $indicativo = $datos[0]['indicativo'];
            $mail = $datos[0]['email'];
            $passwd = $datos[0]['password'];
            $rol = $datos[0]['rol'];
            $gps = $datos[0]['gps'];
            $img = $datos[0]['imagen'];
            $nombre = $datos[0]['nombre'];
            $ap1 = $datos[0]['ap1'];
            $ap2 = $datos[0]['ap2'];

            $usuario = new Usuario();
            $usuario->rellenaUsuario($id, $indicativo, $mail, $passwd, $nombre, $ap1, $ap2, $gps, $rol, $img);

            return $usuario;
        } catch (PDOException $e) {
            throw new PDOException("Error leyendo por clave primaria: " . $e->getMessage());
        }
    }

    public function addUser(Usuario $a):bool
    {
        // Obtenemos los parámetros del usuario dado
        $id = $a->getId();
        $indicativo = $a->getIdentificativo();
        $mail = $a->getEmail();
        $passwd = $a->getPssword();
        $rol = $a->getRol();
        $gps = $a->getGps();
        $img = $a->getImg();
        $nombre = $a->getNombre();
        $ap1 = $a->getAp1();
        $ap2 = $a->getAp2();
        // Preparamos y realizamos el insert
        $sql = "INSERT INTO participante VALUES ($id,$indicativo,$mail,$passwd,$rol,$gps,$img,$nombre,$ap1,$ap2)";
        try {
            // Ejecutamos la instrucción
            $insert = $this->conexion->exec($sql);
            return $insert;
        } catch (PDOException $e) {
            throw new PDOException("Error al insertar: " . $e->getMessage());
        }
    }
}