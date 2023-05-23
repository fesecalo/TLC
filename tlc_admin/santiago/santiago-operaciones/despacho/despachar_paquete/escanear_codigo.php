<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	if(isset($_GET['paquete'])){

		if($_GET['paquete']!=0 || $_GET['paquete']!=''){

			$db->prepare("SELECT
					paquete.id_usuario,
					paquete.tracking_garve,
					paquete.peso,

					estado.nombre_status
				FROM paquete AS paquete
				INNER JOIN data_status AS estado ON estado.id_status=paquete.status
				WHERE id_paquete=:id
			");
			$db->execute(array(':id' => $_GET['paquete']));
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
		document.seleccion_paquete.submit();
	}
	// FIN FUNCION QUE DIRECCIONA AL PRESIONAR ENTER O ESCANEAR UN CODIGO
</script>

<body>

	<!-- menu-->
	<?php 
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==4){
			require $conf['path_host'].'/include/include_menu_operador_local.php'; 
		}else{
			die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
		}
	?> 
	<!--menu-->

	<!--Inicio Contenido -->

	<h2>Modulo Despacho</h2>

	<form action="procesa_seleccion_paquete.php" id="seleccion_paquete" name="seleccion_paquete" method="POST" >
		<center>
		<table >
			<tr>
				<td>
					<h2>INGRESE O ESCANEE <?php echo $conf['path_company_name']; ?> TRACKING</h2>
					<input class="form-control" type="text" id="codigo" name="codigo">
				</td>
			</tr>
		</table>
		</center>
	</form>

	<br><br>
	<?php if(isset($_GET['paquete'])){ ?>
		<?php if(!empty($sql_paquete)){ ?>
			<table>
				<tr>
					<td>CHI</td>
					<td><?php echo $conf['path_company_name']; ?> tracking</td>
					<td>Peso(KG)</td>
					<td>Estado</td>
				</tr>
				<tr>
					<td><?php echo $sql_paquete[0]->id_usuario; ?></td>
					<td><?php echo $sql_paquete[0]->tracking_garve; ?></td>
					<td><?php echo $sql_paquete[0]->peso ?></td>
					<td><strong style="color: red;"><?php echo $sql_paquete[0]->nombre_status ?></strong></td>
				</tr>
			</table>
		<?php } ?>
	<?php } ?>
	<!-- Fin de contenido -->
	<br>
	<br>
</body>
</html>