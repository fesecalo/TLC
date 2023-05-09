<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id=$_GET["paquete"];

	$db->prepare("SELECT
			usuario.id_usuario,
			paquete.tracking_garve,
			paquete.numero_miami,
			paquete.consignatario,

			currier.nombre_currier,

			paquete.tracking_eu,
			paquete.proveedor,
			paquete.valor,
			paquete.descripcion_producto,
			paquete.pieza,
			paquete.peso,
			paquete.largo,
			paquete.ancho,
			paquete.alto,

			valija.cincho,

			vuelo.codigo_vuelo,

			paquete.id_proveedor,

			proveedor.nombre_proveedor,
			tipo_paquete.nombre_tipo_paquete,

			estado.nombre_status

		FROM paquete as paquete
		INNER JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
		INNER JOIN data_currier AS currier ON currier.id_currier=paquete.currier
		LEFT JOIN valijas AS valija ON valija.id_valija=paquete.id_valija
		LEFT JOIN vuelos AS vuelo ON vuelo.id_vuelos=paquete.id_vuelo
		LEFT JOIN data_proveedor AS proveedor ON proveedor.id_proveedor=paquete.id_proveedor
		LEFT JOIN data_tipo_paquete AS tipo_paquete ON tipo_paquete.id_tipo_paquete=paquete.id_tipo_paquete
		LEFT JOIN data_status AS estado ON estado.id_status=paquete.status
		WHERE paquete.id_paquete=:id
		ORDER BY paquete.id_paquete ASC
	");
	$db->execute(array(':id' => $id));

	$sql_paquete=$db->get_results();

	foreach ($sql_paquete as $key => $paquete) {
		$id_cliente=$paquete->id_usuario;
		$tracking_garve=$paquete->tracking_garve;
		$numero_miami =$paquete->numero_miami;
		$consignatario=$paquete->consignatario;
		$nombre_currier =$paquete->nombre_currier;
		$tracking_usa=$paquete->tracking_eu;
		$proveedor=$paquete->proveedor;
		$valor=$paquete->valor;
		$producto=$paquete->descripcion_producto;
		$pieza=$paquete->pieza;
		$peso=$paquete->peso;
		$largo=$paquete->largo;
		$ancho=$paquete->ancho;
		$alto=$paquete->alto;
		$cincho=$paquete->cincho;
		$vuelo=$paquete->codigo_vuelo;

		$id_proveedor=$paquete->id_proveedor;
		$nombre_proveedor=$paquete->nombre_proveedor;
		$nombre_tipo_paquete=$paquete->nombre_tipo_paquete;

		$estado=$paquete->nombre_status;
	}
?>

<!DOCTYPE html>
<html lang="es">
<!-- header con css -->
<?php require_once $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<!-- java scripts -->
<?php require_once $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<body>
	
	<!-- menu-->
	<?php 
		if($_SESSION['tipo_usuario']==1){
			require $conf['path_host'].'/include/include_menu_admin.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

<!--Inicio Contenido -->

	<!-- inicio datos cliente -->
	<br>
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<br>
	<!-- Fin datos cliente -->

	<center><h2>Transporte</h2></center>
	<table>
		<tr>
			<td>Vuelo:</td>
			<td><?php echo $vuelo;?></td>
		</tr>
		<tr>
			<td>Valija:</td>
			<td><?php echo $cincho;?></td>
		</tr>
	</table>

	<br>

	<center><h2>Detalles del paquete</h2></center>
	<table>
		<tr align="left">
			<td><strong>Estado actual</strong></td>
			<td><strong><?php echo $estado; ?></strong>   <a href="<?php echo $conf['path_host_url'] ?>/administracion/editar_paquete/editar_estado/editar_estado.php?id=<?php echo $id; ?>" class="button solid-color">Cambiar estado</a></td>
		</tr>
		<tr align="left">
			<td>N° cuenta de cliente</td>
			<td><?php echo $conf['path_cuenta']; ?> <?php echo $id_cliente; ?></td>
		</tr>
		<tr align="left">
			<td>TLC Tracking</td>
			<?php if(!empty($tracking_garve)){ ?>
				<td>: <?php echo $tracking_garve; ?></td>
			<?php }else{ ?>
				<td>: <?php echo $numero_miami; ?></td>
			<?php } ?>
		</tr>
		<tr align="left">
			<td>Consignatario</td>
			<td>: <?php echo $consignatario; ?></td>
		</tr>
		<tr align="left">
			<td>Compa&ntilde;ia Carrier</td>
			<td>: <?php echo $nombre_currier; ?></td>
		</tr>
		<tr align="left">
			<td>N&deg; Tracking USA</td>
			<td>: <?php echo $tracking_usa; ?></td>
		</tr>
		<?php if($id_proveedor==0){ ?>
			<tr align="left">
				<td>Proveedor</td>
				<td>: <?php echo $proveedor; ?></td>
			</tr>
		<?php }else{ ?>
			<tr align="left">
				<td>Proveedor</td>
				<td>: <?php echo $nombre_proveedor; ?></td>
			</tr>
		<?php } ?>
		<tr align="left">
			<td>Valor del paquete(USD)</td>
			<td>: <?php echo $valor; ?></td>
		</tr>
		<tr align="left">
			<td>Tipo de paquete</td>
			<td>: <?php echo $nombre_tipo_paquete; ?></td>
		</tr>
		<tr align="left">
			<td>Describe tu paquete</td>
			<td>: <?php echo $producto; ?></td>
		</tr>
		<tr align="left">
			<td>N° de paquetes</td>
			<td>: <?php echo $pieza; ?></td>
		</tr>
		<tr align="left">
			<td>Peso (Lb)</td>
			<td>: <?php echo $peso/0.45; ?></td>
		</tr>
		<tr align="left">
			<td>Medidas (cent&iacute;metros)</td>
			<td>
				Largo: <?php echo $largo; ?><br>
				Ancho: <?php echo $ancho; ?><br>
				Alto: <?php echo $alto; ?><br>
			</td>
		</tr>
	</table>

	<br>
	<br>
	<br>
	<br>

	<center><a href="<?php echo $conf['path_host_url'] ?>/administracion/editar_paquete/buscar_paquete.php" class="button solid-color">VOLVER</a></center>
	
	<br>
	<br>

</body>

</html>