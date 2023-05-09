<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id_usu=$_SESSION['id_usu'];

	if(!isset($_POST['tipo_paquete'])) {
		die("Ocurrio un problema con el tipo de paquete ingresado");
	}else{
		$tipo_paquete=$_POST['tipo_paquete'];
	}

	if (!isset($_POST['descripcion'])) {
		die("Ocurrio un problema con la descripcion ingresada");
	}else{
		$descripcion=$_POST['descripcion'];
	}

	// ingreso de datos a la tabla log la cual lleva el registro de todos los cambios realizados en el envio
	$db->prepare("INSERT INTO data_tipo_paquete SET
		nombre_tipo_paquete=:nombre_tipo_paquete,
		descripcion_tipo_paquete=:descripcion_tipo_paquete,
		fecha_registro=:fecha,
		usuario_registro=:usuario_registro,
		status=1
	",true);
	$db->execute(
		array(
			':nombre_tipo_paquete' => $tipo_paquete,
			':descripcion_tipo_paquete' => $descripcion,
			':fecha' => $fecha_actual,
			':usuario_registro' => $id_usu
	));


	header("location: ".$conf['path_host_url']."/miami/configuracion/tipo_paquete/tipo_paquete.php");
?>

					
				