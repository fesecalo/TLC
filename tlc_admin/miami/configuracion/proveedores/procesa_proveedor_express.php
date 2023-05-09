<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id_usu=$_SESSION['id_usu'];

	if(!isset($_POST['proveedor'])) {
		die("Ocurrio un problema con el nombre del proveedor");
	}else{
		$proveedor=$_POST['proveedor'];
	}

	if (!isset($_POST['direccion'])) {
		die("Ocurrio un problema con la direccion ingresada");
	}else{
		$direccion=$_POST['direccion'];
	}

	if (!isset($_POST['fono'])) {
		die("Ocurrio un problema con el fono de contacto ingresado");
	}else{
		$fono=$_POST['fono'];
	}

	// ingreso de datos a la tabla log la cual lleva el registro de todos los cambios realizados en el envio
	$db->prepare("INSERT INTO data_proveedor SET
		nombre_proveedor=:nombre_proveedor,
		direccion_proveedor=:direccion,
		fono_proveedor=:fono,
		fecha_registro=:fecha,
		usuario_registro=:usuario_registro,
		status=1
	",true);
	$db->execute(
		array(
			':nombre_proveedor' => $proveedor,
			':direccion' => $direccion,
			':fono' => $fono,
			':fecha' => $fecha_actual,
			':usuario_registro' => $id_usu
	));

	?>
		<script>
			window.opener.location.reload();
			window.close();
	    </script>
	<?php

?>

					
				