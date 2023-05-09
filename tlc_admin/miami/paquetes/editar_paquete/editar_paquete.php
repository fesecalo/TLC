<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_paquete=$_GET['paquete'];

	$db->prepare("SELECT
			usuario.id_usuario,
			paquete.tracking_garve,
			paquete.consignatario,
			paquete.currier,
			paquete.tracking_eu,
			paquete.id_proveedor,
			paquete.valor,
			paquete.descripcion_producto,
			paquete.pieza,
			paquete.peso,
			paquete.largo,
			paquete.ancho,
			paquete.alto,
			paquete.id_tipo_paquete,
			paquete.eliminado
		FROM paquete as paquete
		INNER JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
		WHERE paquete.id_paquete=:id
		ORDER BY paquete.id_paquete ASC
	",true);
	$db->execute(array(':id' => $id_paquete));

	$sql_paquete=$db->get_results();

	foreach ($sql_paquete as $key => $paquete) {
		$id_cliente=$paquete->id_usuario;
		$tracking_garve=$paquete->tracking_garve;
		$consignatario=$paquete->consignatario;
		$id_currier=$paquete->currier;
		$tracking_usa=$paquete->tracking_eu;
		$valor=$paquete->valor;
		$producto=$paquete->descripcion_producto;
		$pieza=$paquete->pieza;
		$peso=$paquete->peso;
		$largo=$paquete->largo;
		$ancho=$paquete->ancho;
		$alto=$paquete->alto;
		$id_proveedor=$paquete->id_proveedor;
		$id_tipo_paquete=$paquete->id_tipo_paquete;
		$eliminado=$paquete->eliminado;
	}

	if (empty($sql_paquete)) {
		die("Paquete no encontrado, verifique tracking number.");
	}

	$sql_currier=$db->get_results("SELECT * FROM data_currier WHERE status=1 ORDER BY nombre_currier ASC");

	$sql_proveedor=$db->get_results("SELECT * FROM data_proveedor WHERE status=1 ORDER BY nombre_proveedor ASC");

	$sql_tipo_paquete=$db->get_results("SELECT * FROM data_tipo_paquete WHERE status=1 ORDER BY nombre_tipo_paquete ASC");
?>


<!DOCTYPE html>

<html lang="es">

<!-- HEAD-->
	<?php require $conf['path_host'].'/include/include_head.php'; ?>	
<!--FIN HEAD-->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<!-- Inicio Validaciones -->
<script type="text/javascript">
	$(document).ready(function(){

		// oculta los formularios de comprobante
		for(i=1; i<10; i++){
			$(".comprobante".concat(i)).hide();
		}
		// fin ocultar botones

		// agrega comprobante
		cont=0;
		for(j=0; j<10; j++){
			$("#agregar_comprobante".concat(j)).click(function(){
					cont=cont+1;
				$(".comprobante".concat(cont)).show();
			});
		}
		// fin agregar comprobante

		// elimina comprobante
		$("#eliminar_comprobante").click(function(){
			if(cont!=0){
				$(".comprobante".concat(cont)).hide();
				cont=cont-1;
			}
				
		});
		// fin eliina comprobante

		// accion al seleccionar carta como tipo de paquete
		$("#tipo_paquete").change(function(){
			if($("#tipo_paquete").val()==1){
				$(".medidas").hide();
			}else{
				$(".medidas").show();
			}
		});
		// fin accion al seleccionar carta como tipo de paquete

		if($("#tipo_paquete").val()==1){
			$(".medidas").hide();
		}

		// validacion solo letras y solo numeros
		var er_numeros=/[0-9]$/;
		var er_numeros2=/^[0-9]+([.][0-9]+)?$/;
		var er_letras= /[a-zA-Z\u00f1\u00d1\u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\^]$/;
		var er_ups=/(1z|1Z)+[a-zA-Z0-9]/;
		var er_usps=/[0-9]$/
		// fin validacion solo letras y solo numeros
		
		$("#enviar").click(function(){
			if($("#consignatario").val()==""){
				alert("Ingrese el nombre del consignatario.");
				$("#consignatario").focus();
				return false;
			}

			if($("#consignatario").val().match(er_letras)==null){
				alert("Solo son permitidos letras en este campo.");
				$("#consignatario").focus().select();
				return false;
			}

			if($("#currier").val()==0){
				alert("Seleccione una compañia de currier.");
				$("#currier").focus();
				return false;
			}

			if($("#tracking_usa").val()==""){
				alert("Ingrese el numero de tracking de USA.");
				$("#tracking_usa").focus();
				return false;
			}

			if($("#currier").val()==1){
				if($("#tracking_usa").val().match(er_ups)==null){
					alert("Debe comenzar con 1z letras y numeros.");
					$("#tracking_usa").focus().select();
					return false;
				}
			}

			if($("#currier").val()==3){
				if($("#tracking_usa").val().match(er_numeros)==null){
					alert("Solo se permiten numeros.");
					$("#tracking_usa").focus().select();
					return false;
				}
			}

			if($("#currier").val()==4){
				if($("#tracking_usa").val().match(er_numeros)==null){
					alert("Solo se permiten numeros.");
					$("#tracking_usa").focus().select();
					return false;
				}
			}

			if($("#currier").val()==5){
				if($("#tracking_usa").val().match(er_numeros)==null){
					alert("Solo se permiten numeros.");
					$("#tracking_usa").focus().select();
					return false;
				}
			}

			if($("#currier").val()==6){
				if($("#tracking_usa").val().match(er_numeros)==null){
					alert("Solo se permiten numeros.");
					$("#tracking_usa").focus().select();
					return false;
				}
			}

			if($("#proveedor").val()==0){
				alert("Seleccione la tienda proveedora del producto.");
				$("#proveedor").focus();
				return false;
			}

			if($("#valor").val()==""){
				alert("Ingrese el valor del producto, el valor con decimales debe ser ingresado con coma");
				$("#valor").focus();
				return false;
			}

			if($("#valor").val().match(er_numeros2)==null){
				alert("Solo son permitidos n\u00fameros, si es un decimal debe ser ingresado con punto");
				$("#valor").focus().select();
				return false;
			}

			if($("#tipo_paquete").val()==0){
				alert("Seleccione el tipo de paquete");
				$("#tipo_paquete").focus();
				return false;
			}

			if($("#producto").val()==""){
				alert("Ingrese el nombre del producto");
				$("#producto").focus();
				return false;
			}

			if($("#numero_piezas").val()==""){
				alert("Ingrese el nombre del producto");
				$("#numero_piezas").focus();
				return false;
			}

			if($("#numero_piezas").val().match(er_numeros)==null){
				alert("Solo son permitidos n\u00fameros.");
				$("#numero_piezas").focus().select();
				return false;
			}

			if($("#peso_kg").val()==""){
				alert("Ingrese peso en kg, el valor con decimales debe ser ingresado con coma");
				$("#peso_kg").focus();
				return false;
			}

			if($("#peso_kg").val().match(er_numeros2)==null){
				alert("Solo son permitidos n\u00fameros, si es un decimal debe ser ingresado con punto");
				$("#peso_kg").focus().select();
				return false;
			}

			if($("#largo").is(":visible")==true){
				if($("#largo").val()==""){
					alert("Ingrese medida Largo en cm");
					$("#largo").focus();
					return false;
				}

				if($("#largo").val().match(er_numeros2)==null){
					alert("Solo son permitidos n\u00fameros, si ingresara un decimal separe con punto.");
					$("#largo").focus().select();
					return false;
				}

				if($("#ancho").val()==""){
					alert("Ingrese medida Ancho en cm");
					$("#ancho").focus();
					return false;
				}

				if($("#ancho").val().match(er_numeros2)==null){
					alert("Solo son permitidos n\u00fameros, si ingresara un decimal separe con punto.");
					$("#ancho").focus().select();
					return false;
				}

				if($("#alto").val()==""){
					alert("Ingrese medida Alto en cm");
					$("#alto").focus();
					return false;
				}

				if($("#alto").val().match(er_numeros2)==null){
					alert("Solo son permitidos n\u00fameros, si ingresara un decimal separe con punto.");
					$("#alto").focus().select();
					return false;
				}
			}

			$("#cantidad_comprobantes").val(cont+1);

			document.paquete.submit();
		});

	});
</script>
<!-- Fin Validaciones -->

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


	<!-- inicio datos cliente -->
	<br>
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<br>
	<!-- Fin datos cliente -->

<h1>EDITAR PAQUETE</h1>
	<!--Inicio Contenido -->
	<center>

	<?php if($eliminado==1){ ?>
		<h2>PAQUETE ELIMINADO</h2>
	<?php } ?>

	<form id="paquete" name="paquete" action="procesa_editar.php" method="post" enctype="multipart/form-data">
	<input type="hidden" id="id_paquete" name="id_paquete" value="<?php echo $id_paquete; ?>">
	<table>
		<tr align="left">
			<td>N&deg; cuenta de cliente</td>
			<td>
				<input type="text" class="form-control" id="cliente" name="cliente" maxlength="100" value="<?php echo $id_cliente; ?>" readonly="true">
				<a href="editar_cliente/editar_cliente.php?id_paquete=<?php echo $id_paquete; ?>&id=<?php echo $id_cliente; ?>">Cambiar cuenta de cliente</a>
			</td>
		</tr>
		<tr align="left">
			<td>N&deg; Tracking <?php echo $conf['path_company_name']; ?></td>
			<td><input type="text" class="form-control" id="tracking_garve" name="tracking_garve" maxlength="100" value="<?php echo $tracking_garve; ?>" readonly="true"></td>
		</tr>
		<tr align="left">
			<td>Consignatario</td>
			<td><input type="text" class="form-control" id="consignatario" name="consignatario" maxlength="100" value="<?php echo $consignatario; ?>" ></td>
		</tr>
		<tr align="left">
			<td>Compa&ntilde;ia carrier</td>
			<td>
				<select class="form-control" id="currier" name="currier">
				<?php if($id_currier==0){ ?>
					<option value="0">Seleccione compa&ntilde;ia de currier</option>
				<?php }else{ ?>
					<?php foreach ($sql_currier as $key => $currier) { ?>
						<option value="<?php echo $currier->id_currier; ?>" <?php if($id_currier==($currier->id_currier)) {?> selected="selected" <?php }?> ><?php echo $currier->nombre_currier; ?></option>
					<?php } ?>
				<?php } ?>
			 	</select>
		 	</td>
		</tr>
		<tr align="left">
			<td>N&deg; Tracking USA</td>
			<td><input type="text" class="form-control" id="tracking_usa" name="tracking_usa" maxlength="100" value="<?php echo $tracking_usa; ?>"></td>
		</tr>
		<tr align="left">
			<td>Proveedor</td>
			<td>
				<select class="form-control" id="proveedor" name="proveedor">
					<option value="0">Seleccione una opci&oacute;n</option>
					<?php foreach ($sql_proveedor as $key => $proveedor) { ?>
						<option value="<?php echo $proveedor->id_proveedor; ?>" <?php if($id_proveedor==($proveedor->id_proveedor)) {?> selected="selected" <?php }?> ><?php echo $proveedor->nombre_proveedor; ?></option>
					<?php } ?>
			 	</select>
		 	</td>
		</tr>
		<tr align="left">
			<td>Valor del paquete(USD)</td>
			<td><input type="text" class="form-control" id="valor" name="valor" maxlength="100" value="<?php echo $valor; ?>"></td>
		</tr>
		<tr align="left">
			<td>Tipo de paquete</td>
			<td>
				<select class="form-control" id="tipo_paquete" name="tipo_paquete">
					<option value="0">Seleccione una opci&oacute;n</option>
					<?php foreach ($sql_tipo_paquete as $key => $tipo_paquete) { ?>
						<option value="<?php echo $tipo_paquete->id_tipo_paquete; ?>" <?php if($id_tipo_paquete==($tipo_paquete->id_tipo_paquete)) {?> selected="selected" <?php }?> ><?php echo $tipo_paquete->nombre_tipo_paquete; ?></option>
					<?php } ?>
			 	</select>
		 	</td>
		</tr>
		<tr align="left">
			<td>Describe tu paquete</td>
			<td><textarea class="form-control" id="producto" name="producto" rows="6" cols="50" maxlength="300"><?php echo $producto; ?></textarea></td>
		</tr>
		<tr align="left">
			<td>N&deg; de paquetes</td>
			<td><input type="text" class="form-control" id="numero_piezas" name="numero_piezas" maxlength="100" value="<?php echo $pieza; ?>"></td>
		</tr>
		<tr align="left">
			<td>Peso (Lb)</td>
			<td><input type="text" class="form-control" id="peso_kg" name="peso_kg" maxlength="100" value="<?php echo $peso/0.45; ?>"></td>
		</tr>
		<tr align="left" class="medidas">
			<td>Medidas (inch)</td>
			<td>
				Largo<input type="text" id="largo" name="largo" maxlength="100" value="<?= round($largo/2.54, 2); ?>">
				Ancho<input type="text" id="ancho" name="ancho" maxlength="100" value="<?= round($ancho/2.54, 2); ?>">
				Alto<input type="text" id="alto" name="alto" maxlength="100" value="<?= round($alto/2.54, 2); ?>">
			</td>
		</tr>
	</table>
	
	<p>&nbsp;</p>
	
	<table>
		<tr>
			<?php if($eliminado==0){ ?>
				<td colspan="2"><center><input type="button" class="button solid-color" name="enviar" id="enviar" value="Guardar"></center></td>

				<td><a href="<?php echo $conf['path_host_url'] ?>/miami/etiqueta/imprime_etiqueta.php?paquete=<?php echo $id_paquete; ?>&total=<?php echo $pieza;?>&barcode=<?php echo $tracking_garve;?>" target="_blank" class="button solid-color">Imprimir</a></td>

				<td><a href="<?php echo $conf['path_host_url'] ?>/miami/paquetes/editar_paquete/eliminar_paquete.php?id_paquete=<?php echo $id_paquete; ?>" class="button solid-color-danger">ELIMINAR</a></td>

				<td><a href="<?php echo $conf['path_host_url'] ?>/miami/paquetes/editar_paquete/inicio_escanear_codigo.php" class="button solid-color">VOLVER</a></td>
			<?php }else{ ?>
				<td><a href="<?php echo $conf['path_host_url'] ?>/miami/paquetes/editar_paquete/inicio_escanear_codigo.php" class="button solid-color">VOLVER</a></td>
			<?php } ?>
		</tr>
	</table>
	</form>
	</center>
	<!-- Fin de contenido -->
</body>
</html>
