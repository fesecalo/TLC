<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$fecha_inicio=$_GET['fecha_inicio'];
    $fecha_fin=$_GET['fecha_termino'];
	
	$db->prepare("SELECT 
			paquete.id_paquete,
            paquete.status,
			historial.fecha,
			paquete.pieza,
            paquete.proveedor,

            currier.nombre_currier,
            paquete.tracking_eu,
            paquete.tracking_garve,
            valija.cincho,
            usuario.nombre,
			usuario.apellidos,
            paquete.id_usuario,
            paquete.descripcion_producto,
            paquete.peso,
            paquete.largo,
            paquete.ancho,
            paquete.alto,
            paquete.valor,

            paquete.id_proveedor,

			proveedor.nombre_proveedor,
			tipo_paquete.nombre_tipo_paquete

		FROM paquete AS paquete
		LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
        INNER JOIN status_log AS historial ON historial.id_paquete=paquete.id_paquete
        INNER JOIN data_currier AS currier ON currier.id_currier=paquete.currier
        LEFT JOIN valijas AS valija ON valija.id_valija=paquete.id_valija
        LEFT JOIN data_proveedor AS proveedor ON proveedor.id_proveedor=paquete.id_proveedor
		LEFT JOIN data_tipo_paquete AS tipo_paquete ON tipo_paquete.id_tipo_paquete=paquete.id_tipo_paquete
		WHERE historial.id_tipo_status=3
        AND date(historial.fecha) BETWEEN :inicio AND :fin
        AND paquete.eliminado=0
        GROUP BY paquete.id_paquete
		ORDER BY historial.fecha DESC
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
			<p>Muestra la totalidad de paquetes que han sido embarcados en vuelo a Chile</p>
		</div>
	</center>

	<br>
	<br>

	<table>
		<tr>
			<td>Date Rcvd.</td>
			<td>Pcs #</td>
			<td>Shipper Name:</td>
			<td>Delivery Company</td>
			<td>Tracking Number</td>
			<td>Tracking <?php echo $conf['path_company_name']; ?></td>
			<td>BAG No.</td>
			<td>Nombre del Cliente</td>
			<td><?php echo $conf['path_cuenta']; ?> Number</td>
			<td>Tipo de paquete</td>
			<td>Description/Invoice/Amount</td>
			<td>Weight</td>
			<td>Length</td>
			<td>Width</td>
			<td>Height</td>
			<td>Valor USD</td>
			<td>Etiqueta</td>
		</tr>
		<tr>
			<td colspan="17"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php foreach ($sql_paquete as $key => $paquete) {  ?>
		<tr>
			<td><?php echo date("d/m/Y H:i:s",strtotime($paquete->fecha)); ?></td>
			<td><?php echo $paquete->pieza; ?></td>

			<?php if($paquete->id_proveedor==0){ ?>
				<td><?php echo $paquete->proveedor; ?></td>
			<?php }else{ ?>
				<td><?php echo $paquete->nombre_proveedor; ?></td>
			<?php } ?>

			<td><?php echo $paquete->nombre_currier; ?></td>
			<td><?php echo $paquete->tracking_eu; ?></td>
			<td><?php echo $paquete->tracking_garve; ?></td>
			<td><?php echo $paquete->cincho; ?></td>
			<td><?php echo $paquete->nombre.' '.$paquete->apellidos; ?></td>
			<td><?php echo $paquete->id_usuario; ?></td>
			<td><?php echo $paquete->nombre_tipo_paquete; ?></td>
			<td><?php echo $paquete->descripcion_producto; ?></td>
			<td><?php echo $paquete->peso; ?></td>
			<td><?php echo $paquete->largo; ?></td>
			<td><?php echo $paquete->ancho; ?></td>
			<td><?php echo $paquete->alto; ?></td>
			<td><?php echo $paquete->valor; ?></td>
			<td>
				<a href="<?php echo $conf['path_host_url'] ?>/miami/etiqueta/imprime_etiqueta.php?paquete=<?php echo $paquete->id_paquete; ?>&total=<?php echo $paquete->pieza;?>&barcode=<?php echo $paquete->tracking_garve;?>" target="_blank" class="button solid-color">Imprimir</a>
			</td>
		</tr>
		<tr>
			<td colspan="17"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php } ?>
	</table>

	<br/>
	Total de procesos: <?php echo count($sql_paquete); ?>
	
	<br/>
	<br/>
	Exportar
	<br/>
	<a href="reportes_excel/reporte_excel_paquetes_embarcados.php?fecha_inicio=<?php echo $_GET['fecha_inicio']; ?>&fecha_termino=<?php echo $_GET['fecha_termino']; ?>"><img src="<?php echo $conf['path_host_url'] ?>/img/excel.jpg" width="30" height="30"> Excel</a>

	<!-- Fin de contenido -->

</body>
</html>