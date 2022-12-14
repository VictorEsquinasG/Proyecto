<?php
    require_once('../Chargers/autoloader.php');

    Sesion::iniciar();
    if (Sesion::existe('user') && Sesion::leer('user')->getRol('admin')) {
        # Sólo si tiene credenciales le permitimos utilizar la API
        $rp = new repUsuarios(gbd::getConexion());
        
        $us = new Usuario();
        $par['id'] = null; // Creamos -> El id es null
        $par['identificativo'] = $_POST['indicativo'];
        $par['nombre'] = $_POST['nombre'];
        $par['ap1'] = $_POST['ap1'];
        $par['ap2'] = $_POST['ap2'];
        $par['email'] = $_POST['email'];
        $par['pssword'] = $_POST['contrasena'];
        $par['rol'] = $_POST['rol'];
        $par['gps'] = new Gps($_POST['lat'],$_POST['lon']);

        if (isset($_FILES['imagen']) ) {
            // A base64
            $imagen=file_get_contents($_FILES['imagen']['tmp_name']);
            $imagen=base64_encode($imagen);
            $par['imagen'] =  $imagen; 
        }else{
            $par['imagen'] = null;
        }


        $us->rellenaUsuarioArray($par);
        $hecho = $rp->addUser($us);
        
        echo json_encode($hecho);
    }