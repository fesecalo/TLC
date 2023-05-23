<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
?>
<!DOCTYPE html>

<html lang="es">

<!-- header con css -->
<?php require_once $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<!-- java scripts -->
<?php require_once $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<body>

	<!-- menu-->
	<?php 
		if($_SESSION['tipo_usuario']==1){
			require $conf['path_host'].'/include/include_menu_admin.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

	<!--Inicio Contenido -->
	<center>
		<h2>Modulo administrador.</h2>
		<br>
		<br><br>
		<a href="<?php echo $conf['path_host_url'] ?>/administracion/editar_paquete/inicio_escanear_codigo.php" class="button solid-color">Cambiar estado</a>
		<br><br><br>
		<!-- <a href="<?php echo $conf['path_host_url'] ?>/administracion/direcciones/registro_direcciones.php" class="button solid-color">Direcciones</a>
		<br><br><br> -->
		<a href="<?php echo $conf['path_host_url'] ?>/administracion/cambioEstado/cambiarEstado.php" class="button solid-color">Cambio de estado masivo</a>
		<br><br><br>
	</center>
	<!-- Fin de contenido -->

</body>
</html>