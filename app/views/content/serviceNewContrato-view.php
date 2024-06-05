<div class="container is-fluid mb-6">
	<h1 class="title">Servicio Asistencia Tecnica(SAT)</h1>
	<h2 class="subtitle">Pedir Nuevo Servicio SAT</h2>
</div>

<div class="container pb-6 pt-6">

	<form class="FormularioAjax" action="<?php echo APP_URL ?>app/ajax/serviceAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
		<input type="hidden" name="modulo_service" value="registrar">

		<div class="columns">
			<div class="column">
				<div class="control">
					<label for="cat">Categoria: </label>
					<select id="cat" name="serv_categoria">
						<option value="">--- Choose a type ---</option>
						<option value="Electronica">Electronica</option>
						<option value="Albañilería">Albañilería</option>
						<option value="Carpinteria" selected>Carpintería</option>
						<option value="Aire Acondicionado">Aire Acondicionado</option>
						<option value="Informatica">Informaticao</option>
						<option value="Limpieza">Limpieza</option>
					</select>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<label for="tipo">Tipo de Servicio: </label>
					<select id="tipo" name="serv_tipo">
						<option value="">--- Choose a type ---</option>
						<option value="Mantenimiento">Mantenimiento</option>
						<option value="Reparacion" selected>Reparacion</option>
						<option value="Instalacion">Instalacion</option>
						<option value="Desguace">Desguace</option>
					</select>
				</div>
			</div>
		</div>

		<div class="columns">
			<div class="column">
				<div class="control">
					<label for="user">Tecnico User</label>
					<input class="input" id="user" type="text" name="usuario_user" pattern="[a-zA-Z0-9]{4,20}" maxlength="40" required>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<label for="price">Precio</label>
					<input class="input" type="number" id="price" name="serv_price" step="0.01" required>
				</div>
			</div>
		</div>
		<div class="columns">
			<div class="column">
				<div class="control">
					<label form="email">Cliente Email</label>
					<input class="input" id="email" type="email" name="cliente_email" maxlength="100" required>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<label form="direc">Cliente Direccion</label>
					<input class="input" id="direc" type="text" name="serv_address" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9#.,-\s]{4,60}" maxlength="60">
				</div>
			</div>
		</div>

		<div class="column">
			<div class="form-group">
				<label for="serv_description">Description del Servicio</label>
				<textarea class="form-control" id="serv_description" name="serv_descripcion" rows="4"></textarea>
			</div>
		</div>

		<p class="has-text-centered">
			<button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
			<button type="submit" class="button is-info is-rounded">Procesar Solicitud de Servicio</button>
		</p>
	</form>
</div>