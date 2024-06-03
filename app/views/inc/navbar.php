<nav class="navbar">
    <div class="navbar-brand">
        <a class="navbar-item" href="<?php echo APP_URL; ?>dashBoard/">
            <img src="<?php echo APP_URL; ?>app/views/img/bulma.png" alt="Bulma" width="112" height="28">
        </a>
        <div class="navbar-burger" data-target="navbarExampleTransparentExample">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div id="navbarExampleTransparentExample" class="navbar-menu">

        <div class="navbar-start">

            <a class="navbar-item" href="<?php echo APP_URL; ?>dashBoard/">
                Dashboard
            </a>
            <?php if ($_SESSION['rol'] == "Administrador") { ?>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="#">
                    Usuarios
                </a>
                <div class="navbar-dropdown is-boxed">

                    <a class="navbar-item" href="<?php echo APP_URL; ?>userNew/">
                        Nuevo 
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>userList/">
                        Lista
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>userSearch/">
                        Buscar
                    </a>

                </div>
            </div>
            <?php } ?>
            <?php if ($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Tecnico") { ?>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="#">
                    Lista de Mis Oficios, Habilidades y Recomendaciones.
                </a>
                <div class="navbar-dropdown is-boxed">

                    <a class="navbar-item" href="<?php echo APP_URL; ?>oficioContrato/">
                        Aceptar Contrato de Servicio.
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>oficioNew/">
                        Añadir Oficio.
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>oficioList/">
                        Lista de Oficios.
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>oficioNew/">
                        Solicitar tipo de oficio al Administrador.
                    </a>
                </div>
            </div>
            <?php } ?>
            <?php if ($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Cliente") { ?>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="#">
                    Servicios
                </a>
                <div class="navbar-dropdown is-boxed">

                    <a class="navbar-item" href="<?php echo APP_URL; ?>serviceSearch/">
                        Lista de Servicios y Tecnicos.
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>serviceListContratos/">
                        Lista de Mis Servicios Contratados.
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>serviceNewContrato/">
                        Contratar Nuevo Servicio.
                    </a>

                </div>
            </div>
            <?php } ?>
        </div>

        <div class="navbar-end">
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    ** <?php echo $_SESSION['usuario']; ?> **
                </a>
                <div class="navbar-dropdown is-boxed">

                    <a class="navbar-item" href="<?php echo APP_URL . "userUpdate/" . $_SESSION['id'] . "/"; ?>">
                        Mi cuenta
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL . "userPhoto/" . $_SESSION['id'] . "/"; ?>">
                        Mi foto
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="<?php echo APP_URL . "logOut/"; ?>" id="btn_exit">
                        Salir
                    </a>

                </div>
            </div>
        </div>

    </div>
</nav>