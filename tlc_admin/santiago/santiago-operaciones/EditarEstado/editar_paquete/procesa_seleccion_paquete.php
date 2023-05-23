<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$op=$_POST['opcion'];
	$tracking=trim($_POST['codigo'],"[\n|\r|\n\r|\t|\0|\x0B| ]");

	//opcion 1 es Garve
	//opcion 2 es USA

	if($op==1){
		$db->prepare("SELECT * FROM paquete WHERE tracking_garve=:codigo ORDER BY id_paquete DESC LIMIT 1");
		$db->execute(array(':codigo' => $tracking));
		$sql_paquetes=$db->get_results();

		if(empty($sql_paquetes)){
			die("Paquete no encontrado, verifique tracking number.");
		}else{
			$id=$sql_paquetes[0]->id_paquete;
	    	header("location: mostrar_paquete.php?paquete=$id");
	    }
	}else{
		$db->prepare("SELECT * FROM paquete WHERE tracking_eu=:codigo ORDER BY id_paquete DESC LIMIT 1");
		$db->execute(array(':codigo' => $tracking));
		$sql_paquetes=$db->get_results();

		if(empty($sql_paquetes)){
			die("Paquete no encontrado, verifique tracking number.");
		}else{
			$id=$sql_paquetes[0]->id_paquete;
	    	header("location: mostrar_paquete.php?paquete=$id");
	    }
	}
	
	

?>