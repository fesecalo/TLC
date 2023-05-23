<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	
	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_usu=$_SESSION['numero_cliente'];

	$accion=$_GET['accion'];

	if($accion==1){
		$valija=$_GET['id_valija'];
		$cincho=$_GET['cincho'];

		$db->prepare("SELECT * FROM paquete WHERE id_valija=:id ORDER BY id_paquete");
		$db->execute(array(':id' => $valija));
		$sql_paquetes=$db->get_results();

		if(empty($sql_paquetes)){
			die("No es posible cerrar una valija sin paquetes");
		}else{

			$db->prepare("UPDATE valijas SET status_valija='1', cincho=:seguro, fecha=:fecha where id_valija=:id",true);
			$db->execute(array(':id' => $valija, ':seguro' => $cincho, ':fecha' => $fecha_actual));
		
	        header("location: editar_valija.php?valija=$valija");
	    }
	}

	if($accion==2){
		$valija=$_GET['id_valija'];

		$db->prepare("UPDATE valijas SET status_valija='0' where id_valija=:id",true);
		$db->execute(array(':id' => $valija));

		// fin registro tabla log
        header("location: editar_valija.php?valija=$valija");
	}

	if($accion==3){
		$id_paquete=$_GET['id_paquete'];
		$id_valija=$_GET['id_valija'];

		$db->prepare("SELECT * FROM paquete WHERE id_paquete=:id ORDER BY id_paquete LIMIT 1");
		$db->execute(array(':id' => $id_paquete));
		$sql_paquete=$db->get_results();

		foreach($sql_paquete as $key => $paquete){
			$peso_paquete=$paquete->peso;
		}

		$db->prepare("SELECT * FROM valijas WHERE id_valija=:id");
		$db->execute(array(':id' => $id_valija));
		$sql_valija=$db->get_results();

		foreach($sql_valija as $key => $valija){
			$kilogramos=$valija->peso_kilos;
			$numero_paquetes=$valija->numero_paquetes;
		}

		$peso_valija=$kilogramos-$peso_paquete;
		$paquetes_valija=$numero_paquetes-1;

		$db->prepare("UPDATE valijas SET peso_kilos=:kilos, numero_paquetes=:numero WHERE id_valija=:id",true);
		$db->execute(array(':kilos' => $peso_valija, ':numero' =>$paquetes_valija, ':id' => $id_valija));

		$db->prepare("UPDATE paquete SET id_valija='0' where id_paquete=:id",true);
		$db->execute(array(':id' => $id_paquete));
	
		// fin registro tabla log
        header("location: editar_valija.php?valija=$id_valija");
	}

?>