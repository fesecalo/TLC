<?php
    require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$tipo_usu = $_SESSION['tipo_usuario'];
	$id_usuario = $_SESSION['numero_cliente'];
	$id_cons=$_GET['id_consolidado'];

	if(empty($tipo_usu)){
	   	die("Ha expirado la sessi«Ñn.");
	}

	if(empty($id_usuario) ){
	   	die("Ha expirado la sessi«Ñn.");
	}
	
	if(empty($id_cons)){
	   	die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
	}
	
	

	$db->prepare("SELECT * FROM consolidado WHERE id_consolidado=:id and id_usuario=:id_usuario");
	$db->execute(array(':id' => $id_cons, ':id_usuario' => $id_usuario));
	$sql_consolidado=$db->get_results();

	$db->prepare("SELECT * FROM paquete WHERE id_consolidado=:id ORDER BY id_paquete");
	$db->execute(array(':id' => $id_cons));
	$sql_paquetes=$db->get_results();
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
	/*$(document).ready(function(){
		$("#codigo").focus();
		// accion al presionar enter en el campo contraseÃ±a
		$('#codigo').keyup(function(e) {
			if(e.keyCode == 13) {
				validar();
			}
		});
		// FIN accion al presionar enter en el campo contraseÃ±a
	});*/

	// FUNCION QUE DIRECCIONA AL PRESIONAR ENTER O ESCANEAR UN CODIGO
	/*function validar(){
		if($("#codigo").val()==''){
			alert("Ingrese un Codigo de etiqueta.  ----> presiones ESC <---");
			$("#codigo").select();
			return false;
		}
		document.procesa_consolidado.submit();
	}*/
	// FIN FUNCION QUE DIRECCIONA AL PRESIONAR ENTER O ESCANEAR UN CODIGO

	/*function cerrar(){
		if($("#txtAlto").val()==0){
			alert("Ingrese alto");
			$("#txtAlto").select();
			return false;
		}

		if($("#txtLargo").val()==0){
			alert("Ingrese largo");
			$("#txtLargo").select();
			return false;
		}

		if($("#txtAncho").val()==0){
			alert("Ingrese largo");
			$("#txtAncho").select();
			return false;
		}

		$("#accion").val(1);
		document.formConsolidado.submit();
	}*/

	/*function editar(){
		$("#accion").val(2);
		document.formConsolidado.submit();
	}*/
</script>

