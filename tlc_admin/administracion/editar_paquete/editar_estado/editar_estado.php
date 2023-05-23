<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id=$_GET["id"];

	$db->prepare("SELECT 
			historial.fecha,
			estado.nombre_status,
			lugar.nombre_lugar,
			historial.comentario
		FROM status_log AS historial
		INNER JOIN data_status AS estado ON estado.id_status=historial.id_tipo_status
		INNER JOIN data_lugar AS lugar ON lugar.id_lugar=historial.id_lugar
		WHERE id_paquete=:id
		ORDER BY historial.id_status_log DESC
	");
	$db->execute(array(':id' => $id ));
	$sql_historial=$db->get_results();

	$db->prepare("SELECT
			paquete.id_usuario,
			paquete.tracking_garve,
			paquete.numero_miami,

			paquete.status,
			estado.nombre_status

		FROM paquete as paquete
		LEFT JOIN data_status AS estado ON estado.id_status=paquete.status
		WHERE paquete.id_paquete=:id
		ORDER BY paquete.id_paquete ASC
	");
	$db->execute(array(':id' => $id));

	$sql_paquete=$db->get_results();

	foreach ($sql_paquete as $key => $paquete) {
		$id_cliente=$paquete->id_usuario;
		$tracking_garve=$paquete->tracking_garve;
		$numero_miami=$paquete->numero_miami;

		$id_estado=$paquete->status;
		$estado=$paquete->nombre_status;
	}

	$resEstado=$db->get_results("SELECT * FROM data_status WHERE status=1");
	$resLugar=$db->get_results("SELECT * FROM data_lugar WHERE status=1");
?>

<!DOCTYPE html>
<html lang="es">
<!-- header con css -->
<?php require $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<!-- Inicio Validaciones -->
<script type="text/javascript">
	$(document).ready(function(){

		$("#id_estado").change(function(){
			if ($("#id_estado").val()==1 || $("#id_estado").val()==8) {
				$("#id_lugar").val('1');
			}

			if ($("#id_estado").val()==2) {
				$("#id_lugar").val('2');
			}

			if ($("#id_estado").val()==3 || $("#id_estado").val()==13) {
				$("#id_lugar").val('3');
			}

			if ($("#id_estado").val()==4 || $("#id_estado").val()==7 || $("#id_estado").val()==10 || $("#id_estado").val()==11 || $("#id_estado").val()==12 || $("#id_estado").val()==25 || $("#id_estado").val()==26 || $("#id_estado").val()==27) {
				$("#id_lugar").val('4');
			}

			if ($("#id_estado").val()==5 || $("#id_estado").val()==6 || $("#id_estado").val()==9 || $("#id_estado").val()==14 || $("#id_estado").val()==15 || $("#id_estado").val()==16 || $("#id_estado").val()==17 || $("#id_estado").val()==18 || $("#id_estado").val()==19 || $("#id_estado").val()==20) {
				$("#id_lugar").val('5');
			}
		});
		
		$("#guardar").click(function(){
			if($("#id_estado").val()==0){
				alert("Seleccione un estado.");
				$("#id_estado").focus();
				return false;
			}

			$("#id_lugar_enviar").val($("#id_lugar").val());

			document.actualizar_paquete.submit();
		});

	});
</script>
<!-- Fin Validaciones -->
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
	<p>&nbsp;</p>
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<p>&nbsp;</p>
	<!-- Fin datos cliente -->

	<h1>Editar estado</h1>

	<center><h2>Detalles del paquete</h2></center>
	<table class="table-striped table-bordered">
		<tr align="left">
			<td>N° cuenta de cliente:</td>
			<td><?php echo $conf['path_cuenta']; ?> <?php echo $id_cliente; ?></td>
		</tr>
		<tr align="left">
			<td>TLC Tracking</td>
			<?php if(!empty($tracking_garve)){ ?>
				<td> <?php echo $tracking_garve; ?></td>
			<?php }else{ ?>
				<td> <?php echo $numero_miami; ?></td>
			<?php } ?>
		</tr>
	</table>

	<br>
	<br>

	<center><h2>Seguimiento del paquete</h2></center>
	<table class="table-striped table-bordered">
		<tr>
			<td>Fecha</td>
			<td>Detalle</td>
			<td>Lugar</td>
			<td>Comentario</td>
		</tr>
		<form action="procesa_editar_estado.php" id="actualizar_paquete" name="actualizar_paquete" method="POST" >
			<input type="hidden" id="id_paquete" name="id_paquete" value="<?php echo $id; ?>">
			<input type="hidden" id="id_lugar_enviar" name="id_lugar_enviar">
			<tr>
				<td><?php echo date("d/m/Y H:i:s"); ?></td>
				<td>
					<select class="form-control" id="id_estado" name="id_estado">
						<option value="0">Seleccione estado</option>
						<?php foreach ($resEstado as $key => $estado) { ?>
							<option value="<?php echo $estado->id_status; ?>"><?php echo $estado->nombre_status; ?></option>
						<?php } ?>
				 	</select>
				</td>
				<td>
					<select class="form-control" id="id_lugar" name="id_lugar" disabled="true">
						<option value="0">Seleccione estado</option>
						<?php foreach ($resLugar as $key => $lugar) { ?>
							<option value="<?php echo $lugar->id_lugar; ?>"><?php echo $lugar->nombre_lugar; ?></option>
						<?php } ?>
				 	</select>
				</td>
				<td>
					<textarea class="form-control" id="cometario" name="cometario" rows="6" cols="50" maxlength="300"></textarea>
				</td>
				<td><input type="button" class="button solid-color" id="guardar" name="guardar" value="Guardar"></td>
			</tr>
		</form>
		<?php $x=1; foreach ($sql_historial as $key => $historial) {  ?>
			<tr>
				<td><?php echo date("d/m/Y H:i:s",strtotime($historial->fecha)); ?></td>
				<td><?php echo $historial->nombre_status; ?></td>
				<td><?php echo $historial->nombre_lugar; ?></td>
				<td><?php echo $historial->comentario; ?></td>
			</tr>
		<?php } ?>
	</table>

	<br>
	<br>
	<br>
	<br>

	<center>
		<a href="<?php echo $conf['path_host_url'] ?>/administracion/editar_paquete/mostrar_paquete.php?paquete=<?php echo $id; ?>" class="button solid-color">VOLVER</a>

	</center>
	
	<br>
	<br>
	<br>
	<br>

</body>

</html>