<?php

include_once '../../lib/db.php';

class Asistencia extends DB
{
    public function get($id)
    {
        $query = $this->conectar()->prepare('
        SELECT o.oficio_por_id, u.usuario_nombre, u.usuario_apellido, c.category_name, o.service_tipo, o.estado, u.usuario_foto 
        FROM oficio_por o
        JOIN usuario u ON o.usuario_id = u.usuario_id
        JOIN category c ON o.category_id = c.category_id 
        WHERE oficio_por_id = :id 
        LIMIT 20;
        ');
        $query->execute(['id' => $id]);

        $row = $query->fetch();

        return [
            'id' => $row['oficio_por_id'],
            'user_nom' => $row['usuario_nombre'],
            'user_apel' => $row['usuario_apellido'],
            'category' => $row['category_name'],
            'service' => $row['service_tipo'],
            'estado' => $row['estado'],
            'foto' => $row['usuario_foto']
        ];
    }

    public function getItemsByCategory($cat)
    {
        $query = $this->conectar()->prepare('
        SELECT o.oficio_por_id, u.usuario_nombre, usuario_apellido, c.category_name, o.service_tipo, o.estado, u.usuario_foto 
        FROM oficio_por o
        JOIN usuario u ON o.usuario_id = u.usuario_id
        JOIN category c ON o.category_id = c.category_id 
        WHERE o.category_id = :cat
        LIMIT 20;
        ');
        $query->execute(['cat' => $cat]);
        $items = [];

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $item = [
                'id' => $row['oficio_por_id'],
                'user_nom' => $row['usuario_nombre'],
                'user_apel' => $row['usuario_apellido'],
                'category' => $row['category_name'],
                'service' => $row['service_tipo'],
                'estado' => $row['estado'],
                'foto' => $row['usuario_foto']
            ];
            array_push($items, $item);
        }
        return $items;
    }
}

