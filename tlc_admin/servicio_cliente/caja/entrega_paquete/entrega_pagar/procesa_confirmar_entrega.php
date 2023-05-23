<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$nombre_nuevo="";
	$id_usu=$_SESSION['id_usu'];
	$id_transaccion=$_POST['id_transaccion'];
	$numero_recibo=$_POST['numero_recibo'];
	$id_cliente=$_POST['id_cliente'];
	$subtotal=$_POST['subtotal'];
	$totalPagoTarjeta=$_POST['totalPagoTarjeta'];
	$cantidad_cheque=$_POST['cantidad_cheque'];

	if (isset($_POST['pago_tarjeta'])) {

		$pago_tarjeta=$_POST['pago_tarjeta'];
		$tipo_tarjeta=$_POST['tipo_tarjeta'];
		$monto_tarjeta=$_POST['monto_tarjeta'];
		$recargo=$_POST['recargo'];

		// valida y sube el comprobante al servidor
		if (isset($_FILES['comprobante_tarjeta'])) {

			$nombre = $_FILES['comprobante_tarjeta']['name'];
			$nombre_tmp = $_FILES['comprobante_tarjeta']['tmp_name'];
			$tipo = $_FILES['comprobante_tarjeta']['type'];
			$tamano = $_FILES['comprobante_tarjeta']['size'];

			$partes_nombre = explode('.', $nombre);
			$extension = end( $partes_nombre );

			$limite = 10*1024*1024;//10 mb

			if(($tamano <= $limite) AND ($extension=="pdf" || $extension=="PDF" || $extension=="jpg" || $extension=="JPG" || $extension=="xlsx" || $extension=="XLSX" || $extension=="xls" || $extension=="XLS" || $extension=="docx" || $extension=="DOCX" || $extension=="doc" || $extension=="DOC")){ //comprueba si el archivo ingresado es un pdf o jpg de 10mb
				
				// crea la carpeta con el numero de recibo
				if(!file_exists( $conf['path_files_caja'].$numero_recibo) ){
					mkdir($conf['path_files_caja'].$numero_recibo, 0755, true);
				}
				// fin crear la carpeta con el numero de recibo

				// procesa el nombre y el tipo de archivo
				if ($extension=="pdf" || $extension=="PDF") {
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_recibo.'.PDF';
					$ext=1;

					while(file_exists( $conf['path_files_caja'].$numero_recibo."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_recibo.'('.$contador_nombre_archivo.').PDF';
				    }
					
				}elseif($extension=="jpg" || $extension=="JPG"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_recibo.'.JPG';
					$ext=2;

					while(file_exists( $conf['path_files_caja'].$numero_recibo."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_recibo.'('.$contador_nombre_archivo.').JPG';
				    }

				}elseif($extension=="xlsx" || $extension=="XLSX"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_recibo.'.XLSX';
					$ext=3;

					while(file_exists( $conf['path_files_caja'].$numero_recibo."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_recibo.'('.$contador_nombre_archivo.').XLSX';
				    }

				}elseif($extension=="xls" || $extension=="XLS"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_recibo.'.XLS';
					$ext=4;

					while(file_exists( $conf['path_files_caja'].$numero_recibo."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_recibo.'('.$contador_nombre_archivo.').XLS';
				    }

				}elseif($extension=="docx" || $extension=="DOCX"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_recibo.'.DOCX';
					$ext=5;

					while(file_exists( $conf['path_files_caja'].$numero_recibo."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_recibo.'('.$contador_nombre_archivo.').DOCX';
				    }

				}elseif($extension=="doc" || $extension=="DOC"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_recibo.'.DOC';
					$ext=6;

					while(file_exists( $conf['path_files_caja'].$numero_recibo."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_recibo.'('.$contador_nombre_archivo.').DOC';
				    }
				}
				// fin procesa nombre y tipo de archivo

				// mueve el archivo a la carpeta
				move_uploaded_file($nombre_tmp,$conf['path_files_caja'].$numero_recibo."/".$nombre_nuevo);
				// fin mover archivo
				
			}else{
				//error tamaño del archivo o extencion
				$error_comprobante=1;
			}
		}
		// fin validar y subir el comprobante al servidor

		// actualiza el recargo del pago con tarjeta
		$db->prepare("UPDATE transaccion SET total_aduana=:recargo WHERE id_transaccion=:id_transaccion");
		$db->execute(array(':recargo' => $recargo,':id_transaccion' => $id_transaccion));
		// Fin actualiza el recargo del pago con tarjeta

		// inserta los registros de la transaccion
		$db->prepare("INSERT INTO transaccion_detalle SET
			id_transaccion=:id_transaccion,
			id_tipo_pago=:id_tipo_pago,
			id_tipo_tarjeta=:id_tipo_tarjeta,
			monto=:monto,
			comprobante=:comprobante,
			fecha_transaccion=:fecha_transaccion
		");
		$db->execute(array(
			':id_transaccion' => $id_transaccion,
			':id_tipo_pago' => $pago_tarjeta,
			':id_tipo_tarjeta' => $tipo_tarjeta,
			':monto' => $monto_tarjeta,
			':comprobante' => $nombre_nuevo,
			':fecha_transaccion' => $fecha_actual
		));
		// fin insertar los registros de la transaccion
	}

	if (isset($_POST['pago_efectivo'])) {

		$pago_efectivo=$_POST['pago_efectivo'];
		$monto_efectivo=$_POST['monto_efectivo'];
		$monto_pagado_efectivo=$_POST['monto_pagado_efectivo'];
		$vuelto_efectivo=$_POST['vuelto_efectivo'];

		// inserta los registros de la transaccion
		$db->prepare("INSERT INTO transaccion_detalle SET
			id_transaccion=:id_transaccion,
			id_tipo_pago=:id_tipo_pago,
			monto=:monto,
			monto_pagado=:monto_pagado,
			vuelto=:vuelto,
			fecha_transaccion=:fecha_transaccion
		");
		$db->execute(array(
			':id_transaccion' => $id_transaccion,
			':id_tipo_pago' => $pago_efectivo,
			':monto' => $monto_efectivo,
			':monto_pagado' => $monto_pagado_efectivo,
			':vuelto' => $vuelto_efectivo,
			':fecha_transaccion' => $fecha_actual
		));
		// fin insertar los registros de la transaccion

		// registra la transaccion generada
		$db->prepare("INSERT INTO transaccion SET
			id_tipo_transaccion=5,
			id_caja=1,
			id_usuario=:id_usuario,
			id_cliente=:id_cliente,
			numero_recibo=:numero_recibo,
			total=:total,
			tipo=1,
			fecha=:fecha,
			correlativo_transaccion=:correlativo_transaccion
		");

		$db->execute(array(
			':id_usuario' => $id_usu,
			':id_cliente' => $id_cliente,
			':numero_recibo' => $numero_recibo,
			':total' => $subtotal,
			':fecha' => $fecha_actual,
			':correlativo_transaccion' => $id_transaccion
		));
		// fin registra la transaccion generada

		$id_transaccion_egreso=$db->lastId();

		// inserta los registros de la transaccion
		$db->prepare("INSERT INTO transaccion_detalle SET
			id_transaccion=:id_transaccion,
			id_tipo_pago=:id_tipo_pago,
			monto=:monto,
			monto_pagado=:monto_pagado,
			vuelto=:vuelto,
			fecha_transaccion=:fecha_transaccion
		");
		$db->execute(array(
			':id_transaccion' => $id_transaccion_egreso,
			':id_tipo_pago' => $pago_efectivo,
			':monto' => $monto_efectivo,
			':monto_pagado' => $monto_pagado_efectivo,
			':vuelto' => $vuelto_efectivo,
			':fecha_transaccion' => $fecha_actual
		));
		// fin insertar los registros de la transaccion
	}

	if (isset($_POST['pago_deposito'])) {

		$pago_deposito=$_POST['pago_deposito'];
		$monto_deposito=$_POST['monto_deposito'];

		// valida y sube el comprobante al servidor
		if (isset($_FILES['comprobante_transferencia'])) {

			$nombre = $_FILES['comprobante_transferencia']['name'];
			$nombre_tmp = $_FILES['comprobante_transferencia']['tmp_name'];
			$tipo = $_FILES['comprobante_transferencia']['type'];
			$tamano = $_FILES['comprobante_transferencia']['size'];

			$partes_nombre = explode('.', $nombre);
			$extension = end( $partes_nombre );

			$limite = 10*1024*1024;//10 mb

			if(($tamano <= $limite) AND ($extension=="pdf" || $extension=="PDF" || $extension=="jpg" || $extension=="JPG" || $extension=="xlsx" || $extension=="XLSX" || $extension=="xls" || $extension=="XLS" || $extension=="docx" || $extension=="DOCX" || $extension=="doc" || $extension=="DOC")){ //comprueba si el archivo ingresado es un pdf o jpg de 10mb
				
				// crea la carpeta con el numero de recibo
				if(!file_exists( $conf['path_files_caja'].$numero_recibo) ){
					mkdir($conf['path_files_caja'].$numero_recibo, 0755, true);
				}
				// fin crear la carpeta con el numero de recibo

				// procesa el nombre y el tipo de archivo
				if ($extension=="pdf" || $extension=="PDF") {
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_recibo.'.PDF';
					$ext=1;

					while(file_exists( $conf['path_files_caja'].$numero_recibo."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_recibo.'('.$contador_nombre_archivo.').PDF';
				    }
					
				}elseif($extension=="jpg" || $extension=="JPG"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_recibo.'.JPG';
					$ext=2;

					while(file_exists( $conf['path_files_caja'].$numero_recibo."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_recibo.'('.$contador_nombre_archivo.').JPG';
				    }

				}elseif($extension=="xlsx" || $extension=="XLSX"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_recibo.'.XLSX';
					$ext=3;

					while(file_exists( $conf['path_files_caja'].$numero_recibo."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_recibo.'('.$contador_nombre_archivo.').XLSX';
				    }

				}elseif($extension=="xls" || $extension=="XLS"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_recibo.'.XLS';
					$ext=4;

					while(file_exists( $conf['path_files_caja'].$numero_recibo."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_recibo.'('.$contador_nombre_archivo.').XLS';
				    }

				}elseif($extension=="docx" || $extension=="DOCX"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_recibo.'.DOCX';
					$ext=5;

					while(file_exists( $conf['path_files_caja'].$numero_recibo."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_recibo.'('.$contador_nombre_archivo.').DOCX';
				    }

				}elseif($extension=="doc" || $extension=="DOC"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_recibo.'.DOC';
					$ext=6;

					while(file_exists( $conf['path_files_caja'].$numero_recibo."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_recibo.'('.$contador_nombre_archivo.').DOC';
				    }
				}
				// fin procesa nombre y tipo de archivo

				// mueve el archivo a la carpeta
				move_uploaded_file($nombre_tmp,$conf['path_files_caja'].$numero_recibo."/".$nombre_nuevo);
				// fin mover archivo
				
			}else{
				//error tamaño del archivo o extencion
				$error_comprobante=1;
			}
		}
		// fin validar y subir el comprobante al servidor

		// inserta los registros de la transaccion
		$db->prepare("INSERT INTO transaccion_detalle SET
			id_transaccion=:id_transaccion,
			id_tipo_pago=:id_tipo_pago,
			monto=:monto,
			comprobante=:comprobante,
			fecha_transaccion=:fecha_transaccion
		");
		$db->execute(array(
			':id_transaccion' => $id_transaccion,
			':id_tipo_pago' => $pago_deposito,
			':monto' => $monto_deposito,
			':comprobante' => $nombre_nuevo,
			':fecha_transaccion' => $fecha_actual
		));
		// fin insertar los registros de la transaccion
	}
	
	for ($i=0; $i < $cantidad_cheque; $i++) {
		if (isset($_POST['pago_cheque'.$i])) {
			$pago_cheque=$_POST['pago_cheque'.$i];
			$monto_cheque=$_POST['monto_cheque'.$i];
			$numero_cheque=$_POST['numero_cheque'.$i];
			
			// inserta los registros de la transaccion
			$db->prepare("INSERT INTO transaccion_detalle SET
				id_transaccion=:id_transaccion,
				id_tipo_pago=:id_tipo_pago,
				monto=:monto,
				numero_documento=:numero_documento,
				fecha_transaccion=:fecha_transaccion
			");
			$db->execute(array(
				':id_transaccion' => $id_transaccion,
				':id_tipo_pago' => $pago_cheque,
				':monto' => $monto_cheque,
				':numero_documento' => $numero_cheque,
				':fecha_transaccion' => $fecha_actual
			));
			// fin insertar los registros de la transaccion
		}
	}
	
	$db->prepare("SELECT * FROM paquete WHERE id_transaccion=:codigo");
	$db->execute(array(':codigo' => $id_transaccion));
	$resPaquetes=$db->get_results();

	foreach ($resPaquetes as $key => $paquete) {

		// actualiza el estado del id_paquete
		$db->prepare("UPDATE paquete SET status=6, envio_entregado=1 WHERE id_paquete=:id");
		$db->execute(array(':id' => $paquete->id_paquete));
		// fin actualiza el estado del paquete

		// regitra el cambio de estado en el seguimiento
		$db->prepare("INSERT INTO status_log SET
			id_paquete=:id,
			id_tipo_status=6,
			id_usuario=:usuario,
			id_lugar=5,
			fecha=:fecha
		");
		$db->execute(array(
			':id' => $paquete->id_paquete,
			':usuario' => $id_usu,
			':fecha' => $fecha_actual
		));
		// fin regitra el cambio de estado en el seguimiento
	}
	
	// actualiza el estado del id_paquete
	$db->prepare("UPDATE transaccion SET status=1");
	$db->execute(array(':id' => $paquete->id_paquete));
	// fin actualiza el estado del paquete

	header("location: detalle_entrega.php?num_recibo=$id_transaccion");
?>