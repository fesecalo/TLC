<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$tipo_usu=$_SESSION['tipo_usuario'];
	$id_cons=$_GET['id_cons'];

	$db->prepare("
    	SELECT * FROM consolidado 
    	JOIN gar_usuarios ON (gar_usuarios.id_usuario=consolidado.id_usuario_representante) 
    	WHERE id_consolidado=:id"
	);

	$db->execute(array(':id' => $id_cons));
	$sql_consolidado=$db->get_results();

	$db->prepare("SELECT * FROM paquete JOIN gar_usuarios ON(paquete.id_usuario=gar_usuarios.id_usuario) WHERE id_consolidado=:id ORDER BY id_paquete");
	$db->execute(array(':id' => $id_cons));
	$sql_paquetes=$db->get_results();

    $arrayRepresentantes=array();
	foreach($sql_paquetes as $datos_representante){
	    array_push($arrayRepresentantes, array(
	        'id_usuario'=>$datos_representante->id_usuario,
	        'nombre'=>$datos_representante->nombre,
	        'apellidos'=>$datos_representante->apellidos));
	}
	$arrayRepresentantes=array_unique($arrayRepresentantes);
	
	$id_paquete_editar=$_GET['id_paq'];
		
	$db->prepare("SELECT * FROM paquete WHERE id_paquete=:id_paquete");
	$db->execute(array(':id_paquete' => $id_paquete_editar));
	$sql_paquete_editar=$db->get_results();
	
	$paq_edit=$_GET['paq_edit'];
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
		$("#codigo").focus();
		// accion al presionar enter en el campo contraseña
		$('#codigo').keyup(function(e) {
			if(e.keyCode == 13) {
				validar();
			}
		});
		// FIN accion al presionar enter en el campo contraseña
	});

	// FUNCION QUE DIRECCIONA AL PRESIONAR ENTER O ESCANEAR UN CODIGO
	function validar(){
		if($("#codigo").val()==''){
			alert("Ingrese un Codigo de etiqueta.  ----> presiones ESC <---");
			$("#codigo").select();
			return false;
		}
		document.procesa_consolidado.submit();
	}
	// FIN FUNCION QUE DIRECCIONA AL PRESIONAR ENTER O ESCANEAR UN CODIGO

	function cerrar(){
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
		
		if($("#txtPesoConsolidado").val()==0){
			alert("Ingrese el peso consolidado");
			$("#txtPesoConsolidado").select();
			return false;
		}
		
		if($("#txtNumeroPaquetes").val()==0){
			alert("Ingrese la cantidad de paquetes del consolidado");
			$("#txtNumeroPaquetes").select();
			return false;
		}

		$("#accion").val(1);
		document.formConsolidado.submit();
	}

	function editar(){
		$("#accion").val(2);
		document.formConsolidado.submit();
	}
	
	function editar_paquete(){
		document.formEditarPaquete.submit();
	}
</script>

