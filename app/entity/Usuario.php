<?php
namespace app\entity;

use PDO;
use PDOException;
use app\models\mainModel;
use app\entity\Direccion;

class Usuario {
    private int $usuarioId;
    private string $nombre;
    private string $apellido;
    private string $usuarioUser;
    private string $email;
    private string $password;
    private string $rol;
    private string $foto;
    private int $addressId;
    private \DateTime $creado;
    private \DateTime $actualizado;
    private $db;

    public function __construct(int $usuarioId = null, string $nombre = "", string $apellido = "", string $usuarioUser = "", string $email = "", string $password = "", string $rol = "", string $foto = "", int $addressId = null) {
        $this->usuarioId = $usuarioId;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->usuarioUser = $usuarioUser;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
        $this->foto = $foto;
        $this->addressId = $addressId;
        $this->creado = new \DateTime();
        $this->actualizado = new \DateTime();
        $this->db = mainModel::getInstance()->conectar();
    }

    // Getters
    public function getUsuarioId(): int {
        return $this->usuarioId;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getApellido(): string {
        return $this->apellido;
    }

    public function getUsuarioUser(): string {
        return $this->usuarioUser;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getRol(): string {
        return $this->rol;
    }

    public function getFoto(): string {
        return $this->foto;
    }

    public function getAddressId(): int
    {
        return $this->addressId;
    }

    public function getCreado(): string {
        return $this->creado->format('Y-m-d H:i:s');
    }

    public function getActualizado(): string {
        return $this->actualizado->format('Y-m-d H:i:s');
    }

    // Setters
    public function setUsuarioId(int $usuarioId): void {
        $this->usuarioId = $usuarioId;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function setApellido(string $apellido): void {
        $this->apellido = $apellido;
    }

    public function setUsuarioUser(string $usuarioUser): void {
        $this->usuarioUser = $usuarioUser;
    }

    public function setEmail(string $email): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Email inválido: " . $email);
        }
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        if (strlen($password) < 8) {
            throw new \InvalidArgumentException("La contraseña debe tener al menos 8 caracteres.");
        }
        $this->password = $password;
    }

    public function setRol(string $rol): void {
        $validRoles = ['Administrador', 'Colaborador', 'Cliente', 'Tecnico'];
        if (!in_array($rol, $validRoles)) {
            throw new \InvalidArgumentException("Rol inválido: " . $rol);
        }
        $this->rol = $rol;
    }

    public function setFoto(string $foto): void {
        $this->foto = $foto;
    }

    public function setAddressId(int $addressId): void
    {
        $this->addressId = $addressId;
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

    // Métodos de interacción con la base de datos
    public function loadById(int $usuarioId): void {
        $db = $this->db;
        $stmt = $db->prepare("SELECT * FROM usuario WHERE usuario_id = ?");
        $stmt->bindParam(1, $usuarioId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            $this->usuarioId = $row['usuario_id'];
            $this->nombre = $row['usuario_nombre'];
            $this->apellido = $row['usuario_apellido'];
            $this->usuarioUser = $row['usuario_usuario'];
            $this->email = $row['usuario_email'];
            $this->password = $row['usuario_clave'];
            $this->rol = $row['usuario_rol'];
            $this->foto = $row['usuario_foto'];
            $this->addressId = $row['address_id'];
            $this->creado = new \DateTime($row['usuario_creado']);
            $this->actualizado = new \DateTime($row['usuario_actualizado']);
        } else {
            throw new \Exception("Usuario no encontrado");
        }
    }

    public function save(): void {
        $db = $this->db;
        if ($this->usuarioId) {
            $stmt = $db->prepare("UPDATE usuario SET usuario_nombre = ?, usuario_apellido = ?, usuario_usuario = ?, usuario_email = ?, usuario_clave = ?, usuario_rol = ?, usuario_foto = ?, address_id = ?, usuario_actualizado = ? WHERE usuario_id = ?");
            $stmt->bindParam(1, $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(2, $this->apellido, PDO::PARAM_STR);
            $stmt->bindParam(3, $this->usuarioUser, PDO::PARAM_STR);
            $stmt->bindParam(4, $this->email, PDO::PARAM_STR);
            $stmt->bindParam(5, $this->password, PDO::PARAM_STR);
            $stmt->bindParam(6, $this->rol, PDO::PARAM_STR);
            $stmt->bindParam(7, $this->foto, PDO::PARAM_STR);
            $stmt->bindParam(8, $this->addressId, PDO::PARAM_INT);
            $stmt->bindParam(9, $this->actualizado, PDO::PARAM_STR);
            $stmt->bindParam(10, $this->usuarioId, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $db->prepare("INSERT INTO usuario (usuario_nombre, usuario_apellido, usuario_usuario, usuario_email, usuario_clave, usuario_rol, usuario_foto, address_id, usuario_creado, usuario_actualizado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(2, $this->apellido, PDO::PARAM_STR);
            $stmt->bindParam(3, $this->usuarioUser, PDO::PARAM_STR);
            $stmt->bindParam(4, $this->email, PDO::PARAM_STR);
            $stmt->bindParam(5, $this->password, PDO::PARAM_STR);
            $stmt->bindParam(6, $this->rol, PDO::PARAM_STR);
            $stmt->bindParam(7, $this->foto, PDO::PARAM_STR);
            $stmt->bindParam(8, $this->addressId, PDO::PARAM_INT);
            $stmt->bindParam(9, $this->creado, PDO::PARAM_STR);
            $stmt->bindParam(10, $this->actualizado, PDO::PARAM_STR);
            $stmt->execute();
            $this->usuarioId = $db->lastInsertId();
        }
    }

    public function delete(): void {
        if ($this->usuarioId) {
            $db = $this->db;
            $stmt = $db->prepare("DELETE FROM usuario WHERE usuario_id = ?");
            $stmt->bindParam(1, $this->usuarioId, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            throw new \Exception("Usuario no existe.");
        }
    }
}

