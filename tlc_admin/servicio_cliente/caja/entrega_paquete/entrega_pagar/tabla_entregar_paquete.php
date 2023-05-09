<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	
	$codigo=$_GET['codigo'];
	$c=1;


	$db->prepare("SELECT 
		paquete.id_paquete,
		paquete.id_usuario,

		usuario.nombre,
		usuario.apellidos,
		usuario.rut,

		paquete.numero_miami,
		paquete.tracking_eu,
		paquete.tracking_garve,
		paquete.descripcion_producto,

		cargo.id_cargo,
		cargo.aduana,
		cargo.flete,
		cargo.manejo,
		cargo.proteccion,
		cargo.total,

		paquete.status

		FROM paquete 
		LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
		INNER JOIN cargos AS cargo ON cargo.id_cargo=paquete.id_cargo

		WHERE paquete.id_usuario=:codigo 
		AND paquete.status=5
		AND paquete.cancelado=0
		AND cargo.eliminado=0
		ORDER BY id_paquete DESC
	");
	
	$db->execute(array(':codigo' => $codigo));
	$sql_paquete=$db->get_results();
	$total_paquetes=count($sql_paquete);

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
		
		$("#quitarTodo").hide();

		$("#seleccionarTodo").click(function(){
			var contador=$("#contador").val();
			for(r=1; r<(contador+1); r++){
				$("#entregar".concat(r)).attr("checked",true);
			}
			$("#seleccionarTodo").hide();
			$("#quitarTodo").show();
		});

		$("#quitarTodo").click(function(){
			var contador=$("#contador").val();
			for(r=1; r<(contador+1); r++){
				$("#entregar".concat(r)).attr("checked",false);
			}
			$("#seleccionarTodo").show();
			$("#quitarTodo").hide();
		});

	 	$("#entregar_paquetes").click(function(){
	 		if (confirm('Los paquetes seleccionados seran entregados. Desea continuar?')){
				document.entregar.submit();
			}
	 	});

	});
</script>

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
	<h2>ENTREGAR PAQUETE</h2>

	<!--Inicio Contenido -->

	<table>
		<tr>
			<td>
				<input type="button" class="button solid-color" id="seleccionarTodo" name="seleccionarTodo" value="Seleccionar Todo">
			</td>
			<td>
				<input type="button" class="button solid-color" id="quitarTodo" name="quitarTodo" value="Desmarcar Todo">
			</td>
		</tr>
	</table>
	<form id="entregar" name="entregar" action="procesa_entregar.php" method="post" >
		<input type="hidden" name="total_paquetes" id="total_paquetes" value="<?php echo $total_paquetes;?>">
		<input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo $sql_paquete[0]->id_usuario;?>">
		<table>
			<tr>
				<td>Item</td>
				<td>Cuenta</td>
				<td>Cliente</td>
				<td>Rut</td>
				<td>Gu&iacute;a</td>
				<td>Descripci&oacute;n</td>
				<td>Total</td>
				<td>Item</td>
			</tr>

			<?php if(empty($sql_paquete)){ ?>
				<tr>
					<td colspan="8">No tiene paquetes para entregar</td>
				</tr>
			<?php }else{ ?>
				<?php foreach ($sql_paquete as $key => $paquete) { ?>
				<tr>
					<td><?php echo $c; ?></td>
					<td><?php echo $conf['path_cuenta']; ?> <?php echo $paquete->id_usuario; ?></td>
					<td><?php echo $paquete->nombre.' '.$paquete->apellidos; ?></td>
					<td><?php echo $paquete->rut; ?></td>
					<?php if(!empty($paquete->tracking_garve)){ ?>
						<td><?php echo $paquete->tracking_garve; ?></td>
					<?php }else{ ?>
						<td><?php echo $paquete->numero_miami; ?></td>
					<?php } ?>
					<td title="<?php echo $paquete->descripcion_producto; ?>"><?php echo substr($paquete->descripcion_producto,0,30);?></td>
					<td>$<?php echo number_format($paquete->total); ?></td>

					<td>
						<input type="checkbox" id="entregar<?php echo $c; ?>" name="entregar<?php echo $c; ?>" value="<?php echo $paquete->id_paquete; ?>">
					</td>
				</tr>
				<tr>
					<td colspan="12"><hr size="1" color="#FF6600" /></td>
				</tr>
				<?php $c++; } ?>
			<?php } ?>
		</table>

		<br><br>
		<input type="hidden" id="contador" name="contador" value="<?php echo $c; ?>">
		<center><input type="button" class="button solid-color" name="entregar_paquetes" id="entregar_paquetes" value="Continuar Pago"></center>
	</form>
	<!-- Fin de contenido -->

</body>
</html>