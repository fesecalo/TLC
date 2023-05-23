<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id=$_GET['id_paquete'];
	$id_usu=$_SESSION['id_usu'];

	$db->prepare("SELECT * FROM paquete WHERE id_paquete=:id AND status=6 AND envio_entregado=1 AND cancelado=0 ORDER BY id_paquete LIMIT 1");
	$db->execute(array(':id' => $id));
	$sql_paquete=$db->get_results();

	if (empty($sql_paquete)) {
		die("error al cancelar paquete");
	}else{
		foreach ($sql_paquete as $key => $paquete) {
			$id_paquete=$paquete->id_paquete;

			$db->prepare("UPDATE paquete SET status=5, envio_entregado=0 WHERE id_paquete=:id");
			$db->execute(array(':id' => $id_paquete));

			$db->prepare("UPDATE status_log SET visible_cliente=0 WHERE id_paquete=:id AND id_tipo_status='6'");
			$db->execute(array(':id' => $id_paquete));
		}
	}

	header("location: entregar_paquete.php");
?>