<?php

include_once 'asistencia.php';

header('Content-Type: application/json');

if (isset($_GET['category'])) {
    $cat = $_GET['category'];

    if (empty($cat)) {
        echo json_encode(['statuscode' => 400, 'response' => 'No existe la categoria']);
    } else {
        $asist = new Asistencia();
        $items = $asist->getItemsByCategory($cat);
        echo json_encode(['statuscode' => 200, 'items' => $items]);
    }


}else if(isset($_GET['get-item'])){
    $id = $_GET['get-item'];

    if($id == ''){
        echo json_encode(['statuscode' => 400, 
                            'response' => 'No hay valor para id']);    
    }else{
        $asist = new Asistencia();
        $item = $asist->get($id);
        echo json_encode(['statuscode' => 200, 
                        'item' => $item]);
    }
}else{
    echo json_encode(['statuscode' => 404, 
                        'response' => 'No se puede procesar la solicitud']);
}
