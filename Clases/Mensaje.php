<?php

class Mensaje
{
    use rol;
    /* PROPIEDADES */
    private $id;
    private $banda_id;
    private $participacion_id;
    private $concurso_id;
    private $indicativo_juez;
    private $hora;
    private $modo_id;


    /**
     * Constructor a partir de un array asociativo
     * Las claves del array son: id,banda_id,participacion_id,concurso_id,indicativo_juez,hora,modo_id,
     */
    public function rellenaUsuarioArray($Mensaje)
    {
        $this->setId($Mensaje['id']);
        $this->setbanda_id($Mensaje['banda_id']);
        $this->setparticipacion_id($Mensaje['participacion_id']);
        $this->setconcurso_id($Mensaje['concurso_id']);
        $this->setindicativo_juez($Mensaje['indicativo_juez']);
        $this->sethora($Mensaje['hora']);
        $this->setmodo_id($Mensaje['modo_id']);
    }
    /**
     * Constructor
     */
    public function rellenaUsuario($id, $banda_id, $hora, $modo_id, $participacion_id, $concurso_id, $indicativo_juez)
    {
        $this->setId($id);
        $this->setbanda_id($banda_id);
        $this->setparticipacion_id($participacion_id);
        $this->setconcurso_id($concurso_id);
        $this->setindicativo_juez($indicativo_juez);
        $this->sethora($hora);
        $this->setmodo_id($modo_id);

    }

    /**
     * Get el valor de $participacion_id
     */
    public function getparticipacion_id()
    {
        $participacion_id = $this->participacion_id;
        return $participacion_id;
    }

    /**
     * Set el valor de $participacion_id
     *
     * @return  self
     */
    private function setparticipacion_id($participacion_id)
    {
        $id = $participacion_id;
        $this->participacion_id = $id;

        return $this;
    }

    /**
     * Get el valor de  concurso_id
     */
    public function getconcurso_id()
    {
        $apellido = $this->concurso_id;
        return $apellido;
    }

    /**
     * Set el valor de  concurso_id
     *
     * @return  self
     */
    private function setconcurso_id($concurso_id)
    {
        $id = $concurso_id;
        $this->concurso_id = $id;

        return $this;
    }

    /**
     * Get el valor de  indicativo_juez
     */
    public function getindicativo_juez()
    {
        $apellido = $this->indicativo_juez;
        return $apellido;
    }

    /**
     * Set el valor de  indicativo_juez
     *
     * @return  self
     */
    private function setindicativo_juez($indicativo_juez)
    {
        $this->indicativo_juez = $indicativo_juez;

        return $this;
    }

    /**
     * Get el valor de  banda_id
     */
    public function getbanda_id()
    {
        $id = $this->banda_id;
        return $id;
    }

    /**
     * Set el valor de  banda_id
     *
     * @return  self
     */
    private function setbanda_id($banda_id)
    {
        $this->banda_id = $banda_id;

        return $this;
    }

    /**
     * Get el valor de  hora
     */
    public function gethora()
    {
        $correo = $this->hora;
        return $correo;
    }

    /**
     * Set el valor de  hora
     *
     * @return  self
     */
    private function sethora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get el valor de  modo_id
     */
    public function getmodo_id()
    {
        $pass = $this->modo_id;
        return $pass;
    }
    /**
     * Get el valor de  id
     */ 
    public function getId()
    {
        $idnum = $this->id;
        return $idnum;
    }

    /**
     * Set el valor de  id
     *
     * @return  self
     */ 
    private function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of modo_id
     *
     * @return  self
     */ 
    public function setModo_id($modo_id)
    {
        $this->modo_id = $modo_id;

        return $this;
    }
}
