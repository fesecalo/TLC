<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$sql_valija_abierta=$db->get_results("SELECT * FROM valijas WHERE status_valija=0 AND eliminado=0 ORDER BY id_valija DESC");

?>
<!DOCTYPE html>
<!-- header con css -->
<?php require $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<html lang="es">

<body>

	<!-- menu-->
	<?php require $conf['path_host'].'/include/include_menu_operador_externo.php'; ?>  
	<!--menu-->

	<!--Inicio Contenido -->
	<table >
		<tr>
			<td><h2>CREAR VALIJA</h2> <a href="procesa_crear_valija.php" class="button solid-color">CREAR</a></td>
		</tr>
	</table>

	<h2>VALIJAS ABIERTAS</h2>
	<?php if(empty($sql_valija_abierta)){ ?>
		<center><h2>No hay valijas abiertas para trabajar</h2></center>
	<?php }else{ ?>
		<table>
			<tr>
				<td>Cincho</td>
				<td>Peso total(Lb)</td>
				<td>Paquetes</td>
				<td>Estado</td>
				<td>Acci&oacute;n</td>
			</tr>
			<tr>
				<td colspan="8"><hr size="1" color="#FF6600" /></td>
			</tr>
			<?php foreach ($sql_valija_abierta as $key => $valijas) {  ?>
				<tr>
					<td><?php echo $valijas->cincho; ?></td>
					<td><?php echo $valijas->peso_kilos/0.45; ?></td>
					<td><?php echo $valijas->numero_paquetes; ?></td>
					<td><strong>Abierto</strong></td>
					<td><a href="trabajar_valija.php?valija=<?php echo $valijas->id_valija; ?>" class="button solid-color">Trabajar</a></td>	
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