<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id=$_GET["paquete"];

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
			paquete.peso_volumen

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
		$peso_volumen=$paquete->peso_volumen;
	}

	// consulta los archivos de comprobante
	$db->prepare("SELECT
			id_comprobante,
			nombre_comprobante,
			extension,
			fecha,
			eliminado
		FROM comprobante_compra
		WHERE id_paquete=:id
		AND eliminado=0
		ORDER BY id_comprobante ASC
	");
	$db->execute(array(':id' => $id));
	$sql_comprobantes=$db->get_results();
	// Fin consulta archivos de comprobantes

	if($tracking_garve==''){
		$db->prepare("SELECT * FROM cargos WHERE guia=:id ORDER BY id_cargo DESC LIMIT 1");
		$db->execute(array(':id' => $numero_miami));
		$sql_cargos=$db->get_results();
	}else{
		$db->prepare("SELECT * FROM cargos WHERE guia=:id ORDER BY id_cargo DESC LIMIT 1");
		$db->execute(array(':id' => $tracking_garve));
		$sql_cargos=$db->get_results();
	}

	foreach ($sql_cargos as $key => $cargos) {
		$aduana=$cargos->aduana;
		$flete=$cargos->flete;
		$manejo=$cargos->manejo;
		$proteccion=$cargos->proteccion;
		$total=$cargos->total;
	}
?>

<!DOCTYPE html>
<html lang="es">
<!-- header con css -->
<?php require $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<!-- Fin Validaciones -->
<script type="text/javascript">
	$(document).ready(function(){

		var er_numeros2=/^[0-9]+([.][0-9]+)?$/;

		// oculta los formularios de comprobante
		for(i=1; i<10; i++){
			$(".comprobante".concat(i)).hide();
		}
		// fin ocultar botones

		// agrega comprobante
		cont=0;
		$("#agregar_comprobante").click(function(){
				cont=cont+1;
				if(cont>10){
					cont=9;
				}
			$(".comprobante".concat(cont)).show();
		});
		// fin agregar comprobante

		// elimina comprobante
		$("#eliminar_comprobante").click(function(){
			if(cont!=0){
				$(".comprobante".concat(cont)).hide();
				cont=cont-1;
			}
				
		});
		// fin eliina comprobante
		

		$("#enviar").click(function(){

			for(r=0; r<(cont+1); r++){
				if($("#comprobante".concat(r)).val()=="")
				{
					alert("Seleccione un comprobante.");
					$("#comprobante".concat(r)).focus();
					return false;
				}

				if($("#valorFactura".concat(r)).val()=="")
				{
					alert("ingrese valor de factura.".concat(r+1));
					$("#valorFactura".concat(r)).focus();
					return false;
				}else if($("#valorFactura".concat(r)).val().match(er_numeros2)==null){
					alert("Solo son permitidos n\u00fameros, si es un decimal debe ser ingresado con punto");
					$("#valorFactura".concat(r)).focus();
					return false;
				}
			}

			$("#cantidad_comprobantes").val(cont+1);

			document.comprobante.submit();
		});

	});
</script>
<!-- Fin Script -->

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
	<table class="table-striped table-bordered">
		<tr>
			<td>Fecha</td>
			<td>Detalle</td>
			<td>Lugar</td>
			<td>Comentario</td>
		</tr>
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
		<tr align="left">
			<td>Peso volumetrico (KG/VOL)</td>
			<td>: <?php echo $peso_volumen; ?></td>
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

	<center><h2>factura o comprobantes de compra</h2></center>

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
					<td><a href="eliminar_comprobante.php?id_comprobante=<?php echo $comprobantes->id_comprobante; ?>&nombre=<?php echo $comprobantes->nombre_comprobante; ?>&paquete=<?php echo $id; ?>">Eliminar</a></td>
				</tr>
		<?php } ?>
		</table>
	<?php } ?>


	<br>
	<br>

	<br>
	<center><h2>A&ntilde;ade la factura o comprobante de compra</h2></center>
	<br>

	<table>
		<tr>
			<td><input class="trabajar-btn" type="button" id="agregar_comprobante" name="agregar_comprobante" value="+"></td>
			<td><input class="trabajar-btn" type="button" id="eliminar_comprobante" name="eliminar_comprobante" value="-"></td>
		</tr>
	</table>

	<form id="comprobante" name="comprobante" action="subir_comprobante.php" method="post" enctype="multipart/form-data">
		<table class="responsive">
			<?php for ($i=0; $i <10 ; $i++) { ?>
			<tr class="comprobante<?php echo $i ?>">
				<td>
					<?php echo $i+1; ?>)<br>
					<input type="file" name="comprobante<?php echo $i ?>" id="comprobante<?php echo $i ?>"/><br>
					Valor total compra USD(Incluye valor producto+shipping+tax)<br>
					<input type="text" name="valorFactura<?php echo $i ?>" id="valorFactura<?php echo $i ?>"/>
				</td>
			</tr>
			<?php } ?>
		</table>
	
		<input type="hidden" id="cantidad_comprobantes" name="cantidad_comprobantes">
		<input type="hidden" id="id_paquete" name="id_paquete" value="<?php echo $id; ?>">
	</form>
	<!-- fin campos hidden -->
	<table>
		<tr>
			<td colspan="2"><center><input type="button" class="button solid-color" name="enviar" id="enviar" value="Guardar Comprobante"></center></td>
		</tr>
	</table>

	<!-- <center><a href="<?php echo $conf['path_host_url'] ?>/servicio_cliente/buscar_paquete/tabla_buscar_paquete.php?codigo=<?php echo $id_cliente; ?>" class="button solid-color">VOLVER</a></center> -->
	
	<br>
	<br>
	<br>
	<br>

</body>

</html>