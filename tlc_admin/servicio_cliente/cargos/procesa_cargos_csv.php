<?php
    require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
    require $conf['path_host'].'/EasyPDO/conexionPDO.php';
    require $conf['path_host'].'/include/include_sesion.php';

    set_time_limit(0);

    // funcion fecha actual tiene que ir despues de la conexion PDO
    require $conf['path_host'].'/funciones/fecha_actual.php';
    $id_usu=$_SESSION['id_usu'];

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

                if ($columnas!=7){
                    header('Location: importar_cargos_csv.php?id=2');
                }else{
                    //Insertamos los datos con los valores en la tabla cargos
                    $db->prepare('INSERT INTO cargos SET 
                        guia=:guia, 
                        chi=:chi, 
                        aduana=:aduana, 
                        flete=:flete, 
                        manejo=:manejo, 
                        proteccion=:proteccion,
                        total=:total,
                        fecha=:fecha_actual
                    ');

                    $db->execute(array(
                        ':guia' => utf8_decode($data[0]),
                        ':chi' => utf8_decode($data[1]),
                        ':aduana' => utf8_decode($data[2]),
                        ':flete' => utf8_decode($data[3]),
                        ':manejo' => utf8_decode($data[4]),
                        ':proteccion' => utf8_decode($data[5]),
                        ':total' => utf8_decode($data[6]),
                        ':fecha_actual' => $fecha_actual
                    ));

                    $id_cargo=$db->lastId();

                    $db->prepare("UPDATE cargos SET eliminado=1 WHERE guia=:guia AND chi=:chi AND id_cargo!=:id_cargo");
                    $db->execute(array(
                        ':guia'=>utf8_decode($data[0]),
                        ':chi'=>utf8_decode($data[1]),
                        ':id_cargo' => $id_cargo 
                    ));

                    $db->prepare("SELECT * FROM paquete WHERE tracking_garve=:id ORDER BY id_paquete DESC LIMIT 1");
                    $db->execute(array(':id' => utf8_decode($data[0])));
                    $sql_paquete=$db->get_results();

                    if(empty($sql_paquete)){
                        $db->prepare("SELECT * FROM paquete WHERE numero_miami=:id ORDER BY id_paquete DESC LIMIT 1");
                        $db->execute(array(':id' => utf8_decode($data[0])));
                        $sql_paquete=$db->get_results();
                    }

                    $estadoActual=$sql_paquete[0]->status;

                    $tracking_garve=$sql_paquete[0]->tracking_garve;
                    $peso=$sql_paquete[0]->peso;
                    $descripcion_producto=$sql_paquete[0]->descripcion_producto;

                    $db->prepare("UPDATE paquete SET id_cargo=:id_cargo WHERE id_paquete=:id");
                    $db->execute(array('id_cargo'=>$id_cargo ,':id' => $sql_paquete[0]->id_paquete));

                    if($estadoActual==19){

                        $db->prepare("UPDATE paquete SET status=5 WHERE id_paquete=:id");
                        $db->execute(array(':id' => $sql_paquete[0]->id_paquete));

                        $db->prepare("INSERT INTO status_log SET
                            id_paquete=:id,
                            id_tipo_status=18,
                            id_usuario=:usuario,
                            id_lugar=5,
                            visible_cliente=0,
                            fecha=:fecha
                        ");
                        $db->execute(array(
                            ':id' => $sql_paquete[0]->id_paquete,
                            ':usuario' => $id_usu,
                            ':fecha' => $fecha_actual
                        ));

                        $db->prepare("INSERT INTO status_log SET
                            id_paquete=:id,
                            id_tipo_status=5,
                            id_usuario=:usuario,
                            id_lugar=5,
                            visible_cliente=1,
                            fecha=:fecha
                        ");
                        $db->execute(array(
                            ':id' => $sql_paquete[0]->id_paquete,
                            ':usuario' => $id_usu,
                            ':fecha' => $fecha_actual
                        ));

                    }else{

                        $db->prepare("INSERT INTO status_log SET
                            id_paquete=:id,
                            id_tipo_status=18,
                            id_usuario=:usuario,
                            id_lugar=5,
                            visible_cliente=1,
                            fecha=:fecha
                        ");
                        $db->execute(array(
                            ':id' => $sql_paquete[0]->id_paquete,
                            ':usuario' => $id_usu,
                            ':fecha' => $fecha_actual
                        ));
                    }
                }
            }
            
            $db->prepare("DELETE FROM cargos where guia='guia' OR chi=0");
            $db->execute(array());
            
            header('Location: importar_cargos_csv.php?id=1');
        }else{
            //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para  //ver si esta separado por " , "
            header('Location: importar_cargos_csv.php?id=2');
        }        
    }
?>