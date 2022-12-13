<?php
class Validacion
{
    //Array de errores
    private $errores;

    //Constructor
    public function __construct()
    {
        $this->errores = array();
    }

    /**
     * Comprueba si esta vacio
     *
     * @param [type] $campo
     * @return boolean
     */
    public function Requerido($campo)
    {
        if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
            $this->errores[$campo] = "El campo $campo no puede estar vacio";
            return false;
        }
        return true;
    }

    /**
     * Método que comprueba que el campo es un valor entero
     * y de manera opcional un rango de valores
     *
     * @param [String] $campo
     * @param [int] $min
     * @param [int] $max
     * @return boolean
     */
    public function EnteroRango($campo, $min = PHP_INT_MIN, $max = PHP_INT_MAX)
    {
        if (!filter_var(
            $_POST[$campo],
            FILTER_VALIDATE_INT,
            ["options" => ["min_range" => $min, "max_range" => $max]]
        )) {
            $this->errores[$campo] = "Debe ser entero entre $min y $max";
            return false;
        }
        return true;
    }
        
    public function RealRango($campo, $min = PHP_FLOAT_MIN, $max = PHP_FLOAT_MAX)
    {
        if (!filter_var(
            $_POST[$campo],
            FILTER_VALIDATE_FLOAT,
            ["options" => ["min_range" => $min, "max_range" => $max]]
        )) {
            $this->errores[$campo] = "Debe ser real entre $min y $max";
            return false;
        }
        return true;
    }

    /**
     * Método que comprueba el número de caracteres de la cadena
     * entre un mínimo y un máximo
     *
     * @param [String] $campo
     * @param [integer] $max
     * @param integer $min
     * @return boolean
     */
    public function CadenaRango($campo, $max, $min = 0)
    {
        if (!(strlen($_POST[$campo]) > $min && strlen($_POST[$campo]) < $max)) {
            $this->errores[$campo] = "Debe tener entre $min y $max caracteres";
            return false;
        }
        return true;
    }

    /**
     * Comprueba si el campo es un email válido
     *
     * @param [String] $campo
     * @return boolean
     */
    public function Email($campo)
    {
        if (!filter_var($_POST[$campo], FILTER_VALIDATE_EMAIL)) {
            $this->errores[$campo] = "Debe ser un email válido";
            return false;
        }
        return true;
    }

    public function Dni($campo)
    {
        $letras = "TRWAGMYFPDXBNJZSQVHLCKE";
        $mensaje = "";
        if (preg_match("/^[0-9]{8}[a-zA-z]{1}$/", $_POST[$campo]) == 1) {
            $numero = substr($_POST[$campo], 0, 8);
            $letra = substr($_POST[$campo], 8, 1);
            if ($letras[$numero % 23] == strtoupper($letra)) {
                return TRUE;
            } else {
                $mensaje = "El campo $campo es un Dni con letra no válida";
            }
        } else {
            $mensaje = "El campo $campo no es un Dni válido";
        }
        $this->errores[$campo] = $mensaje;
        return FALSE;
    }

    /**
     * Comprueba si el campo cumple una expresión regular (patrón)
     *
     * @param [string] $campo
     * @param [string] $patron
     * @return boolean
     */
    public function Patron($campo, $patron)
    {
        if (!preg_match($patron, $_POST[$campo])) {
            $this->errores[$campo] = "No cumple el patrón $patron";
            return false;
        }
        return true;
    }

    /**
     * Ejecuta una función que será la encargada de validar el campo
     *
     * @param [type] $campo
     * @param [type] $funcion
     * @param [type] $mensaje
     * @return boolean
     */
    public function ValidaConFuncion($campo, $funcion, $mensaje)
    {
        if (!call_user_func($funcion)) {
            $this->errores[$campo] = $mensaje;
            return false;
        }
        return true;
    }

    /**
     * Comprueba si hay errores
     *
     * @return bool
     */
    public function ValidacionPasada(): bool
    {
        if (count($this->errores) != 0) {
            return false;
        }
        return true;
    }

    public function ImprimirError($campo)
    {
        return
            isset($this->errores[$campo]) ? '<span class="error">' . $this->errores[$campo] . '</span>' : '';
    }

    public function getValor($campo)
    {
        return
            isset($_POST[$campo]) ? $_POST[$campo] : '';
    }

    public function fechaPosterior($fecha1, $fecha2,$campo): bool
    {
        # Cogemos las fechas        
        $fecha1 = new DateTimeImmutable($fecha1);
        $fecha2 = new DateTimeImmutable($fecha2);

        // calculamos la diferencia
        $dif = $fecha1->diff($fecha2);
        if ($dif->invert == 0) {
            # Vemos si su diferencia es 0s  
            return true;
        } else {
            $this->errores[$campo] = "Fecha anterior a la permitida";
            return false;
            // throw new Exception("Error FECHA MAL ESTABLECIDA");
        }
    }

    public function getSelected($campo, $valor)
    {
        return
            isset($_POST[$campo]) && $_POST[$campo] == $valor ? 'selected' : '';
    }

    public function getChecked($campo, $valor)
    {
        return
            isset($_POST[$campo]) && $_POST[$campo] == $valor ? 'checked' : '';
    }
}
