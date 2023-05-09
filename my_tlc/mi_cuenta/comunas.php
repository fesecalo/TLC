<?php

	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	include $conf['path_host'].'/conexion.php';
	$idRegion=$_POST['idRegion'];
	$idComunaSelected=$_POST['idComunaSelected'];

	$sql="SELECT * FROM comunas WHERE id_region='$idRegion'";
	$result=mysqli_query($conexion,$sql);

	while ($comuna=mysqli_fetch_assoc($result)) {
	    $selected = ($comuna['id_comuna']==$idComunaSelected) ? 'selected' : '';
	    $cadena=$cadena.'<option value='.$comuna['id_comuna'].' '.$selected.' >'.$comuna['nombre_comuna'].'</option>';
	}

	echo  $cadena;
?>