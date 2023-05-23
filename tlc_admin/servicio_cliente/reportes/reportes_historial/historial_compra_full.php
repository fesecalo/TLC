<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$fecha_inicio=$_GET['fecha_inicio'];
    $fecha_fin=$_GET['fecha_termino'];
	
	$db->prepare("SELECT 
			paquete.id_paquete,
			paquete.fecha_registro,
            paquete.proveedor,
            currier.nombre_currier,
            paquete.tracking_eu,
            paquete.tracking_garve,
            usuario.nombre,
			usuario.apellidos,
            paquete.id_usuario,
            paquete.descripcion_producto,
            paquete.valor,

            paquete.id_proveedor,

			proveedor.nombre_proveedor,
            
            estado.nombre_status

		FROM paquete AS paquete
		LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
        INNER JOIN data_currier AS currier ON currier.id_currier=paquete.currier
        LEFT JOIN data_proveedor AS proveedor ON proveedor.id_proveedor=paquete.id_proveedor
        INNER JOIN data_status AS estado ON estado.id_status=paquete.status
		WHERE date(paquete.fecha_registro) BETWEEN :inicio AND :fin
        GROUP BY paquete.id_paquete
		ORDER BY paquete.id_usuario,paquete.fecha_registro ASC
		LIMIT 5000
	");
	$db->execute(array( 
		':inicio' => $fecha_inicio, 
		':fin' => $fecha_fin
	));
	$sql_paquete=$db->get_results();

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
			<p>Muestra todos los paquetes que ha comprado un cliente segun las fechas seleccionadas</p>
		</div>
	</center>

	<br>
	<br>

	<table>
		<tr>
			<td>#</td>
			<td>Fecha</td>
			<td>Shipper Name</td>
			<td>Delivery Company</td>
			<td>Tracking Number</td>
			<td>Tracking <?php echo $conf['path_company_name']; ?></td>
			<td>Nombre del Cliente</td>
			<td>CHI Number</td>
			<td>Description/Invoice/Amount</td>
			<td>Valor USD</td>
			<td>Estado</td>
			<td>Detalle</td>
		</tr>
		<tr>
			<td colspan="14"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php $x=1; foreach ($sql_paquete as $key => $paquete) {  ?>
			<tr>
				<td><?php echo $x; ?></td>
				<td><?php echo date("d/m/Y H:i:s",strtotime($paquete->fecha_registro)); ?></td>

				<?php if($paquete->id_proveedor==0){ ?>
					<td><?php echo $paquete->proveedor; ?></td>
				<?php }else{ ?>
					<td><?php echo $paquete->nombre_proveedor; ?></td>
				<?php } ?>

				<td><?php echo $paquete->nombre_currier; ?></td>
				<td><?php echo $paquete->tracking_eu; ?></td>
				<td><?php echo $paquete->tracking_garve; ?></td>
				<td><?php echo $paquete->nombre.' '.$paquete->apellidos; ?></td>
				<td><?php echo $paquete->id_usuario; ?></td>
				<td><?php echo $paquete->descripcion_producto; ?></td>
				<td><?php echo $paquete->valor; ?></td>
				<td><?php echo $paquete->nombre_status; ?></td>
				<td>
					<a href="<?php echo $conf['path_host_url'] ?>/servicio_cliente/reportes/reportes_actuales/mostrar_paquete.php?paquete=<?php echo $paquete->id_paquete; ?>&op=1" class="button solid-color">VER</a>
				</td>

			</tr>
			<tr>
				<td colspan="14"><hr size="1" color="#FF6600" /></td>
			</tr>
		<?php $x++; } ?>
	</table>

	<br/>
	<br/>
	Exportar
	<br/>
	<a href="reportes_excel/reporte_excel_historial_compra_full.php?fecha_inicio=<?php echo $_GET['fecha_inicio']; ?>&fecha_termino=<?php echo $_GET['fecha_termino']; ?>"><img src="<?php echo $conf['path_host_url'] ?>/img/excel.jpg" width="30" height="30"> Excel</a>

	<!-- Fin de contenido -->

</body>
</html>