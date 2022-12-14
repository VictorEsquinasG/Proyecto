<?php

class Concurso
{

    /* PROPIEDADES */
    private int | null $id;
    private string | null $nombre;
    private string | null $desc;
    // FECHAS DE INICIO/FIN INSCRIPCIÓN
    private DateTimeImmutable | null $fechInicioInsc;
    private DateTimeImmutable | null $fechFinInsc;
    // FECHAS DE INICIO/FIN DEL CONCURSO
    private DateTimeImmutable | null $fechInicio;
    private DateTimeImmutable | null $fechFin;
    // LA IMAGEN DEL CONCURSO
    private string | null $cartel;
    // PROPIEDADES NO DE CONCURSO
    private $bandas = [];
    private $modos = [];

    /**
     * Se le pasa un array asociativo
     * que rellena el objeto CONCURSO
     * Las claves del array deben  ser:id,nombre,desc,fechaInicioInsc,fechaFinInsc,fechInicio,fechFin,cartel,bandas,modos
     */
    public function rellenaConcursoArray($concurso)
    {
        $this->setId($concurso['id']);
        $this->setNombre($concurso['nombre']);
        if (isset($concurso['descripcion'])) {
            # 
            $this->setDesc($concurso['descripcion']);
        } else {
            $this->setDesc($concurso['desc']);
        }
        if (isset($concurso['fechaInicioInsc'])) {
            # 
            $this->setFechInicioInsc($concurso['fechaInicioInsc']);
        } else {
            $this->setFechInicioInsc($concurso['fechaInicioInscripcion']);
        }
        if (isset($concurso['fechaFinInsc'])) {
            # 
            $this->setFechFinInsc($concurso['fechaFinInsc']);
        } else {
            $this->setFechFinInsc($concurso['fechaFinInscripcion']);
        }
        if (isset($concurso['fechInicio'])) {
            # code...
            $this->setFechInicio($concurso['fechInicio']);
        } else {
            $this->setFechInicio($concurso['fechaInicioConcurso']);
        }
        if (isset($concurso['fechFin'])) {
            # code...
            $this->setFechFin($concurso['fechFin']);
        } else {
            $this->setFechInicio($concurso['fechaFinConcurso']);
        }
        if (isset($concurso['cartel']) && !is_null($concurso['cartel'])) {
            $this->setCartel($concurso['cartel']);
        }
        if (isset($concurso['bandas'])) {
            # Si es un array lo metemos en la propiedad, si no lo añadimos al array
            if (is_array($concurso['bandas'])) {
                $this->setBandas($concurso['bandas']);
            } else {
                $banda = $concurso['bandas'];
                $this->addBandas($banda);
            }
        }
        if (isset($concurso['modos'])) {
            if (is_array($concurso['modos'])) {
                $this->setModos($concurso['modos']);
            } else {
                $this->addModos($concurso['modos']);
            }
        }
    }

