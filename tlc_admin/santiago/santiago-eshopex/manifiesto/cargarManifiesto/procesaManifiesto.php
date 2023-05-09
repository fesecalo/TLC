<?php
    require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
    require $conf['path_host'].'/EasyPDO/conexionPDO.php';
    require $conf['path_host'].'/include/include_sesion.php';

    set_time_limit(0);

    // funcion fecha actual tiene que ir despues de la conexion PDO
    require $conf['path_host'].'/funciones/fecha_actual.php';
    $id_usu=$_SESSION['id_usu'];
    $manifiesto=$_POST['txtManifiesto'];

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
            
            $data = fgetcsv($handle, 1000, ";");
            $columnas= count($data);

            if ($columnas!=16){
                header('Location: importarManifiesto.php?id=2');
            }else{

            	$db->prepare("SELECT * FROM vuelos WHERE codigo_vuelo=:codigo_vuelo ORDER BY id_vuelos DESC");
				$db->execute(array(':codigo_vuelo' => $manifiesto));
				$resVuelo=$db->get_results();

				if (empty($resVuelo)) {

	                $db->prepare('INSERT INTO vuelos SET 
	                    codigo_vuelo=:codigo_vuelo,
	                    id_usuario_creacion=:id_usuario_creacion,
	                    fecha_creacion=:fecha_actual,
	                    cantidad_valijas=1,
	                    id_status_vuelo=2
	                ');

	                $db->execute(array(
	                    ':codigo_vuelo' => $manifiesto,
	                    ':id_usuario_creacion' => $id_usu,
	                    ':fecha_actual' => $fecha_actual
	                ));

	                $idVuelo=$db->lastId();

	                while (($data = fgetcsv($handle, 1000, ";")) != FALSE){
	                    //Insertamos los datos con los valores en la tabla cargos
	                    $db->prepare('INSERT INTO paquete SET 
	                        id_usuario=:id_usuario,
	                        consignatario=:consignatario,
	                        tracking_eu=:tracking_eu,
	                        currier=:currier,
	                        valor=:valor,
	                        id_tipo_paquete=:id_tipo_paquete,
	                        descripcion_producto=:descripcion_producto,
	                        pieza=:pieza,
	                        peso=:peso,
	                        largo=:largo,
	                        ancho=:ancho,
	                        alto=:alto,
	                        rut=:rut,
	                        direccion=:direccion,
	                        proveedor=:proveedor,
	                        awb=:awb,
	                        status=3,
	                        id_vuelo=:id_vuelo,
	                        fecha_registro=:fecha_actual
	                    ');

	                  	$db->execute(array(
	                        ':id_usuario' => utf8_decode($data[0]),
	                        ':consignatario' => utf8_decode($data[1]),
	                        ':tracking_eu' => utf8_decode($data[2]),
	                        ':currier' => utf8_decode($data[3]),
	                        ':valor' => utf8_decode($data[4]),
	                        ':id_tipo_paquete' => utf8_decode($data[5]),
	                        ':descripcion_producto' => utf8_decode($data[6]),
	                        ':pieza' => $data[7],
	                        ':peso' => utf8_decode($data[8]),
	                        ':largo' => utf8_decode($data[9]),
	                        ':ancho' => utf8_decode($data[10]),
	                        ':alto' => utf8_decode($data[11]),
	                        ':rut' => utf8_decode($data[12]),
	                        ':direccion' => utf8_decode($data[13]),
	                        ':proveedor' => utf8_decode($data[14]),
	                        ':awb' => utf8_decode($data[15]),
	                        ':id_vuelo' => $idVuelo,
	                        ':fecha_actual' => $fecha_actual
	                    ));

	                    $idPaquete=$db->lastId();

	                    $db->prepare("INSERT INTO status_log SET
	                        id_paquete=:id,
	                        id_tipo_status=3,
	                        id_usuario=:usuario,
	                        id_lugar=3,
	                        visible_cliente=1,
	                        fecha=:fecha
	                    ");
	                    $db->execute(array(
	                        ':id' => $idPaquete,
	                        ':usuario' => $id_usu,
	                        ':fecha' => $fecha_actual
	                    ));
	                }

	                $db->prepare("DELETE FROM paquete WHERE id_usuario=0");
	                $db->execute(array());
	                
	                header('Location: importarManifiesto.php?id=1');
	            }else{
	            	header('Location: importarManifiesto.php?id=3');
	            }
            }
        }else{
            //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para  //ver si esta separado por " , "
            header('Location: importarManifiesto.php?id=2');
        }        
    }
?>