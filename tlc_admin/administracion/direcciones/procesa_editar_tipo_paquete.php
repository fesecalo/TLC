<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	
	$id_usu=$_SESSION['id_usu'];
	$id_tipo_paquete=$_POST['id_tipo_paquete'];

	$db->prepare("SELECT * FROM data_tipo_paquete WHERE id_tipo_paquete=:id_tipo_paquete");
	$db->execute(array(':id_tipo_paquete' => $id_tipo_paquete));
	$sql_tipo_paquete=$db->get_results();

	foreach ($sql_tipo_paquete as $key => $tipo_paquete) {
		$tipo_paquete_old=$tipo_paquete->nombre_tipo_paquete;
		$descripcion_old=$tipo_paquete->descripcion_tipo_paquete;
	}

	if(isset($_POST['tipo_paquete'])) {
		$tipo_paquete_new=$_POST['tipo_paquete'];

		if($tipo_paquete_new!=$tipo_paquete_old){
			$db->prepare("UPDATE data_tipo_paquete SET nombre_tipo_paquete=:tipo_paquete WHERE id_tipo_paquete=:id_tipo_paquete");
			$db->execute(array(':tipo_paquete' => $tipo_paquete_new, ':id_tipo_paquete' => $id_tipo_paquete));
		}
	}

	if (isset($_POST['descripcion'])) {
		$descripcion_new=$_POST['descripcion'];

		if($descripcion_new!=$descripcion_old){
			$db->prepare("UPDATE data_tipo_paquete SET descripcion_tipo_paquete=:descripcion WHERE id_tipo_paquete=:id_tipo_paquete");
			$db->execute(array(':descripcion' => $descripcion_new, ':id_tipo_paquete' => $id_tipo_paquete));
		}
	}

	header("location: ".$conf['path_host_url']."/miami/mantenedores/tipo_paquete/editar_tipo_paquete.php?id_tipo_paquete=$id_tipo_paquete");
?>

					
				