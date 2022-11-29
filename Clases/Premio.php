<?php

class Premio {
    private $id;
    /* NOMBRE Y DESCRIPCIÓN SON OPCIONALES*/ 
    private $nombre;
    private $desc;
    /* LOS IDs */
    private $id_concurso;
    private $id_modo;
    private $id_ganador; // El id del ganador del premio, se almacena para q al darse de baja no gane el premio otro participante

    /* CONSTRUCTORES */
    function __construct($id,$id_concurso, $id_modo, $id_ganador = null,$nombre = null,$desc = null)
    {
        $this->setId($id);
        $this->setDesc($desc);
        $this->setId_concurso($id_concurso);
        $this->setId_modo($id_modo);
        $this->setNombre($nombre);
        $this->setId_ganador($id_ganador);
    }


    /* GETTERS & SETTERS */

    /**
     * Get el valor de id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set el valor de id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $ID = $id;
        $this->id = $ID;

        return $this;
    }

    /**
     * Get el valor de nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set el valor de nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $name = $nombre;
        $this->nombre = $name;

        return $this;
    }

    /**
     * Get el valor de desc
     */ 
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * Set el valor de desc
     *
     * @return  self
     */ 
    public function setDesc($desc)
    {
        $descr = $desc;
        $this->desc = $descr;

        return $this;
    }

    /**
     * Get el valor de id_concurso
     */ 
    public function getId_concurso()
    {
        return $this->id_concurso;
    }

    /**
     * Set el valor de id_concurso
     *
     * @return  self
     */ 
    public function setId_concurso($id_concurso)
    {
        $ID = $id_concurso;
        $this->id_concurso = $ID;

        return $this;
    }

    /**
     * Get el valor de id_modo
     */ 
    public function getId_modo()
    {
        return $this->id_modo;
    }

    /**
     * Set el valor de id_modo
     *
     * @return  self
     */ 
    public function setId_modo($id_modo)
    {
        $this->id_modo = $id_modo;

        return $this;
    }

    /**
     * Get el valor de id_ganador
     */ 
    public function getId_ganador()
    {
        return $this->id_ganador;
    }

    /**
     * Set el valor de id_ganador
     *
     * @return  self
     */ 
    public function setId_ganador($id_ganador)
    {
        $ID = $id_ganador;
        $this->id_ganador = $ID;

        return $this;
    }
}

?>