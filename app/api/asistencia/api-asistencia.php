<?php

use app\api\asistencia\asistencia;

if(isset($_GET['action'])){

    $accion = $_GET['action'];
    $sat = new Asistencia();
    switch($accion){
        case 'mostrarSolicitudes':
        mostrar($sat);
        break;

        case 'addSolicitud':
        add($sat);
        break;

        case 'removeSolicitud':
        remove($sat);
        break;

        default:
    }
}else{
    echo json_encode(['statuscode' => 404, 
                        'response' => 'No se puede procesar la solicitud']);
}

function mostrarSolicitudes($oficio){
    $itemsOficios = json_decode($oficio->load(), 1);
    $fullItems = [];
    $total = 0;
    $totalItems = 0;
    foreach($itemsOficios as $itemProducto){
        $httpRequest = file_get_contents('http://localhost/CRUD-roger/app/api/oficioPor/api-oficios.php?get-item=' .$itemProducto['id']); 
        $itemProducto = json_decode($httpRequest, 1)['item'];
        $itemProducto['usuario_id'];
        $itemProducto['category_id'];
        $itemProducto['service_tipo'];
        $itemProducto['subtotal'] = $itemProducto['oficio_precio'];
        $total += $itemProducto['subtotal'];
        $totalItems += $itemProducto['cantidad'];
        array_push($fullItems, $itemProducto);
    }
    $resArray = array('info' => ['count' => $totalItems, 'total' => $total] ,'items' => $fullItems);
    //array_push($fullItems, ['count' => $totalItems, 'total' => $total]);
    echo json_encode($resArray);
}

function addSolicitud($sat){
    if(isset($_GET['id'])) {
            $res = $sat->add($_GET['id']);
            echo $res;
    }else{
        echo json_encode(['statuscode' => 400]);
    }
}

function removeSolicitud($sat){
    if(isset($_GET['id'])){
        $res = $sat->remove($_GET['id']);
        if($res){
            echo json_encode(['statuscode' => 200]);
        }else{
            echo json_encode(['statuscode' => 400]);
        }
    }else{
        // error
    }
}


