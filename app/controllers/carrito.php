<?php
namespace app\controllers;
use app\models\mainModel;
require_once 'config/server.php';

class Carrito extends mainModel{

    public function iniciarCarritoControlador() {
        $mensaje = "";

        if (isset($_POST['btnAccion'])) {
            switch ($_POST['btnAccion']) {
                case 'Agregar':
                    $ID = $this->decryptValue($_POST['id']);
                    $USER = $this->decryptValue($_POST['user']);
                    $CATEGORY = $this->decryptValue($_POST['category']);
                    $SERVICE = $this->decryptValue($_POST['service']);
                    $PRECIO = $this->decryptValue($_POST['precio']);
                    $CANTIDAD = $this->decryptValue($_POST['cantidad']);
                    $ESTADO = $this->decryptValue($_POST['estado']);

                    if ($ID && $USER && $CATEGORY && $SERVICE && $PRECIO && $CANTIDAD && $ESTADO) {
                        $mensaje .= "Datos correctos<br/>";
                        if (!isset($_SESSION['CARRITO'])) {
                            $_SESSION['CARRITO'][0] = $this->crearProducto($ID, $USER, $CATEGORY, $SERVICE, $PRECIO, $CANTIDAD, $ESTADO);
                            $mensaje = "Producto agregado al carrito";
                        } else {
                            $idProductos = array_column($_SESSION['CARRITO'], 'ID');
                            if (in_array($ID, $idProductos)) {
                                foreach ($_SESSION['CARRITO'] as &$producto) {
                                    if ($producto['ID'] == $ID) {
                                        $producto['CANTIDAD'] += 1;
                                        $mensaje = "Producto agregado al carrito";
                                        break;
                                    }
                                }
                            } else {
                                $NumeroProductos = count($_SESSION['CARRITO']);
                                $_SESSION['CARRITO'][$NumeroProductos] = $this->crearProducto($ID, $USER, $CATEGORY, $SERVICE, $PRECIO, $CANTIDAD, $ESTADO);
                                $mensaje = "Producto agregado al carrito";
                            }
                        }
                    } else {
                        $mensaje .= "Error en los datos<br/>";
                    }
                    break;

                case "Eliminar":
                    $ID = $this->decryptValue($_POST['id']);
                    $CANT = $this->decryptValue($_POST['cantidad']);

                    foreach ($_SESSION['CARRITO'] as $indice => $producto) {
                        if ($producto['ID'] == $ID) {
                            if ($producto['CANTIDAD'] == 1) {
                                unset($_SESSION['CARRITO'][$indice]);
                            } else {
                                $producto['CANTIDAD'] -= 1;
                            }
                            break;
                        }
                    }
                    break;
            }
        }
        return $mensaje;
    }

    private function decryptValue($value) {
        $decryptedValue = openssl_decrypt($value, COD, KEY);
        return is_numeric($decryptedValue) ? $decryptedValue : false;
    }

    private function crearProducto($ID, $USER, $CATEGORY, $SERVICE, $PRECIO, $CANTIDAD, $ESTADO) {
        return [
            'ID' => $ID,
            'USER' => $USER,
            'CATEGORY' => $CATEGORY,
            'SERVICE' => $SERVICE,
            'PRECIO' => $PRECIO,
            'CANTIDAD' => $CANTIDAD,
            'ESTADO' => $ESTADO
        ];
    }
}
