<?php 
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	require $conf['path_host'].'/include/detecta_pantalla.php';

	$id_usu=$_SESSION['numero_cliente'];

	$db->prepare("SELECT
			consolidado.id_consolidado,
		    consolidado.codigo_consolidado
	    
		FROM consolidado 
		WHERE status_consolidado = 1
		ORDER BY id_consolidado DESC
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

	<!-- registro de prealertas -->	
	<center>
		<h2>CONSOLIDADOS ABIERTOS</h2>
	</center>
	<!-- Fin prealerta -->

	<!-- inicio datos cliente -->
	<p>&nbsp;</p>
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<p>&nbsp;</p>
	<!-- Fin datos cliente -->

	<!-- tabla de datos -->
	<?php if(empty($sql_paquete)){ ?>
		<center><h2>No tiene paquetes en transito</h2></center>
	<?php }else{ ?>

		<?php if($msg_tabla==1 || $navegador==7){ ?>
			<center>
				<div id="aviso2">
					
				</div>
			</center>
			<br><br>
		<?php } ?>
    <link
      rel="stylesheet"
      href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css"
    >
    
    <div class="container-fluid">
    
		<div class="container">
			<div class="row">
    		    
    		    <hr/>
			    
				<div class="col-xs-12">
				    <div class="table-responsive-sm">
    					<table class="table table-sm table-bordered table-hover dt-responsive">
    						<thead>
    							<tr>
    								<th>N&deg;</th>
    								<th>Id Consolidado</th>
    								<th>C&oacute;digo Consolidado</th>
    							</tr>
    						</thead>
    						<tbody>
    							<?php $x=1; foreach ($sql_paquete as $key => $paquete) { 
    							    $existeFactura=$paquete->id_consolidado?"<span style='color: crimson;'>Si</span>":"<span>No</span>";
    							
    							?>
    								<tr>
    									<td>
    									    <?= $x; ?>
    									</td>
    									<td>
    									    <?= $paquete->id_consolidado; ?>
    									</td>
    									<td>
    									    <?= $paquete->codigo_consolidado; ?>
    									</td>
    									<td>
    									    <a href="historial.php?paquete=<?= $paquete->id_consolidado; ?>" title="Detalle" class="button solid-color" style="padding:5px;">Eliminar</a>
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

<!-- INCLUDE FOOTER-->
	<?php require $conf['path_host'].'/include/include_footer.php'; ?> 
<!--FIN FOOTER-->  

</body>

</html>