<body>

	<!-- menu-->
	<?php require $conf['path_host'].'/include/include_menu_operador_externo.php'; ?> 
	<!--menu-->

	<!--Inicio Contenido -->
	
	 <div class="container-fluid">
        <div class="container">


	        
	        <div class="row">
        		<div class="col-xs-10">
        	        <h2>Detalles del Consolidado</h2>	
        	    </div>
        	    <div class="col-xs-2 text-right">
    		        <a href="../../../../tlc_admin/miami/consolidado/index.php" >Volver a M&oacute;dulo Consolidado</a>
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
	        
	        
        		        	<form action="procesa_consolidado.php" 
        		        	    id="formConsolidado" 
        		        	    name="formConsolidado" 
        		        	    method="POST" 
        		        	    >
        		        	    
                        		<input 
                        		    type="hidden" 
                        		    id="accion" 
                        		    name="accion" 
                        		    value="0">
                        		    
                        		<input 
                        		    type="hidden" 
                        		    id="id_consolidado" 
                        		    name="id_consolidado" 
                        		    value="<?= $id_cons; ?>">
                    		    <div class="col-lg-4">
            		                <div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Peso consolidado(Lb)
                                            </b>
                                        </label>
                                        <input 
                    				        type="text" 
                    				        id="txtPesoConsolidado" 
                    				        name="txtPesoConsolidado" 
                    				        value="<?= $sql_consolidado[0]->peso_kilos/0.45; ?>">
                                        <p class="help-block">Agregar Peso del consolidado</p>
                                    </div>
                        		
                    				    <!--<strong>
                    				        <?= ($sql_consolidado[0]->peso_kilos/0.45); ?>
                    				    </strong> -->
                    				
                    				
                    				<div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                N&deg; paquetes
                                            </b>
                                        </label>
                                        <input 
                    				        type="number" 
                    				        id="txtNumeroPaquetes" 
                    				        name="txtNumeroPaquetes" 
                    				        min="1" 
                    				        max="100" 
                    				        value="<?= $sql_consolidado[0]->numero_paquetes; ?>">
                    				    
                                        <p class="help-block">Agregar el numero de paquetes del consolidado</p>
                                    </div>
                                </div>
                                
                                
                				<!--<strong>
                				        <?= $sql_consolidado[0]->numero_paquetes; ?>
                				    </strong>-->
                				
                				    
                			    <?php if (($sql_consolidado[0]->status_consolidado)!=0 && $tipo_usu==1) { ?>
                    				
                    			<div class="col-lg-4">
                    				<div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Alto(inch)
                                            </b>
                                        </label>
                                        <input 
                					        type="text" 
                					        id="txtAlto" 
                					        name="txtAlto" 
                					        value="<?= $sql_consolidado[0]->alto; ?>" 
                					        disabled="true">
                                        <p class="help-block">Agregar alto de los paquetes del consolidado</p>
                                    </div>
                    				
                    				<div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Largo(inch)
                                            </b>
                                        </label>
                                        <input 
                					        type="text" 
                					        id="txtLargo" 
                					        name="txtLargo" 
                					        value="<?= $sql_consolidado[0]->largo; ?>" 
                					        disabled="true">
                                        <p class="help-block">Agregar largo de los paquetes del consolidado</p>
                                    </div>
                                    
                                </div>
                                <div class="col-lg-4">
                    				
                    				<div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Ancho(inch)
                                            </b>
                                        </label>
                                        <input 
                					        type="text" 
                					        id="txtAncho" 
                					        name="txtAncho" 
                					        value="<?= $sql_consolidado[0]->ancho; ?>" 
                					        disabled="true">
                                        <p class="help-block">Agregar archo de los paquetes del consolidado</p>
                                    </div>
            					    
            					    <a href="#" 
            					        class="button solid-color" 
            					        onclick="editar();">
            					        Editar consolidado
            					    </a>
            					    
            					</div>
                    					
                    			<?php }else{ ?>
                    			
                    			<div class="col-lg-4">
                    				
                    				<div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Alto(inch)
                                            </b>
                                        </label>
                                        <input 
                					        type="text" 
                					        id="txtAlto" 
                					        name="txtAlto" 
                					        value="<?= $sql_consolidado[0]->alto; ?>">
                                        <p class="help-block">Agregar alto de los paquetes del consolidado</p>
                                    </div>
                    				
                    				<div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Largo(inch)
                                            </b>
                                        </label>
                                        <input 
                					        type="text" 
                					        id="txtLargo" 
                					        name="txtLargo" 
                					        value="<?= $sql_consolidado[0]->largo; ?>">
                                        <p class="help-block">Agregar largo de los paquetes del consolidado</p>
                                    </div>
                                </div>
                                
            					<div class="col-lg-4">
            					    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Ancho(inch)
                                            </b>
                                        </label>
                                        <input 
                					        type="text" 
                					        id="txtAncho" 
                					        name="txtAncho" 
                					        value="<?= $sql_consolidado[0]->ancho; ?>">
                                        <p class="help-block">Agregar largo de los paquetes del consolidado</p>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="id_usuario_representante"><b>Representante del Consolidado</b></label>
                                        <select id="id_usuario_representante" name="id_usuario_representante" class="form-control">
                                            <?php
                                            foreach($arrayRepresentantes as $representante){ ?>
                                                <option value="<?=$representante['id_usuario']; ?>" >
                                                    <?=$representante['nombre'].' '.$representante['apellidos'];?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <p class="help-block">Seleccione el representante del consolidado</p>
                                    </div>
            					
            					   
            					</div>
                    					
                    			<?php } ?>
                    		
                    	        </form>
                    	        
                    	        <div class="col-lg-12 text-right">
                    	             <a href="#" 
            					        class="button solid-color" 
            					        onclick="cerrar();">
            					        Cerrar consolidado
            					    </a>
                    	        </div>
                    	        
                    	        
                    	        
                    	    </div>
        	            </div>  
    		        
        		    </div>
        	    </div>  
	        

            
        	    <div class="row">
        		    <div class="col-lg-12">
        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">TLC Consolidado Tracking  </h4> 
                                <h3>Ingrese paquetes al consolidado <?= $sql_consolidado[0]->codigo_consolidado; ?></h3>
                            </div>
                            <div class="panel-body">
        	        
        	        
                                <div class="col-lg-12">
    	        
                                	<h2>Ingrese paquetes al consolidado</h2>
                                
                                	<?php if(isset($_GET['msg'])){ ?>
                                		<br><br>
                                		<center>
                                			<div id="sesion">
                                				<p>Error al ingresar paquete en consolidado, intente nuevamente</p>
                                			</div>
                                		</center>
                                		<br><br>
                                	<?php } ?>
                                
                                	<form 
                                	    action="procesa_trabajar_consolidado.php" 
                                	    id="procesa_consolidado" 
                                	    name="procesa_consolidado" 
                                	    method="POST" >
                                		<?php if (($sql_consolidado[0]->status_consolidado)==0) { ?>
                                			<center>
                                			
                                				<input 
                                				    class="form-control" 
                                				    type="text" id="codigo" 
                                				    placeholder="Ingrese o escanee codigo etiqueta <?= $conf['path_company_name']; ?>" 
                                				    name="codigo" >
                                				<input 
                                				    type="hidden" id="id_consolidado" 
                                				    name="id_consolidado" 
                                				    value="<?= $id_cons; ?>">
                                				
                                			</center>
                                			<?php }else{ ?>
                                			<center>
                                			    <h2>
                                			        INGRESE O ESCANEE CODIGO ETIQUETA <?= $conf['path_company_name']; ?>
                                			    </h2>
                                			    <input 
                                			        class="form-control" 
                                			        type="text" 
                                			        id="codigo" 
                                			        placeholder="Ingrese o escanee codigo etiqueta <?= $conf['path_company_name']; ?>" 
                                			        name="codigo" 
                                			        disabled="true">
                                			</center>
                                		<?php } ?>
                                	</form>
                                
                            	<?php if(($sql_consolidado[0]->status_consolidado)==1){ ?>
                            		<center>
                            		    <h2>
                            		        Valija cerrada exitosamente.
                            		    </h2>
                            		</center>
                            	<?php } ?>
            
                    		 </div>
                    		 
                           
                        </div>
                    </div>
        
                </div>
            </div>
                
                
                <?php $cols=$id_paquete_editar==null? 12:8 ;?>
                
            <div class="row">
        	    <div class="col-lg-<?=$cols?>">
        
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">TLC Consolidado Tracking  </h4> 
                            <h3>Paquetes del consolidado <?= $sql_consolidado[0]->codigo_consolidado; ?></h3>
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
                            			<th>Acci&oacute;n</th>
                            		</tr>
                        		</thead>
                        		
                        		<tbody>
                        		
                            		
                            		    
                            		<?php $p=1; foreach ($sql_paquetes as $key => $paquetes) {  ?>
                            		<tr>
                            			<td>
                            			    <?= $p; ?>
                            			</td>
                            			<td>
                            			    <strong>
                            			        <?= $paquetes->tracking_garve; ?>
                            			    </strong>
                            			</td>
                            			<td>
                            			    <?= $paquetes->descripcion_producto; ?>
                            			</td>
                            			<td>
                            			    $<?= $paquetes->valor;?>
                            			</td>
                            			<td>
                            			    <?= ($paquetes->peso/0.45);?>
                            			</td>
                            			<?php if (($sql_consolidado[0]->status_consolidado)==0) { ?>
                            				<td>
                            				    <a href="trabajar_consolidado.php?id_cons=<?= $sql_consolidado[0]->id_consolidado; ?>&id_paq=<?= $paquetes->id_paquete;?>" >
                            				        Editar Peso
                            				    </a>
                            				    &nbsp;
                            				     <a href="eliminar_paquete.php?accion=3&id_paquete=<?= $paquetes->id_paquete;?>&id_consolidado=<?= $sql_consolidado[0]->id_consolidado; ?>" >
                            				        Eliminar
                            				    </a>
                            				    
                            				</td>
                            			<?php }else{ ?>
                            				<td></td>
                            			<?php } ?>
                            		</tr>
                            		
                            		<?php $p++; } ?>
                        		
                        		
                        		
                        		</tbody>
                        		
                        	</table>
                
                        </div>
                    </div>
        
                </div>
            
                <? if($id_paquete_editar!=null){?>
        	    <div class="col-lg-4">
        
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Editar paquete </h4> 
                            <h3>Paquete <?= $sql_paquete_editar[0]->tracking_garve; ?></h3>
                        </div>
                        <div class="panel-body">
        
                	        <form action="editar_paquete.php" 
        		        	    id="formEditarPaquete" 
        		        	    name="formEditarPaquete" 
        		        	    method="POST" 
        		        	    >
        		        	    
                        		<input 
                        		    type="hidden" 
                        		    id="id_consolidado" 
                        		    name="id_consolidado" 
                        		    value="<?= $sql_paquete_editar[0]->id_consolidado; ?>">
                        		    
                        		<input 
                        		    type="hidden" 
                        		    id="id_paquete" 
                        		    name="id_paquete" 
                        		    value="<?= $sql_paquete_editar[0]->id_paquete; ?>">
                    		
                    		    <div class="col-lg-6">
                    		
            		                <div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Peso (Lb)
                                            </b>
                                        </label>
                                        <input 
                                            style="width: 100%";
                    				        type="text" 
                    				        id="txtPesoPaquete" 
                    				        name="txtPesoPaquete" 
                    				        value="<?= $sql_paquete_editar[0]->peso/0.45; ?>"
                    				        placeholder="Editar Peso del paquete">
                                        
                                    </div>
                        		
                    				<div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Alto(inch)
                                            </b>
                                        </label>
                                        <input 
                                            style="width: 100%";
                					        type="text" 
                					        id="txtAlto" 
                					        name="txtAlto" 
                					        value="<?= $sql_paquete_editar[0]->alto; ?>" 
                					        disabled="true"
                					        placeholder="Editar alto del paquete">
                                    </div>
                                </div>
                				
                				<div class="col-lg-6">
                		
                    				<div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Largo(inch)
                                            </b>
                                        </label>
                                        <input 
                                            style="width: 100%";
                					        type="text" 
                					        id="txtLargo" 
                					        name="txtLargo" 
                					        value="<?= $sql_paquete_editar[0]->largo; ?>" 
                					        disabled="true"
                					        placeholder="Editar largo del paquete">
                                    </div>
                    				
                    				<div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Ancho(inch)
                                            </b>
                                        </label>
                                        <input 
                                            style="width: 100%";
                					        type="text" 
                					        id="txtAncho" 
                					        name="txtAncho" 
                					        value="<?= $sql_paquete_editar[0]->ancho; ?>" 
                					        disabled="true" 
                					        placeholder="Editar Ancho del paquete">
                                        
                                    </div>
                                    
                                </div>
                                
        					    <button href="#" 
        					        class="button solid-color" 
        					        type="submit"
        					        >
        					        Editar Peso del Paquete
        					    </button>
                		
                	        </form>

                	        <?php if($paq_edit==1){?>
                                <div class="alert alert-success" role="alert">Paquete editado Exitosamente</div>
                            <?php } ?>
                
                        </div>
                    </div>
        
                </div>
                <? } ?>
            </div>
            
            
                
        	<center>
        	    <a href="<?= $conf['path_host_url'] ?>/miami/consolidado/trabajar_consolidado/consolidado.php" class="button solid-color">
        	        VOLVER
        	    </a>
        	</center>
        	
        	
        	<div class="row">
        		<div class="col-xs-10">
        	        
        	    </div>
        	    <div class="col-xs-2 text-right">
    		        <a href="../tracking.php" >Volver a Tracking</a>
    		    </div>  
        	</div>

	<!-- Fin de contenido -->
</body>
</html>