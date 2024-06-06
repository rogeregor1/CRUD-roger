<?php
namespace app\controllers;
use app\models\mainModel;
use PDO;
class OficioPor extends mainModel{


    public function get($id){
        $query = mainModel::ejecutarConsulta('SELECT * FROM oficio_por WHERE oficio_por_id = :id LIMIT 0,20');
        $query->execute(['id' => $id]);

        $row = $query->fetch();

        return [
            'id'            => $row['oficio_por_id'],
            'usuario_id'    => $row['usuario_id'],
            'category_id'   => $row['category_id'],
            'service_tipo'  => $row['service_tipo'],
            'oficio_precio'  => $row['oficio_precio']
                ];
    }

    public function getItemsByCategory($category){
        $query = mainModel::ejecutarConsulta('SELECT * FROM oficio_por WHERE category_id = :cat LIMIT 0,20');
        $query->execute(['cat' => $category]);
        $items = [];
        
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $item = [
                'id'            => $row['oficio_por_id'],
                'usuario_id'    => $row['usuario_id'],
                'category_id'   => $row['category_id'],
                'service_tipo'  => $row['service_tipo'],
                'oficio_precio'  => $row['oficio_precio']
                    ];
            array_push($items, $item);
        }
        return $items;
    }
}

