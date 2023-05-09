<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$fecha_inicio=$_GET['fecha_inicio'];
    $fecha_fin=$_GET['fecha_termino'];
	
	$db->prepare("SELECT * FROM consolidado 
		WHERE date(fecha) BETWEEN :inicio AND :fin
		AND eliminado=0
		ORDER BY id_consolidado DESC
	");
	$db->execute(array(
		':inicio' => $fecha_inicio, 
		':fin' => $fecha_fin
	));
	$sql_consolidado_cerrado=$db->get_results();

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

	<!--Inicio Contenido -->

	<center>
		<div id="sesion">
			<p>Muestra todas los consolidados abiertos y cerrados que se han procesado.</p>
		</div>
	</center>

	<br>
	<br>

	<?php if(empty($sql_consolidado_cerrado)){ ?>
		<center><h2>No hay consolidados</h2></center>
	<?php }else{ ?>
	<table>
		<tr>
			<td>TLC Tracking Consolidado</td>
			<td>Peso total(kg)</td>
			<td>Paquetes</td>
			<td>Fecha</td>
			<td>Estado</td>
		</tr>
		<tr>
			<td colspan="8"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php foreach ($sql_consolidado_cerrado as $key => $consolidado) {  ?>
		<tr>
			<td><?php echo $consolidado->codigo_consolidado; ?></td>
			<td><?php echo $consolidado->peso_kilos/0.45; ?></td>
			<td><?php echo $consolidado->numero_paquetes; ?></td>
			<td><?php echo date("d/m/Y H:i:s",strtotime($consolidado->fecha)); ?></td>
			<?php if (($consolidado->status_consolidado)==0) { ?>
				<td><strong>Abierto</strong></td>
			<?php }else{ ?>
				<td><strong>Cerrado</strong></td>
			<?php } ?>	
		</tr>
		<tr>
			<td colspan="8"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php } ?>
	</table>

	<br/>
	Total de valijas: <?php echo count($sql_consolidado_cerrado); ?>
	
	<br/>
	<br/>
	Exportar
	<br/>
	<a href="reportes_excel/reporte_excel_consolidado.php?fecha_inicio=<?php echo $_GET['fecha_inicio']; ?>&fecha_termino=<?php echo $_GET['fecha_termino']; ?>"><img src="<?php echo $conf['path_host_url'] ?>/img/excel.jpg" width="30" height="30"> Excel</a>
	<?php } ?>	

	<br>
	<br>

	<!-- Fin de contenido -->

</body>
</html>