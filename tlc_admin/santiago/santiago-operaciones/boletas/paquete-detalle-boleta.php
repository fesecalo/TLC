<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
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
		die("No hay informaciŦn disponible");
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
	$db->prepare("SELECT * FROM cargos WHERE id_cargo=:id_cargo AND eliminado=0 ORDER BY id_cargo DESC LIMIT 1");
	$db->execute(array(':id_cargo' => $id_cargo));
	$sql_cargos=$db->get_results();
	
	foreach ($sql_cargos as $key => $cargos) {
		$aduana=$cargos->aduana;
		$flete=$cargos->flete;
		$manejo=$cargos->manejo;
		$proteccion=$cargos->proteccion;
		$total=$cargos->total;
	}
	// fin consulta de cargos del paquete
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

			// oculta los formulariosFacturas o comprobantes de compra del paquete
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
                			<h1>Detalle del paquete</h1>
                		</center>
                		<!-- Fin prealerta -->
                		
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
                        			<table class="table">
                        				<tr>
                        					<td><center><h4>No se han ingresado cargos asociados</h4></center></td>
                        				</tr>
                        			</table>
                        		<?php }else{ ?>
                        			<table class="table">
                        				<tr>
                        					<td align="left">Aduana :</td>
                        					<td align="right">$ <?= $aduana; ?></td>
                        				</tr>
                        				<tr>
                        					<td align="left">Flete :</td>
                        					<td align="right">$ <?= $flete; ?></td>
                        				</tr>
                        				<tr>
                        					<td align="left">Manejo :</td>
                        					<td align="right">$ <?= $manejo; ?></td>
                        				</tr>
                        				<tr>
                        					<td align="left">Protecci&oacute;n :</td>
                        					<td align="right">$ <?= $proteccion; ?></td>
                        				</tr>
                        				<tr>
                        					<td align="left">Total :</td>
                        					<td align="right">$ <?= $total; ?></td>
                        				</tr>
                        			</table>
                        		<?php } ?>
                            </div>
                        </div>
        		    </div>
        		    
        		    <div class="col-lg-6">
        		        
        		        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Paquete</h3>
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
                        				<td><b>Valor del paquete (USD)</b></td>
                        				<td>: <?= $valor; ?></td>
                        			</tr>
                        			<tr align="left">
                        				<td><b>Describe tu paquete</b></td>
                        				<td>: <?= $producto; ?></td>
                        			</tr>
                        			<tr align="left">
                        				<td><b>N째 de piezas</b></td>
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
        		    
        		    <div class="col-lg-6">
        		    
            		    <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Facturas o comprobantes de compra del paquete</h3>
                            </div>
                            <div class="panel-body">
            		    
                        	    <div class="col-lg-12">
                
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
                            	
                        	</div>
                        </div>
                    
                    </div>
                    
                    
                    
                    
                    
                    
                    
                	
                </div>
                	
                
                <div class="row"> 
                    <div class="col-lg-12">
        		    
            		    <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Formulario para boleta electrónica</h3>
                            </div>
                            <div class="panel-body">
            		    
            		    
            		            <form>
            		                
            		                
            		                <div class="col-lg-12">
            		                
                            	        <div class="row">
                    
                                            <fieldset>
            		                            
                                                <legend class="text-center">
        		                                    Detalles del Documento
        		                                </legend>
                                                
                                                <div class="col-lg-3">
                                                    
                                                    <div class="form-group">
                                                        <label for="descripcion">Descripci&oacute;n (Producto)</label>
                                                        <input type="text" class="form-control" value="<?= $producto; ?>" id="descripcion" readonly placeholder="Producto">
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="cantidad">Cantidad</label>
                                                        <input type="text" class="form-control" value="1" id="cantidad" readonly placeholder="Cantidad">
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="precio">Precio</label>
                                                        <input type="text" class="form-control" value="<?= $valor; ?>" id="precio" readonly placeholder="Precio">
                                                    </div>
                                                    
                                                </div>    
                                                <div class="col-lg-3">
                                                    
                                                    <div class="form-group" style="margin-bottom: 40px;"class="checkbox">
                                                        <label>
                                                            Exento
                                                        </label>
                                                        <input type="checkbox" value"true"> Exento
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="montoItem">Monto Item</label>
                                                        <input type="text" class="form-control" value="<?= $valor; ?>" id="montoItem" readonly placeholder="Monto Item">
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="fechaProducto">Fecha Producto</label>
                                                        <input type="date" class="form-control" value="<?=date('d/m/Y');?>" id="fechaProducto" readonly placeholder="">
                                                    </div>   
                                                
                                                </div>
                                                
                                                <div class="col-lg-3">
    
                                                    <div class="form-group">
                                                        <label for="codigoProducto">Codigo del Producto</label>
                                                        <input type="text" class="form-control" value="<?= !empty($tracking_garve) ? $tracking_garve :  $numero_miami;?>" id="codigoProducto" readonly placeholder="Código Producto">
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="descuentoPorcentaje">Porcentaje de descuento</label>
                                                        <input type="number" class="form-control" value="0" id="descuentoPorcentaje" readonly placeholder="% de descuento">
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="montoDescuento">Monto Descuento</label>
                                                        <input type="text" class="form-control" value="0" id="montoDescuento" readonly placeholder="Monto del descuento">
                                                    </div>
                                                    
                                                </div>    
                                                <div class="col-lg-3">
                                                    
                                                    <div class="form-group">
                                                        <label for="documento">Documento</label>
                                                        <input type="text" class="form-control" value="null" id="documento" readonly placeholder="Documento">
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="totalLinea">Total línea</label>
                                                        <input type="text" class="form-control" value="0" id="totalLinea" readonly placeholder="Total Linea">
                                                    </div>
                                                    
                                                    
                                                
                                                </div>
                                                
                                    		<fieldset>
                                    		
                                    	</div>
                                	
                                	</div>
                                	
                                	
                                	
                                	<div class="col-lg-12">
                                	    
                                	    
                                	    <div class="row">
                                	
                                        	<div class="col-lg-6">
                        
                                                <fieldset>
                		                            
                                                    <legend class="text-center">
            		                                    Empresa
            		                                </legend>
                                                    
                                                    <div class="col-lg-6">
                                                    
                                                        <div class="form-group">
                                                            <label for="DocumentoId">Identificador de Documento</label>
                                                            <input type="text" class="form-control" value="0" id="DocumentoId" readonly placeholder="Identificador del documento">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="OrigenId">Identificador Origen</label>
                                                            <input type="text" class="form-control" value="1" id="OrigenId" readonly placeholder="Identificador Origen">
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="col-lg-6">
                                                        
                                                        <div class="form-group">
                                                            <label for="TipoDte">Tipo DTE</label>
                                                            <select id="TipoDte" class="form-control" style="margin-bottom: 25px;">
                                                                <option value="33" selected> xxxx No se que opcione es xxxx </option>
                                                                <option value="34" >Factura no afecta o exenta Electrónica</option>
                                                                <option value="39">Boleta Electrónica</option>
                                                                <option value="43">Boleta Exenta Electrónica</option>
                                                                <option value="46">Liquidación Factura Electrónica</option>
                                                                <option value="52">Guía de Despacho Electrónica</option>
                                                                <option value="56">Nota de débito Electrónica</option>
                                                                <option value="61">Nota de credito Electrónica</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="TipoOperacion">Tipo de Operación</label>
                                                            <select id="TipoOperacion" class="form-control" readonly disabled title="Tipo de operación" style="margin-bottom: 25px;">
                                                                <option value="1">Compra</option>
                                                                <option value="2" selected>Venta</option>
                                                            </select>
                                                        </div>
        
                                                    </div>
        
                                        		<fieldset>
                                        		
                                        	</div>
                                        	
                                        	<div class="col-lg-6">
                        
                                                <fieldset>
                		                            
                                                    <legend class="text-center">
            		                                    Receptor
            		                                </legend>
                                                    
                                                    
                                                    <div class="col-lg-3">
                                                    
                                                        <div class="form-group">
                                                            <label for="Rut">RUT</label>
                                                            <input type="text" class="form-control" value="15327740-0" id="Rut" readonly placeholder="Rut">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="RazonSocial">RazonSocial</label>
                                                            <input type="text" class="form-control" value="Ruben Vieira" id="RazonSocial" readonly placeholder="Razón Social">
                                                        </div>
                                                        
                                                    </div>    
                                                    <div class="col-lg-3">
                                                        
                                                        <div class="form-group">
                                                            <label for="Giro">Giro</label>
                                                            <input type="text" class="form-control" value="Desarrollador" id="Giro" readonly placeholder="Giro">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="Direccion">Dirección</label>
                                                            <input type="text" class="form-control" value="Isla Carolina" id="Direccion" readonly placeholder="Dirección">
                                                        </div>
                                                    
                                                    </div>
                                                    
                                                    <div class="col-lg-3">
                                                    
                                                        <div class="form-group">
                                                            <label for="Comuna">Comuna</label>
                                                            <input type="text" class="form-control" value="Maipu" id="Comuna" readonly placeholder="Comuna">
                                                        </div>
            
                                                        <div class="form-group">
                                                            <label for="Ciudad">Ciudad</label>
                                                            <input type="text" class="form-control" value="Santiago" id="Ciudad" readonly placeholder="Ciudad">
                                                        </div>
                                                    
                                                    </div>    
                                                    <div class="col-lg-3">
            
                                                        <div class="form-group">
                                                            <label for="Telefono">Tel&eacute;fono</label>
                                                            <input type="text" class="form-control" value="978541133" id="Telefono" readonly placeholder="Telefono">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="Correo">Correo</label>
                                                            <input type="text" class="form-control" value="" id="Correo" readonly placeholder="Correo">
                                                        </div>
                                                    
                                                    </div>
                                                    
        
                                        		<fieldset>
                                        		
                                        	</div>
                                    	
                                    	</div>
                                	
                                	    
                                	
                                	</div>
                                	
                                	<div class="row">
                                	    <div class="col-lg-12">
                                    	   	<div class="pull-right">
                                        	    <button type="submit" class="button solid-color">Enviar Boleta</button>
                                            </div>
                                        </div>
                                    </div>
                                	
                            	</form>
                            	
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