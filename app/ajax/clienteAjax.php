<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\clienteController;

	if(isset($_POST['modulo_cliente'])){

		$insCliente = new clienteController();

		if($_POST['modulo_usuario']=="registrar"){
			echo $insCliente->registrarClienteControlador();
		}

		if($_POST['modulo_usuario']=="eliminar"){
			echo $insCliente->eliminarClienteControlador();
		}

		if($_POST['modulo_usuario']=="actualizar"){
			echo $insCliente->actualizarClienteControlador();
		}

		if($_POST['modulo_usuario']=="eliminarFoto"){
			echo $insClienteo->eliminarFotoClienteControlador();
		}

		if($_POST['modulo_usuario']=="actualizarFoto"){
			echo $insCliente->actualizarFotoClienteControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}