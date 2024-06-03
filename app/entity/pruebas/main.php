<?php
require_once __DIR__ . '/Servicio.php';
require_once __DIR__ . '/../usuario/Usuario.php';
require_once __DIR__ . '/../direccion/Direccion.php';
require_once __DIR__ . '/../../../config/dataBase.php'; // Ajusta el path según tu estructura de directorios

use app\entity\servicio\Servicio;
use app\entity\usuario\Usuario;
use app\entity\direccion\Direccion;
use config\dataBase;

    // Obtener instancia de la base de datos
    $db = dataBase::getInstance()->conectar();

    // Crear objetos de Usuario y Direccion
    $direccion = new Direccion(3, "Av. La Estacion 123", "Lima", "Lima", "12345", "Peru");
    $usuario = new Usuario(3, "Pepe", "PBiondy", "Bpepe", "bpepe@example.com", "password123", "Administrador", "foto.jpg", $direccion->getDireccionId());

    // Guardar Usuario y Direccion
    $direccion->save();
    $usuario->save();

    // Crear y guardar un nuevo servicio
    $servicio = new Servicio(1, "Servicio de Limpieza", "2024-05-18 14:30:00", $direccion->getDireccionId(), $usuario->getUsuarioId(), "Limpieza general", "Mantenimiento");
    $servicio->save();

    // Display Servicio details
    echo "SERVICIO_ID: " . $servicio->getServicioId() . "\n";
    echo "SERVICIO_Nombre: " . $servicio->getNombre() . "\n";
    echo "SERVICIO_Fecha: " . $servicio->getFecha() . "\n";
    echo "SERVICIO_Tipo: " . $servicio->getTipo() . "\n";
    echo "SERVICIO_Detalles: " . $servicio->getDetalles() . "\n";

    echo "SERVICIO_Usuario ID: " . $servicio->getUsuario()->getUsuarioId() . "\n";
    echo "SERVICIO_Dirección ID: " . $servicio->getDireccion()->getDireccionId() . "\n";

