<?php

use app\controllers\OficioPor;

include_once 'oficioPor.php';

if(isset($_GET['category'])){
    $categoria = $_GET['category'];
    
    if($categoria == ''){
        echo json_encode(['statuscode' => 400, 
                            'response' => 'No existe la categor&iacute;a']);    
    }else{
        $oficioPor = new OficioPor();
        $items = $oficioPor->getItemsByCategory($category);
        echo json_encode(['statuscode' => 200, 
                        'items' => $items]);
    }
}else if(isset($_GET['get-item'])){
    $id = $_GET['get-item'];

    if($id == ''){
        echo json_encode(['statuscode' => 400, 
                            'response' => 'No hay valor para id']);    
    }else{
        $oficioPor = new OficioPor();
        $item = $oficioPor->get($id);
        echo json_encode(['statuscode' => 200, 
                        'item' => $item]);
    }
}else{
    echo json_encode(['statuscode' => 404, 
                        'response' => 'No se puede procesar la solicitud']);
}

