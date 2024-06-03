<?php
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\serviceController;

	if(isset($_POST['modulo_service'])){

		$insService = new serviceController();

		if($_POST['modulo_service']=="registrar"){
			echo $insService->registrarServiceControlador();
		}

		if($_POST['modulo_service']=="eliminar"){
			echo $insService->eliminarServiceControlador();
		}

		if($_POST['modulo_service']=="actualizar"){
			echo $insService->actualizarServiceControlador();
		}

	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}