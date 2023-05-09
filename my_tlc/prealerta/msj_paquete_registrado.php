<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $conf['path_host'].'/include/include_sesion.php';
?>
<!DOCTYPE html>
<html lang="es">

<!-- HEAD-->
<?php require $conf['path_host'].'/include/include_head.php'; ?>
<!--FIN HEAD-->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<style type="text/css">
	table{
		width: 100%;
	}
</style>
<!-- Fin Script -->
<body>

<!-- menu-->
<?php 
	if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==5){
		require $conf['path_host'].'/include/include_menu_admin.php';
	}elseif($_SESSION['tipo_usuario']==3){
		require $conf['path_host'].'/include/include_menu.php';
	}else{
		die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
	}
?> 
<!--menu-->

	<!--Inicio Contenido -->
	
	<!-- registro de prealertas -->	
	<center>
	<table >
		<tr>
			<td><h3>Si realizas una compra av&iacute;sanos que el paquete viene en camino para realizar una entrega m&aacute;s r&aacute;pida</h3></td>
			<td><a href="<?php echo $conf['path_host_url'] ?>/prealerta/prealerta.php" class="button solid-color">PREALERTAR</a></td>
		</tr>
	</table>
	</center>
	<!-- Fin prealerta -->
	
	<!-- inicio datos cliente -->
	<br><br>
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<br><br>
	<!-- Fin datos cliente -->

	<center>
		<table >
			<tr>
				<td><h1>Su prealerta ha sido ingresada correctamente</h1></td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<a href="<?php echo $conf['path_host_url'] ?>/tracking/tracking.php" class="button solid-color">REGRESAR</a>
	</center>
	<!-- Fin prealerta -->

	<!-- Fin de contenido -->
	<br><br>
	<!-- INCLUDE FOOTER-->
	<?php require $conf['path_host'].'/include/include_footer.php'; ?> 
	<!--FIN FOOTER-->  

</body>
</html>