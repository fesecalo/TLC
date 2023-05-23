<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_paquete=$_GET["id_paquete"];

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

			var er_numeros=/[0-9]$/;

			$("#codigo").select();

			$("#buscar").click(function(){
				if($("#codigo").val()==""){
					alert("Ingrse el nombre del cliente a buscar.");
					$("#codigo").focus();
					return false;
				}
				text=$("#codigo").val().replace(/ /g,'');
				id_paquete=$("#id_paquete").val().replace(/ /g,'');
				$("#datos_clientes").load("buscar_cliente.php?codigo="+text+"&id_paquete="+id_paquete);
			});

			$('#codigo').keypress(function(e){
		        if(e.which == 13){
		            $('#buscar').click();
		        }
	        });

			$("#enviar").click(function(){
				if($("#id_cliente").val()==""){
					alert("Ingrese el numero de cuenta del cliente.");
					$("#id_cliente").focus();
					return false;
				}

				if($("#id_cliente").val().match(er_numeros)==null){
					alert("Solo son permitidos numeros en este campo.");
					$("#id_cliente").focus().select();
					return false;
				}

				document.registrar.submit();

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

	<h1>Cambiar numero de cliente</h1>
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
		<br>

		<div id="datos_clientes"></div>
		
		<br>
		<br>

		<form id="registrar" name="registrar" action="procesa_cambiar_cliente.php" method="post" enctype="multipart/form-data" autocomplete="off">
			<input type="hidden" id="id_paquete" name="id_paquete" value="<?php echo $id_paquete; ?>">
			<table>
				<tr align="left">
					<td>N&deg; cuenta de cliente</td>
					<td><input type="text" class="form-control" id="id_cliente" name="id_cliente" maxlength="100" value="<?php echo $id_cliente; ?>" readonly="true"></td>
				</tr>
			</table>
		
			<br>
			<br>
			<br>

			<table>
				<tr>
					<td colspan="2"><center><input type="button" class="button solid-color" name="enviar" id="enviar" value="Guardar"></center></td>
					<td><a href="<?php echo $conf['path_host_url'] ?>/servicio_cliente/editar_paquete/editar_paquete.php?paquete=<?php echo $id_paquete; ?>" class="button solid-color">VOLVER</a></td>
				</tr>
			</table>
		</form>
	</center>
	<!-- Fin de contenido -->
</body>
</html>
