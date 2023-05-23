<?php 
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	require $conf['path_host'].'/include/detecta_pantalla.php';

	$db->prepare("SELECT * FROM `boletas_paquete_consolidado` order by id DESC");
	$db->execute();
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
	
	function verPDF(base64){
	    let pdfWindow = window.open("")
        pdfWindow.document.write("<iframe width='100%' height='100%' src='data:application/pdf;base64, " + encodeURI(base64) + "'></iframe>")
	}
	
	function descargarPdf(idBoleta){
	    console.log("Entro");
	    $.get( "descargar-pdf-a-demanda.php?idboleta", { 'idboleta': idBoleta } )
	    .done(function( data ) {
	        console.log(JSON.parse(data));
	        let datos=JSON.parse(data)
	        if(datos.respuesta){
                let pdfWindow = window.open("")
                pdfWindow.document.write("<iframe width='100%' height='100%' src='data:application/pdf;base64, " + encodeURI(datos.respuesta) + "'></iframe>")
	        }else{
	            alert('Hubo un problema durante la descarga y visualizacion del pdf. Por favor contacte a soporte.');
	        }
        });
	}
	//../tlc_admin/santiago/santiago-operaciones/boletas/descargar-pdf-a-demanda.php?idboleta=351

	
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

    <div class="container-fluid">
        <div class="container">
    		<div class="row">
            <!--Inicio Contenido -->
    
        	<h2>Boletas Generadas</h2>	
        
        	<!-- tabla de datos -->
        	<?php if(empty($sql_paquete)){ ?>
        		<center><h2>No tiene Boletas generadas</h2></center>
        	<?php }else{ ?>
        
            <link
              rel="stylesheet"
              href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css"
            >
            </div>
        </div>
    
		<div class="container">
			<div class="row">
			    
    		    <hr/>
			    
				<div class="col-xs-12">
				    <div class="table-responsive-sm">
    					<table class="table table-sm table-bordered table-hover dt-responsive">
    						<thead>
    							<tr>
    								<th>N&deg;</th>
    								<th>Codigo Guia</th>
    								<th>Tipo Paq./Cons.</th>
    								<th>Tipo DTE</th>
    								<th>Folio</th>
    								<th>Fecha</th>
    								<th>Resultado Procesamiento</th>
    								<th>Detalles</th>
    								<th>Documento PDF</th>
    							</tr>
    						</thead>
    						<tbody>
    							<?php $x=1; foreach ($sql_paquete as $key => $paquete) { 
    							    
    							    $url=$conf['path_files_boletas_dominio'] .$paquete->paquete_consolidado.".pdf";
    							    $rutaAbsoluta=$conf['path_files_boletas_absoluto'] .$paquete->paquete_consolidado.".pdf";

    							?>
    								<tr>
    									<td>
    									    <?= $x; ?>
    									</td>
    									<td>
    									    <?= $paquete->paquete_consolidado; ?>
    									</td>
    									<td>
    									    <?= ($paquete->tipo_paquete_consolidado==1)?'Paquete':'Consolidado'; ?>
    									</td>
    									<td>
    									    <?= ($paquete->tipo_dte=='33')?'Factura':"Boleta"; ?>
    									</td>
        								<td>
    									    <?= ($paquete->folio==null)?'No existe':$paquete->folio; ?>
    									</td>
    									<td>
    									    <?= date("d/m/Y h:m:i",strtotime($paquete->fecha)); ?>
    									</td>
    									<td>
    									    <?php //$paquete->json_request; ?>
    									    <?php $response = json_decode($paquete->json_response);?>
    									    <?= $response->Objeto!=NULL ? "<span class='label label-info'>Satisfactorio</span>" : "<span class='label label-danger' style='background-color: red;'>Error</span>"; ?>
    									</td>
    									
    									<td>
    									    <a 
        									    href="../tlc_admin/santiago/santiago-operaciones/boletas/ver-detalle-boleta.php?idBoleta=<?=$paquete->id ?>"
    									        title='Ver detalle de la transacción' 
    									        class='button solid-color' 
    									        target='_blank'
    									        style='padding:5px;'>Ver</a>
    									</td>
    									
    									<td> 
    									    <?php if ($paquete->pdfBase64!=null){ 
    									    $base64=$paquete->pdfBase64;?>
    									    <a 
									        onclick="verPDF('<?=$base64?>');"
									        title='Descargar Boleta Pdf' 
									        class='button solid-color' 
									        target='_blank'
									        style='padding:5px;'>Descargar</a>
									        <?php  }else {  
									            ?>
									            
									            <a 
    									        onclick="descargarPdf('<?=$paquete->id?>');"
    									        title='Actualizar Boleta Pdf' 
    									        class='button solid-color' 
    									        target='_blank'
    									        style='padding:5px;'>Descargar</a>
									            
									        <?php } ?>
    									</td>
    								</tr>
    							<?php $x++; } ?>
    						</tbody>
    					</table>
    					
					</div>
				</div>
			</div>
			
			
			
			<div class="row">
    		    <div class="col-lg-12">
            		<center><a href="index.php" class="button solid-color">VOLVER</a></center>
                </div>
            </div>
			
			<br>
            <br>
            <br>
            <br>
            
            

            
			
		</div>
	</div>
	<?php } ?>
	<!-- fin tabla de datos -->

	<br><br><br><br>

	<!-- INCLUDE FOOTER-->
	<?php //require $conf['path_host'].'/include/include_footer.php'; ?> 
    <!--FIN FOOTER-->  

</body>

</html>