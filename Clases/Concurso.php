<?php

class Concurso {

    /* PROPIEDADES */
    private int | null $id;
    private string $nombre;
    private string $desc;
    // FECHAS DE INICIO/FIN INSCRIPCIÓN
    private DateTimeImmutable $fechInicioInsc;
    private DateTimeImmutable $fechFinInsc;
    // FECHAS DE INICIO/FIN DEL CONCURSO
    private DateTimeImmutable $fechInicio;
    private DateTimeImmutable $fechFin;
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
        $this->setDesc($concurso['desc']);
        $this->setFechInicioInsc($concurso['fechaInicioInsc']);
        $this->setFechFinInsc($concurso['fechaFinInsc']);
        $this->setFechInicio($concurso['fechInicio']);
        $this->setFechFin($concurso['fechFin']);
        if (isset($concurso['cartel']) && is_null($concurso['cartel'])) {
            $this->setCartel($concurso['cartel']);
        }
        # Si es un array lo metemos en la propiedad, si no lo añadimos al array
        if (is_array($concurso['bandas'])) {
            $this->setBandas($concurso['bandas']);
        }else {
            $tamanio = count($concurso['bandas']);
            for ($i=0; $i < $tamanio; $i++) { 
                $banda = $concurso['bandas'][$i];
                $this->addBandas($banda);
            }
        }
        $this->setModos($concurso['modos']);
    }

    public function rellenaConcurso($id,$nombre,$desc,$fechaInicioInsc,$fechaFinInsc,$fechInicio,$fechFin,$cartel = null)
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
    public function getFechInicioInsc()
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
        // if (!isset($fin) || ($valida->EnteroRango($fechInicioInsc,$fin))) {
            $this->fechInicioInsc = $fechInicioInsc;
        // }else {
        //     throw new Exception("Error FECHA DE FIN DE INSCRIPCIÓN NO ESTABLECIDA");
        // }

        return $this;
    }

    /**
     * Get el valor de fechInicio
     */ 
    public function getFechInicio()
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
        $this->fechInicio = $fechInicio;

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
        if (!isset($this->fechFinInsc) || ($valida->EnteroRango($fechFinInsc,new DateTime('now')))) {
            $this->fechFinInsc = $fechFinInsc;
        }

        return $this;
    }

    /**
     * Get el valor de fechFin
     */ 
    public function getFechFin()
    {
        $fecha =$this->fechFin; 
        return $fecha;
    }

    /**
     * Set el valor de fechFin
     *
     * @return  self
     */ 
    public function setFechFin($fechFin)
    {
        $this->fechFin = $fechFin;

        return $this;
    }

    /**
     * Get el valor de cartel
     */ 
    public function getCartel()
    {
        $poster = $this->cartel; 
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
    public function addBandas(Banda $bandas)
    {
        $this->bandas[$bandas->getId()] = $bandas;

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
        if ($modos!=null) {
            # Asignamos el/los modos
            $this->modos = $modos;
        }

        return $this;
    }
}