<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';

	$barcode=trim($_POST['codigo'],"[\n|\r|\n\r|\t|\0|\x0B| ]");
	$id_valija=$_POST['id_valija'];
	$peso_valija=0;

	$db->prepare("SELECT * FROM paquete WHERE tracking_garve=:codigo ORDER BY id_paquete LIMIT 1");
	$db->execute(array(':codigo' => $barcode));
	$sql_paquete=$db->get_results();

	foreach ($sql_paquete as $key => $paquete) {
		$id_paquete=$paquete->id_paquete;
		$id_valija_old=$paquete->id_valija;
	}

	if (empty($sql_paquete)) {
		// echo "No hay paquetes disponibles con el codigo ingresado";
		header("location: trabajar_valija.php?valija=$id_valija&msg=1");
		die;
	}else{

		$db->prepare("UPDATE paquete SET id_valija=:valija WHERE id_paquete=:id");
		$db->execute(array(':valija' => $id_valija, ':id' => $id_paquete));

		$db->prepare("SELECT * FROM paquete WHERE id_valija=:id_valija ORDER BY id_paquete");
		$db->execute(array(':id_valija' => $id_valija));
		$sql_paquete_valija=$db->get_results();

		$numero_paquetes=count($sql_paquete_valija);

		foreach ($sql_paquete_valija as $key => $paquete) {
			$peso_valija=$peso_valija+$paquete->peso;
		}

		$db->prepare("UPDATE valijas SET peso_kilos=:kilos, numero_paquetes=:numero WHERE id_valija=:id");
		$db->execute(array(':kilos' => $peso_valija, ':numero' =>$numero_paquetes, ':id' => $id_valija));

		// si el paquete ya tenia un id de valija antiguo se actualizan los datos de la valija
		if ($id_valija_old!=0) {
			$db->prepare("SELECT * FROM paquete WHERE id_valija=:id_valija ORDER BY id_paquete");
			$db->execute(array(':id_valija' => $id_valija_old));
			$sql_paquete_valija_old=$db->get_results();

			$numero_paquetes_old=count($sql_paquete_valija_old);

			foreach ($sql_paquete_valija_old as $key => $paquete) {
				$peso_valija_old=$peso_valija_old+$paquete->peso;
			}

			$db->prepare("UPDATE valijas SET peso_kilos=:kilos, numero_paquetes=:numero WHERE id_valija=:id");
			$db->execute(array(':kilos' => $peso_valija_old, ':numero' =>$numero_paquetes_old, ':id' => $id_valija_old));
		}
		// fin si el paquete ya tenia un id de valija antiguo se actualizan los datos de la valija

		header("location: editar_valija.php?valija=$id_valija");
	}
?>