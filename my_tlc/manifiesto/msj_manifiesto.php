<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $conf['path_host'].'/include/include_sesion.php';
?>
<!DOCTYPE html>
<html lang="es">
	<!-- HEAD-->
	<?php require $conf['path_host'].'/include/include_head.php'; ?>

	<!-- java scripts -->
	<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   

	<style type="text/css">
		table{
			width: 100%;
		}
	</style>

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

	<!-- inicio datos cliente -->
	<br><br>
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<br><br>

	<center>
		<table >
			<tr>
				<td><h1>Su manifiesto ha sido ingresada correctamente</h1></td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<a href="<?php echo $conf['path_host_url'] ?>/manifiesto/inicio.php" class="button solid-color">REGRESAR</a>
	</center>

	<br><br>

	<!-- INCLUDE FOOTER-->
	<?php require $conf['path_host'].'/include/include_footer.php'; ?> 

</body>
</html>