<body>

	<!-- menu-->
	<?php require $conf['path_host'].'/include/include_menu_operador_externo.php'; ?> 
	<!--menu-->

	<!--Inicio Contenido -->

    <div class="container-fluid">
        <div class="container">
            
            <div class="row">
    		    <div class="col-lg-12">

                    <!-- inicio datos cliente -->
                	<p>&nbsp;</p>
                	<?php require $conf['path_host'].'/include/include_datos_usuario.php';?> 
    	            <p>&nbsp;</p>
    	        </div>
    	    </div>
    	    
    	    <div class="row">
        		<div class="col-xs-10">
        	        <h2>Detalles del Consolidado</h2>	
        	    </div>
        	    <div class="col-xs-2 text-right">
    		        <a href="../tracking.php" >Volver a Tracking</a>
    		    </div>  
        	</div>
    	    

        	<div class="row">
    		    <div class="col-lg-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">TLC Consolidado Tracking  </h4> 
                            <h3><?= $sql_consolidado[0]->codigo_consolidado; ?></h3>
                        </div>
                        <div class="panel-body">
                            
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    		    <b>N&deg; paquetes:</b>
                    	        <?= $sql_consolidado[0]->numero_paquetes; ?>
                    	    </div>
                    	    
                    	    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <!-- datos generales del consolidado -->
                            	<b>Peso consolidado(Lb):</b>
                    	        <?= round($sql_consolidado[0]->peso_kilos/0.45, 2); ?>
                    	    </div>
                    	    
                    	    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    			<b>Peso Volum&eacute;trico:</b>
                    			<?= round($sql_consolidado[0]->peso_volumen,2); ?>
                			</div>	

                    		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    			<b>Alto(inch):</b>
                    			<?= round($sql_consolidado[0]->alto,2); ?>
                    		</div>
                    		
                    		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    			<b>Largo(inch):</b>
                    			<?= round($sql_consolidado[0]->largo,2); ?>
                    		</div>
                    		
                    		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    			<b>Ancho(inch):</b>
                    			<?= round($sql_consolidado[0]->ancho,2); ?>
                    		</div>
                    		
                        </div>
                    </div>

    	        </div>
    	    </div>
        
		    <div class="row">
    		    <div class="col-xs-12">
        	
        	        <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Paquetes incluidos en el Consolidado</h3>
                        </div>
                        <div class="panel-body">
                            
                            <table class="table">
                        		<thead>
                        		    <tr>
                            			<th>N&deg;</th>
                            			<th>N&deg; <?= $conf['path_company_name']; ?></th>
                            			<th>Descripci&oacute;n</th>
                            			<th>Valor USD</th>
                            			<th>Peso(Lb)</th>
                        			</tr>
                        		</thead>
                        		<tbody>
                        		<?php $p=1; foreach ($sql_paquetes as $key => $paquetes) {  ?>
                            		<tr>
                            			<td>
                            			    <?= $p; ?>
                            			</td>
                            			<td>
                            			    <a href="../historial.php?paquete=<?= $paquetes->id_paquete; ?>" title="Ver detalle del paquete">
    									        <?= $paquetes->tracking_garve; ?>
    									    </a>
                            			</td>
                            			<td>
                            			    <?= $paquetes->descripcion_producto; ?>
                            			</td>
                            			<td>
                            			    $<?= $paquetes->valor;?>
                            			</td>
                            			<td>
                            			    <?= round($paquetes->peso/0.45,2);?>
                            			</td>
                            			
                            		</tr>
                        		<?php $p++; } ?>
                        		</tbody>
                        	</table>
                            
                        </div>
                    </div>
        	        
                </div>
    	    </div>
    	    
    	    
    	    <?php
    	       $db->prepare("SELECT * FROM comprobante_consolidado WHERE id_consolidado=:id_consolidado and id_usuario=:id_usuario and eliminado=0 ");
	           $db->execute(
	                array(
	                    ':id_consolidado' => $id_cons,
	                    ':id_usuario' => $id_usuario,
	                )
	           );
	            $comprobantes_consolidado=$db->get_results();
	        ?>
    	    

    	    <div class="row">
    		    <div class="col-xs-12">
        	
        	        <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Facturas de Paquetes y del Consolidado</h3>
                        </div>
                        <div class="panel-body">
                            
		                    <div class="col-lg-6" class='text-center'>
		                        
		                        <fieldset>
		                            
		                            <legend class="text-center">
		                                Lista de Facturas del Consolidado
		                            </legend>
		                            
		                        <!-- Lista de facturas cargadas -->
		                        

                        		<?php if (!empty($comprobantes_consolidado)) { ?>
                        		
                        		<table class="table">
                            		<thead>
                            		    <tr>
                                			<th>Archivo</th>
                                			<th>Acci&oacute;n</th>
                            			</tr>
                            		</thead>
                            		<tbody>

                            			</tr>
                        			<?php foreach ($comprobantes_consolidado as $key => $comprobantes) { ?>
                           				<tr>
                        					<td align="left" title="<?= $comprobantes->nombre_original; ?>">
                        						    <?= $comprobantes->nombre_comprobante; ?>
                        					</td>
                        					
                        					<td>
                        						    
                        					    <!--<a target="_blanck" href="gestor_archivos.php?&usu=<?= $id_usuario; ?>&cons=<?=$comprobantes->id_consolidado;?>&nombre=<?= $comprobantes->nombre_comprobante; ?>&accion=1">
                                                    Ver
                        						</a>-->
                        						
                        						<a 
                        						href="<?=$conf['path_host_url_consolidado']."/".$id_usuario."/".$sql_consolidado[0]->id_consolidado."/".$comprobantes->nombre_comprobante?>" 
                        						
                        						download="<?=$comprobantes->nombre_original?>">
                        						    Descargar
                        						</a>
                        						                   						<a href=" eliminar_comprobante.php?id_comprobante_consolidado=<?=$comprobantes->id_comprobante_consolidado;?>&id_consolidado=<?=$id_cons?>">
                        						    Eliminar
                        						</a>
                        						</td>
                        					</tr>
                        				
                        			<?php } ?>
                        			</table>
                        		<?php }else{ ?>
                                    <h4>No se han ingresado facturas o comprobantes de compra</h4>
                        		<?php } ?>
		                        
		                        </fieldset>
		                        
		                        <!-- Fin Listado de facturas cargadas -->
		                        
		                        
		                    </div>
		                    <div class="col-lg-6">
		                        
		                        
		                        
		                        <fieldset>
		                            
		                            <legend class="text-center">
		                                A&ntilde;ade la factura o comprobante de compra
		                            </legend>
                    			
                    			<?php if ($_GET['result']==1){?>
                    			    <div class="alert alert-success" role="alert">Su factura se ha cargado correctamente</div>
                    			    <?php } ?>
                    			
                    			
                        			<form id="comprobante" action="subir_comprobante.php" method="post" enctype="multipart/form-data">
                        			    
                        			    <input 
                                            type="hidden" 
                                            id="id_consolidado" 
                                            name="id_consolidado"
                                            value="<?=$sql_consolidado[0]->id_consolidado;?>">

                                        <div class="form-group">
                                            <label for="exampleInputFile">
                                                <b>
                                                    Factura del consolidado
                                                </b>
                                            </label>
                                            <input 
                                                type="file" 
                                                id="comprobante" 
                                                name="comprobante">
                                            <p class="help-block">Agregar factura del consolidado</p>
                                        </div>
            							
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">
                                                <b>
                                                    Valor total compra USD
                                                </b>
                                            </label>
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                name="valorFactura"
                                                id="valorFactura" 
                                                placeholder="(Incluye valor producto+shipping+tax)">
                                        </div>
                        			
                        			    <div class="form-group">
                                            <div class="col-sm-12 col-sm-10">
                                                <button 
                                                    type="submit" 
                                                    class="btn btn-default"
                                                    name="enviar" 
                        					        id="enviar" 
                        					        value="Guardar Comprobante">
                                                        Guardar Comprobante
                                                </button>
                                            </div>
                                        </div>
                					    
                					    
                        			</form>
                        			
                        			
                    			<fieldset>
                    			    
		                    </div>
    		               
                        </div>
                    </div>
        	        
                </div>
    	    </div>
    	    
    	    
            <div class="row">
    		    <div class="col-xs-12">
                	<!--<center>
                	    <a href="<?= $conf['path_host_url'] ?>/miami/consolidado/trabajar_consolidado/consolidado.php" class="button solid-color">
                	        VOLVER
                	    </a>
                	</center>-->
                </div>
    	    </div>
    	    
    	    <div class="row">
        		<div class="col-xs-10">
        	        
        	    </div>
        	    <div class="col-xs-2 text-right">
    		        <a href="../tracking.php" >Volver a Tracking</a>
    		    </div>  
        	</div>
	    </div>
	</div>
	
	
	<!-- Fin de contenido -->
</body>
</html>