<?php

class Banda implements JsonSerializable
{
    /* PROPIEDADES */
    private int | null $id;
    private int | null $idConcurso;
    private string $nombre;
    private int $distancia;
    private int $min_rango;
    private int $max_rango;

    /**
     * Constructor
     */
    public function rellenaBanda($id, $nombre, $distancia,$min_rango,$max_rango, $idConcurso = null)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setDistancia($distancia);
        $this->setMin_rango($min_rango);
        $this->setMax_rango($max_rango);
        $this->setIdConcurso($idConcurso);
    }
    /**
     * Constructor
     */
    public function rellenaBandaArray($banda)
    {
        $this->setId($banda['id']);
        $this->setIdConcurso($banda['id_concurso']);
        $this->setNombre($banda['nombre']);
        $this->setDistancia($banda['distancia']);
        $this->setMin_rango($banda['max']);
        $this->setMax_rango($banda['min']);
    }
    /**
     * Constructor
     */
    public function rellenaBandaArrayNum($banda)
    {
        $this->setId($banda[0]);
        $this->setNombre($banda[1]);
        $this->setDistancia($banda[2]);
        $this->setMin_rango($banda[4]);
        $this->setMax_rango($banda[3]);
        $this->setIdConcurso($banda[5]);
    }

    /**
     * Get el valor de id
     */ 
    public function getId()
    {
        $ID = $this->id;
        return $ID;
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
        $this->nombre = (string)$nombre;

        return $this;
    }


    /**
     * Get el valor de distancia
     */ 
    public function getDistancia()
    {
        $dist = $this->distancia;
        return $dist;
    }

    /**
     * Set el valor de distancia
     *
     * @return  self
     */ 
    public function setDistancia($distancia)
    {
        $this->distancia = $distancia;

        return $this;
    }

    /**
     * Get el valor de min_rango
     */ 
    public function getMin_rango()
    {
        $min = $this->min_rango;
        return $min;
    }

    /**
     * Set el valor de min_rango
     *
     * @return  self
     */ 
    public function setMin_rango($min_rango)
    {
        $this->min_rango = $min_rango;

        return $this;
    }

    /**
     * Get el valor de max_rango
     */ 
    public function getMax_rango()
    {
        $max = $this->max_rango;
        return $max;
    }

    /**
     * Set el valor de max_rango
     *
     * @return  self
     */ 
    public function setMax_rango($max_rango)
    {
        $this->max_rango = $max_rango;

        return $this;
    }


    /**
     * Get el valor de idConcurso
     */ 
    public function getIdConcurso()
    {
        return $this->idConcurso;
    }

    /**
     * Set el valor de idConcurso
     *
     * @return  self
     */ 
    public function setIdConcurso($idConcurso)
    {
        $this->idConcurso = $idConcurso;

        return $this;
    }

    public function jsonSerialize()
    {
        # Función que sirve para crear un objeto
        # que es el que devuelve el JSON_ENCODE() 
        $json = new stdClass();
        $json->id = $this->getId();
        $json->idConcurso = $this->getIdConcurso();
        $json->nombre = $this->getNombre();
        $json->distancia = $this->getDistancia();
        $json->max_rango = $this->getMax_rango();
        $json->min_rango = $this->getMin_rango();
        return $json;
    }
}
