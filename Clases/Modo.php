<?php

class Modo
{
    /* PROPIEDADES */
    private int $id;
    private string $nombre;


    /**
     * Constructor
     */
    public function rellenaModo($id, $nombre)
    {
        $this->setId($id);
        $this->setNombre($nombre);
    }
    /**
     * Constructor
     * Requiere un Array Asociativo con las siguientes claves: id,nombre_modo
     */
    public function rellenaModoArray($banda)
    {
        $this->setId($banda['id']);
        $this->setNombre($banda['nombre_modo']);
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

}
