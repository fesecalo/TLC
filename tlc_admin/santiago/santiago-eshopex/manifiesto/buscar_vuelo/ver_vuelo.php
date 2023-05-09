<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_vuelo=$_GET['vuelo'];;

	$db->prepare("SELECT * FROM vuelos WHERE id_vuelos=:id_vuelo ORDER BY id_vuelos DESC");
	$db->execute(array(':id_vuelo' => $id_vuelo ));
	$sql_vuelo=$db->get_results();

	$db->prepare("SELECT 
			paquete.id_paquete,
			paquete.id_archivo_trancito,
			paquete.id_usuario,
			paquete.id_vuelo,

			usuario.nombre,
			usuario.apellidos,
			usuario.rut,

			paquete.rut AS rutConsignatario,

			paquete.consignatario,
			paquete.tracking_garve,
			paquete.numero_miami,
			paquete.tracking_eu,
			paquete.descripcion_producto,

			paquete.prealerta,

			estado.nombre_status,

			paquete.proveedor,
			proveedor.nombre_proveedor

		FROM paquete AS paquete
		LEFT JOIN data_status AS estado ON estado.id_status=paquete.status
		LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
		LEFT JOIN data_proveedor AS proveedor ON proveedor.id_proveedor=paquete.id_proveedor
		WHERE id_vuelo=:id_vuelo 
		ORDER BY id_paquete DESC
	");
	$db->execute(array(':id_vuelo' => $id_vuelo ));
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

		$("#msj_confirmar_vuelo").hide();

		$("#confirmar_vuelo").click(function(){
			$("#confirmar_vuelo").hide();
			$("#msj_confirmar_vuelo").show();
 		});

	});
</script>

<body>

	<!-- menu-->
	<?php 
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==4){
			require $conf['path_host'].'/include/include_menu_operador_eshopex.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

	<!--Inicio Contenido -->
	<div id="logo"><h1>Paquetes en transito</h1></div>

	<!-- inicio datos usuario -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<!-- Fin datos usuario -->

	<br>
	<br>
	<?php if(empty($sql_paquete)){ ?>
		<center><h2>No tiene paquetes</h2></center>
	<?php }else{ ?>

	<br>
	<br>

	<table>
		<tr>
			<td><a href="../manifiesto/manifiesto_excel/excel_manifiesto.php?id=<?php echo $sql_paquete[0]->id_vuelo; ?>" class="button solid-color">DESCARGAR EXCEL</a></td>
		</tr>
	</table>

	<br>
	<br>

	<table>
		<tr>
			<td>N&deg;</td>
			<td>Cuenta</td>
			<td>usuario</td>
			<td>Rut usuario</td>
			<td>Consignatario</td>
			<td>Rut consignatario</td>
			<td>Prealerta</td>
			<td>N&deg; Guia</td>
			<td>TRACKING USA</td>
			<td>TIENDA</td>
			<td>DESCRIPCI&Oacute;N</td>
			<td>ESTADO</td>
		</tr>
		<tr>
			<td colspan="13"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php $x=1; foreach ($sql_paquete as $key => $paquete) {  ?>
			<tr>
				<td><?php echo $x; ?></td>
				<td><?php echo $conf['path_cuenta'].$paquete->id_usuario; ?></td>
				<td><?php echo $paquete->nombre.' '.$paquete->apellidos; ?></td>
				<td><?php echo $paquete->rut; ?></td>
				<td><?php echo $paquete->consignatario; ?></td>
				<td><?php echo $paquete->rutConsignatario; ?></td>

				<?php if($paquete->prealerta==0){ ?>
					<td>NO</td>
				<?php }else{ ?>
					<td>SI</td>
				<?php } ?>

				<?php if($paquete->tracking_garve==''){ ?>
					<td><?php echo $paquete->numero_miami; ?></td>
				<?php }else{ ?>
					<td><?php echo $paquete->tracking_garve; ?></td>
				<?php } ?>

				<td><?php echo $paquete->tracking_eu; ?></td>

				<?php if($paquete->proveedor==''){ ?>
					<td><?php echo $paquete->nombre_proveedor; ?></td>
				<?php }else{ ?>
					<td><?php echo $paquete->proveedor; ?></td>
				<?php } ?>
				
				<td><?php echo $paquete->descripcion_producto; ?></td>
				<td><?php echo $paquete->nombre_status; ?></td>

			</tr>
			<tr>
				<td colspan="13"><hr size="1" color="#FF6600" /></td>
			</tr>
		<?php $x++; } ?>
	</table>
	<?php } ?>

	<br>
	<br>
	<center><a href="<?php echo $conf['path_host_url'] ?>/santiago/santiago-eshopex/manifiesto/buscar_vuelo/vuelos.php" class="button solid-color">VOLVER</a></center>
	<br>
	<br>
	<br>
	<br>
	<!-- Fin de contenido -->

</body>
</html>