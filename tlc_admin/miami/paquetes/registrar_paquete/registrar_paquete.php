<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	if (isset($_GET["tracking"])) {
		$tracking_usa=$_GET["tracking"];
	}else{
		$tracking_usa='';
	}

	if (isset($_GET["id"])) {
		$id=$_GET["id"];

		$db->prepare("SELECT * FROM gar_usuarios WHERE id_usuario=:id ORDER BY id_usuario DESC LIMIT 1");
		$db->execute(array(':id' => $id));
		$sql=$db->get_results();

		foreach ($sql as $key => $cliente) {
			$id_cliente=$cliente->id_usuario;
			$nombre=$cliente->nombre;
			$apellidos=$cliente->apellidos;
		}
	}

	$sql_currier=$db->get_results("SELECT * FROM data_currier WHERE status=1 ORDER BY nombre_currier ASC");
	$sql_proveedor=$db->get_results("SELECT * FROM data_proveedor WHERE status=1 ORDER BY nombre_proveedor ASC");
	$sql_tipo_paquete=$db->get_results("SELECT * FROM data_tipo_paquete WHERE status=1 ORDER BY nombre_tipo_paquete ASC");
?>

<!DOCTYPE html>

	<!-- HEAD-->
	<?php require $conf['path_host'].'/include/include_head.php'; ?>	
	<!--FIN HEAD-->

	<!-- java scripts -->
	<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
	<!-- fin java scripts-->

	<!-- Inicio Validaciones -->
	<script type="text/javascript">
		$(document).ready(function(){
			$("#codigo").select();

			$("#buscar").click(function(){
				if($("#codigo").val()==""){
					alert("Ingrse el nombre del cliente a buscar.");
					$("#codigo").focus();
					return false;
				}
				text=$("#codigo").val().replace(/ /g,'');
				track=$("#tracking_usa").val().replace(/ /g,'');

				$("#datos_clientes").load("buscar_cliente.php?tracking="+track+"&codigo="+text);
			});

			$('#codigo').keypress(function(e){
		        if(e.which == 13){
		            $('#buscar').click();
		        }
	        });

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
				}else if($("#tipo_paquete").val()==6){
					$(".medidas").hide();
				}else{
					$(".medidas").show();
				}
			});
			// fin accion al seleccionar carta como tipo de paquete

			// validacion solo letras y solo numeros
			var er_numeros=/[0-9]$/;
			var er_numeros2=/^[0-9]+([.][0-9]+)?$/;
			var er_letras= /[a-zA-Z\u00f1\u00d1\u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\^]$/;
			var er_ups=/(1z|1Z)+[a-zA-Z0-9]/;
			var er_usps=/[0-9]$/
			// fin validacion solo letras y solo numeros
			

			$("#enviar").click(function(){
				if($("#cliente").val()==""){
					alert("Ingrese el numero de cuenta del cliente.");
					$("#cliente").focus();
					return false;
				}

				if($("#cliente").val().match(er_numeros)==null){
					alert("Solo son permitidos numeros en este campo.");
					$("#cliente").focus().select();
					return false;
				}

				if($("#consignatario").val()==""){
					alert("Ingrese el nombre del consignatario.");
					$("#consignatario").focus();
					return false;
				}

				/*if($("#consignatario").val().match(er_letras)==null){
					alert("Solo son permitidos letras en este campo.");
					$("#consignatario").focus().select();
					return false;
				}*/

				if($("#tracking_usa").val()==""){
					alert("Ingrese el numero de tracking de USA.");
					$("#tracking_usa").focus();
					return false;
				}

				if($("#proveedor").val()==0){
					alert("Seleccione la tienda proveedora del producto.");
					$("#proveedor").focus();
					return false;
				}
				
				if($("#currier").val()==0){
					alert("Seleccione una compañia de currier.");
					$("#currier").focus();
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

				if($("#valor").val()==""){
					alert("Ingrese el valor del producto");
					$("#valor").focus();
					return false;
				}

				if($("#valor").val().match(er_numeros2)==null){
					alert("Solo son permitidos n\u00fameros, si ingresara un decimal separe con un punto.");
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

				if($("#libras").val()==""){
					alert("Ingrese peso en libras, el valor con decimales debe ser ingresado con coma");
					$("#libras").focus();
					return false;
				}

				if($("#libras").val().match(er_numeros2)==null){
					alert("Solo son permitidos n\u00fameros, si ingresara un decimal separe con punto.");
					$("#libras").focus().select();
					return false;
				}

				if($("#largo").is(":visible")==true){

					if($("#largo").val()==""){
						alert("Ingrese medida Largo en pulgadas");
						$("#largo").focus();
						return false;
					}

					if($("#largo").val().match(er_numeros2)==null){
						alert("Solo son permitidos n\u00fameros, si ingresara un decimal separe con punto.");
						$("#largo").focus().select();
						return false;
					}

					if($("#ancho").val()==""){
						alert("Ingrese medida Ancho en pulgadas");
						$("#ancho").focus();
						return false;
					}

					if($("#ancho").val().match(er_numeros2)==null){
						alert("Solo son permitidos n\u00fameros, si ingresara un decimal separe con punto.");
						$("#ancho").focus().select();
						return false;
					}

					if($("#alto").val()==""){
						alert("Ingrese medida Alto en pulgadas");
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

				document.registrar.submit();

			});

		});
	</script>
	<!-- Fin Validaciones -->
	<script type="text/javascript">
		function abrir_popup(){
			// opens events in a popup window
			window.open('<?php echo $conf['path_host_url'] ?>/miami/configuracion/proveedores/agregar_proveedor_express.php', 'gcalevent', 'width=700,height=600');
			return false;
		}
	</script>

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
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<!-- Fin datos cliente -->

	<h1>REGISTRAR PAQUETE</h1>
	<!--Inicio Contenido -->
	<center>
		<table>
			<tr>
				<td colspan="2"><h3>Buscar Cliente</h3></td>
			</tr>
			<tr>
				<td><input type="text" class="form-control" id="codigo" name="codigo" size="40" placeholder="Ingrese numero de cliente"></td>
				<td><input type="button" class="button solid-color" id="buscar" name="buscar" value="Buscar"></td>
			</tr>
		</table>

		<br>
		<h2>Envio no prealertado, ingresar datos</h2>

		<br>
		<br>

		<div id="datos_clientes"></div>
		
		<br>
		<br>

		<form id="registrar" name="registrar" action="procesa_registrar.php" method="post" enctype="multipart/form-data" autocomplete="off">
			<table>
				<?php if(empty($sql)){ ?>
					<tr align="left">
						<td>N&deg; cuenta de cliente</td>
						<td><input type="text" class="form-control" id="cliente" name="cliente" maxlength="100"></td>
					</tr>
					<tr align="left">
						<td>Consignatario</td>
						<td><input type="text" class="form-control" id="consignatario"  onkeyup="this.value = this.value.toUpperCase();" name="consignatario" maxlength="100"></td>
					</tr>
				<?php }else{ ?>
					<tr align="left">
						<td>N&deg; cuenta de cliente</td>
						<td><input type="text" class="form-control" id="cliente" name="cliente" maxlength="100" value="<?php echo $id_cliente; ?>" readonly="true"></td>
					</tr>
					<tr align="left">
						<td>Consignatario</td>
						<td><input type="text" class="form-control" id="consignatario" onkeyup="this.value = this.value.toUpperCase();" name="consignatario" maxlength="100" value="<?= strtoupper($nombre);?> <?= strtoupper($apellidos);?>"></td>
					</tr>
				<?php } ?>
				<tr align="left">
					<td>N&deg; Tracking USA</td>
					<td><input type="text" class="form-control" id="tracking_usa" name="tracking_usa" value="<?php echo $tracking_usa; ?>" maxlength="100"></td>
				</tr>
				<tr align="left">
					<td>Proveedor</td>
					<td>
						<select class="form-control" id="proveedor" name="proveedor">
							<option value="0">Seleccione una opci&oacute;n</option>
							<?php foreach ($sql_proveedor as $key => $proveedor) { ?>
								<option value="<?php echo $proveedor->id_proveedor; ?>"><?php echo $proveedor->nombre_proveedor; ?></option>
							<?php } ?>
					 	</select>
					 	<a id="agregar_proveedor" onclick="abrir_popup()">Agregar Proveedor</a>
				 	</td>
				</tr>
				<tr align="left">
					<td>Compa&ntilde;ia carrier</td>
					<td>
				        <?php //Preseleccionar courier
                        if(substr(strtoupper($tracking_usa), 0, 3) === "TBA"){
                            $id_courier_preselected='5';
                        }else if(substr(strtoupper($tracking_usa), 0, 2) === "1Z"){
                            $id_courier_preselected='1';
                        }else if(substr(strtoupper($tracking_usa), 0, 8) === "42033122"){
                            $id_courier_preselected='2';
                        }else if(substr(strtoupper($tracking_usa), 0, 3) === "1LS"){
                            $id_courier_preselected='6';
                        }?>
                        <select class="form-control" id="currier" name="currier">
                            <option value="0">Seleccione una opci&oacute;n</option>
                            <?php foreach ($sql_currier as $key => $currier) { ?>
                            <?php if($currier->id_currier==$id_courier_preselected){?>
                                <option value="<?php echo $currier->id_currier; ?>" selected><?php echo $currier->nombre_currier; ?></option>
                            <?php }else{ ?>
                                <option value="<?php echo $currier->id_currier; ?>"><?php echo $currier->nombre_currier; ?></option>
                            <?php }
                            }?>
                        </select>
				 	</td>
				</tr>
				<tr align="left">
					<td>Valor del paquete(USD)</td>
					<td><input type="text" class="form-control" id="valor" name="valor" maxlength="100" value="45" readonly="true"></td>
				</tr>
				<tr align="left">
					<td>Tipo de paquete</td>
					<td>
						<select class="form-control" id="tipo_paquete" name="tipo_paquete">
                                                <option value="0">Seleccione una opci&oacute;n</option>
                                            <?php foreach ($sql_tipo_paquete as $key => $tipo_paquete) { ?>
                                                <?php if($tipo_paquete->nombre_tipo_paquete=="CAJA"){?>
                                                <option value="<?php echo $tipo_paquete->id_tipo_paquete; ?>" selected><?php echo $tipo_paquete->nombre_tipo_paquete; ?></option>
                                                <?php }else{ ?>
                                                <option value="<?php echo $tipo_paquete->id_tipo_paquete; ?>"><?php echo $tipo_paquete->nombre_tipo_paquete; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                            </select>
				 	</td>
				</tr>
				<tr align="left">
					<td>Describe tu paquete</td>
					<td><textarea class="form-control" id="producto" name="producto" rows="6" cols="50" maxlength="300"></textarea></td>
				</tr>
				<tr align="left">
					<td>N&deg; de paquetes</td>
					<td><input type="text" class="form-control" id="numero_piezas" name="numero_piezas" maxlength="100"></td>
				</tr>
				<tr align="left">
					<td>Peso</td>
					<td>
						Libras<input type="text" id="libras" name="libras" maxlength="100">
						Onzas<input type="text" id="onzas" name="onzas" maxlength="100">
					</td>
				</tr>
				<tr align="left" class="medidas">
					<td>Medidas (inch)</td>
					<td>
						Largo<input type="text" id="largo" name="largo" maxlength="100">
						Ancho<input type="text" id="ancho" name="ancho" maxlength="100">
						Alto<input type="text" id="alto" name="alto" maxlength="100">
					</td>
				</tr>

			</table>
		
			<br>

			<table>
				<tr>
					<td colspan="2"><center><input type="button" class="button solid-color" name="enviar" id="enviar" value="Imprimir y guardar"></center></td>
					<td><a href="<?php echo $conf['path_host_url'] ?>/miami/paquetes/index.php" class="button solid-color">VOLVER</a></td>
				</tr>
			</table>
		</form>
	</center>
	<!-- Fin de contenido -->
</body>
</html>
