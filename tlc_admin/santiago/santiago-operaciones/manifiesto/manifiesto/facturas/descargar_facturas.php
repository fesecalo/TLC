<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';

	$id=$_GET['id'];

	$db->prepare("SELECT 
			paquete.id_usuario,
			paquete.id_paquete,
			paquete.id_vuelo,
			paquete.id_archivo_trancito,

			vuelo.codigo_vuelo,
			
			archivo.nombre_comprobante

		FROM paquete AS paquete
		INNER JOIN comprobante_compra AS archivo ON archivo.id_paquete=paquete.id_paquete
		INNER JOIN vuelos AS vuelo ON vuelo.id_vuelos=paquete.id_vuelo

		WHERE paquete.id_vuelo=:id_archivo
		AND archivo.eliminado=0
		ORDER BY id_paquete DESC
	");
	$db->execute(array(':id_archivo' => $id ));
	$sql_paquete=$db->get_results();

	$vuelo=$sql_paquete[0]->codigo_vuelo;

	// Creamos un instancia de la clase ZipArchive
	$zip = new ZipArchive();
	// Creamos y abrimos un archivo zip temporal
	$zip->open("facturas.zip",ZipArchive::CREATE);// Añadimos un directorio

	foreach ($sql_paquete as $key => $paquete) {

		$id_usu=$paquete->id_usuario;
		$id_paquete=$paquete->id_paquete;
		$nombre=$paquete->nombre_comprobante;

		// COMPROBAR QUE EL ARCHIVO EXISTA
		if(file_exists($conf['path_files_factura']."/".$id_usu."/".$id_paquete."/".$nombre)){
			// copiamos el archivo a la carpeta factura para comprimir
			copy($conf['path_files_factura']."/".$id_usu."/".$id_paquete."/".$nombre , $conf['path_files_factura_zip']."/".$nombre);
			// Añadimos un archivo en al zip.
			$zip->addFile($nombre);

		}elseif(file_exists($conf['path_files_factura']."/".$id_usu."/".$id_paquete."/".utf8_decode($nombre))){
			// copiamos el archivo a la carpeta factura para comprimir
			copy($conf['path_files_factura']."/".$id_usu."/".$id_paquete."/".$nombre , $conf['path_files_factura_zip']."/".utf8_decode($nombre));
			// Añadimos un archivo en al zip.
			$zip->addFile(utf8_decode($nombre));
		}
	}

	//Añadimos un archivo dentro del directorio que hemos creado
	$zip->close();

	// eliminamos todos los archivos movidos
	foreach ($sql_paquete as $key => $paquete) {

		$nombre=$paquete->nombre_comprobante;

		// COMPROBAR QUE EL ARCHIVO EXISTA
		if(file_exists($conf['path_files_factura_zip']."/".$nombre)){
			//Destruyearchivo temporal
			unlink($conf['path_files_factura_zip']."/".$nombre);

		}elseif(file_exists($conf['path_files_factura_zip']."/".utf8_decode($nombre))){
			//Destruyearchivo temporal
			unlink($conf['path_files_factura_zip']."/".utf8_decode($nombre));

		}
	}

	// Creamos las cabezeras que forzaran la descarga del archivo como archivo zip.
	header("Content-type: application/octet-stream");
	header("Content-disposition: attachment; filename=".$vuelo.".zip");
	// leemos el archivo creado
	readfile('facturas.zip');
	// Por último eliminamos el archivo temporal creado
	unlink('facturas.zip');//Destruyearchivo temporal

?>