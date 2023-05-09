<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$tracking_garve=trim($_POST['codigo'],"[\n|\r|\n\r|\t|\0|\x0B| ]");
	$id_usu=$_SESSION['id_usu'];

	$db->prepare("SELECT * FROM paquete WHERE tracking_garve=:codigo ORDER BY id_paquete DESC LIMIT 1");
	$db->execute(array(':codigo' => $tracking_garve));
	$sql_paquetes=$db->get_results();

	if(empty($sql_paquetes)){
		die("Paquete no encontrado, verifique tracking number.");
	}else{

		$id_paquete=$sql_paquetes[0]->id_paquete;

		$db->prepare("UPDATE paquete SET status=16, envio_entregado=1 WHERE id_paquete=:id");
		$db->execute(array(':id' => $id_paquete));

		$db->prepare("INSERT INTO status_log SET
			id_paquete=:id,
			id_tipo_status=16,
			id_usuario=:usuario,
			id_lugar=5,
			fecha=:fecha
		");
		$db->execute(array(
			':id' => $id_paquete,
			':usuario' => $id_usu,
			':fecha' => $fecha_actual
		));

		$id=$sql_paquetes[0]->id_paquete;
    	header("location: escanear_codigo.php?paquete=$id");
    }
	

?>