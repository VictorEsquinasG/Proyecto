<?php
    if (Sesion::existe('user'))
    {
        $usuario = Sesion::leer('user');
    }else {
        header('Location:?menu=registrate');
    }
?>
<!DOCTYPE html>
<html lang="es-ES">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIPLOMA</title>
</head>

<body> 
    <h2><?= $usuario->getNombreCompleto() ?></h2>
    <p>Desde <?= $usuario->getGps() ?></p>
    <p>Premios: </p><br>
    <ul>
        <li>Perseverancia</li>
        <li>Constancia</li>
        <li>Optimismo</li>
        <li>Autoestima</li>
        <li>Trabajo en Equipo</li>
        <li>Jamón Pata Negra</li>
    </ul>
    <img style="height: 300px ; width: auto;" src="./img/06072-jamon-iberico-puro-pata-negra-julian-martin-guijuelo.jpg" alt="">
</body>

</html>