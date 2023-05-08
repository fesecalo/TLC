<?php
    require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
    require $conf['path_host'].'/EasyPDO/conexionPDO.php';
    require $conf['path_host'].'/include/include_sesion.php';
    require $conf['path_host'].'/funciones/fecha_actual.php';

    set_time_limit(0);

    $id_usu=$_SESSION['id_usu'];
    $numeroMaster=$_POST['numeroMaster'];

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
            
            // Se crea vuelo y asigna numero de vuelo
            $db->prepare("INSERT INTO vuelos SET 
                fecha_creacion=:fecha_registro, 
                id_usuario_creacion=:usuario,
                id_status_vuelo=2,
                codigo_vuelo=:codigo,
                fecha_salida=:fecha
            ");
            $db->execute(array(
                ':fecha_registro'=>$fecha_actual, 
                ':usuario'=>$id_usu,
                ':codigo' => $numeroMaster,
                ':fecha' => $fecha_actual
            ));

            $idVuelo=$db->lastId();

            while (($data = fgetcsv($handle, 1000, ";")) != FALSE){
                //contamos las columnas para validar el archivo correcto 
                $columnas= count($data);

                if ($columnas!=10){
                    header('Location: manifiesto.php?id=2');
                }else{
                    // se crea el numero de tracking de garve shop
                    $sql_parametro=$db->get_results("SELECT * FROM parametro WHERE id_parametro=1");

                    foreach ($sql_parametro as $key => $parametro) { 
                        $prefijo=$parametro->prefijo_etiqueta;
                        $incremento=$parametro->incremento_valor;
                    }

                    $incremento=$incremento+1;
                    $numero_seguimiento=$prefijo.$incremento;

                    // Actualiza el valor de incremento de la tabla parametro
                    $db->prepare("UPDATE parametro SET incremento_valor=:incremento WHERE id_parametro=1");
                    $db->execute(array(':incremento' => $incremento));

                    $valor=str_replace(',', '.', $data[2]);
                    $peso=str_replace(',', '.', $data[6]);
                    $largo=str_replace(',', '.', $data[7]);
                    $ancho=str_replace(',', '.', $data[8]);
                    $alto=str_replace(',', '.', $data[9]);

                    $pesoVolumen=($alto*$ancho*$largo)/6000;

                    // Ingreso de datos a la tabla principal "envios"
                    $db->prepare("INSERT INTO paquete SET 
                        id_usuario=:usuario,
                        consignatario=:consignatario,
                        currier=7, 
                        descripcion_producto=:producto, 
                        valor=:valor,
                        tracking_eu=:tracking_eu,
                        tracking_garve=:seguimiento,
                        proveedor=:proveedor2,
                        pieza=:pieza,
                        peso=:peso_kg,
                        peso_volumen=:peso_volumen,
                        largo=:largo,
                        ancho=:ancho,
                        alto=:alto,
                        prealerta=0,
                        status=3,
                        fecha_registro=:fecha,
                        id_vuelo=:vuelo
                    ");
                    $db->execute(array(
                        ':usuario' => $id_usu,
                        ':consignatario' => $data[0],
                        ':producto' => $data[1],
                        ':valor' => $valor,
                        ':tracking_eu' => $data[3],
                        ':seguimiento' => $numero_seguimiento,
                        ':proveedor2' => $data[4],
                        ':pieza' => $data[5],
                        ':peso_kg' => $peso,
                        ':peso_volumen' => $pesoVolumen,
                        ':largo' => $largo,
                        ':ancho' => $ancho,
                        ':alto' => $alto,
                        ':fecha'=> $fecha_actual,
                        ':vuelo' => $idVuelo
                    ));

                    $id=$db->lastId();

                    $db->prepare("INSERT INTO status_log SET
                        id_paquete=:id,
                        id_tipo_status=3,
                        id_usuario=:usuario,
                        id_lugar=3,
                        fecha=:fecha
                    ");
                    $db->execute(array(
                        ':id' => $id,
                        ':usuario' => $id_usu,
                        ':fecha' => $fecha_actual
                    ));
                }
            }
            
            header('Location: manifiesto.php?id=1');
        }else{
            //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para  //ver si esta separado por " , "
            header('Location: manifiesto.php?id=2');
        }        
    }
?>