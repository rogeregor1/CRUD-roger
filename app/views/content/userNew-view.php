<br><br>
<div class="container is-fluid mb-6">
	<h1 class="title">Usuarios</h1>
	<h2 class="subtitle">Nuevo usuario</h2>
</div>

<div class="container pb-6 pt-6">

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">

		<input type="hidden" name="modulo_usuario" value="registrar">

		<div class="columns">
			<div class="column">
				<div class="control">
					<label for="nombre">Nombres</label>
					<input id="nombre" class="input" type="text" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<label for="apellido">Apellidos</label>
					<input id="apellido" class="input" type="text" name="usuario_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
				</div>
			</div>
		</div>
		<div class="columns">
			<div class="column">
				<div class="control">
					<label for="usuario">Usuario</label>
					<input id="usuario" class="input" type="text" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<label for="email">Email</label>
					<input id="email" class="input" type="email" name="usuario_email" maxlength="70" required>
				</div>
			</div>
		</div>
		<div class="columns">
			<div class="column">
				<div class="control">
					<label for="clave">Clave</label>
					<input id="clave" class="input" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$#@.-]{7,100}" maxlength="100" required>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<label for="claveControl">Repetir clave</label>
					<input id="claveControl" class="input" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$#@.-]{7,100}" maxlength="100" required>
				</div>
			</div>
		</div>
		<div class="columns">
			<div class="column">
				<div class="control">
				<label for="rol">Rol de Usuario:</label>
					<select  id="rol" name="usuario_rol">
						<option value="">--- Choose a rol ---</option>
						<option value="colaborador">Colaborador</option>
						<option value="tecnico" selected>Tecnico</option>
						<option value="cliente">Cliente</option>
					</select>
				</div>
			</div>
			<div class="column">
				<div class="file has-name is-boxed">
					<label for="foto" class="file-label">
						<input id="foto" class="file-input" type="file" name="usuario_foto" accept=".jpg, .png, .jpeg">
						<span class="file-cta">
							<span class="file-label">
								Seleccione una foto
							</span>
						</span>
						<span class="file-name">JPG, JPEG, PNG. (MAX 5MB)</span>
					</label>
				</div>
			</div>
		</div>
		<p class="has-text-centered">
			<button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>