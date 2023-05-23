<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

	$id_cliente=$_SESSION['numero_cliente'];

?>

<!DOCTYPE html>
<html lang="es">

	<!-- HEAD-->
	<?php require $conf['path_host'].'/include/include_head.php'; ?>	
	<!--FIN HEAD-->

	<!-- java scripts -->
	<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
	<!-- fin java scripts-->

	<!-- Fin Validaciones -->
	<script type="text/javascript">
		$(document).ready(function(){

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
		
		<div class="container-fluid">
            <div class="container">
            
                <div class="row"> 
                    <div class="col-lg-12">
        		    
            		    <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Formulario para Cargar paquetes</h3>
                            </div>
                            <div class="panel-body">
            		    
            		    
            		            <form action="cargar_csv_controlador.php" method="post" enctype="multipart/form-data">
            		                
            		                <div class="col-lg-12">
            		                
                            	        <div class="row">
                    
                                            <fieldset>
            		                            
                                                <legend class="text-center">
        		                                    Cargar paquetes desde el archivo csv
        		                                </legend>
                                                
                                                <div class="col-lg-6">
                                                    
                                                    <div class="form-group">
                                                        <label for="csv">CSV</label>
                                                        <input type="file" id="csv" name="csv[]" title="El archivo debe ser de formato CSV separados por 'Coma'">
                                                        <p class="help-block">Cargue el archivo en formato CSV de los paquetes que quiere generarle el DTE.</p>
                                                    </div>
                                                    
                                                </div>    
                                                
                                                <div class="col-lg-6">
                                                    
                                                    <div class="bg-primary" style="margin:10px; padding:10px; border: 2px solid blue; border-radius: 5px;">
                                                        Los separadores de decimales de las columnas con tipo de datos 
                                                        monetarios deben ser con el simbolo punto (.). 
                                                        No debe usar el simbolo coma (,) como separador 
                                                        ni de miles ni de decimales. 
                                                    </div>
                                                    
                                                    
                                                    
                                                </div>  
                                               
                                    		<fieldset>
                                    		
                                    	</div>
                                    	
                                    	<div class="row">
                                    	    
                                    	    <div class="col-lg-6">
                                    	        
                                    	        <div class="bg-primary" style="margin:10px; padding:10px; border: 2px solid blue; border-radius: 5px;">
                                                    Los campos del csv deben ser los siguientes:
                                                    <ol>
                                                        <li>
                                                            Nro Cliente	
                                                        </li>
                                                        <li>
                                                            C&oacute;digo Gu&iacute;a	
                                                        </li>
                                                        <li>
                                                            Peso ---> <b><i>(kg)</i></b>
                                                        </li>
                                                        <li>
                                                            Fob	
                                                        </li>
                                                        <li>
                                                            Servicios ---> <b><i>(USD)</i></b>
                                                        </li>
                                                        <li>
                                                            Gest. Aduanera	---> <b><i>(USD)</i></b>
                                                        </li>
                                                        <li>
                                                            Flete  ---> <b><i>(USD)</i></b>
                                                        </li>
                                                        <li>
                                                            Sed	
                                                        </li>
                                                        <li>
                                                            Container	
                                                        </li>
                                                        <li>
                                                            Pallets	
                                                        </li>
                                                        <li>
                                                            Impuestos  ---> <b><i>(Pesos Chilenos)</i></b>
                                                        </li>
                                                    </ol>
                                                    
                                                    Recuerde respetar el orden de las columnas.
                                                    
                                                </div>
                                    	        
                                    	    </div>
                                    	    
                                    	    <div class="col-lg-6">
                                            
                                                <div class="bg-primary" style="margin:10px; padding:10px; border: 2px solid blue; border-radius: 5px;">
                                                    <p>Para poder declarar los items <b>TLC Manejo Operacional</b>, <b>Gestion Aduanera</b>, <b>TLC Flete</b> o <b>Impuestos</b> 
                                                    debe tener los valores de las columnas un valor mayor a cero.</p>
                                                    <ol>
                                                        
                                                        <li>
                                                            Servicios ---> <b><i>TLC Manejo Operacional</i></b>
                                                        </li>
                                                        <li>
                                                            Gest. Aduanera	---> <b><i>Gestion Aduanera</i></b>
                                                        </li>
                                                        <li>
                                                            Flete  ---> <b><i>TLC Flete</i></b>
                                                        </li>
                                                        <li>
                                                            Impuestos  ---> <b><i>Impuestos</i></b>
                                                        </li>
                                                    </ol>
                                                    
                                                    Recuerde respetar el orden de las columnas.
                                                    
                                                </div>
                                            </div>
                                    	    
                                    	</div>
                                	
                                	</div>
                                	
                                	
                                	<div class="row">
                                	    <div class="col-lg-12">
                                    	   	<div class="pull-right">
                                        	    <input type="submit" value="Enviar" class="button solid-color"></input>
                                            </div>
                                        </div>
                                    </div>
                                	
                            	</form>
                            	
                        	</div>
                        </div>
                    
                    </div>
                </div>	
                	
                <div class="row">
        		    <div class="col-lg-12">
                		<center><a href="index.php" class="button solid-color">VOLVER</a></center>
                    </div>
                </div>
                
                <br>
                <br>
                <br>
                <br>
                		
		    </div>
		</div>
 
		
	</body>

</html>