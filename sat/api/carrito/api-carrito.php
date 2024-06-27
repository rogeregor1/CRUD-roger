<?php

use sat\api\carrito\carrito;

if(isset($_GET['action'])){

    $accion = $_GET['action'];
    $carrito = new Carrito();

    switch($accion){
        case 'mostrar':
        mostrar($carrito);
        break;

        case 'add':
        add($carrito);
        break;

        case 'remove':
        remove($carrito);
        break;

        default:
    }
}else{
    echo json_encode(['statuscode' => 404, 
                        'response' => 'No se puede procesar la solicitud']);
}

function mostrar($carrito){
    $itemsOficios = json_decode($carrito->load(), 1);
    $fullItems = [];
    $total = 0;
    $totalItems = 0;
    foreach($itemsOficios as $itemAsist){
        $httpRequest = file_get_contents('http://localhost/sat/api/asistencia/api-asistencia.php?get-item=' .$itemAsist['id']); 
        $itemAsist = json_decode($httpRequest, 1)['item'];
        $itemAsist['foto'];
        $itemAsist['user_nom'];
        $itemAsist['user_apel'];
        $itemAsist['category'];
        $itemAsist['service'];
        array_push($fullItems, $itemAsist);
    }
    $resArray = array('info' => ['count' => $totalItems, 'total' => $total] ,'items' => $fullItems);
    //array_push($fullItems, ['count' => $totalItems, 'total' => $total]);
    echo json_encode($resArray);
}

function add($carrito){
    if(isset($_GET['id'])) {
            $res = $carrito->add($_GET['id']);
            echo $res;
    }else{
        echo json_encode(['statuscode' => 400]);
    }
}

function remove($carrito){
    if(isset($_GET['id'])){
        $res = $carrito->remove($_GET['id']);
        if($res){
            echo json_encode(['statuscode' => 200]);
        }else{
            echo json_encode(['statuscode' => 400]);
        }
    }else{
        // error
    }
}


