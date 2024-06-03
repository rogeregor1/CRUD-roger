<?php
namespace app\entity;

use app\entity\Usuario;
use app\entity\Direccion;
use PDO;
use PDOException;
use app\models\mainModel;

class Servicio
{
    private int $servicioId;
    private \DateTime $fecha;
    private int $addressId;
    private int $userId;
    private string $detalles;
    private string $categoria;
    private string $tipo;
    private $db;

    public function __construct(int $servicioId=null, string $categoria="", string $fecha="", int $addressId=null, int $userId=null, string $detalles="", string $tipo="")
    {
        $this->servicioId = $servicioId;
        $this->categoria = $categoria;
        $this->fecha = new \DateTime($fecha);
        $this->addressId = $addressId;
        $this->userId = $userId;
        $this->detalles = $detalles;
        $this->tipo = $tipo;
        $this->db = mainModel::getInstance()->conectar();
    }

    // Getters
    public function getServicioId(): int
    {
        return $this->servicioId;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function getFecha(): string
    {
        return $this->fecha->format('Y-m-d H:i:s');
    }

    public function getAdressId(): int
    {
        return $this->addressId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getDetalles(): string
    {
        return $this->detalles;
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    // Setters
    public function setServicioId(int $servicioId): void
    {
        $this->servicioId = $servicioId;
    }

    public function setCategoria(string $categoria): void
    {
        $this->categoria= $categoria;
    }

    public function setAddressId(int $addressId): void
    {
        $this->addressId = $addressId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function setDetalles(string $detalles): void
    {
        $this->detalles = $detalles;
    }

    public function setTipo(string $tipo): void
    {
        $this->tipo = $tipo;
    }

    // Methods to get related Usuario and Direccion objects
    public function getUsuario(): ?Usuario
    {
        if ($this->userId) {
            return new Usuario($this->userId);
        }
        return null;
    }
    public function setUsuario(Usuario $usuario): void {
        $usuario->save();
        $this->userId = $usuario->getUsuarioId();
    }

    // Métodos de integración para manejar la dirección
    public function getDireccion(): ?Direccion {
        if ($this->addressId) {
            return new Direccion($this->addressId);
        }
        return null;
    }
    public function setDireccion(Direccion $direccion): void {
        $direccion->save();
        $this->addressId = $direccion->getDireccionId();
    }

    // Database interactions
    public function loadById(int $servicioId): void {
        $db = $this->db;
        $stmt = $db->prepare("SELECT * FROM servicio WHERE service_id = ?");
        $stmt->bindParam(1, $servicioId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            $this->servicioId = $row['service_id'];
            $this->categoria = $row['service_categoria'];
            $this->fecha = new \DateTime($row['service_fecha']);
            $this->detalles = $row['service_detalles'];
            $this->tipo = $row['service_tipo'];
            $this->addressId = $row['address_id'];
            $this->userId = $row['usuario_id'];
        } else {
            throw new \Exception("Servico no encontrado");
        }
    }

    public function save(): void {
        $db = $this->db;
        if ($this->servicioId) {
            $stmt = $db->prepare("UPDATE servicio SET service_categoria = ?, service_fecha = ?, service_detalles = ?, service_tipo = ?, address_id = ?, usuario_id = ? WHERE service_id = ?");
            $stmt->bindParam(1, $this->categoria, PDO::PARAM_STR);
            $stmt->bindParam(2, $this->fecha, PDO::PARAM_STR);
            $stmt->bindParam(3, $this->detalles, PDO::PARAM_STR);
            $stmt->bindParam(4, $this->tipo, PDO::PARAM_STR);
            $stmt->bindParam(5, $this->addressId, PDO::PARAM_INT);
            $stmt->bindParam(6, $this->userId, PDO::PARAM_INT);
            $stmt->bindParam(7, $this->servicioId, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $db->prepare("INSERT INTO servicio (service_categoria, service_fecha, service_detalles, service_tipo, address_id, usuario_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $this->categoria, PDO::PARAM_STR);
            $stmt->bindParam(2, $this->fecha, PDO::PARAM_STR);
            $stmt->bindParam(3, $this->detalles, PDO::PARAM_STR);
            $stmt->bindParam(4, $this->tipo, PDO::PARAM_STR);
            $stmt->bindParam(5, $this->addressId, PDO::PARAM_INT);
            $stmt->bindParam(6, $this->userId, PDO::PARAM_INT);
            $stmt->execute();
            $this->servicioId = $db->lastInsertId();
        }
    }

    public function delete(): void {
        if ($this->servicioId) {
            $db = $this->db;
            $stmt = $db->prepare("DELETE FROM servicio WHERE service_id = ?");
            $stmt->bindParam(1, $this->servicioId, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            throw new \Exception("Servicio no existe.");
        }
    }

}

