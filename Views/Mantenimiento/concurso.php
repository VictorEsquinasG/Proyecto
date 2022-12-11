<?php

$participa = false; // A priori no sabemos si participa

if (isset($_COOKIE['id'])) {
    # Aquí no comprobaremos su rol, cualquiera puede unirse al concurso
    $repP = new repParticipacion(gbd::getConexion());
    $rp = new repConcurso(gbd::getConexion());
    # capturamos el id
    $idConcurso = $_COOKIE['id'];
    # Cogemos el concurso dado
    $concurso = $rp->getById($idConcurso);
    # Preparamos su página propia
    print "<div class='c-contConcurso'>";
    print "<div class='c-contConcurso__h'>";
    echo "<h1 class='g--font-size-4l'>Concurso: " . $concurso->getNombre() . "</h1>";
    if ($concurso->tieneCartel()) {
        # Si tiene imagen se la imprimimos
        echo "<img src='data:image/png;base64," . $concurso->getCartel() . "'>";
    }

    $participantes = $repP->getParticipantes($idConcurso);
    $concursosD = $rp->getConcursosDisponibles();
    # Concurso = disponible
    for ($j = 0; $j < count($concursosD); $j++) {
        if ($concursosD[$j]->getId() === $concurso->getId()) {
            # Si el concurso existiera y el usuario no está en él
            # comprobamos si no es uno de los participantes ya inscritos
            if (!in_array(Sesion::leer('user')->getId(), $participantes)) {
                # pintamos el botón de unirse
                echo "<form action='' method='POST'>";
                echo "<input type='submit' class='c-card__btn c-btn--primary c-btn--primary__form' name='submit' value='Unirse'>";
                echo "</form>";
            } else {
                $participacion = new Participacion();
                $parti = $repP->get($idConcurso, Sesion::leer('user')->getId());
                $participacion->rellenaParticipacion(null, 'user', $idConcurso, $parti->getId());

                $participa = true;
            }
            // echo "<button onclick='unirse($idConcurso)'>Unirse</button>";
        }
    }

    print "</div>";

    print "<div class='c-contConcurso__desc'>";
    print "<p> Descripción: " . $concurso->getDesc() . "</p>";
    # numero de participantes del concurso
    $num = $repP->cuantos($idConcurso);
    $jueces = $repP->getNumJueces($idConcurso);
    echo "<br>";
    echo "<img src='./images/hombre.png' width='20px' title='participantes' alt='Participantes'>" . $num['COUNT(id)'] . "\n";
    echo "<img src='./images/judge.png' width='20px' title='jueces' alt='Jueces'>" . $jueces['COUNT(id)'] . "</p>";
    print "</div>";

    print "<div class='c-concursos__tabla'>";
    # Tabla de MODOS Y BANDAS
    echo "<table class='c-contConcurso__tabla--1' style='margin-left: 24px;'>";
    echo "<thead>" . "<th>MODOS</th>" . "<th>BANDAS</th>" . "</thead>";
    # Tbody
    echo "<tbody>";
    # Consultamos los modos y las bandas
    $modos = $rp->get_modos($idConcurso);
    $bandas = $rp->get_bandas($idConcurso);
    $tamanio = count($bandas);
    $tamanio2 = count($modos);

    # Listamos
    for ($i = 0; $i < $tamanio2; $i++) {
        echo "<tr>";
        $j = 0;
        while ($j < $tamanio) {
            # si o si entra aquí, si no hay banda o modo -> <td></td>
            $mode = $modos[$i]->getNombre() != null ? "<td>" . $modos[$i]->getNombre() . "</td>" : "<td></td>";
            $band = $bandas[$j]->getNombre() != null ? "<td>" . $bandas[$j]->getNombre() . "</td>" : "<td></td>";
            $j++;
        }

        echo $mode;
        echo $band;
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

    # Mensajes
    if ($participa && Sesion::leer('user')->getRol() !== 'juez') {
        # Si es concursante podrá enviar mensajes
        $repbanda = new repBanda(gbd::getConexion());
        $repModo = new repModo(gbd::getConexion());
        #RELLENAMOS LA TABLA DE MENSAJES
        $rM = new repQSO(gbd::getConexion());
        $mensajes = $rM->getMsg($idConcurso, $parti->getId());
        $filas = "";
        for ($i = 0; $i < count($mensajes); $i++) {
            $filas .= "<tr>";
            # Cogemos el mensaje que toca
            $m = $mensajes[$i];
            # Listamos los mensajes
            $filas .= "<td>" . $m->getHora()->format('d/m/Y H:i:s') . "</td>";
            $banda = $repbanda->getById($m->getId_Banda());
            $filas .= "<td>" . $banda->getNombre() . "</td>";
            $modo = $repModo->getById($m->getId_modo());
            $filas .= "<td>" . $modo->getNombre() . "</td>";
            $filas .= "<td>" . $m->getIndicativo_juez() . "</td>";
            $filas .= "</tr>";
        }
        $msg = <<<EOD
            <form action='' method='POST' class="c-contConcurso__tabla--2" id="mensajes" style="margin:0;display:flex;flex-direction:row;flex:1 1 100%">
                <table style="margin-top:0px">
                    <thead> <th>Hora</th><th>Banda</th><th>Modo</th><th>Juez</th> </thead>
                    <tbody>
                        <div class="c-card__btn c-btn--primary" idConcurso="$idConcurso" id="annadir">+</div>
                        $filas
                    </tbody>        
                </table>
            </form>
        EOD;
        print $msg;
    }
    print "</div>";
    print "</div>";
    print "</div>";
    print "</div>";


    # Matamos la cookie
    setcookie('id', $_COOKIE['id'], time() - 300);
} else {
    # si no tiene la cookie ni ha hecho submit -> Index.php
    header("Location:?menu=inicio");
}
if (isset($_POST['submit'])) {
    # Cogemos el concursante y creamos la participación
    $part = new Participacion();
    $usuario = Sesion::leer("user")->getId(); #TODO idConcurso no existe pero la cookie tampoco
    $part->rellenaParticipacion(null, 'user', $idConcurso, $usuario); # Por defecto -> No es juez
    # Lo unimos al concurso
    if ($repP->set($part) != false) {
        # Si se insertó hacemos alguna señal
        echo "<h1>ENTRADO</h1>";
        header("Location:?concurso=$idConcurso");
    }
}
// else if(isset($_POST['newMsg'])) # Mensaje
// {
//     $msg = new QSO();
//     // $msg 
// }
?>
<script src="./js/api/qso.js">
    // function unirse(id) {
    //     let response = await fetch('./API/meteConcurso.php')
    //         // Éxito
    //         .then(response => response.json()) // a JSON
    //         // ERROR
    //         .catch(err => console.log("Fallo al leer los participantes", err));

    //     let data = await JSON.parse(JSON.stringify(response));
    //     return data;
    // }
</script>