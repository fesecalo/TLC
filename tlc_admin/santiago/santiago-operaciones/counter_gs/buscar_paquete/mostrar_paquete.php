<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id=$_GET["paquete"];

	$db->prepare("SELECT 
			historial.fecha,
			estado.nombre_status,
			lugar.nombre_lugar
		FROM status_log AS historial
		INNER JOIN data_status AS estado ON estado.id_status=historial.id_tipo_status
		INNER JOIN data_lugar AS lugar ON lugar.id_lugar=historial.id_lugar
		WHERE id_paquete=:id
		ORDER BY historial.fecha DESC
	");
	$db->execute(array(':id' => $id ));
	$sql_historial=$db->get_results();

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
			tipo_paquete.nombre_tipo_paquete

		FROM paquete as paquete
		INNER JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
		INNER JOIN data_currier AS currier ON currier.id_currier=paquete.currier
		LEFT JOIN valijas AS valija ON valija.id_valija=paquete.id_valija
		LEFT JOIN vuelos AS vuelo ON vuelo.id_vuelos=paquete.id_vuelo
		LEFT JOIN data_proveedor AS proveedor ON proveedor.id_proveedor=paquete.id_proveedor
		LEFT JOIN data_tipo_paquete AS tipo_paquete ON tipo_paquete.id_tipo_paquete=paquete.id_tipo_paquete
		WHERE paquete.id_paquete=:id
		ORDER BY paquete.id_paquete ASC
	",true);
	$db->execute(array(':id' => $id));

	$sql_paquete=$db->get_results();

	foreach ($sql_paquete as $key => $paquete) {
		$id_cliente=$paquete->id_usuario;
		$tracking_garve=$paquete->tracking_garve;
		$numero_miami =$paquete->numero_miami ;
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
	}

	$db->prepare("SELECT * 
		FROM paquete AS paquete
		INNER JOIN comprobante_compra AS comprobante ON comprobante.id_paquete=paquete.id_paquete
		WHERE paquete.id_paquete=:id
		ORDER BY comprobante.id_comprobante ASC
	");
	$db->execute(array(':id' => $id));

	$sql_comprobantes=$db->get_results();
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
	// funcion que cambia el peso de los paquetes
	function guardar(){
		var er_numeros2=/^[0-9]+([.][0-9]+)?$/;

		if($("#peso_kg").val()==""){
			alert("Ingrese peso en Kilogramos, el valor con decimales debe ser ingresado con coma");
			$("#peso_kg").focus();
			return false;
		}

		if($("#peso_kg").val().match(er_numeros2)==null){
			alert("Solo son permitidos n\u00fameros, si ingresara un decimal separe con punto.");
			$("#peso_kg").focus().select();
			return false;
		}

		var id_paquete=$("#id_paquete").val();
		var peso=$("#peso_kg").val();

		window.location.href = "procesa_guardar_peso.php?id_paquete="+id_paquete+"&peso="+peso;
	}
	// funcion que cambia el peso de los paquetes
</script>

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

	<!-- inicio datos cliente -->
	<p>&nbsp;</p>
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<p>&nbsp;</p>
	<!-- Fin datos cliente -->

	<center><h2>Seguimiento del paquete</h2></center>
	<table>
		<tr>
			<td>Fecha</td>
			<td>Detalle</td>
			<td>Lugar</td>
		</tr>
		<tr>
			<td colspan="3"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php $x=1; foreach ($sql_historial as $key => $historial) {  ?>
			<tr>
				<td><?php echo date("d/m/Y H:i:s",strtotime($historial->fecha)); ?></td>
				<td><?php echo $historial->nombre_status; ?></td>
				<td><?php echo $historial->nombre_lugar; ?></td>
			</tr>
		<?php } ?>
	</table>

	<br>

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
	<input type="hidden" id="id_paquete" name="id_paquete" value="<?php echo $id;?>">
	<table>
		<tr align="left">
			<td>N° cuenta de cliente</td>
			<td><?php echo $conf['path_cuenta']; ?> <?php echo $id_cliente; ?></td>
		</tr>
		<tr align="left">
			<td>N&deg; Tracking <?php echo $conf['path_company_name']; ?></td>
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
			<td>Peso (KG)</td>
			<td>: <input type="text" class="form-control" id="peso_kg" name="peso_kg" maxlength="100" value="<?php echo $peso; ?>"></td>
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

	<p>&nbsp;</p>

	<center><h2>factura o comprobantes de compra</h2></center>

	<?php if (!empty($sql_comprobantes)) { ?>
		<table>
		<tr>
			<td>Archivo</td>
			<td>Acci&oacute;n</td>
		</tr>
		<?php foreach ($sql_comprobantes as $key => $comprobantes) { ?>
			<?php if($comprobantes->extension==1){ ?>
				<tr>
					<td align="left"><?php echo $comprobantes->nombre_comprobante; ?></td>
					<td><a target="_blanck" href="<?php echo $conf['path_host_url'] ?>/miami/paquetes/gestor_archivos.php?envio=<?php echo $id; ?>&usu=<?php echo $id_cliente; ?>&nombre=<?php echo $comprobantes->nombre_comprobante; ?>&accion=1">ver</a></td>
				</tr>
			<?php }else{ ?>
				<tr>
					<td align="left"><?php echo $comprobantes->nombre_comprobante; ?></td>
					<td><a target="_blanck" href="<?php echo $conf['path_host_url'] ?>/miami/paquetes/gestor_archivos.php?envio=<?php echo $id; ?>&usu=<?php echo $id_cliente; ?>&nombre=<?php echo $comprobantes->nombre_comprobante; ?>&accion=2">Descargar</a></td>
				</tr>
			<?php } ?>
		<?php } ?>
		</table>
	<?php } ?>


	<br>
	<br>

	<center>
		<a href="<?php echo $conf['path_host_url'] ?>/santiago/santiago-operaciones/counter_gs/buscar_paquete/index.php" class="button solid-color">VOLVER</a>
		<a class="button solid-color" onclick="guardar();">Guardar</a>
	</center>
	
	<br>
	<br>
	<br>
	<br>

</body>

</html>