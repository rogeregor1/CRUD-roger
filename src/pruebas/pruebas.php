<?php

    /* Métodos de interacción con la base de datos
    public function loadById(int $id): void {
        $stmt = $this->db->prepare("SELECT * FROM usuario WHERE usuario_id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            $this->id = $row['usuario_id'];
            $this->nombre = $row['usuario_nombre'];
            $this->apellido = $row['usuario_apellido'];
            $this->usuario = $row['usuario_usuario'];
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
        if ($this->id) {
            $stmt = $this->db->prepare("UPDATE usuario SET usuario_nombre = ?, usuario_apellido = ?, usuario_usuario = ?, usuario_email = ?, usuario_clave = ?, usuario_foto = ?, usuario_rol = ?, address_id = ?, usuario_actualizado = NOW() WHERE usuario_id = ?");
            $stmt->bindParam(1, $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(2, $this->apellido, PDO::PARAM_STR);
            $stmt->bindParam(3, $this->usuario, PDO::PARAM_STR);
            $stmt->bindParam(4, $this->email, PDO::PARAM_STR);
            $stmt->bindParam(5, $this->password, PDO::PARAM_STR);
            $stmt->bindParam(6, $this->foto, PDO::PARAM_STR);
            $stmt->bindParam(7, $this->rol, PDO::PARAM_STR);
            $stmt->bindParam(8, $this->addressId, PDO::PARAM_INT);
            $stmt->bindParam(9, $this->id, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $this->db->prepare("INSERT INTO usuario (usuario_nombre, usuario_apellido, usuario_usuario, usuario_email, usuario_clave, usuario_foto, usuario_rol, address_id, usuario_creado, usuario_actualizado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->bindParam(1, $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(2, $this->apellido, PDO::PARAM_STR);
            $stmt->bindParam(3, $this->usuario, PDO::PARAM_STR);
            $stmt->bindParam(4, $this->email, PDO::PARAM_STR);
            $stmt->bindParam(5, $this->password, PDO::PARAM_STR);
            $stmt->bindParam(6, $this->foto, PDO::PARAM_STR);
            $stmt->bindParam(7, $this->rol, PDO::PARAM_STR);
            $stmt->bindParam(8, $this->addressId, PDO::PARAM_INT);
            $stmt->execute();
            $this->id = $this->db->lastInsertId();
        }
    }

    public function delete(): void {
        if ($this->id) {
            $stmt = $this->db->prepare("DELETE FROM usuario WHERE usuario_id = ?");
            $stmt->bindParam(1, $this->id, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            throw new \Exception("Usuario no existe.");
        }
    }
    */
