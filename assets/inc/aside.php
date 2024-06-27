<div class="col-auto col-md-12 col-xl-12 px-sm-12 px-0 bg-dark">
    <br><br>
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
        <a href="#" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-5 d-none d-sm-inline">Menu</span>
        </a>
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li>
                <a href="<?php echo APP_URL; ?><?php echo $_SESSION['rol']; ?>Board/"
                    class="nav-link px-0 align-middle">
                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                </a>
            </li>
            <li>
                <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                    <i class="fs-4 bi-bookmark-check-fill"></i> <span class="ms-1 d-none d-sm-inline">Items</span>
                </a>
                <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                    <li class="w-100">
                        <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span>1</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2 </a>
                    </li>
                </ul>
            </li>
            <?php if ($_SESSION['rol'] == "Administrador") { ?>
                <li>
                    <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                        <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Users</span> </a>
                    <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                        <li class="w-100">
                            <a href="<?php echo APP_URL; ?>userNew/" class="nav-link px-0"> <span
                                    class="d-none d-sm-inline">Users</span>Nuevo</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>userList/" class="nav-link px-0"> <span
                                    class="d-none d-sm-inline">Users</span>Lista</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>userSearch/" class="nav-link px-0"> <span
                                    class="d-none d-sm-inline">Users</span>Buscar</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                        <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Bootstrap</span></a>
                    <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                        <li class="w-100">
                            <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1</a>
                        </li>
                        <li>
                            <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php if ($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Tecnico") { ?>
                <li>
                    <a href="#submenu4" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                        <i class="fs-4 bi-wrench-adjustable-circle"></i> <span class="ms-1 d-none d-sm-inline">SAT</span>
                    </a>
                    <ul class="collapse nav flex-column ms-1" id="submenu4" data-bs-parent="#menu">
                        <li class="w-100">
                            <a href="<?php echo APP_URL; ?>tecOficioAceptarContrato/" class="nav-link px-0"> <span
                                    class="d-none d-sm-inline"></span> Aceptar Contrato de Servicio</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>tecOficioAdd/" class="nav-link px-0"> <span
                                    class="d-none d-sm-inline"></span> Añadir Oficio</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>tecOficioList/" class="nav-link px-0"> <span
                                    class="d-none d-sm-inline"></span> Lista de Oficios</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>tecOficioSugerencia/" class="nav-link px-0"> <span
                                    class="d-none d-sm-inline"></span>Sugerencias</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php if ($_SESSION['rol'] == "Administrador" || $_SESSION['rol'] == "Cliente") { ?>
                <li>
                    <a href="#submenu5" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                        <i class="fs-4 bi-cart3"></i> <span class="ms-1 d-none d-sm-inline">Orders</span> </a>
                    <ul class="collapse nav flex-column ms-1" id="submenu5" data-bs-parent="#menu">
                        <li class="w-100">
                            <a href="<?php echo APP_URL; ?>serviceSearch/" class="nav-link px-0"> <span
                                    class="d-none d-sm-inline">Search</span> Servicios y Tecnicos</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>serviceListContratos/" class="nav-link px-0"> <span
                                    class="d-none d-sm-inline">Lista</span> Servicios Contratados</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL; ?>serviceNewContrato/" class="nav-link px-0"> <span
                                    class="d-none d-sm-inline">Contratar</span> Nuevo Servicio</a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <li>
                    <a href="#submenu6" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                        <i class="fs-4 bi-person-vcard"></i> <span
                            class="ms-1 d-none d-sm-inline"><?php echo $_SESSION['rol']; ?></span></a>
                    <ul class="collapse nav flex-column ms-1" id="submenu6" data-bs-parent="#menu">
                        <li class="w-100">
                            <a href="<?php echo APP_URL . "userPhoto/" . $_SESSION['id'] . "/"; ?>" class="nav-link px-0">
                                <span class="d-none d-sm-inline"><?php echo $_SESSION['rol']; ?></span> Foto</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL . "userUpdate/" . $_SESSION['id'] . "/"; ?>" class="nav-link px-0">
                                <span class="d-none d-sm-inline"><?php echo $_SESSION['rol']; ?></span> Profile</a>
                        </li>
                        <li>
                            <a href="<?php echo APP_URL . "logOut/"; ?>" id="btn_exit" class="nav-link px-0"> <span
                                    class="d-none d-sm-inline"><?php echo $_SESSION['rol']; ?></span> Salir</a>
                        </li>
                    </ul>
                </li>
           
        </ul>
        <hr>

    </div>

</div>