<?php
    require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
    require $conf['path_host'].'/EasyPDO/conexionPDO.php';
    require $conf['path_host'].'/include/include_sesion.php';
    require $conf['path_host'].'/funciones/fecha_actual.php';

    set_time_limit(0);

    $id_usu=$_SESSION['id_usu'];
    $id_estado=$_POST['id_estado'];
    $id_lugar=$_POST['id_lugar_enviar'];
    $visible=$_POST['visibleCliente'];

    if($visible==1) {
        $visible=1;
    }else{
        $visible=0;
    }

    // validamos que la conexion y la variable db sea correcta
    if (!empty($db)){

        //Aquí es donde seleccionamos el archivo csv
        $fname = $_FILES['archivo']['name'];
        $chk_ext = explode(".",$fname);
         
        // validamos que la extencion del archivo sea csv
        if(strtolower(end($chk_ext)) == "csv"){
            //si es correcto, entonces damos permisos de lectura para subir
            $filename = $_FILES['archivo']['tmp_name'];
            $handle = fopen($filename, "r");
        
            while (($data = fgetcsv($handle, 1000, ";")) != FALSE){
                //contamos las columnas para validar el archivo correcto 
                $columnas= count($data);

                if ($columnas!=1){
                    header('Location: cambiarEstado.php?id=2');
                }else{

                    $db->prepare("SELECT * FROM paquete WHERE tracking_garve=:id ORDER BY id_paquete DESC LIMIT 1");
                    $db->execute(array(':id' => utf8_decode($data[0])));
                    $sql_paquete=$db->get_results();

                    $id_paquete=$sql_paquete[0]->id_paquete;

                    if($id_estado==6 || $id_estado==16){
                        $db->prepare("UPDATE paquete SET status=:status, envio_entregado=1, cancelado=0 WHERE id_paquete=:paquete");
                        $db->execute(array(':status' => $id_estado, ':paquete' => $id_paquete));
                    }elseif($id_estado==8 || $id_estado==9 || $id_estado==17){
                        $db->prepare("UPDATE paquete SET status=:status, envio_entregado=0, cancelado=1 WHERE id_paquete=:paquete");
                        $db->execute(array(':status' => $id_estado, ':paquete' => $id_paquete));
                    }elseif($id_estado==5){
                        $db->prepare("UPDATE paquete SET status=:status, envio_entregado=0, cancelado=0, email_counter=0 WHERE id_paquete=:paquete");
                        $db->execute(array(':status' => $id_estado, ':paquete' => $id_paquete));
                    }else{
                        $db->prepare("UPDATE paquete SET status=:status, envio_entregado=0, cancelado=0 WHERE id_paquete=:paquete");
                        $db->execute(array(':status' => $id_estado, ':paquete' => $id_paquete));
                    }

                    $db->prepare("INSERT INTO status_log SET
                        id_paquete=:id,
                        id_tipo_status=20,
                        id_usuario=:usuario,
                        id_lugar=5,
                        visible_cliente=0,
                        fecha=:fecha
                    ");
                    $db->execute(array(
                        ':id' => $id_paquete,
                        ':usuario' => $id_usu,
                        ':fecha' => $fecha_actual
                    ));

                    $db->prepare("INSERT INTO status_log SET
                        id_paquete=:id,
                        id_tipo_status=:id_tipo_status,
                        id_usuario=:usuario,
                        id_lugar=:id_lugar,
                        visible_cliente=:visible,
                        fecha=:fecha
                    ");
                    $db->execute(array(
                        ':id' => $id_paquete,
                        ':usuario' => $id_usu,
                        ':id_tipo_status' => $id_estado,
                        ':id_lugar' => $id_lugar,
                        ':visible' => $visible,
                        ':fecha' => $fecha_actual
                    ));
                }
            }
            
            header('Location: cambiarEstado.php?id=1');
        }else{
            //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para  //ver si esta separado por " , "
            header('Location: cambiarEstado.php?id=2');
        }        
    }
?>