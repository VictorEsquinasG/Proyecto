<?php

// MENSAJES QSO
class QSO implements JsonSerializable
{

    /* PROPIEDADES */
    private int | null $id;
    private int | null $id_participacion;
    private int $id_concurso;
    private int $id_banda;
    private int $id_modo;
    private string $indicativo_juez;
    private DateTimeImmutable $hora;
    private bool | null $validado;


    /**
     * Constructor
     */
    public function rellenaQSO($id,$id_participacion,$id_concurso,$id_modo,$id_banda,$indicativo_juez,$hora,$validado = null)
    {
        $this->setId($id);
        $this->setId_participante($id_participacion);
        $this->setId_concurso($id_concurso);
        $this->setId_modo($id_modo);
        $this->setId_banda($id_banda);
        $this->setIndicativo_juez($indicativo_juez);
        $this->setHora($hora);
        $this->setValidado($validado);
    }

    /**
     * Constructor
     * Requiere un Array Asociativo con las siguientes claves: 
     * @param id El id del mensaje
     * @param id_participante El id de la participacion del participante que realiza el mensaje
     * @param id_concurso El id del concurso en el que se realiza el mensaje
     * @param id_modo El id del modo
     * @param id_banda El id de la banda
     * @param indicativo_juez El indicativo del juez contactado
     * @param fecha La fecha y hora en la que el mensaje se efectuó
     * @param validado (OPCIONAL) Si está validado o no 
     */
    public function rellenaQSOArray($mensaje)
    {
        $this->setId($mensaje['id']);
        $this->setId_participante($mensaje['id_participante']);
        $this->setId_concurso($mensaje['id_concurso']);
        $this->setId_modo($mensaje['id_modo']);
        $this->setId_banda($mensaje['id_banda']);
        $this->setIndicativo_juez($mensaje['indicativo_juez']);
        $this->setHora($mensaje['fecha']);
        // Si tiene VALIDADO lo seteamos
        isset($mensaje['validado']) ? $this->setValidado($mensaje['validado']) : null;
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
     * Get el valor de id_participacion
     */
    public function getId_participante()
    {
        return $this->id_participacion;
    }

    /**
     * Set el valor de id_participacion
     *
     * @return  self
     */
    public function setId_participante($id_participacion)
    {
        $this->id_participacion = $id_participacion;

        return $this;
    }

    /**
     * Get el valor de indicativo_juez
     */
    public function getIndicativo_juez()
    {
        return $this->indicativo_juez;
    }

    /**
     * Set el valor de indicativo_juez
     *
     * @return  self
     */
    public function setIndicativo_juez($indicativo_juez)
    {
        $this->indicativo_juez = $indicativo_juez;

        return $this;
    }

    /**
     * Get el valor de hora
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set el valor de hora
     *
     * @return  self
     */
    public function setHora($hora)
    {
        if (gettype($hora)==="DateTimeImmutable") {
            # ya es una fecha
            $this->hora = $hora;
        }else {
            $this->hora = new DateTimeImmutable($hora);
        }

        return $this;
    }

    /**
     * Get el valor de id_banda
     */
    public function getId_banda()
    {
        return $this->id_banda;
    }

    /**
     * Set el valor de id_banda
     *
     * @return  self
     */
    public function setId_banda($id_banda)
    {
        $this->id_banda = $id_banda;

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
     * Get the value of validado
     */ 
    public function getValidado()
    {
        return $this->validado;
    }

    /**
     * Set the value of validado
     *
     * @return  self
     */ 
    public function setValidado($validado)
    {
        $this->validado = $validado;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
       $json = new stdClass();
       
        $json->id = $this->getId();
        $json->participacion = $this->getId_participante();
        $json->idConcurso = $this->getId_concurso();
        $json->id_banda = $this->getId_banda();
        $json->id_modo = $this->getId_modo();
        $json->juez = $this->getIndicativo_juez();
        $json->hora = $this->getHora();
        $json->validado = $this->getValidado();

       return $json; 
    }

}
