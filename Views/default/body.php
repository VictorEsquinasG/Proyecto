<?php
$rp = new repConcurso(gbd::getConexion());
$concursos = $rp->getConcursosDisponibles();
if (Sesion::existe('user')) {
    $id = Sesion::leer('user')->getId();
    # Mis concursos
    $concursosParticipo = $rp->getMisConcursos($id);
    $tamanio = count($concursosParticipo);

    if ($tamanio > 0) {
        // Si hay concursos disponibles -> Pintamos contenedor de estos
        $div = <<<EOD
            <div class="c-panel">
                <div class="c-panel__h"><h2>MIS CONCURSOS</h2>
                <p>Únete a nuestros concursos con un sólo clic</p></div>
            <div class="c-panel__body">
            <div class='c-concursos__disp'>
        EOD;
        echo $div;
        for ($i = 0; $i < $tamanio; $i++) {
            # cada concurso se añade
            $concursos[$i]->tieneCartel() ? $img = '<img src="data:image/png;base64,' . $concursos[$i]->getCartel() . '" width="100px" class="c-card__img">' : $img = '';
            $btn = '<a href="?concurso=' . $concursos[$i]->getId() . '" class="c-card__btn c-card__btn--primary">Ir</a>';
            $name = $concursos[$i]->getNombre();
            # Si participo en concursos, éstos saldrán en la primera plana
            $div = <<<EOD
                
                <div class="c-card" style="width: 18rem;">
                    $img
                <div class="c-card__body">
                    <h5 class="c-card__title">$name</h5>
                    $btn
                </div>
            </div>
            EOD;
            echo $div;
        }
        // cerramos el contenedor
        print '</div>';
        print '</div>';
        print '</div>';
    }
}

$tamanio = count($concursos);
if ($tamanio > 0) {
    // Si hay concursos disponibles -> Pintamos contenedor de estos
    $div = <<<EOD
        <div class="c-panel">
            <div class="c-panel__h"><h2>CONCURSOS DISPONIBLES</h2>
            <p>Únete a nuestros concursos con un sólo clic</p></div>
        <div class="c-panel__body">
        <div class='c-concursos__disp'>
    EOD;
    echo $div;
    for ($i = 0; $i < $tamanio; $i++) {
        # si no está ya apuntado
        if (isset($concursosParticipo) && !in_array($concursos[$i], $concursosParticipo)) {
            # cada concurso se añade
            $concursos[$i]->tieneCartel() ? $img = '<img src="data:image/png;base64,' . $concursos[$i]->getCartel() . '" width="100px" class="c-card__img">' : $img = '';
            $btn = '<a href="?concurso=' . $concursos[$i]->getId() . '" class="c-card__btn c-card__btn--primary">Ir</a>';
            $name = $concursos[$i]->getNombre();
            # Si participo en concursos, éstos saldrán en la primera plana
            $div = <<<EOD
                
                <div class="c-card" style="width: 18rem;">
                    $img
                <div class="c-card__body">
                    <h5 class="c-card__title">$name</h5>
                    $btn
                </div>
            </div>
            EOD;
            echo $div;
        }
    }
    // cerramos el contenedor
    print '</div>';
    print '</div>';
    print '</div>';
}
?>
<!-- RAW HTML -->
<div class="c-Quienes">
    <h2>¿Quiénes somos?</h2>
    <p>
        Somos una asociación libre de radioaficionados
        que centramos nuestros esfuerzos y recursos en
        organizar concursos en España.
        Los miembros de nuestra organización pagan una cuota
        a cambio de participar en los concursos que se organizan
        con dicho dinero.
    </p>
</div>
<div class="c-QyA">
    <h2>FAQ (Preguntas frecuentes)</h2>
    <!-- Preguntas frecuentess -->
    <h2>¿A dónde va el dinero de mi suscripción?</h2>
    <p>
        Todo el dinero recaudado se emplea en el mantenimiento de esta página
        y la organización de concursos que son publicados en ésta.
        También invertimos parte de la recaudación para cestas regalo y otros
        eventos organizados con nuestros suscriptores.
    </p>
    <!-- Otra pregunta -->
    <h2>¿Cuál es la intención de El Patrón · Radioaficionados?</h2>
    <p>
        <br> <!-- La primera línea nos la saltamos evitando el text-indent -->
        · Fomentar la radioafición como servicio de instrucción individual. <br>
        · Cumplir y estimular el cumplimiento de la normativa vigente que señala el Reglamento de Radiocomunicaciones en general y el Reglamento de Estaciones de Aficionados en particular. <br>
        · Fomentar la unión y camaradería entre los radioaficionados, facilitándoles su mutuo conocimiento y estima. <br>
        · Representar a sus socios, y a los radioaficionados en general que lo deseen, ante la Administración del Estado y ante cualquier otra entidad pública o privada, velando por sus intereses. <br>
        · Prestar a sus asociados diversos servicios relacionados con la práctica de la radioafición.
    </p>
</div>