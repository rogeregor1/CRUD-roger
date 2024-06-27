<?php

namespace sat\api\carrito;
use sat\api\session;

class Carrito extends Session
{

    function __construct(){
        parent::__construct('asistencia');
    }

    public function load(){
        if($this->getValue() == NULL){
            return '[]';
        }
        return $this->getValue();
    }

// aceptar servicio de asistencia SAT
    public function add($id){
        if($this->getValue() == NULL){
            $items = [];
        }else{
            $items = json_decode($this->getValue(), 1);
            for($i=0; $i<sizeof($items); $i++){
                if($items[$i]['id'] == $id){
                    $items[$i]['cantidad']++;
                    $this->setValue(json_encode($items));
                    return $this->getValue();
                }
            }
        }
        
        $item = ['id' => (int)$id, 'cantidad' => 1];
        
        array_push($items, $item);
        $this->setValue(json_encode($items));
        return $this->getValue();
    }

// descartar servicio de asistencia SAT
    public function remove($id){
        if($this->getValue() == NULL){
            $items = [];
        }else{
            $items = json_decode($this->getValue(), 1);

            for($i=0; $i<sizeof($items); $i++){
                
                if($items[$i]['id'] == $id){
                    $items[$i]['cantidad']--;
                    if($items[$i]['cantidad'] == 0){
                        unset($items[$i]);
                        $items = array_values($items);
                    }
                    $this->setValue(json_encode($items));
                    return true;
                }
            }
        }
        
        //$item = ['id' => (int)$id, 'cantidad' => 1];
        
        //array_push($items, $item);
        //$this->setValue(json_encode($items));
        //return $this->getValue();
    }

}
?>