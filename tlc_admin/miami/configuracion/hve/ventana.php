<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
?>
<!DOCTYPE html>

<html lang="es">

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<body>
<!-- header con css -->
<?php require $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<!-- menu-->
<?php 
	if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==2){
		require $conf['path_host'].'/include/include_menu_operador_externo.php'; 
	}else{
		die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
	}
?> 
<!--menu-->

<!--Inicio Contenido -->
	<h2>Modulo configuración</h2>

	<br><br><br>
	
	<center>
		<h3>Si puedes visualizar este mensaje las ventanas emergentes han sido habilitadas exitosamente.</h3>
	</center>

<!-- Fin de contenido -->

</body>
</html>