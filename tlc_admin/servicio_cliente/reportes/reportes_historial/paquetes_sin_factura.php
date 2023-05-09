<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
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
            paquete.peso,
            paquete.valor,

            paquete.id_proveedor,

			proveedor.nombre_proveedor,
			factura.nombre_comprobante

		FROM paquete AS paquete
		LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
        INNER JOIN status_log AS historial ON historial.id_paquete=paquete.id_paquete
        INNER JOIN data_currier AS currier ON currier.id_currier=paquete.currier
        LEFT JOIN data_proveedor AS proveedor ON proveedor.id_proveedor=paquete.id_proveedor
        LEFT JOIN comprobante_compra AS factura ON factura.id_paquete=paquete.id_paquete AND factura.eliminado=0
		WHERE historial.id_tipo_status in (4, 19)
        AND date(historial.fecha) BETWEEN :inicio AND :fin
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
	<br>
	
	<div class="container-fluid">
		<div class="container">
			<div class="row">
		        <div id="sesion">
        			<p>Muestra todos los paquetes que se encuentran sin Factura en el counter de TLC.</p>
        		</div>
		    </div>
    		<hr/>
			<div class="row">    
				<div class="col-xs-12">
				    <div class="table-responsive-sm">
	
    					<table class="table table-sm table-bordered table-hover dt-responsive">
    						<thead>
    							<tr>
    								<th>N&deg;</th>
    								<th>Proveedor</th>
    								<th>Courrier TLC</th>
    								<th>Tracking USA</th>
    								<th>Tracking Garve</th>
    								<th>Nombre del Cliente</th>
    								<th>CHI</th>
    								<th>Descripci&oacute;n</th>
    								<th>Peso (KG)</th>
    								<th>Valor (USD)</th>
    								<th>Fecha</th>
    								<?php //if($msg_tabla==1 || $navegador==7){ ?>
    									<!--<th></th>-->
    								<?php //} ?>
    							</tr>
    						</thead>
    						<tbody>
    							<?php $x=1; foreach ($sql_paquete as $key => $paquete) { 
    							    $existeFactura=$paquete->nombre_comprobante?"<span style='color: crimson;'>Si</span>":"<span>No</span>";
    							    
    							?>
    							    <?php if(!$paquete->nombre_comprobante){ ?>
    							        <tr>
        									<td>
        									    <?= $x; ?>
        									</td>
        									    <?php if(!empty($paquete->id_proveedor) || $paquete->id_proveedor == 0){ ?>
        									<td>
        									    <?php echo $paquete->proveedor; ?>
        									</td>
        									    <?php }else{ ?>
        									<td>
        									    <?php echo $paquete->nombre_proveedor; ?>
        									</td>
        									    <?php } ?>
        									<td>
        									    <?= $paquete->nombre_currier; ?>
        									</td>
        									<td>
        									    <?= $paquete->tracking_eu; ?>
        									</td>
                                            <td>
        									    <?= $paquete->tracking_garve; ?>
        									</td>
        									<td>
        									    <?= $paquete->nombre.' '.$paquete->apellidos; ?>
        									</td>
        									<td>
        									    <?= $paquete->id_usuario; ?>
        									</td>
        									<td>
        									    <?= $paquete->descripcion_producto; ?>
        									</td>
        									<td><?php echo $paquete->peso; ?></td>
    				                        <td><?php echo $paquete->valor; ?></td>
        									<td>
        									    <?= date("d/m/Y H:m:s",strtotime($paquete->fecha)); ?>
        									</td>
        									<td>
                                                <?=$existeFactura?>
                                            </td>
        									<td>
        									    <a target="_blank" href="../../../../my_tlc/tracking/historial.php?paquete=<?= $paquete->id_paquete; ?>" title="Detalle" class="button solid-color" style="padding:5px;">Detalle</a>
        									</td>
        									<?php //if($msg_tabla==1 || $navegador==7){ ?>
        									<!--<td></td>-->
        								    <?php //} ?>
        								</tr>
    							    <?php } ?>
    							<?php $x++; } ?>
    						</tbody>
    					</table>
    					
					</div>
				</div>
			</div>
		</div>
		</div>
	<br/>
	Total de registros: <?php echo count($sql_paquete); ?>
	
	<br/>
	<br/>
	Exportar
	<br/>
	<a href="reportes_excel/reporte_excel_paquetes_sin_factura.php?fecha_inicio=<?php echo $_GET['fecha_inicio']; ?>&fecha_termino=<?php echo $_GET['fecha_termino']; ?>"><img src="<?php echo $conf['path_host_url'] ?>/img/excel.jpg" width="30" height="30"> Excel</a>

	<!-- Fin de contenido -->

</body>
</html>