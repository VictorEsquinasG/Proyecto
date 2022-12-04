<?php
$rp = new repConcurso(gbd::getConexion());
$concursos = $rp->getConcursosDisponibles();

$tamanio = count($concursos);
  if ($tamanio>0){
    // Si hay concursos disponibles -> Pintamos contenedor de estos
    $div = <<<EOD
        <div class="c-panel">
            <div class="c-panel__h"><h2>CONCURSOS DISPONIBLES</h2>
            <p>Únete a nuestros concursos con un sólo clic</p></div>
        <div class="c-panel__body">
        <div class='c-concursos__disp'>
    EOD;
    echo $div;
    for ($i=0; $i < $tamanio; $i++){ 
        # cada concurso se añade
        $concursos[$i]->tieneCartel()?$img = '<img src="data:image/png;base64,'.$concursos[$i]->getCartel().'" width="100px" class="c-card__img">':$img = '';
        $btn = '<a href="?concurso='.$concursos[$i]->getId().'" class="c-card__btn c-card__btn--primary">Unirse</a>';
        $name = $concursos[$i]->getNombre();
        # Si hay concursos activos saldrán en la primera plana
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
?>
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
</div>