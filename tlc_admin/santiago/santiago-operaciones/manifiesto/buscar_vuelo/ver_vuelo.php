<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_vuelo=$_GET['vuelo'];
	$codigo_vuelo=$_GET['codigo'];

	$db->prepare("SELECT 
			paquete.id_paquete,

            paquete.status,
			paquete.pieza,
            paquete.proveedor,
            currier.nombre_currier,
            paquete.tracking_eu,
            paquete.tracking_garve,
            valija.cincho,
            usuario.nombre,
			usuario.apellidos,
            paquete.id_usuario,
            paquete.descripcion_producto,
            paquete.peso,
            paquete.largo,
            paquete.ancho,
            paquete.alto,
            paquete.valor,

            paquete.id_proveedor,

			proveedor.nombre_proveedor,
			tipo_paquete.nombre_tipo_paquete,
			vuelo.id_status_vuelo

		FROM paquete AS paquete
		LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
        INNER JOIN data_currier AS currier ON currier.id_currier=paquete.currier
        LEFT JOIN valijas AS valija ON valija.id_valija=paquete.id_valija
        INNER JOIN vuelos AS vuelo ON vuelo.id_vuelos=paquete.id_vuelo
        LEFT JOIN data_proveedor AS proveedor ON proveedor.id_proveedor=paquete.id_proveedor
		LEFT JOIN data_tipo_paquete AS tipo_paquete ON tipo_paquete.id_tipo_paquete=paquete.id_tipo_paquete
		WHERE paquete.id_vuelo=:id_vuelo
        GROUP BY paquete.id_paquete
		ORDER BY paquete.id_paquete DESC
	");
	$db->execute(array(':id_vuelo' => $id_vuelo));
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


	<!-- menu-->
    <?php 
        if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==4){
            require $conf['path_host'].'/include/include_menu_operador_local.php'; 
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
	
                	<div id="logo"><h1>Paquetes en vuelo</h1></div>
                
                	<!-- inicio datos cliente -->
                	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
                	<!-- Fin datos cliente -->
                
                	<br>
                	
                	
		<?php if($sql_vuelo[0]->tipo_vuelo==0){ ?>
			<a href="excel_manifiesto.php?id=<?= $id_vuelo; ?>" class="button solid-color">DESCARGAR EXCEL</a>
		<?php }else{ ?>
			<a href="manifiesto_excel/excel_manifiesto_externo.php?id=<?= $id_vuelo; ?>" class="button solid-color">DESCARGAR EXCEL</a>
		<?php } ?>
		
		<a href="../manifiesto/facturas/descargar_facturas.php?id=<?= $id_vuelo; ?>" class="button solid-color">DESCARGAR FACTURAS</a>

		<!--<?php if($sql_vuelo[0]->id_status_vuelo!=1){ ?>
			<a id="confirmar_vuelo" href="comfirmar_aduana.php?id_vuelo=<?= $id_vuelo; ?>" class="button solid-color" onclick="return confirm('Todos los paquetes de este vuelo pasaran a estado Arribo de vuelo en Chile, Desea continuar?')">CONFIRMAR ARRIBO VUELO</a>
		<?php } ?>

		<?php if($sql_vuelo[0]->id_status_vuelo!=4){ ?>
			<a id="vuelo_retrasado" href="vuelo_retrasado.php?id_vuelo=<?= $id_vuelo; ?>" class="button btn-danger solid-color" onclick="return confirm('Todos los paquetes de este vuelo pasaran a estado Vuelo retrasado, Desea continuar?')">VUELO RETRASADO</a>
		<?php } ?>
			-->
                	
                	<br>
                	<?php if(empty($sql_paquete)){ ?>
                		<center>
                		    <h2>No tiene paquetes</h2>
                		</center>
                	<?php }else{ ?>
                
                	<br>
                	<br>
                
                	<center>
                	    <h2>Vuelo <?= $codigo_vuelo; ?></h2>
                	</center>
                
                	<br>
                	<br>
                
                	<table class="table">
                	    <thead>
                    		<tr>
                    			<th>Bag</th>
                    			<th>Pcs #</th>
                    			<th>Shipper Name:</th>
                    			<th>Delivery Company</th>
                    			<th>Tracking Number</th>
                    			<th>Tracking <?= $conf['path_company_name']; ?></th>
                    			<th>Nombre del Cliente</th>
                    			<th>CHI Number</th>
                    			<th>Tipo de paquete</th>
                    			<th>Description/Invoice/Amount</th>
                    			<th>Weight</th>
                    			<th>Length</th>
                    			<th>Width</th>
                    			<th>Height</th>
                    			<th>Peso Volum&eacute;trico</th>
                    			<th>Valor USD</th>
                    		</tr>
                		</thead>
                		
                		<tbody>
                    		<?php foreach ($sql_paquete as $key => $paquete) {  ?>
                    		<tr>
                    			<td><?= $paquete->cincho; ?></td>
                    			<td><?= $paquete->pieza; ?></td>
                    
                    			<?php if($paquete->id_proveedor==0){ ?>
                    				<td><?= $paquete->proveedor; ?></td>
                    			<?php }else{ ?>
                    				<td><?= $paquete->nombre_proveedor; ?></td>
                    			<?php } ?>
                    
                    			<td><?= $paquete->nombre_currier; ?></td>
                    			<td><?= $paquete->tracking_eu; ?></td>
                    			<td><?= $paquete->tracking_garve; ?></td>
                    			<td><?= $paquete->nombre.' '.$paquete->apellidos; ?></td>
                    			<td><?= $paquete->id_usuario; ?></td>
                    			<td><?= $paquete->nombre_tipo_paquete; ?></td>
                    			<td><?= $paquete->descripcion_producto; ?></td>
                    			<td><?= $paquete->peso; ?></td>
                    			<td><?= $paquete->largo; ?></td>
                    			<td><?= $paquete->ancho; ?></td>
                    			<td><?= $paquete->alto; ?></td>
                    			<td><?=round(($paquete->largo*$paquete->ancho*$paquete->alto)/6000,2); ?></td>
                    			<td><?= $paquete->valor; ?></td>
                    		</tr>
                    		
                    		<?php } ?>
                		</tbody>
                	</table>
                	<?php } ?>
                	<br/>
                	Total de paquetes: <?= count($sql_paquete); ?>
                
                	<br>
                	<br>
                
                	<center>
                	    <a href="<?= $conf['path_host_url'] ?>/santiago/santiago-operaciones/manifiesto/buscar_vuelo/vuelos.php" class="button solid-color">VOLVER
                	    </a>
                	</center>
                	<br>
                	<br>
                </div>
            </div>
        </div>
    </div>
<!-- Fin de contenido -->

</body>
</html>