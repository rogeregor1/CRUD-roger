<?php

use app\api\asistencia\asistencia;

if(isset($_GET['action'])){

    $accion = $_GET['action'];
    $carrito = new Asistencia();
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

function mostrar($oficio){
    $itemsOficios = json_decode($oficio->load(), 1);
    $fullItems = [];
    $total = 0;
    $totalItems = 0;
    foreach($itemsOficios as $itemOficio){
        $httpRequest = file_get_contents('http://localhost/CRUD-roger/app/api/oficioPor/api-oficios.php?get-item=' .$itemOficio['id']); 
        $itemProducto = json_decode($httpRequest, 1)['item'];
        $itemProducto['cantidad'] = $itemOficio['cantidad'];
        $itemProducto['stock'];
        $itemProducto['subtotal'] = $itemProducto['cantidad'] * $itemProducto['precio'];
        $total += $itemProducto['subtotal'];
        $totalItems += $itemProducto['cantidad'];
        array_push($fullItems, $itemProducto);
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


