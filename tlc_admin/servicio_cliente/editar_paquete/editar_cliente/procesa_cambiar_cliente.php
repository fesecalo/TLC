<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_usu=$_SESSION['id_usu'];

	if(!isset($_POST['id_paquete'])) {
		die("Ocurrio un problema con el numero de paquete");
	}else{
		$id_paquete=$_POST['id_paquete'];
	}

	$db->prepare("SELECT id_usuario FROM paquete WHERE id_paquete=:id ORDER BY id_paquete ASC");
	$db->execute(array(':id' => $id_paquete));

	$sql_paquete=$db->get_results();

	foreach ($sql_paquete as $key => $paquete) {
		$id_cliente_old=$paquete->id_usuario;
	}

	if(isset($_POST['id_cliente'])) {
		$id_cliente_new=$_POST['id_cliente'];

		if($id_cliente_new!=$id_cliente_old){
			$db->prepare("UPDATE paquete SET id_usuario=:id_cliente_new WHERE id_paquete=:paquete");
			$db->execute(array(':id_cliente_new' => $id_cliente_new, ':paquete' => $id_paquete));

			$comentario="Cambio de numero de cliente de ".$id_cliente_old." a ".$id_cliente_new;

			$db->prepare("INSERT INTO status_log SET
				id_paquete=:id,
				id_tipo_status=14,
				id_usuario=:usuario,
				id_lugar= 2,
				visible_cliente=0,
				fecha=:fecha,
				comentario=:comentario
			");
			$db->execute(
				array(
					':id' => $id_paquete,
					':usuario' => $id_usu,
					':fecha' => $fecha_actual,
					':comentario' => $comentario
			));
		}
	}

	header("location: ".$conf['path_host_url']."/servicio_cliente/editar_paquete/editar_paquete.php?paquete=$id_paquete");

?>