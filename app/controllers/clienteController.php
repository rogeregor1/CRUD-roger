<?php
	namespace app\controllers;
	
	use app\models\mainModel;

	class clienteController extends mainModel{

		/*----------  Controlador registrar usuario  ----------*/
		public function registrarClienteControlador(){

			# Almacenando datos#
		    $nombre=$this->limpiarCadena($_POST['cliente_nombre']);
		    $apellido=$this->limpiarCadena($_POST['cliente_apellido']);
		    $usuario=$this->limpiarCadena($_POST['cliente_usuario']);
		    $email=$this->limpiarCadena($_POST['cliente_email']);
		    $clave1=$this->limpiarCadena($_POST['cliente_clave_1']);
		    $clave2=$this->limpiarCadena($_POST['clienteo_clave_2']);
			$rol=$this->limpiarCadena($_POST['cliente_rol']);

		    # Verificando campos obligatorios #
		    if($nombre=="" || $apellido=="" || $usuario=="" || $clave1=="" || $clave2=="" || $rol==""){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    # Verificando integridad de los datos #
		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,40}",$apellido)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El APELLIDO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    if($this->verificarDatos("[a-zA-Z0-9]{4,20}",$usuario)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El USUARIO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    if($this->verificarDatos("[a-zA-Z0-9$#@.-]{7,100}",$clave1) || $this->verificarDatos("[a-zA-Z0-9$#@.-]{7,100}",$clave2)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Las CLAVES no coinciden con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    # Verificando email #
		    if($email!=""){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email=mainModel::ejecutarConsulta("SELECT cliente_email FROM cliente WHERE cliente_email='$email'");
					if($check_email->rowCount()>0){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
							"icono"=>"error"
						];
						return json_encode($alerta);
					}
				}else{
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Ha ingresado un correo electrónico no valido",
						"icono"=>"error"
					];
					return json_encode($alerta);
				}
            }

            # Verificando claves #
            if($clave1!=$clave2){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Las contraseñas que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
					"icono"=>"error"
				];
				return json_encode($alerta);
			}else{
				$clave=password_hash($clave1,PASSWORD_BCRYPT,["cost"=>10]);
            }

			if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$rol)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El ROL no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

            # Verificando usuario #
		    $check_cliente=mainModel::ejecutarConsulta("SELECT cliente_usuario FROM cliente WHERE cliente_usuario='$usuario'");
		    if($check_cliente->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El USUARIO ingresado ya se encuentra registrado, por favor elija otro",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/fotos/";

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['cliente_foto']['name']!="" && $_FILES['cliente_foto']['size']>0){

    			# Creando directorio #
		        if(!file_exists($img_dir)){
		            if(!mkdir($img_dir,0777)){
		            	$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"Error al crear el directorio",
							"icono"=>"error"
						];
						return json_encode($alerta);
		            } 
		        }

		        # Verificando formato de imagenes #
		        if(mime_content_type($_FILES['cliente_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['cliente_foto']['tmp_name'])!="image/png"){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La imagen que ha seleccionado es de un formato no permitido",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        }

		        # Verificando peso de imagen #
		        if(($_FILES['cliente_foto']['size']/1024)>5120){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La imagen que ha seleccionado supera el peso permitido",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        }

		        # Nombre de la foto #
		        $foto=str_ireplace(" ","_",$nombre);
		        $foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['cliente_foto']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }

		        chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['cliente_foto']['tmp_name'],$img_dir.$foto)){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"No podemos subir la imagen al sistema en este momento",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        }

    		}else{
    			$foto="";
    		}


		    $cliente_datos_reg=[
				[
					"campo_nombre"=>"cliente_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"cliente_apellido",
					"campo_marcador"=>":Apellido",
					"campo_valor"=>$apellido
				],
				[
					"campo_nombre"=>"cliente_usuario",
					"campo_marcador"=>":Usuario",
					"campo_valor"=>$usuario
				],
				[
					"campo_nombre"=>"cliente_email",
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				[
					"campo_nombre"=>"usuario_clave",
					"campo_marcador"=>":Clave",
					"campo_valor"=>$clave
				],
				[
					"campo_nombre"=>"rol",
					"campo_marcador"=>":rol",
					"campo_valor"=>"Cliente"
				],
				[
					"campo_nombre"=>"cliente_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				],
				[
					"campo_nombre"=>"address_id",
					"campo_marcador"=>":address",
					"campo_valor"=>1
				],
				[
					"campo_nombre"=>"cliente_creado",
					"campo_marcador"=>":Creado",
					"campo_valor"=>date("Y-m-d H:i:s")
				],
				[
					"campo_nombre"=>"cliente_actualizado",
					"campo_marcador"=>":Actualizado",
					"campo_valor"=>date("Y-m-d H:i:s")
				]
			];

			$registrar_cliente=mainModel::guardarDatos("cliente", $cliente_datos_reg);

			if($registrar_cliente->rowCount() > 0){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Usuario registrado",
					"texto"=>"El cliente ".$nombre." ".$apellido." se registro con exito",
					"icono"=>"success"
				];
			}else{
				
				if(is_file($img_dir.$foto)){
		            chmod($img_dir.$foto,0777);
		            unlink($img_dir.$foto);
		        }

				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo registrar el cliente, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);

		}



		/*----------  Controlador listar usuario  ----------*/
		public function listarClienteControlador($pagina,$registros,$url,$busqueda){

			$pagina=$this->limpiarCadena($pagina);
			$registros=$this->limpiarCadena($registros);

			$url=$this->limpiarCadena($url);
			$url=APP_URL.$url."/";

			$busqueda=$this->limpiarCadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){

				$consulta_datos="SELECT * FROM cliente WHERE ((cliente_id!='".$_SESSION['id']."' AND cliente_id!='1') AND (cliente_nombre LIKE '%$busqueda%' OR cliente_apellido LIKE '%$busqueda%' OR cliente_email LIKE '%$busqueda%' OR cliente_usuario LIKE '%$busqueda%' OR rol LIKE '%$busqueda%')) ORDER BY cliente_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(cliente_id) FROM cliente WHERE ((cliente_id!='".$_SESSION['id']."' AND cliente_id!='1') AND (cliente_nombre LIKE '%$busqueda%' OR cliente_apellido LIKE '%$busqueda%' OR cliente_email LIKE '%$busqueda%' OR cliente_usuario LIKE '%$busqueda%' OR rol LIKE '%$busqueda%'))";

			}else{

				$consulta_datos="SELECT * FROM cliente WHERE cliente_id!='".$_SESSION['id']."' AND cliente_id!='1' ORDER BY cliente_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(cliente_id) FROM cliente WHERE cliente_id!='".$_SESSION['id']."' AND cliente_id!='1'";

			}

			$datos = mainModel::ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();

			$total = mainModel::ejecutarConsulta($consulta_total);
			$total = (int) $total->fetchColumn();

			$numeroPaginas =ceil($total/$registros);

			$tabla.='
		        <div class="table-container">
		        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
		            <thead>
		                <tr>
		                    <th class="has-text-centered">#</th>
		                    <th class="has-text-centered">Nombre</th>
		                    <th class="has-text-centered">Email</th>
		                    <th class="has-text-centered">Cliente</th>
							<th class="has-text-centered">Rol</th>
		                    <th class="has-text-centered">Creado</th>
		                    <th class="has-text-centered">Actualizado</th>
		                    <th class="has-text-centered" colspan="3">Opciones</th>
		                </tr>
		            </thead>
		            <tbody>
		    ';

		    if($total>=1 && $pagina<=$numeroPaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){
					$tabla.='
						<tr class="has-text-centered" >
							<td>'.$contador.'</td>
							<td>'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].'</td>
							<td>'.$rows['cliente_email'].'</td>
							<td>'.$rows['cliente_usuario'].'</td>
							<td>'.$rows['rol'].'</td>
							<td>'.date("d-m-Y  h:i:s A",strtotime($rows['cliente_creado'])).'</td>
							<td>'.date("d-m-Y  h:i:s A",strtotime($rows['cliente_actualizado'])).'</td>
							<td>
			                    <a href="'.APP_URL.'userPhoto/'.$rows['cliente_id'].'/" class="button is-info is-rounded is-small">Foto</a>
			                </td>
			                <td>
			                    <a href="'.APP_URL.'userUpdate/'.$rows['cliente_id'].'/" class="button is-success is-rounded is-small">Actualizar</a>
			                </td>
			                <td>
			                	<form class="FormularioAjax" action="'.APP_URL.'app/ajax/clienteAjax.php" method="POST" autocomplete="off" >

			                		<input type="hidden" name="modulo_cliente" value="eliminar">
			                		<input type="hidden" name="cliente_id" value="'.$rows['cliente_id'].'">

			                    	<button type="submit" class="button is-danger is-rounded is-small">Eliminar</button>
			                    </form>
			                </td>
						</tr>
					';
					$contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
					$tabla.='
						<tr class="has-text-centered" >
			                <td colspan="7">
			                    <a href="'.$url.'1/" class="button is-link is-rounded is-small mt-4 mb-4">
			                        Haga clic acá para recargar el listado
			                    </a>
			                </td>
			            </tr>
					';
				}else{
					$tabla.='
						<tr class="has-text-centered" >
			                <td colspan="7">
			                    No hay registros en el sistema
			                </td>
			            </tr>
					';
				}
			}

			$tabla.='</tbody></table></div>';

			### Paginacion ###
			if($total>0 && $pagina<=$numeroPaginas){
				$tabla.='<p class="has-text-right">Mostrando clientes <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';

				$tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7);
			}

			return $tabla;
		}


		/*----------  Controlador eliminar usuario  ----------*/
		public function eliminarClienteControlador(){

			$id=$this->limpiarCadena($_POST['cliente_id']);

			if($id==1){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar el cliente principal del sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
			}

			# Verificando usuario #
		    $datos=mainModel::ejecutarConsulta("SELECT * FROM cliente WHERE cliente_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el cliente en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }else{
		    	$datos=$datos->fetch();
		    }

		    $eliminarCliente=mainModel::eliminarRegistro("cliente","cliente_id",$id);

		    if($eliminarCliente->rowCount()==1){

		    	if(is_file("../views/fotos/".$datos['cliente_foto'])){
		            chmod("../views/fotos/".$datos['cliente_foto'],0777);
		            unlink("../views/fotos/".$datos['cliente_foto']);
		        }

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Cliente eliminado",
					"texto"=>"El cliente ".$datos['cliente_nombre']." ".$datos['cliente_apellido']." ha sido eliminado del sistema correctamente",
					"icono"=>"success"
				];

		    }else{

		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar el cliente ".$datos['cliente_nombre']." ".$datos['cliente_apellido']." del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }

		    return json_encode($alerta);
		}


		/*----------  Controlador actualizar usuario  ----------*/
		public function actualizarClienteControlador(){

			$id=$this->limpiarCadena($_POST['cliente_id']);

			# Verificando usuario #
		    $datos=mainModel::ejecutarConsulta("SELECT * FROM cliente WHERE cliente_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el cliente en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }else{
		    	$datos=$datos->fetch();
		    }

		    $admin_usuario=$this->limpiarCadena($_POST['cliente_usuario']);
		    $admin_clave=$this->limpiarCadena($_POST['cliente_clave']);

		    # Verificando campos obligatorios admin #
		    if($admin_usuario=="" || $admin_clave==""){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No ha llenado todos los campos que son obligatorios, que corresponden a su USUARIO y CLAVE",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    if($this->verificarDatos("[a-zA-Z0-9]{4,20}",$admin_usuario)){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Su USUARIO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Su CLAVE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    # Verificando administrador #
		    $check_admin=mainModel::ejecutarConsulta("SELECT * FROM cliente WHERE cliente_usuario='$admin_usuario' AND cliente_id='".$_SESSION['id']."'");
		    if($check_admin->rowCount()==1){

		    	$check_admin=$check_admin->fetch();

		    	if($check_admin['cliente_usuario']!=$admin_usuario || !password_verify($admin_clave,$check_admin['cliente_clave'])){

		    		$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"CLIENTE o CLAVE de administrador incorrectos",
						"icono"=>"error"
					];
					return json_encode($alerta);
		    	}
		    }else{
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"CLIENTE o CLAVE de administrador incorrectos",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }


			# Almacenando datos#
		    $nombre=$this->limpiarCadena($_POST['cliente_nombre']);
		    $apellido=$this->limpiarCadena($_POST['cliente_apellido']);
		    $usuario=$this->limpiarCadena($_POST['cliente_usuario']);
		    $email=$this->limpiarCadena($_POST['cliente_email']);
		    $clave1=$this->limpiarCadena($_POST['cliente_clave_1']);
		    $clave2=$this->limpiarCadena($_POST['cliente_clave_2']);

		    # Verificando campos obligatorios #
		    if($nombre=="" || $apellido=="" || $usuario==""){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    # Verificando integridad de los datos #
		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El APELLIDO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    if($this->verificarDatos("[a-zA-Z0-9]{4,20}",$usuario)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El USUARIO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    # Verificando email #
		    if($email!="" && $datos['cliente_email']!=$email){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email=$this->ejecutarConsulta("SELECT cliente_email FROM cliente WHERE cliente_email='$email'");
					if($check_email->rowCount()>0){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
							"icono"=>"error"
						];
						return json_encode($alerta);
					}
				}else{
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Ha ingresado un correo electrónico no valido",
						"icono"=>"error"
					];
					return json_encode($alerta);
				}
            }

            # Verificando claves #
            if($clave1!="" || $clave2!=""){
            	if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave1) || $this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave2)){

			        $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Las CLAVES no coinciden con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			    }else{
			    	if($clave1!=$clave2){

						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"Las nuevas CLAVES que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
							"icono"=>"error"
						];
						return json_encode($alerta);
			    	}else{
			    		$clave=password_hash($clave1,PASSWORD_BCRYPT,["cost"=>10]);
			    	}
			    }
			}else{
				$clave=$datos['cliente_clave'];
            }

            # Verificando usuario #
            if($datos['cliente_usuario']!=$usuario){
			    $check_cliente=mainModel::ejecutarConsulta("SELECT cliente_usuario FROM cliente WHERE cliente_usuario='$usuario'");
			    if($check_cliente->rowCount()>0){
			        $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El CLIENTE ingresado ya se encuentra registrado, por favor elija otro",
						"icono"=>"error"
					];
					return json_encode($alerta);
			    }
            }

            $usuario_datos_up=[
				[
					"campo_nombre"=>"cliente_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"cliente_apellido",
					"campo_marcador"=>":Apellido",
					"campo_valor"=>$apellido
				],
				[
					"campo_nombre"=>"cliente_usuario",
					"campo_marcador"=>":Usuario",
					"campo_valor"=>$usuario
				],
				[
					"campo_nombre"=>"cliente_email",
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				[
					"campo_nombre"=>"cliente_clave",
					"campo_marcador"=>":Clave",
					"campo_valor"=>$clave
				],
				[
					"campo_nombre"=>"cliente_actualizado",
					"campo_marcador"=>":Actualizado",
					"campo_valor"=>date("Y-m-d H:i:s")
				]
			];

			$condicion=[
				"condicion_campo"=>"cliente_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("cliente",$usuario_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['nombre']=$nombre;
					$_SESSION['apellido']=$apellido;
					$_SESSION['usuario']=$usuario;
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Cliente actualizado",
					"texto"=>"Los datos del usuario ".$datos['cliente_nombre']." ".$datos['cliente_apellido']." se actualizaron correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido actualizar los datos del cliente ".$datos['cliente_nombre']." ".$datos['cliente_apellido'].", por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}


		/*----------  Controlador eliminar foto usuario  ----------*/
		public function eliminarFotoClienteControlador(){

			$id=$this->limpiarCadena($_POST['cliente_id']);

			# Verificando usuario #
		    $datos=mainModel::ejecutarConsulta("SELECT * FROM cliente WHERE cliente_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el cliente en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/fotos/";

    		chmod($img_dir,0777);

    		if(is_file($img_dir.$datos['cliente_foto'])){

		        chmod($img_dir.$datos['cliente_foto'],0777);

		        if(!unlink($img_dir.$datos['cliente_foto'])){
		            $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Error al intentar eliminar la foto del cliente, por favor intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        }
		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la foto del cliente en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }

		    $usuario_datos_up=[
				[
					"campo_nombre"=>"cliente_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>""
				],
				[
					"campo_nombre"=>"cliente_actualizado",
					"campo_marcador"=>":Actualizado",
					"campo_valor"=>date("Y-m-d H:i:s")
				]
			];

			$condicion=[
				"condicion_campo"=>"cliente_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("cliente",$usuario_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']="";
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"La foto del cliente ".$datos['cliente_nombre']." ".$datos['cliente_apellido']." se elimino correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"No hemos podido actualizar algunos datos del cliente ".$datos['cliente_nombre']." ".$datos['cliente_apellido'].", sin embargo la foto ha sido eliminada correctamente",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}


		/*----------  Controlador actualizar foto usuario  ----------*/
		public function actualizarFotoClienteControlador(){

			$id=$this->limpiarCadena($_POST['cliente_id']);

			# Verificando usuario #
		    $datos=mainModel::ejecutarConsulta("SELECT * FROM cliente WHERE cliente_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el cliente en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/fotos/";

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['cliente_foto']['name']=="" && $_FILES['cliente_foto']['size']<=0){
    			$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No ha seleccionado una foto para el cliente",
					"icono"=>"error"
				];
				return json_encode($alerta);
    		}

    		# Creando directorio #
	        if(!file_exists($img_dir)){
	            if(!mkdir($img_dir,0777)){
	                $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Error al crear el directorio",
						"icono"=>"error"
					];
					return json_encode($alerta);
	            } 
	        }

	        # Verificando formato de imagenes #
	        if(mime_content_type($_FILES['cliente_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['cliente_foto']['tmp_name'])!="image/png"){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La imagen que ha seleccionado es de un formato no permitido",
					"icono"=>"error"
				];
				return json_encode($alerta);
	        }

	        # Verificando peso de imagen #
	        if(($_FILES['cliente_foto']['size']/1024)>5120){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La imagen que ha seleccionado supera el peso permitido",
					"icono"=>"error"
				];
				return json_encode($alerta);
	        }

	        # Nombre de la foto #
	        if($datos['cliente_foto']!=""){
		        $foto=explode(".", $datos['cliente_foto']);
		        $foto=$foto[0];
	        }else{
	        	$foto=str_ireplace(" ","_",$datos['cliente_nombre']);
	        	$foto=$foto."_".rand(0,100);
	        }
	        

	        # Extension de la imagen #
	        switch(mime_content_type($_FILES['cliente_foto']['tmp_name'])){
	            case 'image/jpeg':
	                $foto=$foto.".jpg";
	            break;
	            case 'image/png':
	                $foto=$foto.".png";
	            break;
	        }

	        chmod($img_dir,0777);

	        # Moviendo imagen al directorio #
	        if(!move_uploaded_file($_FILES['cliente_foto']['tmp_name'],$img_dir.$foto)){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos subir la imagen al sistema en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
	        }

	        # Eliminando imagen anterior #
	        if(is_file($img_dir.$datos['cliente_foto']) && $datos['cliente_foto']!=$foto){
		        chmod($img_dir.$datos['cliente_foto'], 0777);
		        unlink($img_dir.$datos['cliente_foto']);
		    }

		    $usuario_datos_up=[
				[
					"campo_nombre"=>"cliente_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				],
				[
					"campo_nombre"=>"cliente_actualizado",
					"campo_marcador"=>":Actualizado",
					"campo_valor"=>date("Y-m-d H:i:s")
				]
			];

			$condicion=[
				"condicion_campo"=>"cliente_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("cliente",$usuario_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']=$foto;
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"La foto del cliente ".$datos['cliente_nombre']." ".$datos['cliente_apellido']." se actualizo correctamente",
					"icono"=>"success"
				];
			}else{

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"No hemos podido actualizar algunos datos del cliente ".$datos['cliente_nombre']." ".$datos['cliente_apellido']." , sin embargo la foto ha sido actualizada",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}

	}