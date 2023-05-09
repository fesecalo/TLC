<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$tipo_usu=$_SESSION['tipo_usuario'];
	$id_consolidado=$_GET['id_consolidado'];

	$db->prepare("SELECT * FROM consolidado WHERE id_consolidado=:id");
	$db->execute(array(':id' => $id_consolidado));
	$sql_consolidado=$db->get_results();

	$db->prepare("SELECT * FROM paquete WHERE id_consolidado=:id ORDER BY id_paquete");
	$db->execute(array(':id' => $id_consolidado));
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
		document.procesa_consolidado.submit();
	}
	// FIN FUNCION QUE DIRECCIONA AL PRESIONAR ENTER O ESCANEAR UN CODIGO

	function cerrar(){
		var consolidado_id=$("#consolidado_id").val();
		window.location.href = "procesa_consolidado.php?accion=1&id_consolidado="+consolidado_id;
	}

	function editar(){
		var consolidado_id=$("#consolidado_id").val();
		window.location.href = "procesa_consolidado.php?accion=2&id_consolidado="+consolidado_id;
	}

</script>

<body>

	<!-- menu-->
	<?php require $conf['path_host'].'/include/include_menu_operador_externo.php'; ?> 
	<!--menu-->

	<!--Inicio Contenido -->
	<h2>INGRESA PAQUETES AL CONSOLIDADO</h2>

	<?php if($sql_consolidado[0]->eliminado==1){ ?>
		<br><br>
		<center><h2>CONSOLIDADO ELIMINADO, NO ES POSIBLE EDITAR NI AGREGAR PAQUETES</h2></center>
		<br><br>
	<?php } ?>

	<form action="procesa_trabajar_consolidado.php" id="procesa_consolidado" name="procesa_consolidado" method="POST" >
		<input type="hidden" id="consolidado_eliminado" name="consolidado_eliminado" value="<?php echo $sql_consolidado[0]->eliminado; ?>">
		<?php if (($sql_consolidado[0]->status_consolidado)==0) { ?>
			<center>
				<table >
					<tr>
						<td>
							<h2>INGRESE O ESCANEE CODIGO ETIQUETA <?php echo $conf['path_company_name']; ?></h2>
							<input class="form-control" type="text" id="codigo" name="codigo">
							<input type="hidden" id="id_consolidado" name="id_consolidado" value="<?php echo $id_consolidado; ?>">
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

	<?php if(($sql_consolidado[0]->status_consolidado)==1){ ?>
		<center><h2>Consolidado cerrado exitosamente.</h2></center>
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

			<?php if (($sql_consolidado[0]->status_consolidado)==0) { ?>
				<td><a href="procesa_consolidado.php?accion=3&id_paquete=<?php echo $paquetes->id_paquete;?>&id_consolidado=<?php echo $sql_consolidado[0]->id_consolidado; ?>" >Eliminar</a></td>
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
			<input type="hidden" id="consolidado_id" name="consolidado_id" value="<?php echo $sql_consolidado[0]->id_consolidado; ?>">
			<td>Peso valija(Lb)</td>
			<td><strong><?php echo ($sql_consolidado[0]->peso_kilos/0.45); ?></strong></td>
			<td>N&deg; paquetes</td>
			<td><strong><?php echo $sql_consolidado[0]->numero_paquetes; ?></strong></td>
			<td>Cincho</td>
			<td><?php echo $sql_consolidado[0]->codigo_consolidado; ?></td>

			<?php if (($sql_consolidado[0]->status_consolidado)!=0 && ($tipo_usu==1 || $tipo_usu==2)) { ?>
				<td><a href="#" id="editar_consolidado" class="button solid-color" onclick="editar();">Editar consolidado</a></td>
			<?php }else{ ?>
				<td><a href="#" id="cerrar_valija" class="button solid-color" onclick="cerrar();">Cerrar consolidado</a></td>
			<?php } ?>

		</tr>
	</table>

	<br><br>

	<center>
		<a href="<?php echo $conf['path_host_url'] ?>/miami/consolidado/editar_consolidado/consolidado.php" class="button solid-color">VOLVER</a>
		<?php if($sql_consolidado[0]->eliminado==0){ ?>
			<a href="eliminar_consolidado.php?id_consolidado=<?php echo $sql_consolidado[0]->id_consolidado; ?>" onclick="return confirm('Al eliminar el consolidado los paquetes contenidos en el deberan ser ingresados en una nueva valija o consolidado. &iquest;Desea continuar?')" class="button solid-color-danger">Eliminar</a>
		<?php } ?>
	</center>

	<br><br><br><br><br><br>
	<!-- Fin de contenido -->

</body>
</html>