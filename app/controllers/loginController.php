<?php
namespace app\controllers;
use app\models\mainModel;

class loginController extends mainModel
{
    /*----------  Controlador iniciar sesion  ----------*/
    public function iniciarSesionControlador(){

        $usuario=$this->limpiarCadena($_POST['login_usuario']);
        $clave=$this->limpiarCadena($_POST['login_clave']);

        # Verificando campos vacios #
        if($usuario=="" || $clave==""){
            echo "<script>
                Swal.fire({
                  icon: 'error',
                  title: 'Ocurrió un error inesperado',
                  text: 'No has llenado todos los campos que son obligatorios'
                });
            </script>";
            exit();
        } else {

            # Verificando integridad de los datos #
            if($this->verificarDatos("[a-zA-Z0-9$@#.-]{4,100}", $usuario)){
                echo "<script>
                    Swal.fire({
                      icon: 'error',
                      title: 'Ocurrió un error inesperado',
                      text: 'El USUARIO no coincide con el formato solicitado'
                    });
                </script>";
                exit();
            } else {

                # Verificando integridad de los datos #
                if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,255}", $clave)){
                    echo "<script>
                        Swal.fire({
                          icon: 'error',
                          title: 'Ocurrió un error inesperado',
                          text: 'La CLAVE no coincide con el formato solicitado'
                        });
                    </script>";
                    exit();
                } else {

                    # Verificando usuario #
                    $check_usuario=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_usuario='$usuario'");

                    if($check_usuario->rowCount()==1){
                        $check=$check_usuario->fetch();

                        if($check['usuario_usuario']==$usuario && password_verify($clave,$check['usuario_clave'])){

                            session_start(['session_name'=>'SERVICIOS']);
                            $_SESSION['id']=$check['usuario_id'];
                            $_SESSION['nombre']=$check['usuario_nombre'];
                            $_SESSION['apellido']=$check['usuario_apellido'];
                            $_SESSION['usuario']=$check['usuario_usuario'];
                            $_SESSION['email']=$check['usuario_email'];
                            $_SESSION['rol']=$check['usuario_rol'];
                            $_SESSION['foto']=$check['usuario_foto'];

                            # Insertar registro de inicio de sesión en bitacora
                            $usuario_id = $_SESSION['id'];
                            $bitacora_tipo = 'Inicio_sesion';
                            $bitacora_detalle = 'Sesión iniciada correctamente';
                            $this->ejecutarConsulta("INSERT INTO bitacora (bitacora_tipo, bitacora_detalle, usuario_id) VALUES ('$bitacora_tipo', '$bitacora_detalle', '$usuario_id')");

                            switch($_SESSION['rol']){
                                case ($_SESSION['rol']=="Administrador"):
                                    if(headers_sent()){
                                        echo "<script> window.location.href='".APP_URL."AdministradorBoard/'; </script>";
                                    } else {
                                        header("Location: ".APP_URL."AdministradorBoard/");
                                    }
                                break;

                                case ($_SESSION['rol']=="Colaborador"):
                                    if(headers_sent()){
                                        echo "<script> window.location.href='".APP_URL."ColaboradorBoard/'; </script>";
                                    } else {
                                        header("Location: ".APP_URL."ColaboradorBoard/");
                                    }
                                break;

                                case ($_SESSION['rol']=="Cliente"):
                                    if(headers_sent()){
                                        echo "<script> window.location.href='".APP_URL."ClienteBoard/'; </script>";
                                    } else {
                                        header("Location: ".APP_URL."ClienteBoard/");
                                    }
                                break;

                                case ($_SESSION['rol']=="Tecnico"):
                                    if(headers_sent()){
                                        echo "<script> window.location.href='".APP_URL."TecnicoBoard/'; </script>";
                                    } else {
                                        header("Location: ".APP_URL."TecnicoBoard/");
                                    }
                                break;
                            }

                        } else {
                            echo "<script>
                                Swal.fire({
                                  icon: 'error',
                                  title: 'Ocurrió un error inesperado',
                                  text: 'Usuario o clave incorrectos'
                                });
                            </script>";
                        }

                    } else {
                        echo "<script>
                            Swal.fire({
                              icon: 'error',
                              title: 'Ocurrió un error inesperado',
                              text: 'Usuario o clave incorrectos'
                            });
                        </script>";
                    }
                }
            }
        }
    }

    /*----------  Controlador cerrar sesion  ----------*/
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
