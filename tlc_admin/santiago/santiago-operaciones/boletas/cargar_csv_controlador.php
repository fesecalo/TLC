<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

    $dir_subida = '/var/www/html/';
    $fichero_subido =  basename($_FILES['csv']['name']);


    //datos del arhivo
    $nombre_archivo = str_replace(" ","_",$_FILES['csv']['name'][0]);
    $date = date('Y-m-d-h-i-s');
    $nombre_archivo = str_replace(".csv","_".$date.".csv",$nombre_archivo);
    $tipo_archivo = $_FILES['csv']['type'][0];
    $tamano_archivo = $_FILES['csv']['size'][0];
    
    //compruebo si las características del archivo son las que deseo
    if (!((strpos($tipo_archivo, "csv") ) )) {
       	//echo "La extensión o el tamaño de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .csv <br><li>se permiten archivos de 100 Kb máximo.</td></tr></table>";
    }else{
       	if (move_uploaded_file($_FILES['csv']['tmp_name'][0],  "csv-files/".$nombre_archivo)){
          	//echo "El archivo ha sido cargado correctamente.";
       	}else{
          	//echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
       	}
    }
    
    $readCsv = array_map('str_getcsv', file( "csv-files/".$nombre_archivo)); 
    //var_dump($readCsv);
    
?>

<?php 
	/*if (isset($_POST['submit'])){
 
    // Allowed mime types
    $fileMimes = array(
        'text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain'
    );
 
    // Validate whether selected file is a CSV file
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes))
    {
 
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
 
            // Skip the first line
            fgetcsv($csvFile);

    }
    else
    {
        echo "Please select valid file";
    }
}*/
	
	
//compruebo si las características del archivo son las que deseo
/*if (!((strpos($tipo_archivo, "csv")) && ($tamano_archivo < 100000))) {
   	echo "La extensión o el tamaño de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .gif o .jpg<br><li>se permiten archivos de 100 Kb máximo.</td></tr></table>";
}else{
   	if (move_uploaded_file($_FILES['userfile']['tmp_name'],  $nombre_archivo)){
      		echo "El archivo ha sido cargado correctamente.";
   	}else{
      		echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
   	}
}*/


