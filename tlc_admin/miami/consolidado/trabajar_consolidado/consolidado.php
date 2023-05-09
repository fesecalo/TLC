<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$sql_consolidado_abierto=$db->get_results("SELECT * FROM consolidado WHERE status_consolidado=0 AND eliminado=0 ORDER BY id_consolidado DESC");
	//$sql_consolidado_abierto=$db->get_results("SELECT * FROM consolidado LEFT JOIN gar_usuarios ON (gar_usuarios.id_usuario=consolidado.id_usuario_representante) WHERE status_consolidado=0 AND eliminado=0 ORDER BY id_consolidado DESC");
	
	
	$i;
	foreach($sql_consolidado_abierto as $consolidado){
	    //var_dump($consolidado->id_consolidado);
	    $sql_paquete_usuario=$db->get_results("SELECT * FROM `paquete` JOIN gar_usuarios ON (gar_usuarios.id_usuario=paquete.id_usuario) where id_consolidado='$consolidado->id_consolidado' ORDER BY id_paquete ASC limit 1");
	    
	    $arrayRepresentantes[] = $sql_paquete_usuario[0]->nombre ? $sql_paquete_usuario[0]->nombre.' '.$sql_paquete_usuario[0]->apellidos : 'Sin Representante';
	    $i++;
	}

	

?>
<!DOCTYPE html>
<!-- header con css -->
<?php require $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<html lang="es">
    
    <script>
	    function confirmDelete(idConsolidado){
	        <?php 
            	if($_SESSION['tipo_usuario']!=1){
            	    die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
            	}
            ?> 
	       var urlEliminar = "../editar_consolidado/eliminar_consolidado.php?id_consolidado=" + idConsolidado
	       var answer = window.confirm("¿Estás seguro de eliminar el consolidado?");
            if (answer) {
                window.location.href =  urlEliminar;
            }
	    }
	</script>

<body>

	<!-- menu-->
	<?php require $conf['path_host'].'/include/include_menu_operador_externo.php'; ?>  
	<!--menu-->

<!--Inicio Contenido -->
    <div class="container-fluid">
        <div class="container">
            
            <div class="row">

    		    <div class="col-xs-12 text-center">
                    <h2>CREAR CONSOLIDADO</h2> 
                    <a href="procesa_crear_consolidado.php" class="button solid-color">CREAR</a>
                    <br>
                	<br>
                </div>

            </div>
            
            <div class="row">
    		    <div class="col-xs-12 ">
                
                	<h2>CONSOLIDADOS ABIERTOS</h2>
                	<?php if(empty($sql_consolidado_abierto)){ ?>
                		<center>
                		    <h2>No hay consolidados abiertos para trabajar</h2>
                		</center>
                	<?php }else{ ?>
                		<table class="table table-striped">
                		    <thead>
                    			<tr>
                    				<th>TLC Consolidado Tracking</th>
                    				<th>Posible - Representante</th>
                    				<th>Peso total(Lb)</th>
                    				<th>Paquetes</th>
                    				<th>Estado</th>
                    				<th>Acci&oacute;n</th>
                    			</tr>
                			</thead>
                			<tbody>
                			<?php $i=0; foreach ($sql_consolidado_abierto as $key => $consolidado) {  ?>
                				<tr>
                					<td><?= $consolidado->codigo_consolidado; ?></td>
                					<!--<td><?= ($consolidado->id_usuario_representante)?$consolidado->nombre.' '.$consolidado->apellidos:'Sin representante' ?></td>-->
                					<td><?= ($arrayRepresentantes[$i])?$arrayRepresentantes[$i]:'Sin representante' ?></td>
                					<td><?= $consolidado->peso_kilos/0.45; ?></td>
                					<td><?= $consolidado->numero_paquetes; ?></td>
                					<td><strong>Abierto</strong></td>
                					<td><a href="trabajar_consolidado.php?id_cons=<?= $consolidado->id_consolidado; ?>" class="button solid-color">Trabajar</a></td>	
                					<td>
            							<button id="eleminar" onclick="confirmDelete(<?php echo $consolidado->id_consolidado; ?>)" class="button solid-color">Eliminar</button>
            						</td>
                				</tr>
                			<?php $i++;} ?>
                			</tbody>
                		</table>
                	<?php } ?>
                
                	<br>
                	<br>
                	<br>
                	<br>
                <!-- Fin de contenido -->
                </div>
            </div>    
        </div>        
    </div>            
</body>

</html>