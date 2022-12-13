<?php

class Usuario implements JsonSerializable
{
    // use Rol;
    /* PROPIEDADES */
    public $id;
    public $identificativo;
    public $nombre;
    public $ap1;
    public $ap2;
    public $email;
    public $pssword;
    public $rol;
    public Gps $gps;
    public $img;

    /**
     * Constructor a partir de un array asociativo
     * Las claves del array son: id,identificativo,nombre,ap1,ap2,email,pssword,
     * rol,gps,img
     */
    public function rellenaUsuarioArray($usuario)
    {
        $this->setId($usuario['id']);
        $this->setIdentificativo($usuario['identificativo']);
        $this->setNombre($usuario['nombre']);
        $this->setAp1($usuario['ap1']);
        $this->setAp2($usuario['ap2']);
        $this->setEmail($usuario['email']);
        $this->setPssword($usuario['pssword']);
        $this->setRol($usuario['rol']);
        $this->setGps($usuario['gps']);
        $this->setImg($usuario['img']);
    }
    /**
     * Constructor
     */
    public function rellenaUsuario($id, $identificativo, $email, $pssword, $nombre, $ap1, $ap2, $gps, $rol = 'user', $img = null)
    {
        $this->setId($id);
        $this->setIdentificativo($identificativo);
        $this->setNombre($nombre);
        $this->setAp1($ap1);
        $this->setAp2($ap2);
        $this->setEmail($email);
        $this->setPssword($pssword);
        $this->setRol($rol);
        $this->setGps($gps);
        $this->setImg($img);
    }

    /**
     * Get el valor de $nombre
     */
    public function getNombre()
    {
        $nombre = $this->nombre;
        return $nombre;
    }

    /**
     * Set el valor de $nombre
     *
     * @return  self
     */
    private function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Devuelve el nombre completo del usuario en formato
     * NOMBRE APELLIDO1 APELLIDO2 
     * con las primeras letras mayúsculas
     */
    public function getNombreCompleto(): string
    {
        # Componemos el nombre completo pasamos a minusculas todos los segmentos
        $nombre = strtolower($this->getNombre()) . " " . strtolower($this->getAp1()) . " " . strtolower($this->getAp2());
        # Ahora ponemos la primera letra de cada palabra a mayúsculas
        return ucwords($nombre);
    }

    /**
     * Get el valor de  ap1
     */
    public function getAp1()
    {
        $apellido = $this->ap1;
        return $apellido;
    }

    /**
     * Set el valor de  ap1
     *
     * @return  self
     */
    private function setAp1($ap1)
    {
        $this->ap1 = $ap1;

        return $this;
    }

    /**
     * Get el valor de  ap2
     */
    public function getAp2()
    {
        $apellido = $this->ap2;
        return $apellido;
    }

    /**
     * Set el valor de  ap2
     *
     * @return  self
     */
    private function setAp2($ap2)
    {
        $this->ap2 = $ap2;

        return $this;
    }

    /**
     * Get el valor de  identificativo
     */
    public function getIdentificativo()
    {
        $id = $this->identificativo;
        return $id;
    }

    /**
     * Set el valor de  identificativo
     *
     * @return  self
     */
    private function setIdentificativo($identificativo)
    {
        $this->identificativo = $identificativo;

        return $this;
    }

    /**
     * Get el valor de  email
     */
    public function getEmail()
    {
        $correo = $this->email;
        return $correo;
    }

    /**
     * Set el valor de  email
     *
     * @return  self
     */
    private function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get el valor de  pssword
     */
    public function getPssword(): string
    {
        $pass = $this->pssword;
        return $pass;
    }

    /**
     * Set el valor de  pssword
     *
     * @return  self
     */
    private function setPssword($pssword)
    {
        $this->pssword = $pssword;

        return $this;
    }

    /**
     * Get el valor de  img
     */
    public function getImg()
    {
        $png = $this->img;
        return $png;
    }

    /**
     * Set el valor de  img
     *
     * @return  self
     */
    private function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get el valor de  rol
     */
    public function getRol()
    {
        $role = $this->rol;
        return $role;
    }

    /**
     * Set el valor de  rol
     *
     * @return  self
     */
    private function setRol($rol)
    {
        if (($rol === 'user') || ($rol === 'admin')) {
            $this->rol = $rol;
            return $this;
        } else {
            throw new Exception("Error. Rol de usuario no válido");
        }
    }

    /**
     * Get el valor de  gps
     */
    public function getGps(): gps
    {
        $direccion = $this->gps;
        return $direccion;
    }

    /**
     * Set el valor de  gps
     *
     * @return  self
     */
    private function setGps(gps $gps)
    {
        $this->gps = $gps;

        return $this;
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

    public function jsonSerialize(): mixed
    {
        # Método para poder hacer un JSON de Usuario
        # Aunque sus propiedades sean privadas
        $json = new stdClass();

        $json->id = $this->getId();
        $json->indicativo = $this->getIdentificativo();
        $json->email = $this->getEmail();
        $json->password = $this->getPssword();
        $json->nombre = $this->getNombre();
        $json->apellido1 = $this->getAp1();
        $json->apellido2 = $this->getAp2();
        $json->rol = $this->getRol();
        $json->Gps = $this->getGps();
        $json->imagen = $this->getImg();

        return $json;
    }
}
