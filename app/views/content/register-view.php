<div class="main-container">
<form class="FormularioAjax" id="formulario"  action="<?php echo APP_URL; ?>app/ajax/registerAjax.php" method="post" autocomplete="off" enctype="multipart/form-data">
        <h5 class="title is-5 has-text-centered is-uppercase">REGISTER</h5>
        
        <input type="hidden" name="modulo_register" value="registrar">
        <div class="columns">
            <div class="column">
                <label for="name">Nombre:</label>
                <input type="text" name="nombre" id="name" class="input>">
            </div>
            <div class="column">
                <label for="apell">Apellido:</label>
                <input type="text" name="apellido" id="apell" class="input">
            </div>
            <div class="column">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="input">
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="input">
            </div>
            <div class="column">
                <label>Rol de Usuario:</label>
                <select name="rol">
                    <option value="">--- Choose a rol ---</option>
                    <option value="Colaborador" selected>Colaborador</option>
                    <option value="Cliente">Cliente</option>
                    <option value="Tecnico">Tecnico</option>
                </select>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <label for="password">Password:</label>
                <input type="password" name="password1" id="password1" pattern="[a-zA-Z0-9$#@.-]{7,255}" maxlength="255" class="input">
            </div>
            <div class="column">
                <label for="password2">Password Again:</label>
                <input type="password" name="password2" id="password2" pattern="[a-zA-Z0-9$#@.-]{7,255}" maxlength="255" class="input">
            </div>
        </div>

        <div class="columns">
            <div class="row">
                <label for="agree">
                    <input type="checkbox" name="agree" id="agree" value="checked" required/>
                    I agree with the
                    <a href="#" title="term of services">term of services</a>
                </label>
            </div>
        </div>
        <section>
            <p>
                <button type="submit" class="button is-info is-rounded">Register</button>
            </p>
            Already a member?<a href="<?php echo APP_URL; ?>login">Login</a>
        </section>

    </form>
</div>
<?php
if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['rol']) && isset($_POST['agree'])) {
    $regUser->registerUser();
}
?>