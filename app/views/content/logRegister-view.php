<?php if (isset($errors['register'])) : ?>
    <div class="alert alert-error">
        <?= $errors['register'] ?>
    </div>
<?php endif ?>

<div class="container-register">
<form class="FormularioAjax" action="" method="post" autocomplete="off">

    <div class="main-register">
    <h5 class="title is-5 has-text-centered is-uppercase">REGISTER</h5>

        <div class="row my-5">
            <div class="field">
                <label class="label" for="name">Nombre:</label>
                <input type="text" name="nomb" id="name" class="input">
            </div>
            <div class="field">
                <label class="label" for="apell">Apellido:</label>
                <input type="text" name="apell" id="apell" class="input">
            </div>
        </div>

        <div class="row my-5">
            <div class="field">
                <label class="label" for="username">Username:</label>
                <input type="text" name="user" id="username" class="input">
            </div>
            <div class="field">
                <label class="label" for="email">Email:</label>
                <input type="email" name="email" id="email" class="input">
            </div>
        </div>

        <div class="row my-5">
            <div class="field">
                <label class="label">Rol de Usuario: 
                <select name="rol">
                    <option value="" selected></option>
                    <option value="Colaborador">Colaborador</option>
                    <option value="Cliente">Cliente</option>
                    <option value="Tecnico">Tecnico</option>
                </select>
                </label>
            </div>
        </div>

        <div class="row my-5">
            <div class="field">
                <label class="label" for="password1">Password:</label>
                <input type="password" name="password1" id="password1" pattern="[a-zA-Z0-9$#@.-]{7,255}" maxlength="255" class="input">
            </div>
            <div class="field">
                <label class="label" for="password2">Password Again:</label>
                <input type="password" name="password2" id="password2" pattern="[a-zA-Z0-9$#@.-]{7,255}" maxlength="255" class="input">
            </div>
        </div>

        <div class="row my-5">
            <div class="field">
                <label class="label" for="agree">
                    <input type="checkbox" name="agree" id="agree" value="checked" required/>
                    I agree with the
                    <a  style="color: blue;" href="#" title="term of services">term of services</a>
                </label>
            </div>
        </div>

        <div class="row my-5">
            <div class="field">
            <p>
                <button type="submit" class="button is-info is-rounded">Register</button>
            </p>
            Already a member?<a style="color: blue;" href="<?php echo APP_URL; ?>login"> Login</a>
          </div>
        </div>
    </div>
    </form>
</div>
<?php
if (isset($_POST['nomb']) && isset($_POST['apell']) && isset($_POST['user']) && isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['rol']) && isset($_POST['agree'])) {
    $regUser->registerController();
}
?>