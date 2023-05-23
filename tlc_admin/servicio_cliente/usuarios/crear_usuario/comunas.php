<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	include $conf['path_host'].'/conexion.php';

	$idRegion=$_POST['idRegion'];

	$sql="SELECT * FROM comunas WHERE id_region='$idRegion'";
	$result=mysqli_query($conexion,$sql);

	while ($comuna=mysqli_fetch_assoc($result)) {
		$cadena=$cadena.'<option value='.$comuna['id_comuna'].'>'.$comuna['nombre_comuna'].'</option>';
	}

	echo  $cadena;
?>