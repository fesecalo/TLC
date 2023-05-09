<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
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
		<!-- HEADER-->
		<?php require $conf['path_host'].'/include/include_menu.php'; ?> 
		<!--FIN HEADER-->

		<!--Inicio Contenido -->
		<h2>REGISTRO USUARIO</h2>
		<center>
			<table >
				<tr>
					<td><h2>Sus datos han sido ingresados correctamente, Recibir&aacute; un correo con la informaci&oacute;n para ingresar al sitio My TLC con el que podr&aacute; registrar env&iacute;os y hacer seguimiento en l&iacute;nea. Recuerde revisar otros correos o correos no deseados.</h2></td>
				</tr>
			</table>
			<a href="<?php echo $conf['path_host_url'] ?>/index.php" class="seguimiento-btn">INGRESAR</a>
		</center>
		<!-- Fin de contenido -->

		<p>&nbsp;</p>

		<!-- INCLUDE FOOTER-->
		<?php require $conf['path_host'].'/include/include_footer.php'; ?> 
		<!--FIN FOOTER-->  
	</body>
</html>
					
