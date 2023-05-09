<?php

    include_once 'tracking.php';

    class courrierTracking{

        function getById($id){
            $tracking = new Tracking();
            $historial = array();
            $historial["items"] = array();

            $res = $tracking->obtenerTracking($id);
           
            if($res->rowCount()){
                while ($row = $res->fetch(PDO::FETCH_ASSOC)){
    
                    $item=array(
                        "status" => $row['nombre_status'],
                        "lugar" => $row['nombre_lugar'],
                        "fecha" => $row['fecha'],
                    );
                    array_push($historial["items"], $item);
                }
        
                $this->printJSON($historial);
            }else{
                echo json_encode(array('mensaje' => 'No hay registro'));
            }
        }

        function error($mensaje){
            echo json_encode(array('mensaje' => $mensaje)); 
        }

        function printJSON($array){
            echo '<code>'.json_encode($array).'</code>';
        }
    }

?>