<?php

	/**************************
		$accion
			1. mostrar
			2. descargar

	**************************/
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';

	$usuario=$_GET["usu"];
	$id_consolidado=$_GET["cons"];
	$nombre_archivo=$_GET["nombre"];
	$accion=$_GET["accion"];

	// COMPROBAR QUE EL ARCHIVO EXISTA
	if(file_exists($conf['path_files_consolidado'].$usuario."/".$id_consolidado."/".$nombre_archivo)){
		$ruta_final=$conf['path_files_consolidado'].$usuario."/".$id_consolidado."/".$nombre_archivo;
	}elseif(file_exists($conf['path_files_consolidado'].utf8_decode($nombre_archivo))){
		$ruta_final=$conf['path_files_consolidado'].$usuario."/".$envio."/".utf8_decode($nombre_archivo);
	}else{
		echo "Archivo no encontrado";
		exit;
	}

	if($accion==1)
	{
		header("Content-type: application/pdf");
		header("Content-Disposition: inline; filename=".$nombre_archivo);
		readfile($ruta_final);
	}
	elseif($accion=2)
	{
		header ("Content-Disposition: attachment; filename=".$nombre_archivo);
		header ("Content-Type: application/force-download");
		header ("Content-Length: ".filesize($ruta_final));
		readfile($ruta_final);
	}
	else
		echo "Error";
?>