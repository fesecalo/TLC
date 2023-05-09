<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	
	if(isset($_GET['id_paquete'])){

		if($_GET['id_paquete']!=0 || $_GET['id_paquete']!=''){

			$db->prepare("SELECT * FROM paquete WHERE id_paquete=:id");
			$db->execute(array(':id' => $_GET['id_paquete']));
			$sql_paquete=$db->get_results();
		}
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

<script type="text/javascript">
	$(document).ready(function(){
		$("#codigo").focus();
		// accion al presionar enter en el campo contraseña
		$('#codigo').keyup(function(e){
			if(e.keyCode == 13) {
				if($("#codigo").val()==""){
					alert("Ingrese un Codigo de etiqueta.  ----> presiones ESC <---");
					$("#codigo").select();
					return false;
				}
				document.procesa_paquete.submit();
			}
		});
		// FIN accion al presionar enter en el campo contraseña
	});
	
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
			require $conf['path_host'].'/include/include_menu_operador_eshopex.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

	<!-- inicio datos cliente -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<!-- Fin datos cliente -->

	<!--Inicio Contenido -->
	<h2>INGRESA PAQUETES A COUNTER DE <?php echo $conf['path_company_name']; ?></h2>

	<br><br>

	<form action="procesa_paquete_counter.php" id="procesa_paquete" name="procesa_paquete" method="POST" >
		<center>
			<table >
				<tr>
					<td>
						<h2>INGRESE O ESCANEE CODIGO ETIQUETA ESHOPEX</h2>
						<input class="form-control" type="text" id="codigo" name="codigo">
					</td>
				</tr>
			</table>
		</center>
	</form>

	<br><br>
	<?php if(isset($_GET['id_paquete'])){ ?>
		<?php if(!empty($sql_paquete)){ ?>
			<table>
				<tr>
					<td>CHI</td>
					<td>Eshopex tracking</td>
					<td>Peso(KG)</td>
				</tr>
				<tr>
					<td><?php echo $sql_paquete[0]->id_usuario; ?></td>
					<td><?php echo $sql_paquete[0]->tracking_eu; ?></td>
					<td><input type="text" class="form-control" id="peso_kg" name="peso_kg" maxlength="100" value="<?php echo $sql_paquete[0]->peso ?>"></td>
					<td><a class="button solid-color" onclick="guardar();">Guardar</a></td>
					<input type="hidden" id="id_paquete" name="id_paquete" value="<?php echo $_GET['id_paquete'];?>">
				</tr>
			</table>
		<?php } ?>
	<?php } ?>

	<br><br><br><br>
	<br><br><br><br>
	<br><br><br><br>
	<!-- Fin de contenido -->
</body>
</html>