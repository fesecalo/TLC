<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	include $conf['path_host'].'/miami/etiqueta/etiqueta_barcode.php';
	
	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_consolidado=$_POST['id_consolidado'];
	$id_paquete=$_POST['id_paquete'];
	$txtPesoPaquete=$_POST['txtPesoPaquete'];
	
	if ($txtPesoPaquete==0) {
		die("El paquete no puede pesar 0. Vuelva a intentar.");
	}

	if (empty($id_consolidado) || empty($id_paquete) || empty($txtPesoPaquete)) {
		die("No es posible editar el paquete. Contacte con soporte.");
	}else{

        if (!isset($_POST['txtPesoPaquete'])) {
			die("Ocurrio un problema con el peso del consolidado ingresado");
		}else{
			$pesoPaquete=$_POST['txtPesoPaquete'];
			$pesoPaquete=floatval($pesoPaquete)*(0.45);
		}
		
	
		/*if (!isset($_POST['txtAlto'])) {
			die("Ocurrio un problema con el alto del producto ingresado");
		}else{
			$alto=$_POST['txtAlto'];
			$alto=floatval($alto)*(2.54);
		}

		if (!isset($_POST['txtLargo'])) {
			die("Ocurrio un problema con el largo del producto ingresado");
		}else{
			$largo=$_POST['txtLargo'];
			$largo=floatval($largo)*(2.54);
		}

		if (!isset($_POST['txtAncho'])) {
			die("Ocurrio un problema con el ancho del producto ingresado");
		}else{
			$ancho=$_POST['txtAncho'];
			$ancho=floatval($ancho)*(2.54);
		}

		$pesoVolumen=($alto*$ancho*$largo)/6000; */

		$db->prepare("UPDATE paquete SET 
			peso=:peso
			WHERE id_paquete=:id_paquete and id_consolidado=:id_consolidado 
		");
		$db->execute(array(
			':id_paquete' => $id_paquete,
			':id_consolidado' => $id_consolidado,
			':peso' => $pesoPaquete
		));
	
    }

// fin registro tabla log
header("location: trabajar_consolidado.php?id_cons=$id_consolidado&paq_edit=1&id_paq=$id_paquete");

?>