<?php

class Usuario
{
    use Rol;
    /* PROPIEDADES */
    private $id;
    private $identificativo;
    private $nombre;
    private $ap1;
    private $ap2;
    private $email;
    private $pssword;
    private Rol $rol;
    private Gps $gps;
    private $img;

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
    public function getPssword()
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
    public function getRol():Rol
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
        if (($rol === Rol::user) || ($rol === Rol::admin)) {
            $this->rol = $rol;
            return $this;
        }else {
            throw new Exception("Error. Rol de usuario no válido");
        }
    }

    /**
     * Get el valor de  gps
     */
    public function getGps():gps
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
}
