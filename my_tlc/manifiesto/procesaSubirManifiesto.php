<?php
    require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
    require $conf['path_host'].'/EasyPDO/conexionPDO.php';
    require $conf['path_host'].'/include/include_sesion.php';
    require $conf['path_host'].'/funciones/fecha_actual.php';

    set_time_limit(0);

    $id_usu=$_SESSION['id_usu'];
    $numeroMaster=$_POST['numeroMaster'];
    $numeroVuelo=$_POST['numeroVuelo'];
    $row=1;//contador de filas, es para ignorar la primera fila

    // validamos que la conexion y la variable db sea correcta
    if (!empty($db)){

        //Aquí es donde seleccionamos el archivo csv
        $nombre = $_FILES['archivo']['name'];
        $nombre_tmp = $_FILES['archivo']['tmp_name'];
        $tipo = $_FILES['archivo']['type'];
        
        $partes_nombre = explode('.', $nombre);
        $extension = end( $partes_nombre );
        
        // validamos que la extencion del archivo sea csv
        if($extension=="csv" || $extension=="CSV"){
            //si es correcto, entonces damos permisos de lectura para subir
            $handle=fopen($nombre_tmp, "r");

            // Se crea vuelo y asigna numero de vuelo
            $db->prepare("INSERT INTO vuelos SET 
                fecha_creacion=:fecha_registro, 
                id_usuario_creacion=:usuario,
                id_status_vuelo=3,
                codigo_vuelo=:numeroMaster,
                num_vuelo=:numeroVuelo,
                fecha_salida=:fecha,
                tipo_vuelo=1
            ");
            $db->execute(array(
                ':fecha_registro'=>$fecha_actual, 
                ':usuario'=>$id_usu,
                ':numeroMaster' => $numeroMaster,
                ':numeroVuelo' => $numeroVuelo,
                ':fecha' => $fecha_actual
            ));

            $idVuelo=$db->lastId();

            // crea la carpeta con el id del cliente
            if(!file_exists( $conf['path_files'].$id_usu."/master/".$idVuelo) ){
                mkdir($conf['path_files'].$id_usu."/master/".$idVuelo, 0777, true);
            }

            $contador_nombre_archivo=0;
            $nombre_nuevo=$numeroMaster.'.CSV';
            $ext=1;

            while(file_exists( $conf['path_files'].$id_usu."/master/".$idVuelo."/".$nombre_nuevo)){
                $contador_nombre_archivo++;
                $nombre_nuevo=$numero_seguimiento.'('.$contador_nombre_archivo.').CSV';
            }  

            // mueve el archivo a la carpeta
            move_uploaded_file($nombre_tmp,$conf['path_files'].$id_usu."/master/".$idVuelo."/".$nombre_nuevo);

            $db->prepare("UPDATE vuelos SET nombre_archivo=:nombre_archivo WHERE id_vuelos=:id_vuelos");
            $db->execute(array(':nombre_archivo'=>$nombre_nuevo, ':id_vuelos'=>$idVuelo));

            while (($data = fgetcsv($handle, 1000, ";")) != FALSE){
                //contamos las columnas para validar el archivo correcto 
                $columnas= count($data);

                if ($columnas!=22){
                    header('Location: manifiesto.php?id=2');
                }else{

                    // ignora la primera fila
                    if($row==1){ 
                        $row++; 
                        continue; 
                    }else{
                        $row++;
                    }

                    $peso=str_replace(',', '.', $data[4]);
                    $valor=str_replace(',', '.', $data[6]);
                    $fecha=date("Y-m-d H:i:s",strtotime($data[9]));
                    $fecha_master=date("Y-m-d H:i:s",strtotime($data[12]));
                    $flete=str_replace(',', '.', $data[18]);

                    // Ingreso de datos a la tabla principal "envios"
                    $db->prepare("INSERT INTO manifiesto SET 
                        id_vuelo=:id_vuelo,
                        num_guia=:num_guia,
                        cliente=:cliente,
                        destino='SCL',
                        piezas=:piezas,
                        peso=:peso,
                        descripcion=:descripcion,
                        valor=:valor,
                        proveedor=:proveedor,
                        origen='MIA',
                        fecha=:fecha,
                        vuelo=:vuelo,
                        master=:master,
                        fecha_master=:fecha_master,
                        estado='',
                        rut=:rut,
                        direccion=:direccion,
                        comuna=:comuna,
                        seguro=0,
                        flete=:flete,
                        empresa='TLC',
                        tipo_envio=1,
                        tipo_flete=:tipo_flete,
                        estado_manifiesto=1
                    ");
                   $db->execute(array(
                        ':id_vuelo'=> $idVuelo,
                        ':num_guia'=> $data[0],
                        ':cliente'=> $data[1],
                        ':piezas'=> $data[3],
                        ':peso'=> $peso,
                        ':descripcion'=> $data[5],
                        ':valor'=> $valor,
                        ':proveedor'=> $data[7],
                        ':fecha'=> $fecha,
                        ':vuelo'=> $data[10],
                        ':master'=> $data[11],
                        ':fecha_master'=> $fecha_master,
                        ':rut'=> $data[14],
                        ':direccion'=> $data[15],
                        ':comuna'=> $data[16],
                        ':flete'=> $flete,
                        ':tipo_flete'=> $data[21]
                    ));
                }
            }
            
            header("Location: mostrar_archivo_manifiesto.php?vuelo=$idVuelo");
        }else{
            //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para  //ver si esta separado por " , "
            header('Location: manifiesto.php?id=2');
        }        
    }
?>