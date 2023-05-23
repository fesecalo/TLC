<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	// funcion fecha actual tiene que ir despues de la conexion PDO
	require $conf['path_host'].'/funciones/fecha_actual.php';
	
	$id=$_GET["id"];
	$id_usu=$_SESSION['id_usu'];

	$db->prepare("SELECT
			paquete.id_paquete,
			paquete.consignatario,
			paquete.tracking_eu,
			paquete.tracking_garve,

			paquete.currier,
			currier.nombre_currier,

			paquete.proveedor,
			paquete.valor,
			paquete.pieza,
			paquete.descripcion_producto,
			paquete.peso,
			paquete.status

		FROM paquete as paquete
		INNER JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
		INNER JOIN data_status AS estado ON estado.id_status=paquete.status
		INNER JOIN data_currier AS currier ON currier.id_currier=paquete.currier
		WHERE paquete.id_paquete=:id
		ORDER BY paquete.id_paquete ASC
	");
	$db->execute(array(':id' => $id));

	$sql_paquete=$db->get_results();

	foreach ($sql_paquete as $key => $paquete) {
		$id_paquete=$paquete->id_paquete;
		$consignatario=$paquete->consignatario;
		$tracking_usa=$paquete->tracking_eu;
		$tracking_garve=$paquete->tracking_garve;
		$id_currier=$paquete->currier;
		$nombre_currier=$paquete->nombre_currier;
		$proveedor=$paquete->proveedor;
		$valor=$paquete->valor;
		$pieza=$paquete->pieza;
		$producto=$paquete->descripcion_producto;
		$peso=$paquete->peso;
		$status=$paquete->status;
	}

	$db->prepare("SELECT * 
		FROM paquete AS paquete
		INNER JOIN comprobante_compra AS comprobante ON comprobante.id_paquete=paquete.id_paquete
		WHERE paquete.id_paquete=:id
		ORDER BY comprobante.id_comprobante ASC
	");
	$db->execute(array(':id' => $id));

	$sql_comprobantes=$db->get_results();

	$db->prepare("SELECT * FROM cargos WHERE guia=:id ORDER BY id_cargo DESC LIMIT 1");
	$db->execute(array(':id' => $tracking_garve));

	$sql_cargos=$db->get_results();

	foreach ($sql_cargos as $key => $cargos) {
		$aduana=$cargos->aduana;
		$flete=$cargos->flete;
		$manejo=$cargos->manejo;
		$proteccion=$cargos->proteccion;
		$total=$cargos->total;
	}

	$sql_forma_pago=$db->get_results("SELECT * FROM data_forma_pago WHERE status=1 ");
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

		$("#enviar").click(function(){
			if($("#forma_pago").val()==0){
				alert("Seleccione forma de pago");
				$("#forma_pago").focus();
				return false;
			}

			document.procesa_paquete.submit();
		});

	});