    public function rellenaConcurso($id, $nombre, $desc, $fechaInicioInsc, $fechaFinInsc, $fechInicio, $fechFin, $cartel = null)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setDesc($desc);
        $this->setFechInicioInsc($fechaInicioInsc);
        $this->setFechFinInsc($fechaFinInsc);
        $this->setFechInicio($fechInicio);
        $this->setFechFin($fechFin);
        // if (isset($cartel) && !(is_null($cartel))) {
        // PERMITIMOS QUE SEA NULL
        $this->setCartel($cartel);
        // }
        // $this->setBandas($bandas);
        // $this->setModos($modos);
    }

    public function tieneCartel()
    {
        # Si tiene cartel no dará error
        try {
            //Cogemos el valor del cartel
            $this->getCartel();
            $cartel = true;
        } catch (Error $e) { // ERROR COUGTH
            //El cartel no se puede acceder si no está inicializado
            $cartel = false;
        }
        return $cartel;
    }

    public function acabado()
    {
        # Usaremos el metodo FECHA_POSTERIOR de Validacion
        $valida = new Validacion();
        # cogemos el valor de las variables
        $fin = $this->getFechFin();
        $inicio = $this->getFechInicio();
        # Devolvemos la diferencia 
        return ($valida->fechaPosterior($fin,$inicio,''));
    }

    /**
     * Función que calcula la puntuación del usuario dado
     * en este concurso 
     */
    public function calculaPuntuacion($idUsuario)
    {
        # este concurso
        $id = $this->getId();
        # El multiplicador (valor del mensaje segun el juez)
        $multi = 1; // Por defecto 1

        # Calculamos sus mensajes
        $rP = new repParticipacion(gbd::getConexion());
        $rM = new repQSO(gbd::getConexion()); 

        $idparti = $rP->get($id,$idUsuario);
        $mensajes = $rM->getMsg($id,$idparti);
        
        return count($mensajes) * $multi; //TODO separar los mensajes segun el juez y sumar todos
    }


    /* GETTERS & SETTERS */
    /**
     * Get el valor de id
     */
    public function getId()
    {
        $iD = $this->id;
        return $iD;
    }

    /**
     * Set el valor de id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get el valor de nombre
     */
    public function getNombre()
    {
        $name = $this->nombre;
        return $name;
    }

    /**
     * Set el valor de nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get el valor de desc
     */
    public function getDesc()
    {
        $descr = $this->desc;
        return $descr;
    }

    /**
     * Set el valor de desc
     *
     * @return  self
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;

        return $this;
    }

    /**
     * Get el valor de fechInicioInsc
     */
    public function getFechInicioInsc(): DateTimeImmutable
    {
        $fecha = $this->fechInicioInsc;
        return $fecha;
    }

    /**
     * Set el valor de fechInicioInsc
     *
     * @return  self
     */
    public function setFechInicioInsc($fechInicioInsc)
    {
        // $valida = new Validacion(); 
        // $fin = $this->fechFinInsc;
        // cogemos la fecha, si no es DateTime la convertimos
        if (gettype($fechInicioInsc) === 'object') {
            $fecha = $fechInicioInsc;
        } else {
            $fecha = new DateTimeImmutable($fechInicioInsc);
        }

        $this->fechInicioInsc = $fecha;
        // } else {
        //     throw new Exception("Error FECHA DE FIN DE INSCRIPCIÓN NO ESTABLECIDA");
        // }

        return $this;
    }

    /**
     * Get el valor de fechInicio
     */
    public function getFechInicio(): DateTimeImmutable
    {
        $fecha = $this->fechInicio;
        return $fecha;
    }

    /**
     * Set el valor de fechInicio
     *
     * @return  self
     */
    public function setFechInicio($fechInicio)
    {
        if (gettype($fechInicio) === 'object') {
            $this->fechInicio = $fechInicio;
        } else {
            $this->fechInicio = new DateTimeImmutable($fechInicio);
        }

        return $this;
    }

    /**
     * Get el valor de fechFinInsc
     */
    public function getFechFinInsc()
    {
        $fecha = $this->fechFinInsc;
        return $fecha;
    }

    /**
     * Set el valor de fechFinInsc
     *
     * @return  self
     */
    public function setFechFinInsc($fechFinInsc)
    {
        $valida = new Validacion();
        if (!isset($this->fechFinInsc) || ($valida->EnteroRango($fechFinInsc, new DateTime('now')))) {

            if (gettype($fechFinInsc) === 'object') {
                $this->fechFinInsc = $fechFinInsc;
            } else {
                $this->fechFinInsc = new DateTimeImmutable($fechFinInsc);
            }
        }

        return $this;
    }

    /**
     * Get el valor de fechFin
     */
    public function getFechFin()
    {
        $fecha = $this->fechFin;
        return $fecha;
    }

    /**
     * Set el valor de fechFin
     *
     * @return  self
     */
    public function setFechFin($fechFin)
    {
        if (gettype($fechFin) === 'object') {
            $this->fechFin = $fechFin;
        } else {
            $this->fechFin = new DateTimeImmutable($fechFin);
        }
        return $this;
    }

    /**
     * Get el valor de cartel
     */
    public function getCartel()
    {
        if (isset($this->cartel)) {
            $poster = $this->cartel;
        } else {
            $poster = null;
        }
        return $poster;
    }

    /**
     * Set el valor de cartel
     *
     * @return  self
     */
    public function setCartel($cartel)
    {
        $this->cartel = $cartel;

        return $this;
    }

    /**
     * Get el valor de bandas
     */
    public function getBandas()
    {
        $gang = $this->bandas;
        return $gang;
    }

    public function setBandas(array $bandas)
    {
        $array = $bandas;
        $this->bandas = $array;
    }
    /**
     * Set el valor de bandas
     *
     * @return  self
     */
    public function addBandas($bandas)
    {
        $this->bandas[] = $bandas;

        return $this;
    }
    public function addModos($modos)
    {
        $this->modos[] = $modos;

        return $this;
    }

    /**
     * Get el valor de modos
     */
    public function getModos()
    {
        $aux = $this->modos;
        return $aux;
    }

    /**
     * Set el valor de modos
     *
     * @return  self
     */
    public function setModos($modos)
    {
        if ($modos != null) {
            # Asignamos el/los modos
            $this->modos = $modos;
        }

        return $this;
    }
}
