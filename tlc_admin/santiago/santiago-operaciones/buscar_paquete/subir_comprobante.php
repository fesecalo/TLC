<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

// funcion fecha actual tiene que ir despues de la conexion PDO
require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/garve_admin/funciones/fecha_actual.php';

$id_usu=$_SESSION['numero_cliente'];
$id=$_POST['id_paquete'];

$db->prepare("SELECT
		paquete.id_paquete,
		paquete.tracking_garve,
		paquete.numero_miami

	FROM paquete as paquete

	WHERE paquete.id_paquete=:id
");
$db->execute(array(':id' => $id));

$sql_paquete=$db->get_results();

$tracking_garve=$sql_paquete[0]->tracking_garve;
$tracking_miami=$sql_paquete[0]->numero_miami;

if($tracking_miami==0){
	$numero_seguimiento=$tracking_garve;
}else{
	$numero_seguimiento=$tracking_miami;
}

if (!isset($_POST['cantidad_comprobantes'])) {
	die("Ocurrio un problema con la cantidad de comprobantes ingresados");
}else{
	$cantidad_comprobantes=$_POST['cantidad_comprobantes'];
}

if( !isset($_FILES['comprobante0']) ){
	die("Ocurrio un problema con los comprobantes ingresados");
}else{
	
	for ($i=0; $i < $cantidad_comprobantes; $i++) {

		$valorFactura=$_POST['valorFactura'.$i];

		$nombre = $_FILES['comprobante'.$i]['name'];
		$nombre_tmp = $_FILES['comprobante'.$i]['tmp_name'];
		$tipo = $_FILES['comprobante'.$i]['type'];
		$tamano = $_FILES['comprobante'.$i]['size'];

		$partes_nombre = explode('.', $nombre);
		$extension = end( $partes_nombre );

		$limite = 10*1024*1024;//10 mb

		if(($tamano <= $limite) AND ($extension=="pdf" || $extension=="PDF" || $extension=="jpg" || $extension=="JPG" || $extension=="xlsx" || $extension=="XLSX" || $extension=="xls" || $extension=="XLS" || $extension=="docx" || $extension=="DOCX" || $extension=="doc" || $extension=="DOC")){ //comprueba si el archivo ingresado es un pdf o jpg de 10mb
			
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
			");
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
			die("El archivo ingresado no es un PDF o supera los 10 mb");
		}
	}
}

header("location: mostrar_paquete.php?paquete=$id");
?>