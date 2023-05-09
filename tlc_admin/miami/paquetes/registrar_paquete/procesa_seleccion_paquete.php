<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$tracking_usa=trim($_POST['codigo'],"[\n|\r|\n\r|\t|\0|\x0B| ]");

	$db->prepare("SELECT id_paquete FROM paquete WHERE tracking_eu=:codigo AND status=1 AND cancelado=0 ORDER BY id_paquete DESC LIMIT 1");
	$db->execute(array(':codigo' => $tracking_usa));
	$sql_paquetes=$db->get_results();

	if(empty($sql_paquetes)){

		$sql_paquetes2=$db->get_results("SELECT id_paquete,tracking_eu FROM paquete WHERE status=1 AND cancelado=0 ORDER BY id_paquete");

		foreach ($sql_paquetes2 as $key => $paquetes2) {

			$buscar=$paquetes2->tracking_eu;
			$id=$paquetes2->id_paquete;

			if (preg_match("/".$buscar."/i", $tracking_usa)) {
				// echo "id: ".$id;
				// echo "<br>";
				// echo "prealerta: ".$buscar;
				// echo "<br>";
				// echo "Escaneo: ".$tracking_usa;
				// echo "<br>";
				// echo "<br>";
				header("location:trabajar_paquete.php?paquete=$id");
				die;
			}
		}
		
		header("location:registrar_paquete.php?tracking=$tracking_usa");

	}else{
		$id=$sql_paquetes[0]->id_paquete;
    	header("location:trabajar_paquete.php?paquete=$id");
    }
	

?>