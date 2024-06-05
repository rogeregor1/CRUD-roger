<?php
# Verificando integridad de los datos
		if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{3,40}", $cate)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "La categoria no coincide con el formato solicitado",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		# Verificando categoria de servicio
		$check_cate = mainModel::ejecutarConsulta("SELECT category_id FROM category WHERE category_name='$cate'");
		if ($check_cate->rowCount() == 0) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "El servicio requerido, de momento, no lo podemos ofrecer, disculpe las molestias, por favor intente nuevamente",
				"icono" => "error"
			];
			return json_encode($alerta);
		} else {
			$category_id = $check_cate->fetchColumn();
		}

		# Verificando tipo de servicio
		$check_userId = mainModel::ejecutarConsulta("SELECT usuario_id FROM oficio_por WHERE category_id='$category_id' AND servicio_tipo='$tipo'");
		if ($check_userId->rowCount() == 0) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "El Tecnico requerido, de momento puede ofrecer el servicio, disculpe las molestias, por favor intente nuevamente",
				"icono" => "error"
			];
			return json_encode($alerta);
		} else {
			$user_id = $check_userId->fetchColumn();
		}

		
		if ($this->verificarDatos("[a-zA-Z0-9]{4,20}", $usuario_user)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "El usuario del TECNICO no coincide con el formato solicitado",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		# Verificando usuario
		$check_user = mainModel::ejecutarConsulta("SELECT usuario_id FROM usuario WHERE usuario_usuario='$usuario_user' AND usuario_id='$user_id'");
		if ($check_user->rowCount() == 0) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "El TECNICO seleccionado no se encuentra registrado, por favor elija otro",
				"icono" => "error"
			];
			return json_encode($alerta);
		} else {
			$usuario_id = $check_user->fetchColumn();
		}


		if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s]{6,70}", $direccion)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "La DIRECCION no coincide con el formato solicitado",
				"icono" => "error"
			];
			return json_encode($alerta);
		}