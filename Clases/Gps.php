<?php
class Gps {
    private float $x;
    private float $y;

    public function __construct($x,$y)
    {
        $this->setX($x);
        $this->setY($y);
    }
    public function setX (float $x = null)
    {
        $latitud = $x;
        $this->x = $latitud;
    }
    public function setY (float $y = null)
    {
        $longitud = $y;
        $this->y = $longitud;
    }

    /**
     * Get the value of y
     */ 
    public function getY()
    {
        return $this->y;
    }
    /**
     * Get the value of x
     */ 
    public function getX()
    {
        return $this->x;
    }

    public function __toString()
    {
        return "POINT(".$this->getX().",".$this->getY().")";
    }
    
   
}