<?php 
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	require $conf['path_host'].'/include/detecta_pantalla.php';

	$id_usu=$_SESSION['numero_cliente'];

	$db->prepare("SELECT
			paquete.id_paquete,
		    paquete.descripcion_producto,
		    paquete.tracking_garve,
		    paquete.tracking_eu,
		    paquete.numero_miami,
		    
		    data_status.nombre_status,
		    paquete.status,
		    
		    paquete.fecha_registro,
		    
		    consolidado.codigo_consolidado,
		    consolidado.id_consolidado,
		    
		    factura.nombre_comprobante,
		    
		    status_log.fecha,
		    paquete.fecha_procesado_miami
	    
		FROM paquete 
		INNER JOIN data_status ON data_status.id_status=paquete.status
	    LEFT JOIN status_log ON (status_log.id_paquete=paquete.id_paquete AND status_log.id_tipo_status=paquete.status)
	    LEFT JOIN comprobante_compra AS factura ON factura.id_paquete=paquete.id_paquete AND factura.eliminado=0
	    LEFT JOIN consolidado ON (paquete.id_consolidado = consolidado.id_consolidado)
		WHERE paquete.id_usuario=:id_usu
		AND (paquete.status!=6 AND paquete.status!=16)
		AND paquete.cancelado=0
		AND paquete.eliminado=0
		GROUP BY paquete.id_paquete
		ORDER BY paquete.id_paquete DESC
	");
	$db->execute(array(':id_usu' => $id_usu ));
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

<script type="text/javascript">
	$(document).ready(function(){
		$('table').DataTable();
	});
</script>

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
<!--menu-->


<!--Inicio Contenido -->

    <div class="container-fluid">
        
        <div class="container">
			<div class="row">
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    
                    <h4>INFORMACIÓN IMPORTANTE</h4> </br>
                    <h5>Exoneración de impuestos para importaciones de hasta USD$41</h5>
                    Debe subir subir la factura/invoice de su paquetes antes de que este sea embarcado a Chile, sino las Aduanas de Chile se reserva el derecho de aplicar está exoneración de impuestos. En el caso que el cliente reciba varias guías en el mismo vuelo, el beneficio aplicará únicamente en el caso que la suma de los valores declarados de todos los paquetes sea igual o inferior a <b>USD$41</b>.</br>
                    Esto con el fin de evitar retenciones de sus paquetes. </br>
                    En el caso que no se enlace su pre alerta con una guía ingresada en Miami, nuestro personal de TLC la anexara por usted. </br>
                    Atte. </br>
                    <b>TLC Courier SpA</b>
                </div>
            </div>
            
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4>PROCESO PARA CONSOLIDACIÓN</h4> </br>
                    En caso que envie mas de 1 bulto por Tracking Number y que correspondan a la misma Factura/Invoice debe <b>CONSOLIDAR</b> para evitar problemas con aduana. Para ello debe enviar un correo a 
                    <b>contacto@tlccourier.cl</b> indicando los Tracking Number que vienen a su nombre y cuales desea consolidar, el correo debe tener como asunto <b>"CONSOLIDADO USUARIO TLC-Nº Cliente"</b>
                    (Ejemplo: CONSOLIDADO USUARIO TLC-0004)
                    </br>
                    <b>TLC Courier SpA</b>
                </div>
            </div>
            
            	<!-- registro de prealertas -->	
            <div class="row">
            	<center>
            		<h3>Si realizas una compra av&iacute;sanos que el paquete viene en camino para realizar una entrega m&aacute;s r&aacute;pida</h3>
            		<a href="<?= $conf['path_host_url'] ?>/prealerta/prealerta.php" class="button solid-color">PREALERTAR</a>
            	</center>
            </div>
            	<!-- Fin prealerta -->
            
            	<!-- inicio datos cliente -->
            <div class="row">
            	<p>&nbsp;</p>
            	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
            	<p>&nbsp;</p>
            </div>
            	<!-- Fin datos cliente -->
            	
            <div class="row">
            	<h2>PAQUETES REGISTRADOS</h2>	
            
            	<!-- tabla de datos -->
            	<?php if(empty($sql_paquete)){ ?>
            		<center><h2>No tiene paquetes en transito</h2></center>
            	<?php }else{ ?>
            
            		<?php if($msg_tabla==1 || $navegador==7){ ?>
            			<center>
            				<div id="aviso2">
            					Para visualizar la informaci&oacute;n completa del paquete presiona sobre el numerador. EJ N째1.
            				</div>
            			</center>
            			<br><br>
            		<?php } ?>
                <link
                  rel="stylesheet"
                  href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css"
                >
            </div>
        </div>
    
    </div>
    
    <div class="container-fluid">
    
		<div class="container">
			<div class="row">
			    
			    <div class="row">
			        <div class="btn-group" role="group" aria-label="...">
			            
			            <?php if($_SESSION["tipo_usuario"]==2 || $_SESSION["tipo_usuario"]==1){ ?>
    
                        <a type="button" href="<?= $conf['path_host_url'] ?>/tracking/lista_paquetes_consolidar.php" class="btn btn-default">
                          Consolidar paquetes
                        </a>
                        
                        <?php } ?>
                    </div>
    		    </div>
    		    
    		    <hr/>
			    
				<div class="col-xs-12">
				    <div class="table-responsive-sm">
    					<table class="table table-sm table-bordered table-hover dt-responsive">
    						<thead>
    							<tr>
    								<th>N&deg;</th>
    								<th>Descripci&oacute;n</th>
    								<th>Tracking TLC</th>
    								<th>Tracking USA</th>
    								<th>Estado</th>
    								<th>Fecha</th>
    								<th>Factura</th>
    								<th>Cod. Consolidado</th>
    								<th>Acci&oacute;n</th>
    								<?php //if($msg_tabla==1 || $navegador==7){ ?>
    									<!--<th></th>-->
    								<?php //} ?>
    							</tr>
    						</thead>
    						<tbody>
    							<?php $x=1; foreach ($sql_paquete as $key => $paquete) { 
    							    $existeFactura=$paquete->nombre_comprobante?"<span style='color: crimson;'>Si</span>":"<span>No</span>";
    							
    							?>
    								<tr>
    									<td>
    									    <?= $x; ?>
    									</td>
    									<td>
    									    <?= $paquete->descripcion_producto; ?>
    									</td>
    									    <?php if(!empty($paquete->numero_miami)){ ?>
    									<td>
    									    <a href="historial.php?paquete=<?= $paquete->id_paquete; ?>" title="Ver detalle del paquete">
    									        <?= $paquete->numero_miami; ?>
    									    </a>
    									</td>
    									    <?php }else{ ?>
    									<td>
    									    <a href="historial.php?paquete=<?= $paquete->id_paquete; ?>" title="Ver detalle del paquete">
    									        <?= $paquete->tracking_garve; ?>
    									    </a>
    									</td>
    									    <?php } ?>
    									<td>
    									    <?= $paquete->tracking_eu; ?>
    									</td>
    
    									<?php if($paquete->status==3 && $paquete->fecha==''){ ?>
    									<td>
    									    Recibido en Miami
    									</td>
    									<td>
    									    <?= date("d/m/Y H:m:s",strtotime($paquete->fecha_procesado_miami)); ?>
    									</td>
    									<?php }else{ ?>
    									<td>
    									    <?= $paquete->nombre_status; ?>
    									</td>
    									<td>
    									    <?= date("d/m/Y H:m:s",strtotime($paquete->fecha)); ?>
    									</td>
    									<?php } ?>
                                        <td>
                                            <?=$existeFactura?>
                                        </td>
                                        <td>
                                        <?php
                                        if ($paquete->codigo_consolidado!=''){
                                            $codigoConsolidado=$paquete->codigo_consolidado;
                                            ?>
                                            
                                            <a type="button" href="<?= $conf['path_host_url'] ?>/tracking/consolidado/detalles_consolidado.php?id_consolidado=<?= $paquete->id_consolidado ?>" title="Ver detalle del consolidado">
                                                <?= $codigoConsolidado ?>
                                            </a>
                                        
                                        <?php
                                        }else{
                                            $codigoConsolidado="No consolidado";
                                            echo $codigoConsolidado;
                                        }
                                        ?>
                                        
                                        </td>
    									<td>
    									    <a href="historial.php?paquete=<?= $paquete->id_paquete; ?>" title="Detalle" class="button solid-color" style="padding:5px;">Detalle</a>
    									</td>
    									<?php //if($msg_tabla==1 || $navegador==7){ ?>
    									<!--<td></td>-->
    								<?php //} ?>
    								</tr>
    							<?php $x++; } ?>
    						</tbody>
    					</table>
    					
					</div>
				</div>
			</div>
		</div>
		</div>
	<?php } ?>
	<!-- fin tabla de datos -->

	<br><br><br><br>



</body>

</html>