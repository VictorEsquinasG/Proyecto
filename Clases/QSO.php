<?php

// MENSAJES QSO
class QSO
{

    /* PROPIEDADES */
    private int $id;
    private int $id_participante;
    private int $id_banda;
    private int $id_modo;
    private string $indicativo_juez;
    private DateTimeImmutable $hora;


    /**
     * Constructor
     */
    public function rellenaQSO($id, $id_participante,$id_modo,$id_banda,$indicativo_juez,$hora)
    {
        $this->setId($id);
        $this->setId_participante($id_participante);
        $this->setId_modo($id_modo);
        $this->setId_banda($id_banda);
        $this->setIndicativo_juez($indicativo_juez);
        $this->setHora($hora);
    }

    /**
     * Constructor
     * Requiere un Array Asociativo con las siguientes claves: 
     * @param id El id del mensaje
     * @param id_participante El id del participante que realiza el mensaje
     * @param id_modo El id del modo
     * @param id_banda El id de la banda
     * @param indicativo_juez El indicativo del juez contactado
     * @param fecha La fecha y hora en la que el mensaje se efectuó
     */
    public function rellenaQSOArray($mensaje)
    {
        $this->setId($mensaje['id']);
        $this->setId_participante($mensaje['id_participante']);
        $this->setId_modo($mensaje['id_modo']);
        $this->setId_banda($mensaje['id_banda']);
        $this->setIndicativo_juez($mensaje['indicativo_juez']);
        $this->setHora($mensaje['fecha']);
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
     * Get el valor de id_participante
     */
    public function getId_participante()
    {
        return $this->id_participante;
    }

    /**
     * Set el valor de id_participante
     *
     * @return  self
     */
    public function setId_participante($id_participante)
    {
        $this->id_participante = $id_participante;

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
        $this->hora = $hora;

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
}
