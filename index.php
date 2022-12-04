<?php
class Principal
{
    public static function main()
    {
        require_once './Chargers/autoloader.php';
        require_once './Views/Principal/layout.php';
    }
}
Principal::main();

// PRUEBAS DE REPOSITORIOS
// $con =  gbd::getConexion();
// $rp = new repUsuarios($con);
// $rp->getById(5);

?>