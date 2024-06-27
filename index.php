<?php

require_once "config/app.php";
require_once "autoload.php";

/*---------- Iniciando sesion ----------*/
require_once "./assets/inc/session_start.php";

if (isset($_GET['views'])) {
    $url = explode("/", $_GET['views']);
} else {
    $url = ["login"];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once "./assets/inc/head.php"; ?>
</head>

<body>
    <?php
        use app\controllers\viewsController;
        use app\controllers\loginController;
        use app\controllers\registerController;
        use app\controllers\userController;

        $insLogin = new loginController();
        $viewsController = new viewsController();
        $regUser = new registerController();
        $insUsuario = new userController();

        $vista = $viewsController->obtenerVistasControlador($url[0]);

        if ($vista == "login" || $vista == "404" || $vista == "logRegister") {
        require_once "./app/views/content/" . $vista . "-view.php";
    } else {

        # Cerrar sesion #
        if ((!isset($_SESSION['id']) || $_SESSION['id'] == "") || (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")) {
            $insLogin->cerrarSesionControlador();
            exit();
        }
    ?>
        <aside>
            <?php require_once "./assets/inc/aside.php"; ?>
        </aside>

        <header>
                <?php require_once "./assets/inc/navCarrito.php"; ?>
        </header>

        <section>
            <div class="container-fluid my-5">
                <?php require_once $vista; ?>
            </div>
        </section>
        
        <footer class="my-5 pt-5 text-muted text-center text-small">
            <?php require_once "./assets/inc/footer.php"; ?>
        </footer>
    <?php
    }
    ?>

</body>

</html>