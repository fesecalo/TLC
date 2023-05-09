<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	require $conf['path_host'].'/include/detecta_pantalla.php';
	
	$id_usu=$_SESSION['numero_cliente'];

	$db->prepare("SELECT * 
		FROM paquete 
		INNER JOIN data_status ON data_status.id_status=paquete.status 
		LEFT JOIN consolidado ON (paquete.id_consolidado = consolidado.id_consolidado)
		WHERE paquete.id_usuario=:id_usu 
		AND (paquete.status=6 OR paquete.status=8 OR paquete.status=16) 
		ORDER BY id_paquete DESC
	");
	$db->execute(array(':id_usu' => $id_usu ));
	$sql_paquete=$db->get_results();
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
		$('table').DataTable();
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
<!--menu-->

<!--Inicio Contenido -->

	<!-- registro de prealertas -->	
	<center>
		<h3>Si realizas una compra av&iacute;sanos que el paquete viene en camino para realizar una entrega m&aacute;s r&aacute;pida</h3>
		<a href="<?php echo $conf['path_host_url'] ?>/prealerta/prealerta.php" class="button solid-color">PREALERTAR</a>
	</center>
	<!-- Fin prealerta -->

	<br><br>

	<!-- inicio datos cliente -->
	<p>&nbsp;</p>
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<p>&nbsp;</p>
	<!-- Fin datos cliente -->

	<h2>HISTORIAL</h2>	

	<!-- tabla de datos -->
	<?php if(empty($sql_paquete)){ ?>
		<center><h2>No tiene paquetes entregados</h2></center>
	<?php }else{ ?>

		<?php if($msg_tabla==1 || $navegador==7){ ?>
			<center>
				<div id="aviso2">
					Para visualizar la informaci&oacute;n completa del paquete presiona sobre el numerador. EJ N°1.
				</div>
			</center>
		<?php } ?>

		<br><br>

		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<table class="table table-bordered table-hover dt-responsive">
						<thead>
							<tr>
								<td>N&deg;</td>
								<td>DESCRIPCI&Oacute;N</td>
								<td>BTRACE TRACKING</td>
								<td>TRACKING USA</td>
								<td>ESTADO</td>
								<td>FECHA REGISTRO</td>
								<td>COD. CONSOLIDADO</td>
								<td>ACCI&Oacute;N</td>
								<?php if($msg_tabla==1 || $navegador==7){ ?>
									<td></td>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php $x=1; foreach ($sql_paquete as $key => $paquete) {  ?>
								<tr>
									<td><?php echo $x; ?></td>
									<td><?php echo $paquete->descripcion_producto; ?></td>
									<?php if(!empty($paquete->numero_miami)){ ?>
										<td><?php echo $paquete->numero_miami; ?></td>
									<?php }else{ ?>
										<td><?php echo $paquete->tracking_garve; ?></td>
									<?php } ?>
									<td><?php echo $paquete->tracking_eu; ?></td>
									<td><?php echo $paquete->nombre_status; ?></td>
									<td><?php echo date("d/m/Y H:m:s",strtotime($paquete->fecha_registro)); ?></td>
									<td>
                                        <?php
                                        if ($paquete->codigo_consolidado!=''){
                                            $codigoConsolidado=$paquete->codigo_consolidado;
                                            ?>
                                            
                                            <a type="button" href="<?= $conf['path_host_url'] ?>/tracking/consolidado/detalles_consolidado.php?id_consolidado=<?= $paquete->id_consolidado ?>" title="Ver detalle del consolidado">
                                                <?= $codigoConsolidado ?>
                                            </a>
                                        
                                        <?php
                                        }else{
                                            $codigoConsolidado="No consolidado";
                                            echo $codigoConsolidado;
                                        }
                                        ?>
                                        
                                        </td>
									<td><a href="detalle_historial.php?paquete=<?php echo $paquete->id_paquete; ?>" class="button solid-color">DETALLE</a></td>
									<?php if($msg_tabla==1 || $navegador==7){ ?>
										<td></td>
									<?php } ?>
								</tr>
							<?php $x++; } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- fin tabla de datos -->

<!-- Fin de contenido -->
	
	<br><br><br>

<!-- INCLUDE FOOTER-->
	<?php require $conf['path_host'].'/include/include_footer.php'; ?> 
<!--FIN FOOTER-->  

</body>

</html>