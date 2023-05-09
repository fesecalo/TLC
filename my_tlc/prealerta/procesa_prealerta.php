<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// validacion con csrf tiene que ir despues de la funcion session_start()
	require $conf['path_host'].'/funciones/validar_csrf.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_usu=$_SESSION['numero_cliente'];

	if(!isset($_POST['currier'])){
		die("Ocurrio un problema con la compañia de currier seleccionada");
	}else{
		$currier=$_POST['currier'];
	}

	if(!isset($_POST['tracking'])){
		die("Ocurrio un problema con el numero de tracking ingresado");
	}else{
		$tracking=trim($_POST['tracking'],"[\n|\r|\n\r|\t|\0|\x0B| ]");
	}

	if(!isset($_POST['proveedor2'])){
		$proveedor2='';
	}else{
		$proveedor2=$_POST['proveedor2'];
	}

	if(!isset($_POST['valor'])){
		die("Ocurrio un problema con el valor del producto ingresado");
	}else{
		$valor=$_POST['valor'];
	}

	if(!isset($_POST['producto'])){
		die("Ocurrio un problema con el nombre del producto ingresado");
	}else{
		$producto=$_POST['producto'];
	}

	if(!isset($_POST['consignatario'])){
		die("Ocurrio un problema con el consignatario ingresado");
	}else{
		$consignatario=$_POST['consignatario'];
	}
	// Se ingresan los datos del paquete
	
	if ($currier==2) {
		$preUSPS='42033122';
		$tracking=$preUSPS.$tracking;
	}

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
	// Fin actualizar tabla parametros

	// Ingreso de datos a la tabla principal "envios"
	$db->prepare("INSERT INTO paquete SET 
		id_usuario=:usuario,
		consignatario=:consignatario,
		currier=:currier, 
		descripcion_producto=:producto, 
		valor=:valor,
		tracking_eu=:tracking_eu,
		tracking_garve=:seguimiento,
		proveedor=:proveedor2,
		prealerta=1,
		status=1,
		fecha_registro=:fecha
	");
	$db->execute(array(
		':usuario' => $id_usu,
		':consignatario' => $consignatario,
		':currier' => $currier,
		':producto' => $producto,
		':valor' => $valor,
		':tracking_eu' => $tracking,
		':seguimiento' => $numero_seguimiento,
		':proveedor2' => $proveedor2,
		':fecha'=> $fecha_actual
	));
	$id=$db->lastId();
	//obtiene el id de la solicitud ingresada
	
	// ingreso de datos a la tabla log la cual lleva el registro de todos los cambios realizados en el envio
	$db->prepare("INSERT INTO status_log SET
		id_paquete=:id,
		id_tipo_status=1,
		id_usuario=:usuario,
		id_lugar=1,
		fecha=:fecha
	",true);
	$db->execute(array(
		':id' => $id,
		':usuario' => $id_usu,
		':fecha' => $fecha_actual
	));
	// fin ingreso de datos de envio

	if (!isset($_POST['cantidad_comprobantes'])) {
		die("Ocurrio un problema con la cantidad de comprobantes ingresados");
	}else{
		$cantidad_comprobantes=$_POST['cantidad_comprobantes'];
	}

	if( !isset($_FILES['comprobante0']) ){
		die("Ocurrio un problema con los comprobantes ingresados");
	}else{
		
		for ($i=0; $i < $cantidad_comprobantes; $i++) {

			$nombre = $_FILES['comprobante'.$i]['name'];
			$nombre_tmp = $_FILES['comprobante'.$i]['tmp_name'];
			$tipo = $_FILES['comprobante'.$i]['type'];
			$tamano = $_FILES['comprobante'.$i]['size'];

			$partes_nombre = explode('.', $nombre);
			$extension = end( $partes_nombre );

			$limite = 10*1024*1024;//10 mb		

			if(($tamano <= $limite) AND ($extension=="png" || $extension=="PNG" || $extension=="pdf" || $extension=="PDF" || $extension=="jpg" || $extension=="JPG" || $extension=="xlsx" || $extension=="XLSX" || $extension=="xls" || $extension=="XLS" || $extension=="docx" || $extension=="DOCX" || $extension=="doc" || $extension=="DOC")){ //comprueba si el archivo ingresado es un pdf o jpg de 10mb
				
				// crea la carpeta con el id del cliente
				if(!file_exists( $conf['path_files'].$id_usu."/".$id) ){
					mkdir($conf['path_files'].$id_usu."/".$id, 0777, true);
				}
				// fin crear carpeta

				// procesa el nombre y el tipo de archivo
				if ($extension=="pdf" || $extension=="PDF") {
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_seguimiento.'.PDF';
					$ext=1;

					while(file_exists( $conf['path_files'].$id_usu."/".$id."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_seguimiento.'('.$contador_nombre_archivo.').PDF';
				    }
					
				}elseif($extension=="jpg" || $extension=="JPG"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_seguimiento.'.JPG';
					$ext=2;

					while(file_exists( $conf['path_files'].$id_usu."/".$id."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_seguimiento.'('.$contador_nombre_archivo.').JPG';
				    }

				}elseif($extension=="xlsx" || $extension=="XLSX"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_seguimiento.'.XLSX';
					$ext=3;

					while(file_exists( $conf['path_files'].$id_usu."/".$id."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_seguimiento.'('.$contador_nombre_archivo.').XLSX';
				    }

				}elseif($extension=="xls" || $extension=="XLS"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_seguimiento.'.XLS';
					$ext=4;

					while(file_exists( $conf['path_files'].$id_usu."/".$id."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_seguimiento.'('.$contador_nombre_archivo.').XLS';
				    }

				}elseif($extension=="docx" || $extension=="DOCX"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_seguimiento.'.DOCX';
					$ext=5;

					while(file_exists( $conf['path_files'].$id_usu."/".$id."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_seguimiento.'('.$contador_nombre_archivo.').DOCX';
				    }

				}elseif($extension=="doc" || $extension=="DOC"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_seguimiento.'.DOC';
					$ext=6;

					while(file_exists( $conf['path_files'].$id_usu."/".$id."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_seguimiento.'('.$contador_nombre_archivo.').DOC';
				    }
				}elseif($extension=="png" || $extension=="PNG"){
					$contador_nombre_archivo=0;
					$nombre_nuevo=$numero_seguimiento.'.PNG';
					$ext=6;

					while(file_exists( $conf['path_files'].$id_usu."/".$id."/".$nombre_nuevo)){
				        $contador_nombre_archivo++;
				        $nombre_nuevo=$numero_seguimiento.'('.$contador_nombre_archivo.').PNG';
				    }
				}
				// fin procesa nombre y tipo de archivo

				// mueve el archivo a la carpeta
				move_uploaded_file($nombre_tmp,$conf['path_files'].$id_usu."/".$id."/".$nombre_nuevo);
				// fin mover archivos

				// ingreso de registros en la tabla comprobante_compra
				$db->prepare("INSERT INTO comprobante_compra SET 
					id_paquete=:id,
					id_usuario=:usuario,
					nombre_comprobante=:comprobante,
					extension=:extension,
					fecha=:fecha_registro,
					nombre_original=:nombre_original
				",true);
				$db->execute(array(
					':id' => $id,
					':usuario' => $id_usu,
					':comprobante' => $nombre_nuevo,
					':extension' => $ext,
					':fecha_registro' => $fecha_actual,
					':nombre_original' => $nombre
				));
				// fin registro tabla comprobante_compra
				
			}else{
				die("El archivo ingresado no es un PDF, JPG, Excel, Word o supera los 10 mb");
			}
		}
	}

	header("location:".$conf['path_host_url']."/prealerta/msj_paquete_registrado.php");
?>				
				