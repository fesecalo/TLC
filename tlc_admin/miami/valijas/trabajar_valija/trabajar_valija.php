<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$tipo_usu=$_SESSION['tipo_usuario'];
	$id_valija=$_GET['valija'];

	$db->prepare("SELECT * FROM valijas WHERE id_valija=:id");
	$db->execute(array(':id' => $id_valija));
	$sql_valija=$db->get_results();

	$db->prepare("SELECT
			paquete.id_paquete,
			paquete.tracking_garve,
			paquete.descripcion_producto,
			paquete.valor,
			paquete.peso,
			consolidado.codigo_consolidado

		FROM paquete AS paquete
		LEFT JOIN consolidado AS consolidado ON consolidado.id_consolidado=paquete.id_consolidado
		WHERE paquete.id_valija=:id 
		ORDER BY paquete.id_paquete,consolidado.codigo_consolidado
	");
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
		// accion al presionar enter en el campo contraseña
		$('#codigo').keyup(function(e) {
			if(e.keyCode == 13) {
				{
					validar();
				}
			}
		});
		// FIN accion al presionar enter en el campo contraseña
	});

	// FUNCION QUE DIRECCIONA AL PRESIONAR ENTER O ESCANEAR UN CODIGO
	function validar(){
		if($("#codigo").val()=='')
		{
			alert("Ingrese un Codigo de etiqueta.  ----> presiones ESC <---");
			$("#codigo").select();
			return false;
		}
		document.procesa_valija.submit();
	}
	// FIN FUNCION QUE DIRECCIONA AL PRESIONAR ENTER O ESCANEAR UN CODIGO

	function cerrar(){
		if($("#cincho").val()=='')
		{
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

	<?php if(isset($_GET['msg'])){ ?>
		<br><br>
		<center>
			<div id="sesion">
				<p>Error al ingresar paquete en valija, intente nuevamente</p>
			</div>
		</center>
		<br><br>
	<?php } ?>

	<form action="procesa_trabajar_valija.php" id="procesa_valija" name="procesa_valija" method="POST" >
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
			<td>TLC Tracking</td>
			<td>TLC Tracking Consolidado</td>
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

			<?php if($paquetes->codigo_consolidado==''){ ?>
				<td></td>
			<?php }else{?>
				<td><strong><?php echo $paquetes->codigo_consolidado; ?></strong></td>
			<?php } ?>
			
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
				<td><a href="#" class="button solid-color" onclick="editar();">Editar valija</a></td>
			<?php }else{ ?>
				<td>Cincho</td>
				<td><input type="text" id="cincho" name="cincho" value="<?php echo $sql_valija[0]->cincho; ?>"></td>
				<td><a href="#" class="button solid-color" onclick="cerrar();">Cerrar valija</a></td>
			<?php } ?>
		</tr>
	</table>

	<br><br>

	<center><a href="<?php echo $conf['path_host_url'] ?>/miami/valijas/trabajar_valija/valijas.php" class="button solid-color">VOLVER</a></center>
	
	<br><br><br><br><br><br>
	<!-- Fin de contenido -->
</body>
</html>