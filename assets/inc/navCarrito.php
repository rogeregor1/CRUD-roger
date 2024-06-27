<nav class="nav nav-fill my-0 navbar-expand-sm navbar-light bg-light fixed-top">

    <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="my-nav" class="collapse navbar-collapse">
        <ul class="nav justify-content-end">

            <li class="nav-item active">
                <a class="nav-link active"
                    href="<?php echo APP_URL; ?><?php echo $_SESSION['rol']; ?>Board/">SAT</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="<?php echo APP_URL; ?>mostrarCarrito/" tabindex="-1" aria-disabled="true">
                    Orders(<?php echo empty($_SESSION['CARRITO']) ? 0 : count($_SESSION['CARRITO']); ?>)</a>
            </li>
            <li class="nav-item active">

            </li>
        </ul>
            <a class="nav-link active" href="">¡Bienvenido:
            <?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido']; ?>!</a>
        <figure class="image is-32x32">
            <?php
            if (is_file("./assets/img/" . $_SESSION['foto'])) {
                echo '<img class="is-rounded" src="' . APP_URL . 'assets/img/' . $_SESSION['foto'] . '">';
            } else {
                echo '<img class="is-rounded" src="' . APP_URL . 'assets/img/default.png">';
            }
            ?>
        </figure>
    </div>
    
</nav>