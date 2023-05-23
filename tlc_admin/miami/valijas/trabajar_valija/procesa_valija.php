<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	
	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$accion=$_GET['accion'];

	if($accion==1){
		$valija=$_GET['id_valija'];
		$cincho=$_GET['cincho'];

		$db->prepare("SELECT * FROM paquete WHERE id_valija=:id ORDER BY id_paquete");
		$db->execute(array(':id' => $valija));
		$sql_paquetes=$db->get_results();

		if (empty($sql_paquetes)) {
			die("No es posible cerrar una valija sin paquetes");
		}else{

			$db->prepare("UPDATE valijas SET status_valija=1, cincho=:seguro, fecha=:fecha where id_valija=:id");
			$db->execute(array(':id' => $valija, ':seguro' => $cincho, ':fecha' => $fecha_actual));
		
	        header("location: ".$conf['path_host_url']."/miami/valijas/trabajar_valija/valijas.php");
	    }
	}

	if($accion==2){
		$valija=$_GET['id_valija'];

		$db->prepare("UPDATE valijas SET status_valija=0 where id_valija=:id");
		$db->execute(array(':id' => $valija));

		// fin registro tabla log
        header("location:trabajar_valija.php?valija=$valija");
	}

	// eliminar paquete
	if($accion==3){
		$id_paquete=$_GET['id_paquete'];
		$id_valija=$_GET['id_valija'];

		$db->prepare("UPDATE paquete SET id_valija=0 where id_paquete=:id");
		$db->execute(array(':id' => $id_paquete));

		$db->prepare("SELECT * FROM paquete WHERE id_valija=:id_valija ORDER BY id_paquete");
		$db->execute(array(':id_valija' => $id_valija));
		$sql_paquete_valija=$db->get_results();

		$numero_paquetes=count($sql_paquete_valija);

		foreach ($sql_paquete_valija as $key => $paquete) {
			$peso_valija=$peso_valija+$paquete->peso;
		}

		$db->prepare("UPDATE valijas SET peso_kilos=:kilos, numero_paquetes=:numero WHERE id_valija=:id");
		$db->execute(array(':kilos' => $peso_valija, ':numero' =>$numero_paquetes, ':id' => $id_valija));
	
		// fin registro tabla log
        header("location:trabajar_valija.php?valija=$id_valija");
	}

?>