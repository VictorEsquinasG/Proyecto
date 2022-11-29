<?php

class Banda
{
    /* PROPIEDADES */
    private int $id;
    private int $idConcurso;
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
        $this->nombre = $nombre;

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
}