/*	$db->prepare("SELECT 
			historial.fecha,
			estado.nombre_status,
			lugar.nombre_lugar,
			historial.comentario
		FROM status_log AS historial
		INNER JOIN data_status AS estado ON estado.id_status=historial.id_tipo_status
		INNER JOIN data_lugar AS lugar ON lugar.id_lugar=historial.id_lugar
		WHERE id_paquete=:id
		ORDER BY historial.id_status_log DESC
	");
	$db->execute(array(':id' => $id ));
	$sql_historial=$db->get_results();

	$db->prepare("SELECT
			usuario.id_usuario,
			paquete.tracking_garve,
			paquete.numero_miami,
			paquete.consignatario,

			currier.nombre_currier,

			paquete.tracking_eu,
			paquete.proveedor,
			paquete.valor,
			paquete.descripcion_producto,
			paquete.pieza,
			paquete.peso,
			paquete.largo,
			paquete.ancho,
			paquete.alto,

			valija.cincho,

			vuelo.codigo_vuelo,

			paquete.id_proveedor,

			proveedor.nombre_proveedor,
			tipo_paquete.nombre_tipo_paquete,
			paquete.peso_volumen

		FROM paquete as paquete
		INNER JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
		INNER JOIN data_currier AS currier ON currier.id_currier=paquete.currier
		LEFT JOIN valijas AS valija ON valija.id_valija=paquete.id_valija
		LEFT JOIN vuelos AS vuelo ON vuelo.id_vuelos=paquete.id_vuelo
		LEFT JOIN data_proveedor AS proveedor ON proveedor.id_proveedor=paquete.id_proveedor
		LEFT JOIN data_tipo_paquete AS tipo_paquete ON tipo_paquete.id_tipo_paquete=paquete.id_tipo_paquete
		WHERE paquete.id_paquete=:id
		ORDER BY paquete.id_paquete ASC
	",true);
	$db->execute(array(':id' => $id));

	$sql_paquete=$db->get_results();

	foreach ($sql_paquete as $key => $paquete) {
		$id_cliente=$paquete->id_usuario;
		$tracking_garve=$paquete->tracking_garve;
		$numero_miami =$paquete->numero_miami ;
		$consignatario=$paquete->consignatario;
		$nombre_currier =$paquete->nombre_currier;
		$tracking_usa=$paquete->tracking_eu;
		$proveedor=$paquete->proveedor;
		$valor=$paquete->valor;
		$producto=$paquete->descripcion_producto;
		$pieza=$paquete->pieza;
		$peso=$paquete->peso;
		$largo=$paquete->largo;
		$ancho=$paquete->ancho;
		$alto=$paquete->alto;
		$cincho=$paquete->cincho;
		$vuelo=$paquete->codigo_vuelo;

		$id_proveedor=$paquete->id_proveedor;
		$nombre_proveedor=$paquete->nombre_proveedor;
		$nombre_tipo_paquete=$paquete->nombre_tipo_paquete;
		$peso_volumen=$paquete->peso_volumen;
	}

	// consulta los archivos de comprobante
	$db->prepare("SELECT
			id_comprobante,
			nombre_comprobante,
			extension,
			fecha,
			eliminado
		FROM comprobante_compra
		WHERE id_paquete=:id
		AND eliminado=0
		ORDER BY id_comprobante ASC
	");
	$db->execute(array(':id' => $id));
	$sql_comprobantes=$db->get_results();
	// Fin consulta archivos de comprobantes

	if($tracking_garve==''){
		$db->prepare("SELECT * FROM cargos WHERE guia=:id ORDER BY id_cargo DESC LIMIT 1");
		$db->execute(array(':id' => $numero_miami));
		$sql_cargos=$db->get_results();
	}else{
		$db->prepare("SELECT * FROM cargos WHERE guia=:id ORDER BY id_cargo DESC LIMIT 1");
		$db->execute(array(':id' => $tracking_garve));
		$sql_cargos=$db->get_results();
	}

	foreach ($sql_cargos as $key => $cargos) {
		$aduana=$cargos->aduana;
		$flete=$cargos->flete;
		$manejo=$cargos->manejo;
		$proteccion=$cargos->proteccion;
		$total=$cargos->total;
	}*/
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

$(document).ready(function() {
    $('input[id="seleccionar"]').click(function() {
        if($(this).prop("checked") == true) {
            checkAll();
        }
        else if($(this).prop("checked") == false) {
            uncheckAll();
        }
    });
    
});


function uncheckAll() {
    document.querySelectorAll('#generar-boletas input[type=checkbox]').forEach(function(checkElement) {
        checkElement.checked = false;
    });
}

function checkAll() {
    document.querySelectorAll('#generar-boletas input[type=checkbox]').forEach(function(checkElement) {
        checkElement.checked = true;
    });
}

