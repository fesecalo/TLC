<?php 
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	require $conf['path_host'].'/include/detecta_pantalla.php';

    if($_SESSION["tipo_usuario"]!=2 && $_SESSION["tipo_usuario"]!=1){
        echo "Disculpe. Usted no tiene permisos para acceder a esta página.";
        die();
    }

	$id_usu=$_SESSION['numero_cliente'];
	
	// Buscar Consolidados abiertos
	$db->prepare("SELECT * FROM consolidado WHERE id_usuario=:id_usu AND status_consolidado=0 AND eliminado=0 ORDER BY id_consolidado DESC
	");
	$db->execute(array(':id_usu' => $id_usu ));
	$sql_consolidado_abierto=$db->get_results();
	
	//$sql_consolidado_abierto=$db->get_results("SELECT * FROM consolidado WHERE status_consolidado=0 AND eliminado=0 ORDER BY id_consolidado DESC");
	
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
		    
		    factura.nombre_comprobante,
		    
		    status_log.fecha,
		    paquete.fecha_procesado_miami
	    
		FROM paquete 
		INNER JOIN data_status ON data_status.id_status=paquete.status
	    LEFT JOIN status_log ON (status_log.id_paquete=paquete.id_paquete AND status_log.id_tipo_status=paquete.status)
	    LEFT JOIN comprobante_compra AS factura ON factura.id_paquete=paquete.id_paquete AND factura.eliminado=0
	    LEFT JOIN consolidado ON (paquete.id_consolidado = consolidado.id_consolidado)
		WHERE paquete.id_usuario=:id_usu
		AND consolidado.codigo_consolidado IS NULL
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
	    
	    $('#sin-consolidado').show();
        $('#datos-consolidado').hide();
        $('#nuevo-consolidado').hide();
	    
		$('table').DataTable();
		
		$('[name="checks[]"]').click(function() {
            habilitarDeshabilitarBotonConsolidar();
        });
        $('#id_consolidado').click(function() {
            habilitarDeshabilitarBotonConsolidar();
            if($('#id_consolidado').val()==='Seleccione Consolidado'){
                $('#sin-consolidado').show();
                $('#datos-consolidado').hide();
                $('#nuevo-consolidado').hide();
            }else if($('#id_consolidado').val()==='nuevoConsolidado'){
                $('#sin-consolidado').hide();
                $('#datos-consolidado').hide();
                $('#nuevo-consolidado').show();
            }else{
                datosConsolidado();
                $('#sin-consolidado').hide();
                $('#datos-consolidado').show();
                $('#nuevo-consolidado').hide();
            }
        });
		
	});
	
	function habilitarDeshabilitarBotonConsolidar(){
	    var arr = $('[name="checks[]"]:checked').map(function(){
                return this.value;
            }).get();
            if($('#id_consolidado').val()!=='Seleccione Consolidado' && arr.length > 0){
                $("#boton-consolidar").prop('disabled', false);
            }else { 
                if($_SESSION["tipo_usuario"]!=2 && $_SESSION["tipo_usuario"]!=1){
                    $("#boton-consolidar").prop('disabled', false);
                }else{
                    $("#boton-consolidar").prop('disabled', true);
                }
            }
            var str = arr.join(',');
            $('#arr').text(JSON.stringify(arr));
            $('#str').text(str);
	}
	
	function consolidarPaquetes(){
        var arr = $('[name="checks[]"]:checked').map(function(){
                return this.value;
            }).get();
            
        $.ajax({
            type: "POST", 
            dataType: "json",
            data: {
                'id_consolidado':$('#id_consolidado').val(),
                'array_tracking_garve':arr
            },
            url: 'procesar_lista_paquetes_consolidar.php',   
            beforeSend: function () {
                //console.log("Loading");
            },
            success: function (datos) { 
                alert("Sus paquetes fueron consolidados correctamente.");
                location.reload();
            },
            error: function () {
                alert("Disculpe. En estos momentos no ha sido posible procesar su solicitud, inténtelo de nuevo más tarde", "warning");
                location.reload();
            }
        });
            
	}
	
	function datosConsolidado(){
	    
	    $.ajax({
            type: "GET",
            dataType: "json",
            data: {
                'id_consolidado':$('#id_consolidado').val()
            },
            url: 'consultar_datos_consolidado.php',   
            beforeSend: function () {
                //console.log("Loading");
            },
            success: function (datos) { 
                $("#codigo_consolidado_span").html(datos.consolidado.codigo_consolidado);
                $("#peso_kilos_span").html(datos.consolidado.peso_kilos);
                $("#numero_paquetes_span").html(datos.consolidado.numero_paquetes);
            },
            error: function () {
                alert("Disculpe. En estos momentos no ha sido posible procesar su solicitud, inténtelo de nuevo más tarde", "warning");
                location.reload();
            }
        });
            
	}
	
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
    		    <div class="col-xs-12">
                	<!-- inicio datos cliente -->
                	<p>&nbsp;</p>
                	<?php require $conf['path_host'].'/include/include_datos_usuario.php';?> 
    	            <p>&nbsp;</p>
    	        </div>
    	    </div>
        	<!-- Fin datos cliente -->
            <div class="row">
        		<div class="col-xs-10">
        	        <h2>PAQUETES REGISTRADOS A CONSOLIDAR</h2>	
        	    </div>
        	    <div class="col-xs-2 text-right">
    		        <a href="tracking.php" >Volver Tracking</a>
    		    </div>  
        	</div>
        	
        	<!-- tabla de datos -->
        	<?php if(empty($sql_paquete)){ ?>
        		<center><h2>No tiene paquetes en transito</h2></center>
        	<?php }else{ ?>
        
    		
            <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css" >
    
            <div>
                
                <div class="row ">
                    <div class="col-xs-5" style="padding:40px;">
                        
                        <fieldset>
                            <legend style="float:right">Acciones del Consolidado:</legend>
                            
                        <!--<div class="col-xs-2">
        			        <div class="form-group">
                                <label for="disabledSelect">Nuevo</label>
                                <button type="button" id="boton-crear-nuevo-consolidado" title="Crear nuevo Consolidado" onclick="crearNuevoConsolidado();">
                                  Crear
                                </button>
                            </div>
            		    </div>-->
            		    
            		    <div class="col-xs-6">
        			        <div class="form-group">
                                <label for="disabledSelect">Seleccionar Consolidado</label>
                                <select id="id_consolidado" title="Seleccionar Consolidado existente" class="form-control">
                                    <option>Seleccione Consolidado</option>
                                    <?php foreach($sql_consolidado_abierto as $consolidado){?>
                                    <option value="<?=$consolidado->id_consolidado?>"><?=$consolidado->codigo_consolidado?></option>
                                    <?php } ?>
                                    <option value="nuevoConsolidado">Nuevo Consolidado</option>
                                    
                                </select>
                            </div>
            		    </div>
            		    
            		    <div class="col-xs-6 text-right">
        			        <div class="btn-group" role="group" aria-label="...">
        			            <label for="fname">Acción:</label>
                                <button class="btn btn-primary" type="button" title="Consolidar paquetes seleccionados" id="boton-consolidar" title="Consolidar paquetes seleccionados" onclick="consolidarPaquetes();">
                                  Consolidar seleccionados
                                </button>
                            </div>
            		    </div>
            		    
            		    </fieldset>
                    </div>
                    
        		    <div class="col-xs-7" style="padding:40px;">
            		    <div class="col-xs-12">
        			        <fieldset>
                                <legend>Datos del consolidado seleccionado:</legend>
                                <div id="datos-consolidado">
                                    <div class="row">
                    					<div class="col-xs-3"><b>TLC Consolidado Tracking</b></div>
                    				    <div class="col-xs-3"><b>Peso total(Lb)</b></div>
                    					<div class="col-xs-3"><b>Paquetes</b></div>
                    					<div class="col-xs-3"><b>Estado</b></div>
                    				</div>
                    				<div class="row">
                						<div class="col-xs-3" id="codigo_consolidado_span"></div>
                						<div class="col-xs-3" id="peso_kilos_span"></div>
                						<div class="col-xs-3" id="numero_paquetes_span"></div>
                						<div class="col-xs-3">Abierto</div>
                					</div>
            					</div>
            					<div id="sin-consolidado" class="col-xs-12">
                			        <center>
                			            <div class="alert alert-info" role="alert">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            <span class="sr-only">Info:</span>
                                              Seleccione Consolidado o cree uno nuevo.
                                        </div>
        
                			        </center>  
                    		    </div>
                    		    <div id="nuevo-consolidado" class="col-xs-12">
                			        <center>
                			            <div class="alert alert-success" role="alert">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            <span class="sr-only">Info:</span>
                                              Nuevo Consolidado.
                                        </div>
        
                			        </center>  
                    		    </div>
                            </fieldset>   
            		    </div>
            		    
        		    </div>
        		    
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
    									    <div class="checkbox">
                                                <label>
                                                    <input name="checks[]" type="checkbox" value="<?= $paquete->tracking_garve; ?>"/>
                                                </label>
                                            </div>
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
    									    <?php echo date("d/m/Y H:m:s",strtotime($paquete->fecha)); ?>
    									</td>
    									<?php } ?>
                                        <td>
                                            <?=$existeFactura?>
                                        </td>
                                        <td>
                                            <?php
                                            $codigoConsolidado=$paquete->codigo_consolidado!=''?$paquete->codigo_consolidado:"No consolidado";
                                            echo $codigoConsolidado;
                                        ?>
                                        </td>
    									<td>
    									    <a href="historial.php?paquete=<?= $paquete->id_paquete; ?>" title="Detalle" class="button solid-color" style="padding:5px;">
    									        Detalle
    									    </a>
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
		
		
	<?php } ?>
	<!-- fin tabla de datos -->
	    </div>
    </div>
	<br><br><br><br>

<!-- INCLUDE FOOTER-->
	<?php require $conf['path_host'].'/include/include_footer.php'; ?> 
<!--FIN FOOTER-->  

</body>

</html>