<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$fecha_inicio=$_GET['fecha_inicio'];
    $fecha_fin=$_GET['fecha_termino'];
	
	$db->prepare("SELECT 
			paquete.id_paquete,
			historial.fecha,
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

			proveedor.nombre_proveedor

		FROM paquete AS paquete
		LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
        INNER JOIN status_log AS historial ON historial.id_paquete=paquete.id_paquete
        INNER JOIN data_currier AS currier ON currier.id_currier=paquete.currier
        LEFT JOIN data_proveedor AS proveedor ON proveedor.id_proveedor=paquete.id_proveedor
		WHERE paquete.status=1
        AND date(historial.fecha) BETWEEN :inicio AND :fin
        AND paquete.eliminado=0
        GROUP BY paquete.id_paquete
		ORDER BY historial.fecha ASC
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
			<p>Muestra todos los paquetes que han sido prealertados por los clientes y no han sido procesados en Miami.</p>
		</div>
	</center>

	<br>
	<br>

	<table>
		<tr>
			<td>#</td>
			<td>Fecha prealerta</td>
			<td>Shipper Name:</td>
			<td>Delivery Company</td>
			<td>Tracking Number</td>
			<td>Tracking <?php echo $conf['path_company_name']; ?></td>
			<td>Nombre del Cliente</td>
			<td><?php echo $conf['path_cuenta']; ?> Number</td>
			<td>Description/Invoice/Amount</td>
			<td>Valor USD</td>
			<!-- <td>Detalle</td> -->
		</tr>
		<tr>
			<td colspan="14"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php $x=1; foreach ($sql_paquete as $key => $paquete) {  ?>
			<tr>
				<td><?php echo $x; ?></td>
				<td><?php echo date("d/m/Y H:i:s",strtotime($paquete->fecha)); ?></td>

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
				<!-- <td>
					<a href="<?php echo $conf['path_host_url'] ?>/administracion/mostrar_archivos/historial.php?paquete=<?php echo $paquete->id_paquete; ?>&op=1" class="button solid-color">VER</a>
				</td> -->

			</tr>
			<tr>
				<td colspan="14"><hr size="1" color="#FF6600" /></td>
			</tr>
		<?php $x++; } ?>
	</table>

	<br>
	<br>

	<!-- Fin de contenido -->

</body>
</html>