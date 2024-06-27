<?php

namespace app\models;

class viewsModel
{

	/*---------- Modelo obtener vista ----------*/
	protected function obtenerVistasModelo($vista)
	{

		$listaBlanca = ["AdministradorBoard", "ClienteBoard", "TecnicoBoard", "ColaboradorBoard", "userNew", "userList", "userUpdate", "userSearch", "userPhoto", "logOut", "ofiElectronica", "ofiCarpinteria", "ofiLimpieza", "ofiInformatica", "ofiReformas", "tecOficioAceptarContrato", "tecOficioAdd", "tecOficioList", "tecOficioSugerencia", "serviceSearch", "serviceListContratos", "serviceNewContrato", "mostrarCarrito", "pagar"];

		if (in_array($vista, $listaBlanca)) {
			if (is_file("./app/views/content/" . $vista . "-view.php")) {
				$contenido = "./app/views/content/" . $vista . "-view.php";
			} else {
				$contenido = "404";
			}
		} elseif ($vista == "login" || $vista == "index") {
			$contenido = "login";
		}elseif($vista=="logRegister"){
				$contenido="logRegister";
		}elseif($vista=="recuperarClave"){
				$contenido="recuperarClave";		
		} else {
			$contenido = "404";
		}
		return $contenido;
	}
}
