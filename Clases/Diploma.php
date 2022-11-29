<?php

class Diploma {
    private int $id;
    private int $id_concurso;
    private string $nombre;
    private int $min_puntuacion;
    private string $categoria;
    private $image;

    /**
     * Función que rellena el objeto Diploma con un array asociativo de claves:
     * @param id ID único de cada diploma
     * @param concurso_id El id del concurso al que pertenece
     * @param nombre El nombre que recibe el diploma
     * @param min La puntuación mínima para obtener el diploma
     * @param categoria La categoría a la que pertenece. Ejemplo: Oro, Plata o Bronce
     * @param imagen La imagen asociada al diploma (URL)
     */
    public function rellenaDiplomaArray($diploma)
    {
        $this->setId($diploma['id']);
        $this->setId_concurso($diploma['concurso_id']);
        $this->setNombre($diploma['nombre']);
        $this->setMin_puntuacion($diploma['min']);
        $this->setCategoria($diploma['categoria']);
        $this->setImage($diploma['imagen']);
    }
    /**
     * Método que rellena todos los campos de un Diploma dado
     * @param id ID único de cada diploma
     * @param id_concurso ID del concurso en el que se da ESTE diploma
     * @param nombre El nombre del diploma
     * @param min_puntuacion La puntuación mínima para obtener dicho diploma
     * @param categoria La categoría a la que pertenece. (Oro,Plata,Bronce)
     * @param imagen URL de la imagen asociada al diploma
     */
    public function rellenaDiploma($id,$id_concurso,$nombre,$min_puntuacion,$categoria,$imagen = null)
    {
        $this->setId($id);
        $this->setId_concurso($id_concurso);
        $this->setNombre($nombre);
        $this->setMin_puntuacion($min_puntuacion);
        $this->setCategoria($categoria);
        $this->setImage($imagen);
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
        $this->id = $id;

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
        $this->id_concurso = $id_concurso;

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
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get el valor de min_puntuacion
     */ 
    public function getMin_puntuacion()
    {
        return $this->min_puntuacion;
    }

    /**
     * Set el valor de min_puntuacion
     *
     * @return  self
     */ 
    public function setMin_puntuacion($min_puntuacion)
    {
        $this->min_puntuacion = $min_puntuacion;

        return $this;
    }

    /**
     * Get el valor de categoria
     */ 
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set el valor de categoria
     *
     * @return  self
     */ 
    public function setCategoria($categoria)
    {
        $cat = $categoria;
        $this->categoria = $cat;

        return $this;
    }

    /**
     * Get el valor de image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set el valor de image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }
}