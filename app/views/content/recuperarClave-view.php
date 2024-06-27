<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<div id="page-container" class="main-content-boxed">
    <main id="main-container">
        <h2 class="h5 font-w400 text-muted mb-0">Recuperar Contraseña</h2>
        <div class="px-30">
            <form action="app/controllers/logicamail.php" method="POST">
                <div class="form-group row">
                    <div class="col-12">
                        <div class="form-material floating">
                            <label for="email">Escriba su Email</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                    </div>
                </div>
                <?php
                if (isset($_SESSION['response'])):
                    ?>
                    <div class="alert alert-danger">
                        <?php echo $_SESSION['response']; ?>
                    </div>
                    <?php
                    unset($_SESSION['response']);
                endif;
                ?>
                <div class="form-group">
                    <button class="btn btn-sm btn-hero btn-primary" name="send">
                        <i class="si si-login mr-10"></i> Recuperar
                    </button>

                </div>
            </form>
        </div>
    </main>
</div>
