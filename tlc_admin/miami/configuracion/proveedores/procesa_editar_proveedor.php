<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	
	$id_usu=$_SESSION['id_usu'];
	$id_proveedor=$_POST['id_proveedor'];

	$db->prepare("SELECT * FROM data_proveedor WHERE id_proveedor=:id_proveedor");
	$db->execute(array(':id_proveedor' => $id_proveedor));
	$sql_proveedor=$db->get_results();

	foreach ($sql_proveedor as $key => $proveedor) {
		$proveedor_old=$proveedor->nombre_proveedor;
		$direccion_old=$proveedor->direccion_proveedor;
		$fono_old=$proveedor->fono_proveedor;
	}

	if(isset($_POST['proveedor'])) {
		$proveedor_new=$_POST['proveedor'];

		if($proveedor_new!=$proveedor_old){
			$db->prepare("UPDATE data_proveedor SET nombre_proveedor=:proveedor WHERE id_proveedor=:proveedor");
			$db->execute(array(':proveedor' => $proveedor_new, ':proveedor' => $id_proveedor));
		}
	}

	if (isset($_POST['direccion'])) {
		$direccion_new=$_POST['direccion'];

		if($direccion_new!=$direccion_old){
			$db->prepare("UPDATE data_proveedor SET direccion_proveedor=:direccion WHERE id_proveedor=:proveedor");
			$db->execute(array(':direccion' => $direccion_new, ':proveedor' => $id_proveedor));
		}
	}

	if (isset($_POST['fono'])) {
		$fono_new=$_POST['fono'];

		if($fono_new!=$fono_old){
			$db->prepare("UPDATE data_proveedor SET fono_proveedor=:fono WHERE id_proveedor=:proveedor");
			$db->execute(array(':fono' => $fono_new, ':proveedor' => $id_proveedor));
		}
	}

	header("location: ".$conf['path_host_url']."/miami/configuracion/proveedores/editar_proveedor.php?id_proveedor=$id_proveedor");
?>

					
				