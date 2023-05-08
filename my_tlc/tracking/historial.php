<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id=$_GET["paquete"];
	$id_cliente=$_SESSION['numero_cliente'];

	// Consulta el historial del paquete
	$db->prepare("SELECT 
			historial.fecha,
			estado.nombre_status,
			lugar.nombre_lugar
		FROM status_log AS historial
		INNER JOIN data_status AS estado ON estado.id_status=historial.id_tipo_status
		INNER JOIN data_lugar AS lugar ON lugar.id_lugar=historial.id_lugar
		WHERE id_paquete=:id 
		AND visible_cliente=1
		ORDER BY historial.fecha DESC
	");
	$db->execute(array(':id' => $id ));
	$sql_historial=$db->get_results();
	// Fin consulta historial del paquete

	// consulta datos del paquete
	$db->prepare("SELECT
			paquete.id_paquete,
			paquete.consignatario,
			paquete.tracking_eu,
			paquete.tracking_garve,
			paquete.numero_miami,

			paquete.currier,
			currier.nombre_currier,

			paquete.proveedor,
			paquete.valor,
			paquete.pieza,
			paquete.descripcion_producto,
			paquete.peso,
			paquete.status,

			paquete.id_proveedor,
			proveedor.nombre_proveedor,

			paquete.id_cargo,
			paquete.peso_volumen

		FROM paquete as paquete
		INNER JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
		INNER JOIN data_status AS estado ON estado.id_status=paquete.status
		LEFT JOIN data_currier AS currier ON currier.id_currier=paquete.currier
		LEFT JOIN data_proveedor AS proveedor ON proveedor.id_proveedor=paquete.id_proveedor
		WHERE paquete.id_paquete=:id
		AND paquete.id_usuario=:id_usu
		ORDER BY paquete.id_paquete ASC
	");
	$db->execute(array(':id' => $id, ':id_usu' => $id_cliente));

	$sql_paquete=$db->get_results();

	foreach ($sql_paquete as $key => $paquete) {
		$id_paquete=$paquete->id_paquete;
		$consignatario=$paquete->consignatario;
		$tracking_usa=$paquete->tracking_eu;
		$tracking_garve=$paquete->tracking_garve;
		$numero_miami=$paquete->numero_miami;
		$id_currier=$paquete->currier;
		$nombre_currier=$paquete->nombre_currier;
		$proveedor=$paquete->proveedor;
		$valor=$paquete->valor;
		$pieza=$paquete->pieza;
		$producto=$paquete->descripcion_producto;
		$peso=$paquete->peso;
		$status=$paquete->status;

		$id_proveedor=$paquete->id_proveedor;
		$nombre_proveedor=$paquete->nombre_proveedor;

		$id_cargo=$paquete->id_cargo;
		$peso_volumen=$paquete->peso_volumen;
	}
	// fin consulta datos del paquete

	if(empty($sql_paquete)){
		die("No hay informaci¨®n disponible");
	}

	// consulta los archivos de comprobante
	$db->prepare("SELECT
			id_comprobante,
			nombre_comprobante,
			extension,
			eliminado
		FROM comprobante_compra
		WHERE id_paquete=:id
		AND eliminado=0
		ORDER BY id_comprobante ASC
	");
	$db->execute(array(':id' => $id));
	$sql_comprobantes=$db->get_results();
	// Fin consulta archivos de comprobantes

	// consulta los cargos del paquete
	$db->prepare("SELECT * FROM cargos WHERE guia=:guia AND eliminado=0 ORDER BY id_cargo DESC ");
	$db->execute(array(':guia' => $tracking_garve));
	$sql_cargos=$db->get_results();

?>

<!DOCTYPE html>
<html lang="es">

	<!-- HEAD-->
	<?php require $conf['path_host'].'/include/include_head.php'; ?>	
	<!--FIN HEAD-->

	<!-- java scripts -->
	<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
	<!-- fin java scripts-->

	<!-- Fin Validaciones -->
	<script type="text/javascript">
		$(document).ready(function(){

			// oculta los formularios de comprobante
			for(i=1; i<10; i++){
				$(".comprobante".concat(i)).hide();
			}
			// fin ocultar botones

			// agrega comprobante
			cont=0;
			for(j=0; j<10; j++){
				$("#agregar_comprobante".concat(j)).click(function(){
						cont=cont+1;
					$(".comprobante".concat(cont)).show();
				});
			}
			// fin agregar comprobante

			// elimina comprobante
			$("#eliminar_comprobante").click(function(){
				if(cont!=0){
					$(".comprobante".concat(cont)).hide();
					cont=cont-1;
				}
					
			});
			// fin eliina comprobante
			

			$("#enviar").click(function(){
				
				$("#cantidad_comprobantes").val(cont+1);

				document.comprobante.submit();
			});

		});
	</script>
	<!-- Fin Script -->
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
        		    <div class="col-lg-12">

                		<!-- registro de prealertas -->	
                		<center>
                			<h3>Si realizas una compra av&iacute;sanos que el paquete viene en camino para realizar una entrega m&aacute;s r&aacute;pida</h3>
                			<a href="<?= $conf['path_host_url'] ?>/prealerta/prealerta.php" class="button solid-color">PREALERTAR</a>
                		</center>
                		<!-- Fin prealerta -->
                		
                	</div>
                </div>

                <hr>

                <div class="row">
        		    <div class="col-lg-12">
                		<!-- inicio datos cliente -->
                		<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
                		<!-- Fin datos cliente -->
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
        		    <div class="col-lg-6">
		
                		<div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Seguimiento del paquete</h3>
                            </div>
                            <div class="panel-body">

                        		<table class="table">
                        		    <thead>
                            			<tr>
                            				<th>Fecha</th>
                            				<th>Detalle</th>
                            				<th>Lugar</th>
                            			</tr>
                        			</thead>
                        			<tbody>
                        			<?php $x=1; foreach ($sql_historial as $key => $historial) {  ?>
                        				<tr>
                        					<td><?= $historial->fecha; ?></td>
                        					<td><?= $historial->nombre_status; ?></td>
                        					<td><?= $historial->nombre_lugar; ?></td>
                        				</tr>
                        			<?php } ?>
                        			</tbody>
                        		</table>
                        		
                        	</div>
                        </div>
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Cargos del paquete</h3>
                            </div>
                            <div class="panel-body">

                        		<?php if(empty($sql_cargos)){ ?>
                        			<center><h4>No se han ingresado cargos asociados</h4></center>
                        		<?php }else{
                        		
                        		
                        		
                        		?>
                        			<table class="table">
                        			    <thead>
                                			<tr>
                                				<th>Descripci&oacute;n</th>
                                				<th>Total (Pesos)</th>
                                				<th>Fecha</th>
                                			</tr>
                            			</thead>
                        				<tbody>
                                			<?php
                                			$acumuladorCargos=0;
                                			foreach ($sql_cargos as $key => $cargo) { 
                                			?>
                                				
                        					<tr>
                        						<td align="left"><?= $cargo->descripcion ?></td>
                        						<td>
                        							<?= $cargo->total_pesos ?>
                        						</td>
                        						<td>
                        							<?= $cargo->fecha ?>
                        						</td>
                        					</tr>
                                				
                                			<?php 
                                			$acumuladorCargos=$cargo->total_pesos+$acumuladorCargos;
                                			
                                			} ?>
                                			
                                			<tr>
                        						<td align="left"><b>Total</b></td>
                        						<td>
                        							<b><?= $acumuladorCargos ?></b>
                        						</td>
                        						<td>
                        							<b><?= date('Y-m-d H:i:s'); ?></b>
                        						</td>
                        					</tr>
                                			
                                		</tbody>
                        		
                        			</table>
                        		<?php } ?>
                            </div>
                        </div>
        		    </div>
        		    
        		    <div class="col-lg-6">
        		        
        		        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Detalles del paquete</h3>
                            </div>
                            <div class="panel-body">

                        		<table class="table">
                        			<tr align="left">
                        				<td><b>TLC Tracking</b></td>
                        				<?php if(!empty($tracking_garve)){ ?>
                        					<td>: <?= $tracking_garve; ?></td>
                        				<?php }else{ ?>
                        					<td>: <?= $numero_miami; ?></td>
                        				<?php } ?>
                        			</tr>
                        			<tr align="left">
                        				<td><b>Consignatario</b></td>
                        				<td>: <?= $consignatario; ?></td>
                        			</tr>
                        			<tr align="left">
                        				<td><b>N&deg; Tracking USA</b></td>
                        				<td>: <?= $tracking_usa; ?></td>
                        			</tr>
                        			<tr align="left">
                        				<td><b>Compa&ntilde;ia Currier</b></td>
                        				<td>: <?= $nombre_currier; ?></td>
                        			</tr>
                        
                        			<?php if($id_proveedor==11){ ?>
                        				<tr align="left">
                        					<td><b>Tienda</b></td>
                        					<td>: <?= $proveedor; ?></td>
                        				</tr>
                        			<?php }elseif($id_proveedor==0){ ?>
                        				<tr align="left">
                        					<td><b>Tienda</b></td>
                        					<td>: <?= $proveedor; ?></td>
                        				</tr>
                        			<?php }else{ ?>
                        				<tr align="left">
                        					<td><b>Tienda</b></td>
                        					<td>: <?= $nombre_proveedor; ?></td>
                        				</tr>
                        			<?php } ?>
                        
                        			<tr align="left">
                        				<td><b>Valor del paquete(USD)</b></td>
                        				<td>: <?= $valor; ?></td>
                        			</tr>
                        			<tr align="left">
                        				<td><b>Describe tu paquete</b></td>
                        				<td>: <?= $producto; ?></td>
                        			</tr>
                        			<tr align="left">
                        				<td><b>NÂ° de piezas</b></td>
                        				<td>: <?= $pieza; ?></td>
                        			</tr>
                        			<tr align="left">
                        				<td><b>Peso (KG)</b></td>
                        				<td>: <?= $peso; ?></td>
                        			</tr>
                        			<tr align="left">
                        				<td><b>Peso volumetrico (KG/VOL)</b></td>
                        				<td>: <?= $peso_volumen; ?></td>
                        			</tr>
                        		</table>
                		
                		
                		    </div>
        		    
        		        </div>
                		
        		    </div>
        		    
        		</div>
        		
        		<div class="row">
        		    
        		    
        		    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Facturas o comprobantes de compra del paquete</h3>
                        </div>
                        <div class="panel-body">
        		    
                    	    <div class="col-lg-6">
            
                                <fieldset>
		                            
		                            <legend class="text-center">
		                                Lista de Facturas del Paquete
		                            </legend>

                            		<?php if (!empty($sql_comprobantes)) { ?>
                            			<table class="table">
                            			    <thead>
                                    			<tr>
                                    				<th>Archivo</th>
                                    				<th colspan="2" class="text-center">Acciones</th>
                                    			</tr>
                                    		</thead>
                                    		<tbody>
                                    			<?php foreach ($sql_comprobantes as $key => $comprobantes) { ?>
                                    				<?php if($comprobantes->extension==1){ ?>
                                    					<tr>
                                    						<td align="left"><?= $comprobantes->nombre_comprobante; ?></td>
                                    						<td>
                                    							<a target="_blanck" href="<?= $conf['path_host_url'] ?>/gestor_archivos.php?envio=<?= $id_paquete; ?>&usu=<?= $id_cliente; ?>&nombre=<?= $comprobantes->nombre_comprobante; ?>&accion=1">Ver</a>
                                    						</td>
                                    						<td>
                                    							<a href="<?= $conf['path_host_url'] ?>/tracking/eliminar_comprobante.php?id_comprobante=<?= $comprobantes->id_comprobante; ?>&nombre=<?= $comprobantes->nombre_comprobante; ?>&paquete=<?= $id_paquete; ?>">Eliminar</a>
                                    						</td>
                                    					</tr>
                                    				<?php }else{ ?>
                                    					<tr>
                                    						<td align="left"><?= $comprobantes->nombre_comprobante; ?></td>
                                    						<td>
                                    							<a target="_blanck" href="<?= $conf['path_host_url'] ?>/gestor_archivos.php?envio=<?= $id_paquete; ?>&usu=<?= $id_cliente; ?>&nombre=<?= $comprobantes->nombre_comprobante; ?>&accion=2">Descargar</a>
                                    						</td>
                                    						<td>
                                    							<a href="<?= $conf['path_host_url'] ?>/tracking/eliminar_comprobante.php?id_comprobante=<?= $comprobantes->id_comprobante; ?>&nombre=<?= $comprobantes->nombre_comprobante; ?>&paquete=<?= $id_paquete; ?>">Eliminar</a>
                                    						</td>
                                    					</tr>
                                    				<?php } ?>
                                    			<?php } ?>
                                    		</tbody>
                                    	    
                            			</table>
                            		<?php }else{ ?>
                            			<table class="table">
                            				<tr>
                            					<td><center><h4>No se han ingresado facturas o comprobantes de compra</h4></center></td>
                            				</tr>
                            			</table>
                            		<?php } ?>
                        		
                        		<fieldset>
                        		
                        	</div>
                        	
                        	<div class="col-lg-6">
        
                        		<?php if($status!=6 && $status!=8){ ?>
        
                                 <fieldset>
		                            
		                            <legend class="text-center">
		                                A&ntilde;ade la factura o comprobante de compra
		                            </legend>

                    			<form id="comprobante" name="comprobante" action="subir_comprobante.php" method="post" enctype="multipart/form-data">
                    			    
                    			     <div class="form-group">
                                        <label for="comprobante"><b>Comprobante o factura</b></label>
                                        <input type="file" name="comprobante" id="comprobante"/><br>
                                      </div>
                                      <div class="form-group">
                                        <label for="valorFactura"><b>Valor total compra USD</b></label>
                    				    <input type="text" class="form-control" style="width:100%;" placeholder="Incluye valor producto + shipping + tax" name="valorFactura" id="valorFactura"/>
                                      </div>
                                      
                                      <input type="hidden" id="id_paquete" name="id_paquete" value="<?= $id_paquete; ?>">
                    			    
                    			</form>

                    			<!-- fin campos hidden -->
                                <center><input type="button" class="button solid-color" name="enviar" id="enviar" value="Guardar Comprobante"></center></td>
                    				
                    		    <?php } ?>
                        		<!-- Fin de contenido -->
                        
                        		<?php if($status==1){ ?>
                        			<br><br>
                        			<center>
                        				<a href="cancelar_paquete.php?id_paquete=<?= $id_paquete; ?>" class="button solid-color">CANCELAR PEDIDO</a>
                        			</center>
                        		<?php } ?>
                        	
                        	</div>
            	
                    	</div>
                    </div>
                	
                </div>
                	
                <div class="row">
        		    <div class="col-lg-12">
                		<center><a href="tracking.php" class="button solid-color">VOLVER</a></center>
                    </div>
                </div>
                
                <br>
                <br>
                <br>
                <br>
                		
		    </div>
		</div>

		<!-- INCLUDE FOOTER-->
		<?php require $conf['path_host'].'/include/include_footer.php'; ?>
		<!--FIN FOOTER-->  
		
	</body>

</html>