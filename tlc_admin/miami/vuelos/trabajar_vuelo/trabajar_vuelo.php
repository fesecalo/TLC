<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$tipo_usu=$_SESSION['tipo_usuario'];
	$id_vuelo=$_GET['vuelo'];

	$db->prepare("SELECT * FROM vuelos WHERE id_vuelos=:id");
	$db->execute(array(':id' => $id_vuelo));
	$sql_vuelo=$db->get_results();

	$sql_valijas=$db->get_results("SELECT * FROM valijas WHERE id_vuelo=0 AND status_valija=1 AND eliminado=0 ORDER BY id_valija ASC");
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

		$("#btn").click(function(){
			if($("#codigo_vuelo").val()==""){
				alert("Ingrese el codigo del vuelo.");
				$("#codigo_vuelo").focus();
				return false;
			}

			if($("#numero_vuelo").val()==""){
				alert("Ingrese MAWB.");
				$("#numero_vuelo").focus();
				return false;
			}
			document.procesa_vuelo.submit();
		});

	});
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

	<center>
		<table >
			<tr>
				<td>
					<h2>SELECCIONE LAS VALIJAS QUE IR&Aacute;N EN ESTE VUELO</h2>
				</td>
			</tr>
		</table>
	</center>

	<br>
	<?php if(($sql_vuelo[0]->id_status_vuelo)==1){ ?>
		<center><h2>Vuelo cerrada exitosamente.</h2></center>
	<?php } ?>
	<br>

	<form action="procesa_trabajar_vuelo.php" id="procesa_vuelo" name="procesa_vuelo" method="POST" >
		<table>
			<tr>
				<td>Check</td>
				<td>Cincho</td>
				<td>Peso total(Lb)</td>
			</tr>
			<tr>
				<td colspan="8"><hr size="1" color="#F60" /></td>
			</tr>
			<?php $v=0; foreach ($sql_valijas as $key => $valijas) {  ?>
			<tr>
				<td><input type="checkbox" id="valija<?php echo $v; ?>" name="valija<?php echo $v; ?>" value="<?php echo $valijas->id_valija; ?>" ></td>
				<td><?php echo $valijas->cincho; ?></td>
				<td><?php echo ($valijas->peso_kilos/0.45); ?></td>	
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
				<td>Codigo vuelo</td>
				<td><input type="text" id="codigo_vuelo" name="codigo_vuelo" value="<?php echo $sql_vuelo[0]->codigo_vuelo; ?>"></td>
				<td>MAWB</td>
				<td><input type="text" id="numero_vuelo" name="numero_vuelo" value="<?php echo $sql_vuelo[0]->num_vuelo; ?>"></td>
				<td><input type="button" id="btn"  name="btn" class="button solid-color"  value="Cerrar vuelo"></td>
			</tr>
		</table>
	</form>
	<!-- Fin de contenido -->

	<br><br>
	<center><a href="<?php echo $conf['path_host_url'] ?>/miami/vuelos/trabajar_vuelo/vuelos.php" class="button solid-color">VOLVER</a></center>
	<br><br><br><br><br><br>
	
</body>
</html>