<?php
namespace app\controllers;
use app\models\mainModel;

class registerController extends mainModel
{
    /*----------  Controlador registro de users ----------*/
    public function registerController(){

        /*== Almacenando datos en variables ==*/
        $nombre = $this->limpiarCadena($_POST['nomb']);
        $apellido = $this->limpiarCadena($_POST['apell']);
        $usuario = $this->limpiarCadena($_POST['user']);
        $clave1 = $this->limpiarCadena($_POST['password1']);
        $clave2 = $this->limpiarCadena($_POST['password2']);
        $email = $this->limpiarCadena($_POST['email']);
        $rol = $this->limpiarCadena($_POST['rol']);
        $agree = $this->limpiarCadena($_POST['agree']);

        # Verificando campos vacios #
        if ($nombre == "" || $apellido == "" || $usuario == "" || $email == "" || $clave1 == "" || $clave2 == "" || $rol == "" || $agree == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();

        }else{

        # Verificando integridad de los datos #
        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El NOMBRE no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El APELLIDO no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-Z0-9]{4,20}", $usuario)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El USUARIO no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

         // Validar que se ha seleccionado un rol
         if (empty($rol)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "Debes seleccionar un rol",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        
        // Validar que el checkbox está marcado
        if ($agree != 'checked') {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "Debes aceptar los términos y condiciones.",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-Z0-9$#@.-]{7,255}", $clave1) || $this->verificarDatos("[a-zA-Z0-9$#@.-]{7,255}", $clave2)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "Las CLAVES no coinciden con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Verificando email #
        if ($email != "") {
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
                    exit();
                }
            } else {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "Ha ingresado un correo electrónico no valido",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        }

        # Verificando claves #
        if ($clave1 != $clave2) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "Las contraseñas que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $clave = password_hash($clave1, PASSWORD_BCRYPT, ["cost" => 10]);
        }

        # Verificando usuario #
        $check_usuario = $this->ejecutarConsulta("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
        if ($check_usuario->rowCount() > 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El USUARIO ingresado ya se encuentra registrado, por favor elija otro",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        $usuario_datos_reg = [
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
                "campo_nombre" => "usuario_rol",
                "campo_marcador" => ":rol",
                "campo_valor" => $rol
            ],
        ];

        $registrar_usuario = $this->guardarDatos("usuario", $usuario_datos_reg);

        if ($registrar_usuario->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Usuario registrado",
                "texto" => "El usuario " . $nombre . " " . $apellido . " se registro como: " . $rol . " con exito",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar el usuario, por favor intente nuevamente",
                "icono" => "error"
            ];
        }
        return json_encode($alerta);
        exit();
    }
}
    public function cerrarSesionControlador(){

        $usuario_id = $_SESSION['id'];
        $bitacora_tipo = 'Cerrar_sesion';
        $bitacora_detalle = 'Sesión cerrada correctamente';
        $this->ejecutarConsulta("INSERT INTO bitacora (bitacora_tipo, bitacora_detalle, usuario_id) VALUES ('$bitacora_tipo', '$bitacora_detalle', '$usuario_id')");
        
        session_unset();
        session_destroy();

        if(headers_sent()){
            echo "<script> window.location.href='".APP_URL."login/'; </script>";
        } else {
            header("Location: ".APP_URL."login/");
        }
    }
}