<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php'; 
	require $conf['path_host'].'/funciones/generar_csrf.php'; //agregar input hidden en form para enviar el token

	$sql_currier=$db->get_results("SELECT * FROM data_currier WHERE status=1 ORDER BY nombre_currier ASC");

	$sql_proveedor=$db->get_results("SELECT * FROM data_proveedor WHERE status=1 ORDER BY nombre_proveedor ASC");

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

		// validacion solo letras y solo numeros
		var er_numeros=/[0-9]$/;
		var er_numeros2=/^[0-9]+([.][0-9]+)?$/;
		var er_letras= /[a-zA-Z\u00f1\u00d1\u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\^]$/;
		var er_ups=/(1z|1Z)+[a-zA-Z0-9]/;
		var er_usps=/[0-9]$/
		var er_lship=/[a-zA-Z0-9]/;
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
				alert("Seleccione una compañia de curier.");
				$("#currier").focus();
				return false;
			}

			if($("#tracking").val()==""){
				alert("Ingrese un numero de tracking.");
				$("#tracking").focus();
				return false;
			}

			if($("#currier").val()==1){
				if($("#tracking").val().match(er_ups)==null){
					alert("Debe comenzar con 1z letras y numeros.");
					$("#tracking").focus().select();
					return false;
				}
			}

			if($("#currier").val()==2){
				if($("#tracking").val().match(er_usps)==null){
					alert("Solo se permiten numeros.");
					$("#tracking").focus().select();
					return false;	
				}
			}

			if($("#currier").val()==3){
				if($("#tracking").val().match(er_numeros)==null){
					alert("Solo se permiten numeros.");
					$("#tracking").focus().select();
					return false;
				}
			}

			if($("#currier").val()==4){
				if($("#tracking").val().match(er_numeros)==null){
					alert("Solo se permiten numeros.");
					$("#tracking").focus().select();
					return false;
				}
			}

			if($("#currier").val()==5){
				if($("#tracking").val().match(er_numeros)==null){
					alert("Solo se permiten numeros.");
					$("#tracking").focus().select();
					return false;
				}
			}

			if($("#currier").val()==6){
				if($("#tracking").val().match(er_lship)==null){
					alert("Solo se permiten numeros.");
					$("#tracking").focus().select();
					return false;
				}
			}

			if($("#proveedor2").val()==""){
				alert("Ingrese la tienda proveedora del producto.");
				$("#proveedor2").focus();
				return false;
			}

			if($("#valor").val()=="")
			{
				alert("Ingrese el valor del producto");
				$("#valor").focus();
				return false;
			}

			if($("#valor").val().match(er_numeros2)==null)
			{
				alert("Solo son permitidos n\u00fameros, si es un decimal debe ser ingresado con punto");
				$("#valor").focus().select();
				return false;
			}

			if($("#producto").val()=="")
			{
				alert("Describa su producto");
				$("#producto").focus();
				return false;
			}

		 	for(r=0; r<(cont+1); r++){
				if($("#comprobante".concat(r)).val()=="")
				{
					alert("Seleccione un comprobante.");
					$("#comprobante".concat(r)).focus();
					return false;
				}
			}

			$("#cantidad_comprobantes").val(cont+1);
			$("#enviar").attr("disabled",true);
			document.prealerta.submit();
		});

	});
</script>
<!-- Fin Validaciones -->

<body>
<!-- menu-->
<?php 
	if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==5){
		require $conf['path_host'].'/include/include_menu_admin.php';
	}elseif($_SESSION['tipo_usuario']==3){
		require $conf['path_host'].'/include/include_menu.php';
	}else{
		die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
	}
?> 
<!--menu-->

<!--Inicio Contenido -->
	
	<!-- registro de prealertas -->	
	<center>
		<h3>Si realizas una compra av&iacute;sanos que el paquete viene en camino para realizar una entrega m&aacute;s r&aacute;pida</h3>
		<a href="<?php echo $conf['path_host_url'] ?>/prealerta/prealerta.php" class="button solid-color">PREALERTAR</a>
	</center>
	<!-- Fin prealerta -->

	<br><br>
	
	<!-- inicio datos cliente -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<!-- Fin datos cliente -->

	<h2>PREALERTA</h2>
	<center>
	<form id="prealerta" name="prealerta" action="procesa_prealerta.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="<?php echo $token_value; ?>" />
	<table>
		<tr>
			<td colspan="2"><h2>PREALERTA TU PAQUETE</h2></td>
		</tr>
		<tr align="left">
			<td>Consignatario</td>
			<td><input type="text" class="form-control" id="consignatario" name="consignatario" maxlength="100" value="<?php echo $_SESSION['nombre']; ?> <?php echo $_SESSION['apellidos']; ?>" ></td>
		</tr>
		<tr align="left">
			<td>Compa&ntilde;ia Courier</td>
			<td>
				<select class="form-control" id="currier" name="currier">
				<option value="0">Seleccione compa&ntilde;ia de currier</option>
				<?php foreach ($sql_currier as $key => $currier) { ?>
					<option value="<?php echo $currier->id_currier; ?>"><?php echo $currier->nombre_currier; ?></option>
				<?php } ?>
			 	</select>
		 	</td>
		</tr>
		<tr align="left">
			<td>N&deg; Tracking</td>
			<td><input type="text" class="form-control" id="tracking" name="tracking" maxlength="100"></td>
		</tr>
		<tr class="proveedor_otro">
			<td>Tienda donde compraste</td>
			<td><input type="text" class="form-control" id="proveedor2" name="proveedor2" maxlength="100"></td>
		</tr>
		<tr align="left">
			<td>Valor total compra USD<br>(Incluye valor producto+<br>shipping+tax)</td>
			<td><input type="text" class="form-control" id="valor" name="valor" maxlength="100"></td>
		</tr>
		<tr align="left">
			<td>Describe tu paquete</td>
			<td><textarea class="form-control" id="producto" name="producto" rows="6" cols="50" maxlength="300"></textarea></td>
		</tr>
	</table>

	<table>
		<tr>
			<td colspan="2"><center><h2>A&ntilde;ade la factura o comprobante de compra</h2></center></td>
		</tr>
		<?php for ($i=0; $i <10 ; $i++) { ?>
		<tr class="comprobante<?php echo $i ?>">
			<td>Subir factura o comprobante</td>
			<td><input type="file" name="comprobante<?php echo $i ?>" id="comprobante<?php echo $i ?>"/></td>
			<?php if($i==0){ ?>
			<td><input class="trabajar-btn" type="button" id="agregar_comprobante<?php echo $i ?>" name="agregar_comprobante<?php echo $i ?>" value="+"></td>
			<td><input class="trabajar-btn" type="button" id="eliminar_comprobante" name="eliminar_comprobante" value="-"></td>
			<?php } ?>
		</tr>
		<?php } ?>
	</table>

	<input type="hidden" id="cantidad_comprobantes" name="cantidad_comprobantes">

	<p>&nbsp;</p>
	<table>
		<tr>
			<td colspan="2"><center><input type="button" class="button solid-color" name="enviar" id="enviar" value="Prealertar"></center></td>
		</tr>
	</table>

	</form>
	</center>
<!-- Fin de contenido -->
	<p>&nbsp;</p>

<!-- INCLUDE FOOTER-->
	<?php require $conf['path_host'].'/include/include_footer.php'; ?>  
<!--FIN FOOTER-->  

</body>
</html>