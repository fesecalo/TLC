<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	include_once 'courrierTracking.php';

    $api = new courrierTracking();

    if(isset($_POST['id'])){
        $id = $_POST['id'];

        $api->getById($id);

    }else{
        if(isset($_GET['id'])){
            $id = $_GET['id'];

            $api->getById($id);

        }else{
            $api->error('El id es incorrecto');
            die;
        }
    }

	$db->prepare("SELECT 
			estado.nombre_status,
			lugar.nombre_lugar,
		    historial.fecha
		    
		FROM paquete AS paquete
		INNER JOIN status_log AS historial ON historial.id_paquete=paquete.id_paquete
		INNER JOIN data_status AS estado ON estado.id_status=historial.id_tipo_status
		INNER JOIN data_lugar AS lugar ON lugar.id_lugar=historial.id_lugar
		WHERE paquete.tracking_eu=:id
		ORDER BY historial.id_status_log DESC
	");
	$db->execute(array(':id' => $id ));
	$sql_historial=$db->get_results();

?>

<!DOCTYPE html>
<html lang="es">
<!-- header con css -->
<?php require $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<body>
	<br><br><br><br><br>
	<center><h2>Seguimiento del paquete</h2></center>
	<table class="table-striped table-bordered">
		<tr>
			<td>Fecha</td>
			<td>Detalle</td>
			<td>Lugar</td>
		</tr>
		<?php $x=1; foreach ($sql_historial as $key => $historial) {  ?>
			<tr>
				<td><?php echo date("d/m/Y H:i:s",strtotime($historial->fecha)); ?></td>
				<td><?php echo $historial->nombre_status; ?></td>
				<td><?php echo $historial->nombre_lugar; ?></td>
			</tr>
		<?php } ?>
	</table>

</body>
</html>