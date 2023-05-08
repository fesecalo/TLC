<?php
require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
require $conf['path_host'].'/EasyPDO/conexionPDO.php';
require $conf['path_host'].'/include/include_sesion.php';

// funcion fecha actual tiene que ir despues de la conexion PDO
require $conf['path_host'].'/funciones/fecha_actual.php';

$id_usu=$_SESSION['numero_cliente'];
$id=$_POST['id_paquete'];

$db->prepare("SELECT
		paquete.id_paquete,
		paquete.tracking_garve,
		paquete.numero_miami
	FROM paquete as paquete
	WHERE paquete.id_paquete=:id
",true);
$db->execute(array(':id' => $id));

$sql_paquete=$db->get_results();

$tracking_garve=$sql_paquete[0]->tracking_garve;
$tracking_miami=$sql_paquete[0]->numero_miami;

if($tracking_miami==0){
	$numero_seguimiento=$tracking_garve;
}else{
	$numero_seguimiento=$tracking_miami;
}

$valorFactura=$_POST['valorFactura'];

$nombre = $_FILES['comprobante']['name'];
$nombre_tmp = $_FILES['comprobante']['tmp_name'];
$tipo = $_FILES['comprobante']['type'];
$tamano = $_FILES['comprobante']['size'];

$partes_nombre = explode('.', $nombre);
$extension = strtoupper(end( $partes_nombre ));

$limite = 20*1024*1024;//20 mb

if(($tamano <= $limite) AND 
	($extension=="PNG" || 
	 $extension=="PDF" || 
	 $extension=="JPG" || 
	 $extension=="XLSX" || 
	 $extension=="XLS" || 
	 $extension=="DOCX" || 
	 $extension=="DOC")){ //comprueba si el archivo ingresado es un pdf o jpg de 10mb
	
	// crea la carpeta con el id del cliente
	if(!file_exists( $conf['path_files'].$id_usu."/".$id) ){
		mkdir($conf['path_files'].$id_usu."/".$id, 0777, true);
	}
	// fin crear carpeta

	// procesa el nombre y el tipo de archivo
	if ($extension=="PDF") {
		$contador_nombre_archivo=0;
		$nombre_nuevo=$numero_seguimiento.'.PDF';
		$ext=1;

		while(file_exists( $conf['path_files'].$id_usu."/".$id."/".$nombre_nuevo)){
	        $contador_nombre_archivo++;
	        $nombre_nuevo=$numero_seguimiento.'('.$contador_nombre_archivo.').PDF';
	    }
		
	}elseif($extension=="JPG"){
		$contador_nombre_archivo=0;
		$nombre_nuevo=$numero_seguimiento.'.JPG';
		$ext=2;

		while(file_exists( $conf['path_files'].$id_usu."/".$id."/".$nombre_nuevo)){
	        $contador_nombre_archivo++;
	        $nombre_nuevo=$numero_seguimiento.'('.$contador_nombre_archivo.').JPG';
	    }

	}elseif($extension=="XLSX"){
		$contador_nombre_archivo=0;
		$nombre_nuevo=$numero_seguimiento.'.XLSX';
		$ext=3;

		while(file_exists( $conf['path_files'].$id_usu."/".$id."/".$nombre_nuevo)){
	        $contador_nombre_archivo++;
	        $nombre_nuevo=$numero_seguimiento.'('.$contador_nombre_archivo.').XLSX';
	    }

	}elseif($extension=="XLS"){
		$contador_nombre_archivo=0;
		$nombre_nuevo=$numero_seguimiento.'.XLS';
		$ext=4;

		while(file_exists( $conf['path_files'].$id_usu."/".$id."/".$nombre_nuevo)){
	        $contador_nombre_archivo++;
	        $nombre_nuevo=$numero_seguimiento.'('.$contador_nombre_archivo.').XLS';
	    }

	}elseif($extension=="DOCX"){
		$contador_nombre_archivo=0;
		$nombre_nuevo=$numero_seguimiento.'.DOCX';
		$ext=5;

		while(file_exists( $conf['path_files'].$id_usu."/".$id."/".$nombre_nuevo)){
	        $contador_nombre_archivo++;
	        $nombre_nuevo=$numero_seguimiento.'('.$contador_nombre_archivo.').DOCX';
	    }

	}elseif($extension=="DOC"){
		$contador_nombre_archivo=0;
		$nombre_nuevo=$numero_seguimiento.'.DOC';
		$ext=6;

		while(file_exists( $conf['path_files'].$id_usu."/".$id."/".$nombre_nuevo)){
	        $contador_nombre_archivo++;
	        $nombre_nuevo=$numero_seguimiento.'('.$contador_nombre_archivo.').DOC';
	    }
	}elseif($extension=="PNG"){
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
	
	$db->prepare("UPDATE paquete SET valor=:valor_factura WHERE id_paquete=:id");
	$db->execute(array(':id' => $id,':valor_factura' => $valorFactura));
	
}else{
	die("El archivo ingresado no cumple con los formatos pdf, jpg, xlsx, xls, docx o doc, o supera los 10 mb");
}

header("location: historial.php?paquete=$id");
?>