<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
    require $conf['path_host'].'/EasyPDO/conexionPDO.php';
    require $conf['path_host'].'/include/include_sesion.php';
    require $conf['path_host'].'/funciones/fecha_actual.php';
	
	set_time_limit(0);

	$id=$_GET['id_vuelo'];
	$id_usu=$_SESSION['id_usu'];

	//vuelo confirmado en chile
	$db->prepare("UPDATE vuelos SET 
		id_status_vuelo=5, 
		eliminado=1,
		usuario_eliminado=:id_usu,
		fecha_eliminado=:fecha
		WHERE id_vuelos=:id
	");
	$db->execute(array(
		':id' => $id,
		':id_usu'=>$id_usu,
		':fecha'=>$fecha_actual
	));

	$db->prepare("UPDATE manifiesto SET eliminado=1 WHERE id_vuelo=:id");
	$db->execute(array(':id' => $id));

	header("location: mostrar_archivo_manifiesto.php?vuelo=$id");
?>