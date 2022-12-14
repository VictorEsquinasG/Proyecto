<?php

class Participacion implements JsonSerializable {
    private int | null $id;
    private string $rol;
    private int $id_concurso;
    private int $id_usuario;

    public function __construct()
    {
        
    }
    public function rellenaParticipacion($id,$rol,$concurso,$participacion)
    {
        $this->setId($id);
        $this->setRol($rol);
        $this->setId_concurso($concurso);
        $this->setId_usuario($participacion);
    }
    
    public function rellenaParticipacionArray($participacion)
    {
        $this->setId($participacion['id']);
        $this->setRol($participacion['rol']);
        $this->setId_concurso($participacion['concurso']);
        $this->setId_usuario($participacion['participacion']);
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of rol
     */ 
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set the value of rol
     *
     * @return  self
     */ 
    public function setRol($rol)
    {
        if ($rol === 'user' || $rol === 'juez') {
            # si es uno de los 2
            $this->rol = $rol;
        }else {
            throw new Exception("Rol no válido (fuera de enum user/juez)");
        }

        return $this;
    }

    /**
     * Get the value of id_concurso
     */ 
    public function getId_concurso()
    {
        return $this->id_concurso;
    }

    /**
     * Set the value of id_concurso
     *
     * @return  self
     */ 
    public function setId_concurso($id_concurso)
    {
        $this->id_concurso = $id_concurso;

        return $this;
    }

    /**
     * Get the value of id_usuario
     */ 
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    /**
     * Set the value of id_usuario
     *
     * @return  self
     */ 
    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        $json = new stdClass();
        
        $json->id = $this->getId();
        $json->id_concurso = $this->getId_concurso();
        $json->id_usuario = $this->getId_usuario();
        $json->rol = $this->getRol();

        return $json;
    }

}