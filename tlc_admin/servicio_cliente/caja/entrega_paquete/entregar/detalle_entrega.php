<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_transaccion=$_GET['num_recibo'];

	$db->prepare("SELECT
            transaccion.id_cliente,
            transaccion.numero_recibo,
            cliente.email

        FROM transaccion AS transaccion
        INNER JOIN gar_usuarios AS cliente ON cliente.id_usuario=transaccion.id_cliente
        WHERE id_transaccion=:id
    ");
    $db->execute(array(':id' => $id_transaccion ));
    $resTransaccion=$db->get_results();
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

		var er_correo = /^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/;

	 	$("#enviar").click(function(){

	 		if($("#email").val()==""){
				alert("Ingrese email al que enviara el archivo detalle de entrega.");
				$("#email").focus().select();
				return false;
			}

			if($("#email").val().match(er_correo)==null){
				alert("Correo no valido");
				$("#email").focus().select();	
				return false;
			}

			document.enviar_email.submit();
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
	<h2>Detalle de entrega</h2>

	<center>
		<?php if(isset($_GET['msj'])){ ?>
			<br><br>
			<center>
				<div id="aviso">
					<p>Email enviado correctamente.</p>
				</div>
			</center>
			<br><br>
		<?php } ?>

		<form id="enviar_email" name="enviar_email" action="enviar_email.php" method="post" >
			<input type="hidden" id="id_recibo" name="id_recibo" value="<?php echo $id_transaccion; ?>">
			<input type="hidden" id="numero_recibo" name="numero_recibo" value="<?php echo $resTransaccion[0]->numero_recibo; ?>">
			<table >
				<tr>
					<td>Email de destino</td>
					<td>
						<input class="form-control" size="50" type="text" id="email" name="email" value="<?php echo $resTransaccion[0]->email; ?>">
					</td>
					<td colspan="2" align="center" id="subtitulo">
						<input type="button" name="enviar" id="enviar" value="Enviar" style="height: 40px;">
					</td>
				</tr>
			</table>
		</form>

		<br><br>

		<iframe src="<?php echo $conf['path_host_url'] ?>/servicio_cliente/caja/recibo_dinero/recibo_dinero_entrega.php?num_recibo=<?php echo $id_transaccion ?>" style="width:800px; height:1200px;" frameborder="0"></iframe>
	</center>
	<!-- Fin de contenido -->

	<br>
</body>
</html>