</script>
<!-- Fin Validaciones -->
<!-- Fin Script -->
<body>

	<!-- menu-->
	<?php 
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==5){
			require $conf['path_host'].'/include/include_menu_servicio_cliente.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

	<!-- inicio datos cliente -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<!-- Fin datos cliente -->

	<!--Inicio Contenido -->
	<?php if(isset($_GET['msg'])){ ?>
		<div id="aviso"><center><h2>Paquete entregado exitosamente</h2></center><br></div>
	<?php } ?>
	<p>&nbsp;</p>
	<center><h2>Detalles del paquete</h2></center>
	<table>
		<tr align="left">
			<td>N&deg; Tracking <?php echo $conf['path_company_name']; ?></td>
			<td>: <?php echo $tracking_garve; ?></td>
		</tr>
		<tr align="left">
			<td>Consignatario</td>
			<td>: <?php echo $consignatario; ?></td>
		</tr>
		<tr align="left">
			<td>N&deg; Tracking USA</td>
			<td>: <?php echo $tracking_usa; ?></td>
		</tr>
		<tr align="left">
			<td>Compa&ntilde;ia Currier</td>
			<td>: <?php echo $nombre_currier; ?></td>
		</tr>
		<tr align="left">
			<td>Tienda</td>
			<td>: <?php echo $proveedor; ?></td>
		</tr>
		<tr align="left">
			<td>Valor del paquete(USD)</td>
			<td>: <?php echo $valor; ?></td>
		</tr>
		<tr align="left">
			<td>Describe tu paquete</td>
			<td>: <?php echo $producto; ?></td>
		</tr>
		<tr align="left">
			<td>Peso (KG)</td>
			<td>: <?php echo $peso; ?></td>
		</tr>
	</table>

	<p>&nbsp;</p>

	<center><h2>Cargos del paquete</h2></center>
	<?php if(empty($sql_cargos)){ ?>
		<table>
			<tr>
				<td><center><h2>No se han ingresado cargos asociados</h2></center></td>
			</tr>
		</table>
	<?php }else{ ?>

	<table>
		<tr>
			<td align="left">Aduana :</td>
			<td align="right">$ <?php echo $aduana; ?></td>
		</tr>
		<tr>
			<td align="left">Flete :</td>
			<td align="right">$ <?php echo $flete; ?></td>
		</tr>
		<tr>
			<td align="left">Manejo :</td>
			<td align="right">$ <?php echo $manejo; ?></td>
		</tr>
		<tr>
			<td align="left">Protecci&oacute;n :</td>
			<td align="right">$ <?php echo $proteccion; ?></td>
		</tr>
		<tr>
			<td align="left">Total :</td>
			<td align="right">$ <?php echo $total; ?></td>
		</tr>
	</table>

	<?php } ?>
	<p>&nbsp;</p>

	<?php if (!empty($sql_comprobantes)) { ?>
		<table>
		<tr>
			<td>Archivo</td>
			<td>Fecha</td>
			<td>Acci&oacute;n</td>
		</tr>
		<?php foreach ($sql_comprobantes as $key => $comprobantes) { ?>
				<tr>
					<td align="left"><?php echo $comprobantes->nombre_comprobante; ?></td>
					<td align="left"><?php echo date("d/m/Y H:i:s",strtotime($comprobantes->fecha)); ?></td>
					<?php if($comprobantes->extension==1){ ?>
						<td><a target="_blanck" href="<?php echo $conf['path_host_url'] ?>/miami/paquetes/gestor_archivos.php?envio=<?php echo $id; ?>&usu=<?php echo $id_cliente; ?>&nombre=<?php echo $comprobantes->nombre_comprobante; ?>&accion=1">ver</a></td>
					<?php }else{ ?>
						<td><a target="_blanck" href="<?php echo $conf['path_host_url'] ?>/miami/paquetes/gestor_archivos.php?envio=<?php echo $id; ?>&usu=<?php echo $id_cliente; ?>&nombre=<?php echo $comprobantes->nombre_comprobante; ?>&accion=2">Descargar</a></td>
					<?php } ?>
				</tr>
		<?php } ?>
		</table>
	<?php } ?>

	<?php if(!isset($_GET['msg'])){ ?>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<center><h2>Registrar forma de pago</h2></center>
	<form action="procesa_paquete.php" id="procesa_paquete" name="procesa_paquete" method="POST" >
	<input type="hidden" name="id_paquete" id="id_paquete" value="<?php echo $id; ?>">
	<table>
		<tr align="left">
			<td>Forma de pago</td>
			<td>
				<select class="form-control" id="forma_pago" name="forma_pago">
					<option value="0">Seleccione una opci&oacute;n</option>
					<?php
						foreach ($sql_forma_pago as $key => $pago) { 
					?>									?>
					<option value="<?php echo $pago->id_forma_pago; ?>"><?php echo $pago->forma_pago; ?></option>
					<?php
					}
				 	?>
			 	</select>
		 	</td>
		</tr>
		<tr>
			<td colspan="2"><input type="button" class="button solid-color" name="enviar" id="enviar" value="Confirmar entrega"></td>
		</tr>
	</table>
	</form>
	<?php } ?>

	<p>&nbsp;</p>
	<p>&nbsp;</p>

	<center><a href="entregar_paquete.php" class="button solid-color">VOLVER</a></center>
	
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>

</body>

</html>