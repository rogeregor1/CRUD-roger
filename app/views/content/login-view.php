<div class="main-container">

	<form class="box login" action="" method="POST" autocomplete="off">
		<h5 class="title is-5 has-text-centered is-uppercase">LOGIN</h5>

		<div class="field">
			<label for="user" class="label">Usuario</label>
			<input id="user" class="input" type="text" name="login_usuario" pattern="[a-zA-Z0-9$@#.-]{4,100}" maxlength="100" required>
		</div>

		<div class="field">
			<label for="pass" class="label">Clave</label>
			<input id="pass" class="input" type="password" name="login_clave" pattern="[a-zA-Z0-9$@#.-]{7,255}" maxlength="100" required autocomplete="off">
		</div>
		<section>
			<p class="has-text-centered mb-4 mt-3">
				<button type="submit" class="button is-info is-rounded">Iniciar sesion</button>
			</p>
			<a href="<?php echo APP_URL; ?>register/">Register</a>
		</section>
	</form>
</div>

<?php
if (isset($_POST['login_usuario']) && isset($_POST['login_clave'])) {
	$insLogin->iniciarSesionControlador();
}

?>