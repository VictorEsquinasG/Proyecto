<?php

$participa = false; // A priori no sabemos si participa
$juez = false; // A priori no es juez
$rPar = new repParticipacion(gbd::getConexion());

if (!Sesion::existe('user')) {
    # Si no está logeado
    header("Location:?menu=registrate");
} else {
    $admin = Sesion::leer('user')->getRol() === "admin";
    # Cogemos el usuario
    $idUsuario = Sesion::leer('user')->getId();
}

if (isset($_GET['concurso'])) {
    # Aquí no comprobaremos su rol, cualquiera puede unirse al concurso
    $repP = new repParticipacion(gbd::getConexion());
    $rp = new repConcurso(gbd::getConexion());
    # capturamos el id
    $idConcurso = $_GET['concurso'];
    # Cogemos el concurso dado
    $concurso = $rp->getById($idConcurso);
    # Preparamos su página propia
    print "<div class='c-contConcurso'>";
    print "<div class='c-contConcurso__h'>";
    echo "<h1 class='g--font-size-4l'>Concurso: " . $concurso->getNombre() . "</h1>";
    if ($concurso->tieneCartel()) {
        # Si tiene imagen se la imprimimos
        // echo "<img src='data:image/png;base64," . $concurso->getCartel() . "'>";
    }

} else {
    # si no tiene la cookie ni ha hecho submit -> Index.php
    header("Location:?menu=inicio");
}

$participantes = $repP->getParticipantes($idConcurso);
$concursosD = $rp->getConcursosDisponibles();
# Concurso = disponible
for ($j = 0; $j < count($concursosD); $j++) {
    if ($concursosD[$j]->getId() === $concurso->getId()) {
        # Si el concurso existiera y el usuario no está en él
        # comprobamos si no es uno de los participantes ya inscritos
        if (!in_array($idUsuario, $participantes)) {
            # pintamos el botón de unirse
            echo "<form action='' method='POST'>";
            echo "<input type='submit' class='c-card__btn c-btn--primary c-btn--primary__form' name='submit' value='Unirse'>";
            echo "</form>";
        } else {
            $part = $rPar->get($idConcurso, $idUsuario);
            $juez = ($part->getRol() === "juez");
            if (!$juez) {
                # pintamos el botón de darse de baja
                echo "<form action='' method='POST'>";
                echo "<input type='submit' class='c-card__btn c-btn--primary c-btn--primary__form' name='submit' value='Darme de baja'>";
                echo "</form>";
                $participacion = new Participacion();
                $parti = $repP->get($idConcurso, $idUsuario);
                $participacion->rellenaParticipacion(null, 'user', $idConcurso, $parti->getId());
            }
            $participa = true;
        }
    }
}

print "<p id='contador' fechaFin='" . $concurso->getFechFin()->format('Y-m-d H:i:s') . "'></p>";
print "</div>";

print "<div class='c-contConcurso__desc'>";
print "<p> Descripción: " . $concurso->getDesc() . "</p>";
# numero de participantes del concurso
$num = $repP->cuantos($idConcurso);
$jueces = $repP->getNumJueces($idConcurso);

echo "<br>";
echo "<img src='./images/hombre.png' width='20px' title='participantes' alt='Participantes'>" . $num['COUNT(id)'] . "\n";
echo "<img src='./images/judge.png' width='20px' title='jueces' alt='Jueces'>" . $jueces['COUNT(id)'] . "</p>";
if ($admin) {
    # El admin podrá dar de alta a los usuarios y asignar los jueces
    echo "<br>";
    echo "<a class='c-card__btn c-btn--primary' href='?menu=alta'>Gestionar</a>";
}
if ($juez) {
    # El juez validará mensajes
    echo "<br><br>";
    echo "<a class='c-card__btn c-btn--primary' href='?menu=mensaje&conc=" . $idConcurso . "'>Validar mensajes</a>";
}
print "</div>";

print "<div class='c-concursos__tabla'>";
# Tabla de MODOS Y BANDAS
echo "<table class='c-contConcurso__tabla--1' style='margin-left: 24px;'>";
echo "<thead>" . "<th> " . ' <span id="btnAsc">▲▼</span>' . "MODOS</th>" .
    "<th>" . ' <span id="btnAsc">▲▼</span>' . "BANDAS</th>" . "</thead>";
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
if ($participa && !$juez) { 
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
                        <div class="c-card__btn c-btn--primary" idConcurso="$idConcurso" idUsuario="$idUsuario" id="annadir">+</div>
                        $filas
                    </tbody>        
                </table>
            </form>
        EOD;
    if (!$concurso->acabado()) {
        # Si el concurso sigue activo podemos mandar mensajes
        print $msg;
    }
}
print "</div>";
print "</div>";
print "</div>";
print "</div>";

# Matamos la cookie (le damos 3s)
// setcookie('id', $_COOKIE['id'], time() + 3);

if (isset($_POST['submit'])) {
    # Comprobamos si se da de baja o se une
    if ($_POST['submit'] === "Unirse") {
        # Cogemos el concursante y creamos la participación
        $part = new Participacion();
        $usuario = Sesion::leer("user")->getId();
        $part->rellenaParticipacion(null, 'user', $idConcurso, $usuario); # Por defecto -> No es juez
        # Lo unimos al concurso
        if ($repP->set($part) != false) {
            # Si se insertó hacemos alguna señal
            echo "<h1>ENTRADO</h1>";
            header("Location:?concurso=$idConcurso");
        }
    } else if ($_POST['submit'] === "Darme de baja") {
        # lo damos de baja
        $usuario = Sesion::leer("user")->getId();
        $part = $rPar->get($idConcurso, $usuario);
        # Borramos
        $rPar->delete($part->getId());
    }
}
// else if(isset($_POST['newMsg'])) # Mensaje
// {
//     $msg = new QSO();
//     // $msg 
// }
?>
<script src="./js/contador.js"></script>
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