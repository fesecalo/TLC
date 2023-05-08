<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-my-tlc.php';
    require $conf['path_host'].'/EasyPDO/conexionPDO.php';
    require $conf['path_host'].'/include/include_sesion.php';
    require $conf['path_host'].'/funciones/fecha_actual.php';

	$id_vuelo=$_GET['vuelo'];;

	$db->prepare("SELECT * FROM vuelos WHERE id_vuelos=:id_vuelo ORDER BY id_vuelos DESC");
	$db->execute(array(':id_vuelo' => $id_vuelo ));
	$sql_vuelo=$db->get_results();

	$vueloEliminado=$sql_vuelo[0]->eliminado;

	$db->prepare("SELECT 
			id_manifiesto,
			num_guia,
			cliente,
			destino,
			piezas,
			peso,
			descripcion,
			valor,
			proveedor,
			origen,
			fecha,
			vuelo,
			master,
			fecha_master,
			estado,
			rut,
			direccion,
			comuna,
			seguro,
			flete,
			empresa,
			tipo_envio,
			tipo_flete

		FROM manifiesto
        
		WHERE id_vuelo=:id_vuelo
		AND eliminado=0
	");
	$db->execute(array(':id_vuelo' => $id_vuelo ));
	$resManifiesto=$db->get_results();

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

		$("#msj_confirmar_vuelo").hide();

		$("#confirmar_vuelo").click(function(){
			$("#confirmar_vuelo").hide();
			$("#msj_confirmar_vuelo").show();
 		});

	});
</script>

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

	<!--Inicio Contenido -->
	<div id="logo"><h1>Manifiesto</h1></div>

	<!-- inicio datos usuario -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<!-- Fin datos usuario -->

	<br>
	<br>
	<?php if($vueloEliminado==1){ ?>
		<div>
			<center>
				<h2 style="font-size: 24px; color: red;">Manifiesto eliminado</h2>
			</center>
		</div>
	<?php } ?>

	<br>
	<br>

	<?php if(empty($resManifiesto)){ ?>
		<center><h2>No tiene paquetes</h2></center>
		<?php if($vueloEliminado==0){ ?>
			<table>
				<tr>
					<td>
						<a id="vuelo_retrasado" href="eliminarManifiesto.php?id_vuelo=<?php echo $id_vuelo; ?>" class="button btn-danger solid-color" onclick="return confirm('Todos los paquetes de este manifiesto seran eliminados, Desea continuar?')">ELIMINAR MANIFIESTO</a>
					</td>
				</tr>
			</table>
		<?php } ?>
	<?php }else{ ?>

	<div id="msj_confirmar_vuelo">
		<center>
			<h2 style="font-size: 24px; color: red;">No cierre la pestaña o el navegador hasta que el proceso finalice.</h2>
		</center>
	</div>

	<br>
	<br>

	<?php if($vueloEliminado==0){ ?>
		<table>
			<tr>
				<td><a href="procesaConfirmarManifiesto.php?id_vuelo=<?php echo $id_vuelo; ?>" class="button solid-color">FINALIZAR Y CONFIRMAR MANIFIESTO</a></td>
				<td>
					<a id="vuelo_retrasado" href="eliminarManifiesto.php?id_vuelo=<?php echo $id_vuelo; ?>" class="button btn-danger solid-color" onclick="return confirm('Todos los paquetes de este manifiesto seran eliminados, Desea continuar?')">ELIMINAR MANIFIESTO</a>
				</td>

			</tr>
		</table>
	<?php } ?>

	<br>
	<br>

	<table>
		<tr>
			<td>#</td>
			<td>N&deg; DE GUIA</td>
			<td>CLIENTE</td>
			<td>DESTINO</td>
			<td>PIEZAS</td>
			<td>PESO</td>
			<td>DESCRIPCION</td>
			<td>VALOR</td>
			<td>PROVEEDOR</td>
			<td>ORIGEN</td>
			<td>FECHA</td>
			<td>VUELO</td>
			<td>MASTER</td>
			<td>FECHA MASTER</td>
			<td>ESTADO</td>
			<td>RUT</td>
			<td>DIRECCION</td>
			<td>COMUNA</td>
			<td>SEGURO</td>
			<td>FLETE</td>
			<td>EMPRESA</td>
			<td>TIPO DE ENVIO</td>
			<td>TIPO FLETE</td>
		</tr>
		<tr>
			<td colspan="13"><hr size="1" color="#FF6600" /></td>
		</tr>
		<?php $x=1; foreach ($resManifiesto as $key => $paquete) {  ?>
			<tr>
				<td><?php echo $x; ?></td>
				<td><?php echo $paquete->num_guia; ?></td>
				<td><?php echo $paquete->cliente; ?></td>
				<td><?php echo $paquete->destino; ?></td>
				<td><?php echo $paquete->piezas; ?></td>
				<td><?php echo $paquete->peso; ?></td>
				<td><?php echo $paquete->descripcion; ?></td>
				<td><?php echo $paquete->valor; ?></td>
				<td><?php echo $paquete->proveedor; ?></td>
				<td><?php echo $paquete->origen; ?></td>
				<td><?php echo date("d/m/Y",strtotime($paquete->fecha)); ?></td>
				<td><?php echo $paquete->vuelo; ?></td>
				<td><?php echo $paquete->master; ?></td>
				<td><?php echo date("d/m/Y",strtotime($paquete->fecha_master)); ?></td>
				<td><?php echo $paquete->estado; ?></td>
				<td><?php echo $paquete->rut; ?></td>
				<td><?php echo $paquete->direccion; ?></td>
				<td><?php echo $paquete->comuna; ?></td>
				<td><?php echo $paquete->seguro; ?></td>
				<td><?php echo $paquete->flete; ?></td>
				<td><?php echo $paquete->empresa; ?></td>
				<td><?php echo $paquete->tipo_envio; ?></td>
				<td><?php echo $paquete->tipo_flete; ?></td>

				<?php if($vueloEliminado==0){ ?>
					<td><a href="eliminarPaqueteManifiesto.php?idManifiesto=<?php echo $paquete->id_manifiesto; ?>&id_vuelo=<?php echo $id_vuelo; ?>" class="button btn-danger solid-color">Eliminar</a></td>
				<?php } ?>

			</tr>
			<tr>
				<td colspan="13"><hr size="1" color="#FF6600" /></td>
			</tr>
		<?php $x++; } ?>
	</table>
	<?php } ?>

	<br>
	<br>
	<center>
		<a href="<?php echo $conf['path_host_url'] ?>/manifiesto/vuelosPendientes.php" class="button solid-color">VOLVER</a>
	</center>
	<br>
	<br>
	<br>
	<br>
	<!-- Fin de contenido -->

</body>
</html>