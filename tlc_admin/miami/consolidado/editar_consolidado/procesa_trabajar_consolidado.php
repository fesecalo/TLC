<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';

	$barcode=trim($_POST['codigo'],"[\n|\r|\n\r|\t|\0|\x0B| ]");
	$id_consolidado=$_POST['id_consolidado'];
	$peso_consolidado=0;

	$db->prepare("SELECT * FROM paquete WHERE tracking_garve=:codigo ORDER BY id_paquete LIMIT 1");
	$db->execute(array(':codigo' => $barcode));
	$sql_paquete=$db->get_results();

	foreach ($sql_paquete as $key => $paquete) {
		$id_paquete=$paquete->id_paquete;
		$id_consolidado_old=$paquete->id_consolidado;
	}

	if (empty($sql_paquete)) {
		// "No hay paquetes disponibles con el codigo ingresado";
		header("location: editar_consolidado.php?id_consolidado=$id_consolidado&msg=1");
		die;
	}else{
		$db->prepare("UPDATE paquete SET id_consolidado=:id_consolidado WHERE id_paquete=:id");
		$db->execute(array(':id_consolidado' => $id_consolidado, ':id' => $id_paquete));

		$db->prepare("SELECT * FROM paquete WHERE id_consolidado=:id_consolidado ORDER BY id_paquete");
		$db->execute(array(':id_consolidado' => $id_consolidado));
		$sql_paquete_consolidado=$db->get_results();

		$numero_paquetes=count($sql_paquete_consolidado);

		foreach ($sql_paquete_consolidado as $key => $paquete) {
			$peso_consolidado=$peso_consolidado+$paquete->peso;
		}

		$db->prepare("UPDATE consolidado SET peso_kilos=:kilos, numero_paquetes=:numero WHERE id_consolidado=:id");
		$db->execute(array(':kilos' => $peso_consolidado, ':numero' =>$numero_paquetes, ':id' => $id_consolidado));

		// si el paquete ya tenia un id de valija antiguo se actualizan los datos de la valija
		if ($id_consolidado_old!=0) {
			$db->prepare("SELECT * FROM paquete WHERE id_consolidado=:id_consolidado ORDER BY id_paquete");
			$db->execute(array(':id_consolidado' => $id_valija_old));
			$sql_paquete_consolidado_old=$db->get_results();

			$numero_paquetes_old=count($sql_paquete_consolidado_old);

			foreach ($sql_paquete_consolidado_old as $key => $paquete) {
				$peso_consolidado_old=$peso_consolidado_old+$paquete->peso;
			}

			$db->prepare("UPDATE consolidado SET peso_kilos=:kilos, numero_paquetes=:numero WHERE id_consolidado=:id");
			$db->execute(array(':kilos' => $peso_consolidado_old, ':numero' =>$numero_paquetes_old, ':id' => $id_consolidado_old));
		}
		// fin si el paquete ya tenia un id de valija antiguo se actualizan los datos de la valija

		header("location: editar_consolidado.php?id_consolidado=$id_consolidado");
	}
?>