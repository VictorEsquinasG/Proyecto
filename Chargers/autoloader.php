<?php

function mi_autoCargador($clase)
{
    // Le concatenamos el nombre del proyecto
    $raiz = $_SERVER["DOCUMENT_ROOT"] . "/Proyecto"; 

    // Comprobamos que el fichero existe y según dónde se encuentre lo importamos
    if (file_exists("$raiz/Clases/$clase.php")) {
        require_once("$raiz/Clases/$clase.php");
    }else if (file_exists("$raiz/Helper/$clase.php")){
        require_once("$raiz/Helper/$clase.php");
    }else if (file_exists("$raiz/data/$clase.php")){
        require_once ("$raiz/data/$clase.php");
    }else if (file_exists("$raiz/Repositories/$clase.php")){
        require_once("$raiz/repositories/$clase.php");
    }
}

spl_autoload_register("mi_autoCargador");

?>