<?php

	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\carrito;


	if(isset($_POST['modulo_carrito']) && isset($_POST['id']) && isset($_POST['user']) && isset($_POST['category']) && isset($_POST['service']) && isset($_POST['precio']) && isset($_POST['cantidad']) && isset($_POST['estado']) ){

		/*--------- Instancia al controlador ---------*/
		$insCarrito = new Carrito();
		if($_POST['modulo_carrito']=="carrito"){
			echo $insCarrito->iniciarCarritoControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
		exit();
	}