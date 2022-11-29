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
echo "<br><br><br><br><br><br><br><br><br>";
// $con =  gbd::getConexion();
// $rp = new repUsuarios($con);
// $rp->getById(5);

?>