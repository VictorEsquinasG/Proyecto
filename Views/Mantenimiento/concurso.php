<?php
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
    for ($i = 0; $i < count($participantes); $i++) {
        # comprobamos todos los IDs en todos los concursos disponibles
        for ($j = 0; $j < count($concursosD); $j++) {
            if (($concursosD[$j] === $concurso) && (Sesion::leer('user')->getId() !== $participantes[$i])) {
                #TODO
                # Si el concurso existiera y el usuario no está en él
                echo "<form action='' method='POST'>";
                echo "<input type='submit' name='submit' value='Unirse'>";
                echo "</form>";
                // echo "<button onclick='unirse($idConcurso)'>Unirse</button>";
            }
        }
    }
    print "</div>";
    print "<div class='c-contConcurso__desc'>";
    print "<p>" . $concurso->getDesc() . "</p>";
    print "</div>";
    # Tabla de MODOS Y BANDAS
    echo "<table>";
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
            $mode = $modos[$i]->getNombre()!=null?"<td>" . $modos[$i]->getNombre() . "</td>":"<td></td>";
            $band = $bandas[$j]->getNombre()!=null?"<td>" . $bandas[$j]->getNombre() . "</td>":"<td></td>";
            $j++;
        }
            
        echo $mode;
        echo $band;
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
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
?>
<script>
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