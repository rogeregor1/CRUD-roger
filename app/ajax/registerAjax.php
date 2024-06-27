<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\registerController;

	if(isset($_POST['modulo_register'])){

		$regUser = new registerController();

		if($_POST['modulo_register']=="registrar"){
			echo $regUser->registerController();
		}
		
	}else{
		session_start(['session_name'=>'SERVICIOS']);
		session_unset();
		session_destroy();
		header("Location: ".APP_URL."login/");
		exit();
	}