function noPuntoComa( event ) {
    var e = event || window.event;
    var key = e.keyCode || e.which;

    if (key == 190 || key == 110 || key == 46 || key == 8 ) {
        return false; 
    }else if(key < 48 || key > 57 ) {
        e.preventDefault();   
    }
}

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
    
    	<!-- inicio datos cliente -->
    	<p>&nbsp;</p>
    	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
    	<p>&nbsp;</p>
    <!-- Fin datos cliente -->
    
        <section style="margin:5%;">
        	<center>
        	    <h2>Aplicar Documento Tributario Electrónico a Paquetes</h2>
        	</center>
        	
        	<?php 
        	
        	$banderaContienePunto=null;
        	
        	foreach ($readCsv as $key => $columna) {  
    		    foreach ($columna as $col){
    		        $contienePunto=strstr($col, ',');
    		        if($contienePunto!=false){
    		            $banderaContienePunto=true;
    		        }
    		    }
            }
            
            if($banderaContienePunto){
                ?>
                <div class="container-fluid">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="bg-danger">Alguna de las columnas del CSV contiene el simbolo coma (,) . Por favor, asegurese de no usar este caracter.</p>
                                <p class="bg-info">Si desea usar un separador de decimales, utilice siempre el simbolo punto (.)</p>
                                <p class="bg-info">Le pedimos que los montos no utilice simbolos para separadores de miles.</p>
                                <p class="bg-success">Ejemplo del formato de un monto correcto. 1254.34</p>
                            </div>
                        </div>
                    </div>
                </div>
    
                <?php
    
            }else{
    
            ?>
        	
        	<form class="form-inline" id="generar-boletas" method="POST" action="generar-dte.php">
        	
                <div class="container-fluid">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-condensed">
                                    <thead>
                            			<tr>
                            			    <th class="text-center">Seleccione</th>
                            				<th>Nro Cliente</th>
                            				<th>C&oacute;digo Gu&iacute;a</th>
                            				<th>Peso</th>
                            				<th>Fob</th>
                            				<th>Servicios</th>
                            				<th>Gest. Aduanera</th>
                            				<th>Flete</th>
                            				<th>Sed</th>
                            				<th>Container</th>
                            				<th>Pallets</th>
                            				<th>Impuestos</th>
                            			</tr>
                        			</thead>
                        			<tbody>
                        			<?php $x=1; foreach ($readCsv as $key => $columna) {  ?>
                        			<?php if($x>1){ 
                        			    $datos=$columna[0].'|'.$columna[1].'|'.$columna[2].'|'.$columna[3].'|'.$columna[4].'|'.$columna[5].'|'.$columna[6].'|'.$columna[7].'|'.$columna[8].'|'.$columna[9].'|'.$columna[10];
                        			?>
                        				<tr>
                        				    <td class="justify-content-center">
                        				        <input type="checkbox" name="paquete[]" id="paquete[]" class="inputCheckbox" value="<?=$datos?>">
                        				    </td>
                        					<td>
                        					    <?= $columna[0]; ?>
                        					</td>
                        					<td>
                        					    <?= $columna[1]; ?>
                        					</td>
                        					<td>
                        					    <?= $columna[2]; ?>
                        					</td>
                        					<td>
                        					    <?= $columna[3]; ?>
                        					</td>
                        					<td>
                        					    <?= $columna[4]; ?>
                        					</td>
                        					<td>
                        					    <?= $columna[5]; ?>
                        					</td>
                        					<td>
                        					    <?= $columna[6]; ?>
                        					</td>
                        					<td>
                        					    <?= $columna[7]; ?>
                        					</td>
                        					<td>
                        					    <?= $columna[8]; ?>
                        					</td>
                        					<td>
                        					    <?= $columna[9]; ?>
                        					</td>
                        					<td>
                        					    <?= $columna[10]; ?>
                        					</td>
                        				</tr>
                        			<?php }
                        			$x++;} ?>
                        			</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="container">
                        
                    <div class="row ">
                        <div class="col-xs-12" >
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Acción</h3>
                                </div>
                                <div class="panel-body">
                                    
                                    <fieldset>
                                        
                                        <div class="form-group">
                                            <label for="tipo_cambio"  title="Seleccionar todos los paquetes y consolidados">Seleccionar todos</label>
                                            <input type="checkbox" id="seleccionar" title="Seleccionar todos los paquetes y consolidados" style="margin:0px;"> 
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        |
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="form-group">
                                            <label for="tipo_cambio" title="Ingrese el tipo de cambio">Tipo de Cambio (Pesos/USD)</label>
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="tipo_cambio" 
                                                name="tipo_cambio" 
                                                placeholder="944.89" 
                                                title="Ingrese el tipo de cambio" 
                                                onkeydown="noPuntoComa(event)">
                                        </div>
                                        <button 
                                            title="Procesar paquetes y consolidados seleccionados" 
                                            id="procesar" 
                                            class="btn btn-primary" 
                                            onclick="$('#procesar').attr('disabled','true');$('#generar-boletas').submit();">Procesar</button>
                                        
                            		</fieldset>
                                    
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                        
                </div>
            
            </form>
            
            <?php } ?>
            
        </section>
        
        <section>
    	    <div class="row">
    		    <div class="col-lg-12">
            		<center><a href="index.php" class="button solid-color">VOLVER</a></center>
                </div>
            </div>
            
            <br>
            <br>
            <br>
            <br>
    
    	</section>
    
    </body>
</html>