<?php 
	require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';

	session_start();

    if(!isset($_SESSION['numero_cliente'])){
    	header("location:".$conf['path_host_url']."/cerrar_sesion.php");
	}

	$id_usu=$_SESSION['numero_cliente'];

?>

<!DOCTYPE html>
<html lang="es">

<!-- HEAD-->
<?php require $conf['path_host'].'/include/include_head.php'; ?>	
<!--FIN HEAD-->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<script type="text/javascript">
	$(document).ready(function(){
		var er_pass = /(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
		
		$("#validar").click(function(){
			if($("#new").val()!=$("#new2").val()){
				alert("Las nuevas contrase\u00f1as no coinciden.");
				return false;
			}
			if($("#new").val().match(er_pass)==null){
				alert("Contrase\u00f1a nueva no v\u00e1lida, debe contener m\u00ednimo 8 caracteres, una letra may\u00fascula, una m\u00faniscula y un n\u00famero.");
				return false;
			}
			document.form_pass.submit();
		});
	});
</script>
<!-- Fin Script -->
<body>

<!-- menu-->
<?php 
	if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==5){
		require $conf['path_host'].'/include/include_menu_admin.php';
	}elseif($_SESSION['tipo_usuario']==3){
		require $conf['path_host'].'/include/include_menu.php';
	}else{
		die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
	}
?> 
<!--menu-->

<!--Inicio Contenido -->

	<!-- inicio datos cliente -->
	<p>&nbsp;</p>
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<p>&nbsp;</p>
	<!-- Fin datos cliente -->

	<h2>CAMBIAR CONTRASE&Ntilde;A</h2>	

	<?php if(isset($_GET['msg'])){ ?>
		<div id="aviso">Su contrase&ntilde;a ha sido cambiada exitosamente.<br></div>

		<br><br>
		<center>
			<a href="<?php echo $conf['path_host_url'] ?>/tracking/tracking.php" class="button solid-color">CONTINUAR</a>
		</center>

		<br><br>
	<?php }else{ ?>
		<form action="procesa_cambiar_pass.php" method="POST" name="form_pass">
			<table>
				<tr>
					<th colspan='2'><center>Cambiar Contrase&ntilde;a</center></th>
				</tr>
				<tr>
					<td>Contrase&ntilde;a Actual</td>
					<td><input type="password" class="form-control" name="old" id="old"/></td>
				</tr>
				<tr>
					<td>Contrase&ntilde;a Nueva</td>
					<td><input type="password" class="form-control" name="new" id="new"/></td>
				</tr>
				<tr>
					<td>Confirmar Contrase&ntilde;a Nueva</td>
					<td><input type="password" class="form-control" name="new2" id="new2"/></td>
				</tr>
			</table>
			<br>
			<center><input type="button" class="button solid-color" id="validar" value="Guardar"/></center>
		</form>
	<?php } ?>
	<!-- Fin de contenido -->
		<p>&nbsp;</p>

	<!-- INCLUDE FOOTER-->
		<?php require $conf['path_host'].'/include/include_footer.php'; ?> 
	<!--FIN FOOTER-->  

</body>

</html>