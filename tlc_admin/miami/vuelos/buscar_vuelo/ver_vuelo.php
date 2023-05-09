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
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==2){
			require $conf['path_host'].'/include/include_menu_operador_externo.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

	<!--Inicio Contenido -->
	<div id="logo"><h1>Paquetes en valija</h1></div>

	<!-- inicio datos cliente -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<!-- Fin datos cliente -->

	<br>
	<br>
	<?php if(empty($sql_paquete)){ ?>
		<center><h2>No tiene paquetes</h2></center>
	<?php }else{ ?>

	<br>
	<br>

	<center><h2>Vuelo <?php echo $codigo_vuelo; ?></h2>
		<?php if($sql_paquete[0]->id_status_vuelo==3){ ?> 
			<a href="procesa_confirmar_vuelo.php?vuelo=<?php echo $id_vuelo; ?>&codigo=<?php echo $codigo_vuelo;?>" class="button solid-color">Confirmar vuelo a Chile</a>
		<?php } ?>
	</center>

	<br>
	<br>

	<table>
		<tr>
			<td>Bag</td>
			<td>Pcs #</td>
			<td>Shipper Name:</td>
			<td>Delivery Company</td>
			<td>Tracking Number</td>
			<td>Tracking <?php echo $conf['path_company_name']; ?></td>
			<td>Nombre del Cliente</td>
			<td><?php echo $conf['path_cuenta']; ?> Number</td>
			<td>Tipo de paquete</td>
			<td>Description/Invoice/Amount</td>
			<td>Weight</td>
			<td>Length</td>
			<td>Width</td>
			<td>Height</td>
			<td>Valor USD</td>
		</tr>
		<tr>
			<td colspan="17"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php foreach ($sql_paquete as $key => $paquete) {  ?>
		<tr>
			<td><?php echo $paquete->cincho; ?></td>
			<td><?php echo $paquete->pieza; ?></td>

			<?php if($paquete->id_proveedor==0){ ?>
				<td><?php echo $paquete->proveedor; ?></td>
			<?php }else{ ?>
				<td><?php echo $paquete->nombre_proveedor; ?></td>
			<?php } ?>

			<td><?php echo $paquete->nombre_currier; ?></td>
			<td><?php echo $paquete->tracking_eu; ?></td>
			<td><?php echo $paquete->tracking_garve; ?></td>
			<td><?php echo $paquete->nombre.' '.$paquete->apellidos; ?></td>
			<td><?php echo $paquete->id_usuario; ?></td>
			<td><?php echo $paquete->nombre_tipo_paquete; ?></td>
			<td><?php echo $paquete->descripcion_producto; ?></td>
			<td><?php echo $paquete->peso; ?></td>
			<td><?php echo $paquete->largo; ?></td>
			<td><?php echo $paquete->ancho; ?></td>
			<td><?php echo $paquete->alto; ?></td>
			<td><?php echo $paquete->valor; ?></td>
		</tr>
		<tr>
			<td colspan="17"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php } ?>
	</table>
	<?php } ?>
	<br/>
	Total de paquetes: <?php echo count($sql_paquete); ?>

	<br>
	<br>

	<center><a href="<?php echo $conf['path_host_url'] ?>/miami/vuelos/buscar_vuelo/vuelos.php" class="button solid-color">VOLVER</a></center>
	<br>
	<br>
<!-- Fin de contenido -->

</body>
</html>