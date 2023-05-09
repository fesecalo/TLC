<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	
	$sql_vuelo_abierto=$db->get_results("SELECT * FROM vuelos WHERE id_status_vuelo=0 AND eliminado=0 ORDER BY id_vuelos DESC");

?>
<!DOCTYPE html>
<html lang="es">
<!-- header con css -->
<?php require $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<body>

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
	<table >
		<tr>
			<td><h2>CREAR VUELO</h2> <a href="procesa_crear_vuelo.php" class="button solid-color">CREAR</a></td>
		</tr>
	</table>

	<h2>VUELOS ABIERTOS</h2>
	<?php if(empty($sql_vuelo_abierto)){ ?>
		<center><h2>No hay vuelos abiertos para trabajar</h2></center>
	<?php }else{ ?>
	<table>
		<tr>
			<td>Codigo vuelo</td>
			<td>N&uacute;mero de valijas</td>
			<td>Estado</td>
			<td>Acci&oacute;n</td>
		</tr>
		<tr>
			<td colspan="8"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php foreach ($sql_vuelo_abierto as $key => $vuelos) {  ?>
		<tr>
			<td><?php echo $vuelos->codigo_vuelo; ?></td>
			<td><?php echo $vuelos->cantidad_valijas; ?></td>
			<td><strong>Abierto</strong></td>
			<td><a href="trabajar_vuelo.php?vuelo=<?php echo $vuelos->id_vuelos; ?>" class="button solid-color">Trabajar</a></td>
		</tr>
		<tr>
			<td colspan="8"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php } ?>
	</table>
	<?php } ?>

	<br>
	<br>
	<br>
	<br>
	
<!-- Fin de contenido -->
</body>

</html>