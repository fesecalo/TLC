<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	
	$id=$_GET["id_paquete"];

	$db->prepare("SELECT
			paquete.consignatario,
			paquete.tracking_eu,
			paquete.numero_miami,
			paquete.currier,
			currier.nombre_currier,
			paquete.proveedor,
			paquete.valor,
			paquete.pieza,
			paquete.descripcion_producto,
			paquete.peso,
			paquete.status,
			estado.nombre_status,
			usuario.id_usuario

		FROM paquete as paquete
		INNER JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
		INNER JOIN data_currier AS currier ON currier.id_currier=paquete.currier
		INNER JOIN data_status AS estado ON estado.id_status=paquete.status
		WHERE paquete.id_paquete=:id
		ORDER BY paquete.id_paquete DESC LIMIT 1
	",true);
	$db->execute(array(':id' => $id));

	$sql_paquete=$db->get_results();

	foreach ($sql_paquete as $key => $paquete) {
		$consignatario=$paquete->consignatario;
		$tracking_usa=$paquete->tracking_eu;
		$numero_miami=$paquete->numero_miami;
		$id_currier=$paquete->currier;
		$nombre_currier=$paquete->nombre_currier;
		$proveedor=$paquete->proveedor;
		$valor=$paquete->valor;
		$pieza=$paquete->pieza;
		$producto=$paquete->descripcion_producto;
		$peso=$paquete->peso;
		$status=$paquete->status;
		$nombre_status=$paquete->nombre_status;
		$id_usuario=$paquete->id_usuario;
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

<script>
	// funcion que cambia el peso de los paquetes
	function cancelar(){

		var id_paquete=$("#id_paquete").val();
		var peso=$("#peso_kg").val();

		window.location.href = "cancelar_paquete.php?id_paquete="+id_paquete;
	}
	// funcion que cambia el peso de los paquetes
</script>

<body>

	<!-- menu-->
    <?php 
        if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==4){
            require $conf['path_host'].'/include/include_menu_operador_eshopex.php'; 
        }else{
            die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
        }
    ?> 
    <!--menu-->

<!--Inicio Contenido -->

	<h2>DETALLES DEL PAQUETE</h2>
	<?php if(empty($sql_paquete)){ ?>
		<center><h2>No hay datos para mostrar</h2></center>
	<?php }else{ ?>
		<table>
			<tr align="left">
				<td>Estado</td>
				<?php if($status==16){ ?>
					<td>: <strong style="color: red;"><?php echo $nombre_status; ?></strong></td>
				<?php }else{ ?>
					<td>: <?php echo $nombre_status; ?></td>
				<?php } ?>
			</tr>
			<tr align="left">
				<td>CHI</td>
				<td>: <?php echo $id_usuario; ?></td>
			</tr>
			<tr align="left">
				<td>Consignatario</td>
				<td>: <?php echo $consignatario; ?></td>
			</tr>
			<tr align="left">
				<td>N&deg; Tracking USA</td>
				<td>: <?php echo $tracking_usa; ?></td>
			</tr>
			<tr align="left">
				<td>Compa&ntilde;ia Currier</td>
				<td>: <?php echo $nombre_currier; ?></td>
			</tr>
			<tr align="left">
				<td>Tienda</td>
				<td>: <?php echo $proveedor; ?></td>
			</tr>
			<tr align="left">
				<td>Valor del paquete(USD)</td>
				<td>: <?php echo $valor; ?></td>
			</tr>
			<tr align="left">
				<td>Describe tu paquete</td>
				<td>: <?php echo $producto; ?></td>
			</tr>
			<tr align="left">
				<td>Peso (KG)</td>
				<td>: <?php echo $peso; ?></td>
			</tr>
		</table>
	<?php } ?>
	<!-- Fin de contenido -->
	<p>&nbsp;</p>
	<center>
		<a class="button solid-color" onclick="cancelar();">Cancelar despacho</a>
		<input type="hidden" id="id_paquete" name="id_paquete" value="<?php echo $id; ?>">
		<a href="index.php" class="button solid-color">VOLVER</a>
	</center>

	<p>&nbsp;</p>
	<p>&nbsp;</p>

</body>
</html>