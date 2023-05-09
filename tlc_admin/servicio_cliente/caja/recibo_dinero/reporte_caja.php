<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$fecha_inicio=$_GET['fecha_inicio'];
    $fecha_fin=$_GET['fecha_termino'];
    
	$db->prepare("SELECT
			tran.id_transaccion,
			tran.numero_recibo,
			tran.id_tipo_transaccion,
			tipo_tran.nombre_transaccion,
		    pago.tipo_pago,
		    
		    detalle.monto,
		    detalle.monto_pagado,
		    detalle.vuelto,

		    detalle.numero_documento,

		    tran.fecha

		FROM transaccion AS tran
		LEFT JOIN transaccion_detalle AS detalle ON detalle.id_transaccion=tran.id_transaccion
		INNER JOIN data_tipo_transaccion AS tipo_tran ON tipo_tran.id_tipo_transaccion=tran.id_tipo_transaccion
		LEFT JOIN data_tipo_pago AS pago ON pago.id_tipo_pago=detalle.id_tipo_pago

		WHERE date(tran.fecha) BETWEEN :inicio AND :fin
		AND (tran.id_tipo_transaccion=4 OR tran.id_tipo_transaccion=7 OR tran.id_tipo_transaccion=8)
		AND tran.status=1
		GROUP BY tran.numero_recibo
		ORDER BY tran.fecha ASC
	");
	$db->execute(array( 
		':inicio' => $fecha_inicio, 
		':fin' => $fecha_fin
	));
	$sqlPago=$db->get_results();
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
			<p>Muestra todos los paquetes que han sido entregados y no registran un pago.</p>
		</div>
	</center>

	<br>
	<br>

	<table>
		<tr>
			<td>#</td>
			<td>Numero Recibo</td>
			<td>Transacción</td>
			<td>Fecha</td>
		</tr>
		<tr>
			<td colspan="14"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php $x=1; foreach ($sqlPago as $key => $paquete) {  ?>
			<tr>
				<td><?php echo $x; ?></td>
				<td><?php echo $paquete->numero_recibo; ?></td>
				<td><?php echo $paquete->nombre_transaccion; ?></td>
				<td><?php echo date("d/m/Y H:i:s",strtotime($paquete->fecha)); ?></td>
				<td>
					<?php if($paquete->id_tipo_transaccion==4){ ?>
						<a href="<?php echo $conf['path_host_url'] ?>/servicio_cliente/caja/recibo_dinero/recibo_dinero_pdf.php?num_recibo=<?php echo $paquete->id_transaccion ?>" target="_blank" class="button solid-color">Imprimir recibo</a>
					<?php }elseif($paquete->id_tipo_transaccion==7){ ?>
						<a href="<?php echo $conf['path_host_url'] ?>/servicio_cliente/caja/recibo_dinero/recibo_dinero_sin_pago_pdf.php?num_recibo=<?php echo $paquete->id_transaccion ?>" target="_blank" class="button solid-color">Imprimir recibo</a>
					<?php }elseif($paquete->id_tipo_transaccion==8){ ?>
						<a href="<?php echo $conf['path_host_url'] ?>/servicio_cliente/caja/recibo_dinero/recibo_dinero_pago_sin_entrega_pdf.php?num_recibo=<?php echo $paquete->id_transaccion ?>" target="_blank" class="button solid-color">Imprimir recibo</a>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td colspan="14"><hr size="1" color="#FF6600" /></td>
			</tr>
		<?php $x++; } ?>
	</table>

	<!-- Fin de contenido -->

</body>
</html>