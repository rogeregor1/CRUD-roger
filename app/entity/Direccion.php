<?php
namespace app\entity;

use app\models\mainModel;
use PDO;
use PDOException;

class Direccion {
    private ?int $direccionId;
    private string $calle;
    private string $nombre;
    private string $ciudad;
    private string $provincia;    
    private string $codigoPostal;
    private string $pais;
    private $db;

    public function __construct(int $direccionId = null, string $calle = "", string $nombre = "", string $ciudad = "", string $provincia = "", string $codigoPostal = "", string $pais = "") {
        $this->direccionId = $direccionId;
        $this->calle = $calle;
        $this->nombre = $nombre;
        $this->ciudad = $ciudad;
        $this->provincia = $provincia;
        $this->codigoPostal = $codigoPostal;
        $this->pais = $pais;
        $this->db = mainModel::getInstance()->conectar();
    }

    // Getters
    public function getDireccionId(): int {
        return $this->direccionId;
    }

    public function getCalle(): string {
        return $this->calle;
    }

    public function getNombre(): string {
        return $this->calle;
    }

    public function getCiudad(): string {
        return $this->nombre;
    }

    public function getProvincia(): string {
        return $this->provincia;
    }

    public function getCodigoPostal(): string {
        return $this->codigoPostal;
    }

    public function getPais(): string {
        return $this->pais;
    }

    // Setters
    public function setDireccionId(int $direccionId): void {
        $this->direccionId = $direccionId;
    }

    public function setCalle(string $calle): void {
        $this->calle = $calle;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function setCiudad(string $ciudad): void {
        $this->ciudad = $ciudad;
    }

    public function setProvincia(string $provincia): void {
        $this->provincia = $provincia;
    }

    public function setCodigoPostal(string $codigoPostal): void {
        $this->codigoPostal = $codigoPostal;
    }

    public function setPais(string $pais): void {
        $this->pais = $pais;
    }

    // Database interactions
    public function loadById(int $direccionId): void {
        $db = $this->db;
        $stmt = $db->prepare("SELECT * FROM direccion WHERE address_id = ?");
        $stmt->bindParam(1, $direccionId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            $this->direccionId = $row['address_id'];
            $this->calle = $row['address_calle'];
            $this->nombre = $row['address_name'];
            $this->ciudad = $row['address_ciudad'];
            $this->provincia = $row['address_provincia'];
            $this->codigoPostal = $row['address_cp'];
            $this->pais = $row['address_pais'];
        } else {
            throw new \Exception("Dirección no encontrada");
        }
    }

    public function save(): void {
        $db = $this->db;
        if ($this->direccionId) {
            $stmt = $db->prepare("UPDATE direccion SET address_calle = ?, address_ciudad = ?, address_provincia = ?, address_cp = ?, address_pais = ? WHERE address_id = ?");
            $stmt->bindParam(1, $this->calle, PDO::PARAM_STR);
            $stmt->bindParam(2, $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(3, $this->ciudad, PDO::PARAM_STR);
            $stmt->bindParam(4, $this->provincia, PDO::PARAM_STR);
            $stmt->bindParam(5, $this->codigoPostal, PDO::PARAM_STR);
            $stmt->bindParam(6, $this->pais, PDO::PARAM_STR);
            $stmt->bindParam(7, $this->direccionId, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $db->prepare("INSERT INTO direccion (address_calle, address_ciudad, address_provincia, address_cp, address_pais) VALUES (?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $this->calle, PDO::PARAM_STR);
            $stmt->bindParam(2, $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(3, $this->ciudad, PDO::PARAM_STR);
            $stmt->bindParam(4, $this->provincia, PDO::PARAM_STR);
            $stmt->bindParam(5, $this->codigoPostal, PDO::PARAM_STR);
            $stmt->bindParam(6, $this->pais, PDO::PARAM_STR);
            $stmt->execute();
            $this->direccionId = $db->lastInsertId();
        }
    }

    public function delete(): void {
        if ($this->direccionId) {
            $db = $this->db;
            $stmt = $db->prepare("DELETE FROM direccion WHERE address_id = ?");
            $stmt->bindParam(1, $this->direccionId, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            throw new \Exception("Dirección no existe.");
        }
    }
}

