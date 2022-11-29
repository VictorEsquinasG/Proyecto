<header>
    <nav>
        <div class="c-nav__contenedor">
            <div id="c-btn-home">
                <a href="?menu=inicio"><img src="./images/casa.png" alt="El Patrón"></a>
            </div>


            <div class="c-nav__menu">
                <img src="./images/lista-de-verificacion.png">
                <a href="?menu=mantenimiento">MANTENIMIENTO</a>
            </div>
            <div class="c-nav__menu">
                <img src="./images/accountable.png">
                <a href="?menu=listadoparticipantes">PARTICIPANTES</a>
            </div>
            <div class="c-nav__menu">
                <img src="./images/trofeo.png">
                <a href="?menu=listadoconcursos">CONCURSOS</a>
            </div>

            <?= Sesion::existe('login') ? "Hola bienvenido " . Sesion::leer('login') .
                "<a href='?menu=cerrarsesion'>Cerrar sesión</a>" : ""; ?>

            <div class="c-nav__login">
                <a href="?menu=login">Iniciar sesión</a>
                <img src="./images/perfil.png" alt="">
            </div>
        </div>

    </nav>
</header>