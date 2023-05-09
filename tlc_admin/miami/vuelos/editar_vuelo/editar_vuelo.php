<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$tipo_usu=$_SESSION['tipo_usuario'];
	$id_vuelo=$_GET['vuelo'];

	$db->prepare("SELECT * FROM vuelos WHERE id_vuelos=:id");
	$db->execute(array(':id' => $id_vuelo));
	$sql_vuelo=$db->get_results();

	$db->prepare("SELECT * FROM valijas WHERE id_vuelo=:id AND status_valija=2 ORDER BY id_valija ASC");
	$db->execute(array(':id' => $id_vuelo));
	$sql_valijas=$db->get_results();
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

		if($("#vuelo_eliminado").val()==1){
			$("#codigo_vuelo").val('');
			$("#codigo_vuelo").attr("disabled",true);
			$("#agregar_valija").hide();
			$("#cerrar_valija").hide();
		}else{
			$("#codigo_vuelo").attr("disabled",false);
		}
	});

	function cerrar(){

		if($("#codigo_vuelo").val()==""){
			alert("Ingrese el codigo del vuelo.");
			$("#codigo_vuelo").focus();
			return false;
		}

		var vuelo_id=$("#vuelo_id").val();
		var codigo=$("#codigo_vuelo").val();

		window.location.href = "procesa_cerrar_vuelo.php?id_vuelo="+vuelo_id+"&codigo_vuelo="+codigo;
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

	<!--Inicio Contenido -->

	<h2>INGRESA VALIJAS EN VUELO</h2>

	<?php if($sql_vuelo[0]->eliminado==1){ ?>
		<br><br>
		<center><h2>VUELO ELIMINADO, NO ES POSIBLE EDITAR NI AGREGAR VALIJAS</h2></center>
		<br><br>
	<?php } ?>

	<form action="procesa_trabajar_vuelo.php" id="procesa_vuelo" name="procesa_vuelo" method="POST" >
		<input type="hidden" id="vuelo_eliminado" name="vuelo_eliminado" value="<?php echo $sql_vuelo[0]->eliminado; ?>">
		<table>
			<tr>
				<td>Cincho</td>
				<td>Peso total(Lb)</td>
				<td>Acción</td>
			</tr>
			<tr>
				<td colspan="8"><hr size="1" color="#F60" /></td>
			</tr>
			<?php $v=0; foreach ($sql_valijas as $key => $valijas) {  ?>
			<tr>
				<td><?php echo $valijas->cincho; ?></td>
				<td><?php echo ($valijas->peso_kilos/0.45); ?></td>
				<td><a href="procesa_eliminar_valija.php?id_valija=<?php echo $valijas->id_valija; ?>&id_vuelo=<?php echo $id_vuelo;?>" >Eliminar</a></td>
			</tr>
			<tr>
				<td colspan="8"><hr size="1" color="#F60" /></td>
			</tr>
			<?php $v++; } ?>
		</table>

		<input type="hidden" id="total_valijas" name="total_valijas" value="<?php echo $v; ?>">

		<br><br>

		<table>
			<tr>
				<input type="hidden" id="vuelo_id" name="vuelo_id" value="<?php echo $sql_vuelo[0]->id_vuelos; ?>">
				<td>Cantidad de valijas</td>
				<td><strong><?php echo $sql_vuelo[0]->cantidad_valijas; ?></strong></td>
				<td>Codigo vuelo</td>
				<td><input type="text" id="codigo_vuelo" name="codigo_vuelo" value="<?php echo $sql_vuelo[0]->codigo_vuelo; ?>"></td>
				<td>MAWB</td>
				<td><input type="text" id="numero_vuelo" name="numero_vuelo" value="<?php echo $sql_vuelo[0]->num_vuelo; ?>"></td>
				<td><a href="#" id="cerrar_valija" class="button solid-color" onclick="cerrar();">Cerrar vuelo</a></td>
				<td><a id="agregar_valija" class="button solid-color" href="agregar_valija.php?vuelo=<?php echo $id_vuelo;?>" >Agregar valija</a></td>
			</tr>
		</table>
	</form>
	<!-- Fin de contenido -->

	<br><br>
	<center>
		<a href="<?php echo $conf['path_host_url'] ?>/miami/vuelos/editar_vuelo/vuelos.php" class="button solid-color">VOLVER</a>
		<?php if($sql_vuelo[0]->eliminado==0){ ?>
			<a href="eliminar_vuelo.php?vuelo=<?php echo $sql_vuelo[0]->id_vuelos; ?>" onclick="return confirm('Al eliminar el vuelo las valijas contenidas en el deberan ser ingresadas en un nuevo vuelo. &iquest;Desea continuar?')" class="button solid-color-danger">Eliminar</a>
		<?php } ?>
	</center>
	<br><br><br><br><br><br>
	
</body>
</html>