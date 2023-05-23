<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	include $conf['path_host'].'/conexion.php';

	$idRegion=$_POST['idRegion'];
	$idComuna=$_POST['idComuna'];

	$sql="SELECT * FROM comunas WHERE id_region='$idRegion'";
	$result=mysqli_query($conexion,$sql);

	while ($comuna=mysqli_fetch_assoc($result)) {
		if($idComuna==($comuna['id_comuna'])) {
			$cadena=$cadena.'<option selected="selected" value='.$comuna['id_comuna'].'>'.$comuna['nombre_comuna'].'</option>';
		}else{
			$cadena=$cadena.'<option value='.$comuna['id_comuna'].'>'.$comuna['nombre_comuna'].'</option>';
		}
	}

	echo  $cadena;
?>