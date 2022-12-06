<?php Sesion::iniciar(); ?>
<header>
    <nav>
        <div class="c-nav__contenedor">
            <div id="c-btn-home">
                <a class="menu" href="?menu=inicio"><img src="./images/elpatronlogo.png" alt="El Patrón"></a>
                <!-- <a class="menu" href="?menu=inicio"><img width="90" height="auto" src="./images/radio-imagen-animada-0070.gif" alt="El Patrón"></a> -->
            </div>

            <?php
            if ((Sesion::existe('user')) && Sesion::leer('user')->getRol() === 'admin') {
                $menu = <<<EOD
                <div class="c-nav__menu">
                    <img src="./images/lista-de-verificacion.png">
                    <a href="?menu=mantenimiento">MANTENIMIENTO</a>
                </div>
                <div class="c-nav__menu">
                    <img src="./images/accountable.png">
                    <a href="?menu=listadoparticipantes">PARTICIPANTES</a>
                </div>
                EOD;
                print $menu;
            }
            ?>

            <div class="c-nav__menu">
                <img src="./images/trofeo.png">
                <a href="?menu=listadoconcursos">CONCURSOS</a>
            </div>


            <div id="c-nav__login">
                <?php
                if (Sesion::existe('user')) {
                    #Sesión iniciada
                    print "<p>" . Sesion::leer('user')->getNombreCompleto() . "</p>";
                    print "<a href='?menu=cerrarsesion'> Cerrar sesión</a>";

                    print "<ul class='desplegable'>";
                    print "<li class='submenu'>" . "<a href='?menu=profile'>Mi perfil</a>" . "</li>";
                    print "<li class='submenu'>" . "<ul><li>A</li><li>A</li></ul>" . "</li>";
                    print "<li class='submenu'>" . "</li>";
                    print "<li class='submenu'>" . "</li>";
                    print "</ul>";  

                    #Foto de perfil
                    if (!is_null(Sesion::leer('user')->getImg())) {
                        print '<img id="imagen-perfil" src="data:image/png;base64,' . Sesion::leer('user')->getImg() .
                            '" alt="Mi imagen de perfil">';
                    } else {
                        #Foto de perfil por defecto
                        print '<img id="imagen-perfil" src="./images/default-profile.png" alt="Mi imagen de perfil">';
                    }
                } else {
                    print '<a href="?menu=login">Iniciar sesión</a>' .
                        '<img src="./images/default-profile.png" alt="">';
                }
                ?>
            </div>
        </div>

    </nav>
</header>