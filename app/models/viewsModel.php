<?php

namespace app\models;

class viewsModel
{

	/*---------- Modelo obtener vista ----------*/
	protected function obtenerVistasModelo($vista)
	{

		$listaBlanca = ["dashBoard", "clienteBoard", "tecnicoBoard", "colaboradorBoard", "userNew", "userList", "userUpdate", "userSearch", "userPhoto", "logOut", "oficioList", "oficioAceptar", "clienteNew", "clienteList", "clienteUpdate", "clienteSearch", "clientePhoto", "serviceSearch", "serviceListContratos", "serviceNewContrato"];

		if (in_array($vista, $listaBlanca)) {
			if (is_file("./app/views/content/" . $vista . "-view.php")) {
				$contenido = "./app/views/content/" . $vista . "-view.php";
			} else {
				$contenido = "404";
			}
		} elseif ($vista == "login" || $vista == "index") {
			$contenido = "login";
			/*}elseif($vista=="register"){
				$contenido="register";*/
		} else {
			$contenido = "404";
		}
		return $contenido;
	}
}
