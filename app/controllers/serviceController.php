<?php

namespace app\controllers;

use app\models\mainModel;
use app\models\viewsModel;

class serviceController extends mainModel
{
	private $viewModel;

    public function __construct()
    {
        parent::__construct();
        $this->viewModel = new viewsModel();
    }

	/*----------  Controlador registrar servicio  ----------*/
	public function registrarServiceControlador()
	{

		# Almacenando datos
		$cate = $this->limpiarCadena($_POST['serv_categoria']);
		$tipo = $this->limpiarCadena($_POST['serv_tipo']);
		$direccion = $this->limpiarCadena($_POST['serv_address']);
		$cliente_email = $this->limpiarCadena($_POST['cliente_email']);
		$descripcion = $this->limpiarCadena($_POST['serv_descripcion']);
		$usuario_user = $this->limpiarCadena($_POST['usuario_user']);
		$precio = $this->limpiarCadena($_POST['serv_price']);

		# Verificando campos obligatorios
		if ($cate == "" || $descripcion == "" || $tipo == "" || $precio == "" || $usuario_user == "" || $cliente_email == "" || $direccion == "") {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "No has llenado todos los campos que son obligatorios",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		# Verificando integridad de los datos
		if ($this->verificarDatos("[0-9.]{1,10}", $precio)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "El precio no coincide con el formato solicitado",
				"icono" => "error"
			];
			return json_encode($alerta);
		}	

		# Verificando integridad de los datos
		if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{3,40}", $cate)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "El NOMBRE no coincide con el formato solicitado",
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
				"texto" => "La CATEGORIA de Servicio no esta disponible, disculpe las molestias, por favor intente nuevamente",
				"icono" => "error"
			];
			return json_encode($alerta);
		} else {
			$category_id = $check_cate->fetchColumn();
		}

		# Verificando integridad de los datos
		if ($this->verificarDatos("[a-zA-Z0-9]{4,20}", $usuario_user)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "El USUARIO no coincide con el formato solicitado",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		# Verificando usuario_id
		$check_usuario = mainModel::ejecutarConsulta("SELECT usuario_id FROM oficio_por WHERE category_id ='$category_id' AND service_tipo='$tipo'");
		if ($check_usuario->rowCount() == 0) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "El TECNICO seleccionado no esta disponible para ese tipo de servicio, por favor elija otro",
				"icono" => "error"
			];
			return json_encode($alerta);
		} else {
			$tecnico_id = $check_usuario->fetchColumn();
		}


		# Verificando integridad de los datos
		if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s]{6,70}", $direccion)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "La DIRECCION no coincide con el formato solicitado",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		# Verificando cliente dirección
		$check_direccion = mainModel::ejecutarConsulta("SELECT address_id FROM direccion WHERE address_name='$direccion'");
		if ($check_direccion->rowCount() == 0) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "La DIRECCION no coincide con nuestro registro, por favor REGISTRECE e intente nuevamente",
				"icono" => "error"
			];
			return json_encode($alerta);
		} else {
			$address_id = $check_direccion->fetchColumn();
		}

		# Verificando integridad de los datos
		if ($this->verificarDatos("[a-zA-Z0-9@.-]{4,100}", $cliente_email)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "El Email no coincide con el formato solicitado",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		# Verificando cliente email
		if ($cliente_email != "") {
			if (filter_var($cliente_email, FILTER_VALIDATE_EMAIL)) {
				$check_email = mainModel::ejecutarConsulta("SELECT usuario_id FROM usuario WHERE usuario_email='$cliente_email' AND address_id='$address_id'");
				if ($check_email->rowCount() == 0) {
					$alerta = [
						"tipo" => "simple",
						"titulo" => "Ocurrió un error inesperado",
						"texto" => "El EMAIL que acaba de ingresar o la DIRECCION es incorrecta, por favor REGISTRECE e intente nuevamente",
						"icono" => "error"
					];
					return json_encode($alerta);
				} else {
					$cliente_id = $check_email->fetchColumn();
				}
			}
		}

		# Verificando integridad de los datos
		if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9.,\s]{2,200}", $descripcion)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "La DESCRIPCION debe tener como minimo 2 caracteres y como maximo 200",
				"icono" => "error"
			];
			return json_encode($alerta);
		}


		$service_datos_reg = [
			[
				"campo_nombre" => "service_fecha",
				"campo_marcador" => ":fecha",
				"campo_valor" => date("Y-m-d H:i:s")
			],
			[
				"campo_nombre" => "service_detalle",
				"campo_marcador" => ":serv_description",
				"campo_valor" => $descripcion
			],
			[
				"campo_nombre" => "cliente_id",
				"campo_marcador" => ":cliente_email",
				"campo_valor" => $cliente_id
			],
			[
				"campo_nombre" => "usuario_id",
				"campo_marcador" => ":usuario_user",
				"campo_valor" => $tecnico_id
			],
			[
				"campo_nombre" => "address_id",
				"campo_marcador" => ":serv_address",
				"campo_valor" => $address_id
			]
		];

		$registrar_service = mainModel::guardarDatos("servicio", $service_datos_reg);

		if ($registrar_service->rowCount() >= 1) {
			$alerta = [
				"tipo" => "limpiar",
				"titulo" => "Servicio registrado",
				"texto" => "El servicio cuya categoria es: " . $cate . " de tipo como: " . $tipo . " fue registrado con exito. En breve, el Tecnico: " . $usuario_user . " se pondra en contacto con Ud.",
				"icono" => "success"
			];
		} else {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "No se pudo registrar el Servicio, por favor intente nuevamente",
				"icono" => "error"
			];
		}

		return json_encode($alerta);
	}



	
    /*----------  Controlador listar servicio  ----------*/
    public function listarServiceControlador($pagina, $registros, $url, $busqueda)
    {
        // Limpiar y preparar variables
        $pagina = $this->limpiarCadena($pagina);
        $registros = $this->limpiarCadena($registros);
        $url = $this->limpiarCadena($url);
        $url = APP_URL . $url . "/";
        $busqueda = $this->limpiarCadena($busqueda);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        // Consultas SQL
        if (isset($busqueda) && $busqueda != "") {
            $consulta_datos = "
                SELECT s.service_id, s.service_fecha, s.service_detalle, d.address_name, u.usuario_email, o.usuario_id
                FROM servicio s
                JOIN direccion d ON s.address_id = d.address_id
                JOIN usuario u ON s.cliente_id = u.usuario_id
                JOIN oficio_por o ON s.usuario_id = o.usuario_id
                WHERE 
                    (d.address_name LIKE '%$busqueda%' 
                    OR u.usuario_email LIKE '%$busqueda%' 
                    OR s.service_detalle LIKE '%$busqueda%' 
                    OR o.usuario_id LIKE '%$busqueda%') 
                ORDER BY s.service_fecha ASC 
                LIMIT $inicio, $registros";

            $consulta_total = "
                SELECT COUNT(s.service_id) 
                FROM servicio s
                JOIN direccion d ON s.address_id = d.address_id
                JOIN usuario u ON s.cliente_id = u.usuario_id
                JOIN oficio_por o ON s.usuario_id = o.usuario_id
                WHERE 
                    (d.address_name LIKE '%$busqueda%' 
                    OR u.cliente_email LIKE '%$busqueda%' 
                    OR s.service_detalle LIKE '%$busqueda%' 
                    OR o.usuario_id LIKE '%$busqueda%')";
        } else {
            $consulta_datos = "
                SELECT s.service_id, s.service_fecha, s.service_detalle, d.address_name, u.usuario_email, o.usuario_id
                FROM servicio s
                JOIN direccion d ON s.address_id = d.address_id
                JOIN usuario u ON s.cliente_id = u.usuario_id
                JOIN oficio_por o ON s.usuario_id = o.usuario_id
                ORDER BY s.service_fecha ASC 
                LIMIT $inicio, $registros";

            $consulta_total = "
                SELECT COUNT(s.service_id) 
                FROM servicio s
                JOIN direccion d ON s.address_id = d.address_id
                JOIN usuario u ON s.cliente_id = u.usuario_id
                JOIN oficio_por o ON s.usuario_id = o.usuario_id";
        }

        // Ejecutar consultas
        $datos = mainModel::ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $total = mainModel::ejecutarConsulta($consulta_total);
        $total = (int) $total->fetchColumn();

        $numeroPaginas = ceil($total / $registros);

        // Generar tabla HTML
        $tabla .= '
            <div class="table-container">
                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                    <thead>
                        <tr>
                            <th class="has-text-centered">#</th>
                            <th class="has-text-centered">Fecha</th>
                            <th class="has-text-centered">Dirección</th>
                            <th class="has-text-centered">Detalle del Servicio</th>
                            <th class="has-text-centered">Email del Cliente</th>
                            <th class="has-text-centered">Id del Tecnico</th>
                            <th class="has-text-centered" colspan="2">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
        ';

        if ($total >= 1 && $pagina <= $numeroPaginas) {
            $contador = $inicio + 1;
            $pag_inicio = $inicio + 1;
            foreach ($datos as $rows) {
                $tabla .= '
                    <tr class="has-text-centered">
                        <td>' . $contador . '</td>
                        <td>' . date("d-m-Y  h:i:s A", strtotime($rows['service_fecha'])) . '</td>
                        <td>' . $rows['address_name'] . '</td>
                        <td>' . $rows['service_detalle'] . '</td>
                        <td>' . $rows['usuario_email'] . '</td>
                        <td>' . $rows['usuario_id'] . '</td>
                        <td>
                            <a href="' . APP_URL . 'serviceUpdate/' . $rows['service_id'] . '/" class="button is-success is-rounded is-small">Actualizar</a>
                        </td>
                        <td>
                            <form class="FormularioAjax" action="' . APP_URL . 'app/ajax/serviceAjax.php" method="POST" autocomplete="off">
                                <input type="hidden" name="modulo_service" value="eliminar">
                                <input type="hidden" name="service_id" value="' . $rows['service_id'] . '">
                                <button type="submit" class="button is-danger is-rounded is-small">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                ';
                $contador++;
            }
            $pag_final = $contador - 1;
        } else {
            if ($total >= 1) {
                $tabla .= '
                    <tr class="has-text-centered">
                        <td colspan="10">
                            <a href="' . $url . '1/" class="button is-link is-rounded is-small mt-4 mb-4">
                                Haga clic acá para recargar el listado
                            </a>
                        </td>
                    </tr>
                ';
            } else {
                $tabla .= '
                    <tr class="has-text-centered">
                        <td colspan="10">
                            No hay registros en el sistema
                        </td>
                    </tr>
                ';
            }
        }

        $tabla .= '</tbody></table></div>';

        // Paginación
        if ($total > 0 && $pagina <= $numeroPaginas) {
            $tabla .= '<p class="has-text-right">Mostrando servicios <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
            $tabla .= $this->paginadorTablas($pagina, $numeroPaginas, $url, 7);
        }

        return $tabla;
    }



	/*----------  Controlador eliminar usuario  ----------*/
	public function eliminarServiceControlador()
	{

		$id = $this->limpiarCadena($_POST['service_id']);

		if ($id == 1) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "No podemos eliminar el servicio principal del sistema",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		# Verificando usuario #
		$datos = mainModel::ejecutarConsulta("SELECT * FROM servicio WHERE service_id='$id'");
		if ($datos->rowCount() <= 0) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "No hemos encontrado el servicio en el sistema",
				"icono" => "error"
			];
			return json_encode($alerta);
		} else {
			$datos = $datos->fetch();
		}

		$eliminarServicio = $this->eliminarRegistro("servicio", "service_id", $id);

		if ($eliminarServicio->rowCount() == 1) {

			$alerta = [
				"tipo" => "recargar",
				"titulo" => "Servicio eliminado",
				"texto" => "El SERVICIO  " . $datos['service_id'] . " ha sido eliminado del sistema correctamente",
				"icono" => "success"
			];
		} else {

			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "No hemos podido eliminar el servicio " . $datos['servicio_id'] . " del sistema, por favor intente nuevamente",
				"icono" => "error"
			];
		}

		return json_encode($alerta);
	}


	/*----------  Controlador actualizar usuario  ----------*/
	public function actualizarServiceControlador()
	{

		$id = $this->limpiarCadena($_POST['usuario_id']);

		# Verificando usuario #
		$datos = mainModel::ejecutarConsulta("SELECT * FROM usuario WHERE usuario_id='$id'");
		if ($datos->rowCount() <= 0) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "No hemos encontrado el usuario en el sistema",
				"icono" => "error"
			];
			return json_encode($alerta);
		} else {
			$datos = $datos->fetch();
		}

		$admin_usuario = $this->limpiarCadena($_POST['administrador_usuario']);
		$admin_clave = $this->limpiarCadena($_POST['administrador_clave']);

		# Verificando campos obligatorios admin #
		if ($admin_usuario == "" || $admin_clave == "") {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "No ha llenado todos los campos que son obligatorios, que corresponden a su USUARIO y CLAVE",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		if ($this->verificarDatos("[a-zA-Z0-9]{4,20}", $admin_usuario)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "Su USUARIO no coincide con el formato solicitado",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		if ($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $admin_clave)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "Su CLAVE no coincide con el formato solicitado",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		# Verificando administrador #
		$check_admin = mainModel::ejecutarConsulta("SELECT * FROM usuario WHERE usuario_usuario='$admin_usuario' AND usuario_id='" . $_SESSION['id'] . "'");
		if ($check_admin->rowCount() == 1) {

			$check_admin = $check_admin->fetch();

			if ($check_admin['usuario_usuario'] != $admin_usuario || !password_verify($admin_clave, $check_admin['usuario_clave'])) {

				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "USUARIO o CLAVE de administrador incorrectos",
					"icono" => "error"
				];
				return json_encode($alerta);
			}
		} else {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "USUARIO o CLAVE de administrador incorrectos",
				"icono" => "error"
			];
			return json_encode($alerta);
		}


		# Almacenando datos#
		$nombre = $this->limpiarCadena($_POST['usuario_nombre']);
		$apellido = $this->limpiarCadena($_POST['usuario_apellido']);
		$usuario = $this->limpiarCadena($_POST['usuario_usuario']);
		$email = $this->limpiarCadena($_POST['usuario_email']);
		$clave1 = $this->limpiarCadena($_POST['usuario_clave_1']);
		$clave2 = $this->limpiarCadena($_POST['usuario_clave_2']);

		# Verificando campos obligatorios #
		if ($nombre == "" || $apellido == "" || $usuario == "") {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "No has llenado todos los campos que son obligatorios",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		# Verificando integridad de los datos #
		if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "El NOMBRE no coincide con el formato solicitado",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "El APELLIDO no coincide con el formato solicitado",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		if ($this->verificarDatos("[a-zA-Z0-9]{4,20}", $usuario)) {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "El USUARIO no coincide con el formato solicitado",
				"icono" => "error"
			];
			return json_encode($alerta);
		}

		# Verificando email #
		if ($email != "" && $datos['usuario_email'] != $email) {
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$check_email = $this->ejecutarConsulta("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
				if ($check_email->rowCount() > 0) {
					$alerta = [
						"tipo" => "simple",
						"titulo" => "Ocurrió un error inesperado",
						"texto" => "El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
						"icono" => "error"
					];
					return json_encode($alerta);
				}
			} else {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "Ha ingresado un correo electrónico no valido",
					"icono" => "error"
				];
				return json_encode($alerta);
			}
		}

		# Verificando claves #
		if ($clave1 != "" || $clave2 != "") {
			if ($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $clave1) || $this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $clave2)) {

				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "Las CLAVES no coinciden con el formato solicitado",
					"icono" => "error"
				];
				return json_encode($alerta);
			} else {
				if ($clave1 != $clave2) {

					$alerta = [
						"tipo" => "simple",
						"titulo" => "Ocurrió un error inesperado",
						"texto" => "Las nuevas CLAVES que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
						"icono" => "error"
					];
					return json_encode($alerta);
				} else {
					$clave = password_hash($clave1, PASSWORD_BCRYPT, ["cost" => 10]);
				}
			}
		} else {
			$clave = $datos['usuario_clave'];
		}

		# Verificando usuario #
		if ($datos['usuario_usuario'] != $usuario) {
			$check_usuario = mainModel::ejecutarConsulta("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
			if ($check_usuario->rowCount() > 0) {
				$alerta = [
					"tipo" => "simple",
					"titulo" => "Ocurrió un error inesperado",
					"texto" => "El USUARIO ingresado ya se encuentra registrado, por favor elija otro",
					"icono" => "error"
				];
				return json_encode($alerta);
			}
		}

		$usuario_datos_up = [
			[
				"campo_nombre" => "usuario_nombre",
				"campo_marcador" => ":Nombre",
				"campo_valor" => $nombre
			],
			[
				"campo_nombre" => "usuario_apellido",
				"campo_marcador" => ":Apellido",
				"campo_valor" => $apellido
			],
			[
				"campo_nombre" => "usuario_usuario",
				"campo_marcador" => ":Usuario",
				"campo_valor" => $usuario
			],
			[
				"campo_nombre" => "usuario_email",
				"campo_marcador" => ":Email",
				"campo_valor" => $email
			],
			[
				"campo_nombre" => "usuario_clave",
				"campo_marcador" => ":Clave",
				"campo_valor" => $clave
			],
			[
				"campo_nombre" => "usuario_actualizado",
				"campo_marcador" => ":Actualizado",
				"campo_valor" => date("Y-m-d H:i:s")
			]
		];

		$condicion = [
			"condicion_campo" => "usuario_id",
			"condicion_marcador" => ":ID",
			"condicion_valor" => $id
		];

		if ($this->actualizarDatos("usuario", $usuario_datos_up, $condicion)) {

			if ($id == $_SESSION['id']) {
				$_SESSION['nombre'] = $nombre;
				$_SESSION['apellido'] = $apellido;
				$_SESSION['usuario'] = $usuario;
			}

			$alerta = [
				"tipo" => "recargar",
				"titulo" => "Usuario actualizado",
				"texto" => "Los datos del usuario " . $datos['usuario_nombre'] . " " . $datos['usuario_apellido'] . " se actualizaron correctamente",
				"icono" => "success"
			];
		} else {
			$alerta = [
				"tipo" => "simple",
				"titulo" => "Ocurrió un error inesperado",
				"texto" => "No hemos podido actualizar los datos del usuario " . $datos['usuario_nombre'] . " " . $datos['usuario_apellido'] . ", por favor intente nuevamente",
				"icono" => "error"
			];
		}

		return json_encode($alerta);
	}
}
