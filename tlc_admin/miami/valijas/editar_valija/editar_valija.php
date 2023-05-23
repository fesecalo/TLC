<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$tipo_usu=$_SESSION['tipo_usuario'];
	$id_valija=$_GET['valija'];

	$db->prepare("SELECT * FROM valijas WHERE id_valija=:id");
	$db->execute(array(':id' => $id_valija));
	$sql_valija=$db->get_results();

	$db->prepare("SELECT * FROM paquete WHERE id_valija=:id ORDER BY id_paquete");
	$db->execute(array(':id' => $id_valija));
	$sql_paquetes=$db->get_results();

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

		if($("#valija_eliminada").val()==1){
			$("#codigo").attr("readonly",true);
			$("#cincho").attr("readonly",true);
		}else{
			$("#codigo").attr("readonly",false);
			$("#cincho").attr("readonly",false);
		}
		// accion al presionar enter en el campo contraseña
		$('#codigo').keyup(function(e) {
			if(e.keyCode == 13) {
				validar();
			}
		});
		// FIN accion al presionar enter en el campo contraseña
	});

	// FUNCION QUE DIRECCIONA AL PRESIONAR ENTER O ESCANEAR UN CODIGO
	function validar(){
		if($("#codigo").val()==''){
			alert("Ingrese un Codigo de etiqueta.  ----> presiones ESC <---");
			$("#codigo").select();
			return false;
		}
		document.procesa_valija.submit();
	}
	// FIN FUNCION QUE DIRECCIONA AL PRESIONAR ENTER O ESCANEAR UN CODIGO

	function cerrar(){
		if($("#cincho").val()==''){
			alert("Ingrese un numero de cincho");
			$("#cincho").select();
			return false;
		}

		var valija_id=$("#valija_id").val();
		var seguro=$("#cincho").val();
		window.location.href = "procesa_valija.php?accion=1&id_valija="+valija_id+"&cincho="+seguro;
	}

	function editar(){
		var valija_id=$("#valija_id").val();
		window.location.href = "procesa_valija.php?accion=2&id_valija="+valija_id;
	}

</script>

<body>

	<!-- menu-->
	<?php require $conf['path_host'].'/include/include_menu_operador_externo.php'; ?> 
	<!--menu-->

	<!--Inicio Contenido -->
	<h2>INGRESA PAQUETES A LA VALIJA</h2>

	<?php if($sql_valija[0]->eliminado==1){ ?>
		<br><br>
		<center><h2>VALIJA ELIMINADA, NO ES POSIBLE EDITAR NI AGREGAR PAQUETES</h2></center>
		<br><br>
	<?php } ?>

	<form action="procesa_trabajar_valija.php" id="procesa_valija" name="procesa_valija" method="POST" >
		<input type="hidden" id="valija_eliminada" name="valija_eliminada" value="<?php echo $sql_valija[0]->eliminado; ?>">
		<?php if (($sql_valija[0]->status_valija)==0) { ?>
			<center>
				<table >
					<tr>
						<td>
							<h2>INGRESE O ESCANEE CODIGO ETIQUETA <?php echo $conf['path_company_name']; ?></h2>
							<input class="form-control" type="text" id="codigo" name="codigo">
							<input type="hidden" id="id_valija" name="id_valija" value="<?php echo $id_valija; ?>">
						</td>
					</tr>
				</table>
			</center>
		<?php }else{ ?>
			<center>
				<table >
					<tr>
						<td><h2>INGRESE O ESCANEE CODIGO ETIQUETA <?php echo $conf['path_company_name']; ?></h2><input class="form-control" type="text" id="codigo" name="codigo" disabled="true"></td>
					</tr>
				</table>
			</center>
		<?php } ?>

	</form>

	<?php if(($sql_valija[0]->status_valija)==1){ ?>
		<center><h2>Valija cerrada exitosamente.</h2></center>
	<?php } ?>

	<br><br>

	<table>
		<tr>
			<td>N&deg;</td>
			<td>N&deg; <?php echo $conf['path_company_name']; ?></td>
			<td>Descripci&oacute;n</td>
			<td>Valor USD</td>
			<td>Peso(Lb)</td>
			<td>Acci&oacute;n</td>
		</tr>
		<tr><td colspan="7"><hr size="1" color="#FF6600" /></td></tr>

		<?php $p=1; foreach ($sql_paquetes as $key => $paquetes) {  ?>
		<tr>
			<td><?php echo $p; ?></td>
			<td><strong><?php echo $paquetes->tracking_garve; ?></strong></td>
			<td><?php echo $paquetes->descripcion_producto; ?></td>
			<td>$<?php echo $paquetes->valor;?></td>
			<td><?php echo ($paquetes->peso/0.45);?></td>

			<?php if (($sql_valija[0]->status_valija)==0) { ?>
				<td><a href="procesa_valija.php?accion=3&id_paquete=<?php echo $paquetes->id_paquete;?>&id_valija=<?php echo $sql_valija[0]->id_valija; ?>" >Eliminar</a></td>
			<?php }else{ ?>
				<td></td>
			<?php } ?>

		</tr>
		<tr><td colspan="7"><hr size="1" color="#FF6600" /></td></tr>
		<?php $p++; } ?>

	</table>

	<br><br>

	<table>
		<tr>
			<input type="hidden" id="valija_id" name="valija_id" value="<?php echo $sql_valija[0]->id_valija; ?>">
			<td>Peso valija(Lb)</td>
			<td><strong><?php echo ($sql_valija[0]->peso_kilos/0.45); ?></strong></td>
			<td>N&deg; paquetes</td>
			<td><strong><?php echo $sql_valija[0]->numero_paquetes; ?></strong></td>

			<?php if (($sql_valija[0]->status_valija)!=0 && $tipo_usu==1) { ?>
				<td>Cincho</td>
				<td><input type="text" id="cincho" name="cincho" value="<?php echo $sql_valija[0]->cincho; ?>" disabled="true"></td>
				<td><a href="#" id="editar_valija" class="button solid-color" onclick="editar();">Editar valija</a></td>
			<?php }else{ ?>

				<td>Cincho</td>
				<td><input type="text" id="cincho" name="cincho" value="<?php echo $sql_valija[0]->cincho; ?>"></td>
				<td><a href="#" id="cerrar_valija" class="button solid-color" onclick="cerrar();">Cerrar valija</a></td>

			<?php } ?>

		</tr>
	</table>

	<br><br>

	<center>
		<a href="<?php echo $conf['path_host_url'] ?>/miami/valijas/editar_valija/valija.php" class="button solid-color">VOLVER</a>
		<?php if($sql_valija[0]->eliminado==0){ ?>
			<a href="eliminar_valija.php?valija=<?php echo $sql_valija[0]->id_valija; ?>" onclick="return confirm('Al eliminar la valija los paquetes contenidos en ella deberan ser ingresados en una nueva valija. &iquest;Desea continuar?')" class="button solid-color-danger">Eliminar</a>
		<?php } ?>
	</center>

	<br><br><br><br><br><br>
	<!-- Fin de contenido -->

</body>
</html>