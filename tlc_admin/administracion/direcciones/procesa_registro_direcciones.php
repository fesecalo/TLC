<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id_usu=$_SESSION['id_usu'];

	if(!isset($_POST['direccion'])) {
		die("Ocurrio un problema con la direccion ingresado");
	}else{
		$direccion=$_POST['direccion'];
	}

	if (!isset($_POST['ciudad'])) {
		die("Ocurrio un problema con la ciudad ingresada");
	}else{
		$ciudad=$_POST['ciudad'];
	}

	if (!isset($_POST['pais'])) {
		die("Ocurrio un problema con el pais ingresada");
	}else{
		$pais=$_POST['pais'];
	}

	if (!isset($_POST['phone'])) {
		$phone='';
	}else{
		$phone=$_POST['phone'];
	}
	
	// ingreso de datos a la tabla log la cual lleva el registro de todos los cambios realizados en el envio
	$db->prepare("INSERT INTO data_direccion SET
		direccion=:direccion,
		ciudad=:ciudad,
		pais=:pais,
		phone=:phone,
		status=1
	");
	$db->execute(array(
		':direccion' => $direccion,
		':ciudad' => $ciudad,
		':pais' => $pais,
		':phone' => $phone
	));

	header("location: ".$conf['path_host_url']."/administracion/direcciones/registro_direcciones.php");
?>

					
				