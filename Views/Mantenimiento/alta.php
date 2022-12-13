<?php

?>
<article class="c-alta">
    <!-- TODO hacer estilos -->

    <div id="titulos">
        <h2>Alumnos sin matricular</h2>
        <h2>Alumnos matriculados</h2>
    </div>

    <div>
        <select size="10" name="" id="participantes" multiple>
            <option>Daniel Barrera</option>
            <option>Luís Carlos Gascón</option>
            <option>Andrés Address</option>
            <option>Iván García</option>
            <option>Víctor Esquinas</option>
            <option>Antonio Millán</option>
        </select>
        <div id="btnes">
            <button>></button>
            <button>>></button>
            <button><<</button>
            <button><</button>
        </div>

        <select name="" id="matriculados" multiple size="10">
            <!-- Aquí listaremos los participantes dados de alta en el concurso -->
        </select>
    </div>

    <br><br>
    <h6>Use Ctrl para seleccionar más de un elemento</h6>
</article>
<script src="js/addParticipante.js"></script>