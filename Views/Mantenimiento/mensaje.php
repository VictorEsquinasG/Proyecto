<?php
/* MANTENIMIENTO MENSAJES + VALIDAR MENSAJES (JUEZ) */

$rPar = new repParticipacion(gbd::getConexion());
$rm = new repQSO(gbd::getConexion()); # Repositorio mensajes

# Si no está logueado se expulsa
!Sesion::existe('user') ? header("Location:?menu=registrate") : null;
# Cogemos el usuario
$usuario = Sesion::leer('user');

$juez = false;
$admin = $usuario->getRol() === "admin";

/* Si viene con un concurso concreto */
if (isset($_GET['conc'])) {
    # Cogemos el concurso que quiere
    $idConcurso = $_GET['conc'];

    $part = $rPar->get($idConcurso, $usuario->getId());
    $juez = ($part->getRol() === "juez");
    # Para estar aquí o es juez o es admin
} else {
    /* Si no viene con ningún concurso debe ser admin */
    !$admin ? header("Location:?menu=registrate") : null;
}

!$juez && !$admin ? header("Location:?menu=registrate") : null;

if (isset($_POST['valida'])) {
    # Validamos el mensaje
    // $rm->validar();
}

$rC = new repConcurso(gbd::getConexion());
$concursos = $rC->getAllConcursos();
$opt = "";
for ($i = 0; $i < count($concursos); $i++) {
    $concurso = $concursos[$i];
    # concursos al select
    $opt .= "<option value='" . $concurso->getId() . "'>" . $concurso->getNombre() . "</option>";
}

$selecConcurso = <<<EOD
<th>
    <select id="conc" name="conc">
        $opt
    </select>
</th>
EOD;
?>
<section>
    <div style="margin-left: 40rem;color:orange;font-weight:bold;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
        <h1 class="g--font-size-5l">Mensajes QSO</h1>
    </div>
    <article class="tablas">
        <table>
            <thead>
                <th>Banda <span id="btnAsc">▲▼</span></th>
                <th>Modo <span id="btnAsc">▲▼</span></th>
                <th>Hora <span id="btnAsc">▲▼</span></th>
                <th>Remitente <span id="btnAsc">▲▼</span></th>
                <th>Destinatario <span id="btnAsc">▲▼</span></th>
                <th>Concurso <span id="btnAsc">▲▼</span></th>
                <th>Validado</th>
                <?= $admin ? $selecConcurso : "" ?>
            </thead>
            <tbody>
                <?php
                /*
                 Cogemos el concurso según el SELECT y ponemos el SELECT fijo con el concurso de la ID por si entra siendo juez
                 a través de su concurso
                */
                //TODO el id del concurso se cogerá siempre del SELECT que estará seleccionado de forma fija para no administradores
                // $concurso = $rC->getById(); 
                // Los mensajes
                /* try { */
                $mensajes = $rm->getFrom($idConcurso);
                /*  } catch (Exception $e) {
                    // por defecto devolvemos un array con un mensaje
                    $mensajes = [];
                    $ms = new QSO();
                    $ms->rellenaQSO(null,0,0,0,0,'sin mensajes',time());
                    $mensajes[] = $ms;

                    $men = $e->getMessage();
                    echo "<script>console.log($men)</script>";
                } */

                $name = $concurso->getNombre();
                foreach ($mensajes as $msg) {
                    # Cada mensaje se añade a la tabla
                    if ($juez && $msg->getIndicativo_juez() === $usuario->getIdentificativo() && !$msg->getValidado()) { //TODO || $admin
                        # si tú eres el juez y no está validado aún
                        $valida = "<td><button class='c-btn--primary c-card__btn btnMsg' idQso='" . $msg->getId() . "' style='width:100%'>❌</button></td>";
                    } else {
                        ($juez && $msg->getIndicativo_juez() === $usuario->getIdentificativo() &&  $msg->getValidado()) ? $valida = "<td><button class='c-btn--primary c-card__btn btnBMsg' idQso='" . $msg->getId() . "' style='width:100%'>✅</button></td>" : $valida = "<td></td>";
                    }
                    $rB = new repBanda(gbd::getConexion());
                    $Banda = $rB->getById($msg->getId_banda());
                    $rM = new repModo(gbd::getConexion());
                    $Modo = $rM->getById($msg->getId_modo());
                    $rU = new repUsuarios(gbd::getConexion());
                    $participante = $rU->getById($rPar->getById($msg->getId_participante())->getId_usuario());

                    $quien = "<td>" . $participante->getIdentificativo() . " · " . $participante->getNombre() . "</td>";
                    $banda = "<td>" . $Banda->getNombre() . "</td>";
                    $modo = "<td>" . $Modo->getNombre() . "</td>";
                    $destino = "<td>" . $msg->getIndicativo_juez() . "</td>";
                    $hora = "<td>" . $msg->getHora()->format("d/m/Y H:i:s") . "</td>";
                    $con = "<td>" . $name . "</td>";
                    $relleno = "<td></td>";

                    echo "<tr>" . $banda . $modo . $hora . $quien . $destino . $con . $valida . $relleno . "</tr>";
                }
                ?>
            </tbody>
        </table>
        <script src="./js/Helper/validaMensaje.js"></script>
        <script src="./js/clases/tabla.js"></script>
    </article>
</section>