<?php
/* MANTENIMIENTO MENSAJES + VALIDAR MENSAJES (JUEZ) */

$rPar = new repParticipacion(gbd::getConexion());
$rm = new repQSO(gbd::getConexion()); # Repositorio mensajes

!Sesion::existe('user') ? header("Location:?menu=registrate") : null;
$usuario = Sesion::leer('user');
$admin = $usuario->getRol() === "admin";


/* Si viene con un concurso concreto */
if (isset($_GET['conc'])) {
    # Cogemos el concurso que quiere
    $idConcurso = $_GET['conc'];
    $part = $rPar->get($idConcurso, $usuario->getId());
    $juez = $part->getRol() === "juez" ? true : false;
    # Para estar aquí o es juez o es admin
    !$juez || !$admin ? header("Location:?menu=registrate") : null;
} else {
    /* Si no viene con ningún concurso debe ser admin */
    !$admin ? header("Location:?menu=registrate") : null;
}


if (isset($_POST['valida'])) {
    # Validamos el mensaje
    // $rm->validar();
}

$rC = new repConcurso(gbd::getConexion());
$concursos = $rC->getAllConcursos();
$opt = "";
for ($i=0; $i < count($concursos); $i++) { 
    $concurso = $concursos[$i];
    # concursos al select
    $opt .= "<option value='".$concurso->getId()."'>".$concurso->getNombre()."</option>";
}

$selecConcurso = <<<EOD
<th>
    <select id="" name="conc">
        $opt
    </select>
</th>
EOD;
?>
<article class="tablas">
    <table>
        <thead>
            <th>Banda<span id="btnDec">▼</span> <span id="btnAsc">▲</span> </th>
            <th>Modo<span id="btnDec">▼</span> <span id="btnAsc">▲</span> </th>
            <th>Hora<span id="btnDec">▼</span> <span id="btnAsc">▲</span> </th>
            <th>Remitente<span id="btnDec">▼</span> <span id="btnAsc">▲</span> </th>
            <th>Concurso<span id="btnDec">▼</span> <span id="btnAsc">▲</span> </th>
            <?= $admin ? $selecConcurso : "" ?>
        </thead>
        <tbody>
            <?php
                $mensajes = $rm->getFrom($idConcurso);
                $name = $concurso->getNombre();
                foreach ($mensajes as $msg) {
                    # Cada mensaje se añade a la tabla
                    if ($juez && $msg->getIndicativo_juez() === $usuario->getIdentificativo()) {
                        # si tú eres el juez
                        $valida = "<td><button>Validar</button></td>";
                    }else {
                        $valida = "<td></td>";
                    }
                    $rB = new repBanda(gbd::getConexion());
                    $Banda = $rB->getById($msg->getId_banda());
                    $rM = new repModo(gbd::getConexion());
                    $Modo = $rM->getById($msg->getId_modo());
                    $rU = new repUsuarios(gbd::getConexion());
                    $participante = $rU->getById($rPar->getById($msg->getId_participante())->getId_usuario());

                    $quien = "<td>".$participante->getIdentificativo()." · ".$participante->getNombre()."</td>";
                    $banda = "<td>".$Banda->getNombre()."</td>";
                    $modo = "<td>".$Modo->getNombre()."</td>";
                    $hora = "<td>".$msg->getHora()->format("d/m/Y H:i:s")."</td>";
                    $con = "<td>".$name."</td>";
                    
                    echo "<tr>".$banda.$modo.$hora.$quien.$con.$valida."</tr>";
                }
            ?>
        </tbody>
    </table>
    <script src="./js/tabla.js"></script>
</article>