<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
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
		var codigo;
		var op;

	 	$("#buscar").click(function(){

	 		codigo=$("#codigo").val();
	 		op=$("#opcion").val();

	 		if($("#codigo").val()==""){
				alert("Ingrese numero de cuenta de cliente o rut");
				$("#codigo").focus().select();
				return false;
			}

			switch(op){
               
				case '1':
				$("#paquetes").load("tabla_buscar_paquete_usa.php?codigo="+codigo+"&op="+op);
				break;

				case '2':
				$("#paquetes").load("tabla_buscar_cliente_id.php?codigo="+codigo+"&op="+op);
				break;

                default:
                alert("Seleccione un Tipo de entrega");
                break;
            }
	 	});

	});
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

	<!-- inicio datos cliente -->
	<?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
	<!-- Fin datos cliente -->

	<!--Inicio Contenido -->
	<h2>BUSCAR PAQUETE</h2>

	<center>
		<table >
			<tr>
				<td>Buscar por</td>
				<td>
					<select name="opcion" id="opcion" class="form-control">
						<option value='1'>Tracking Eshopex</option>
						<option value='2'>N° cliente</option>
					</select>
				</td>
				<td>
					<input class="form-control" type="text" id="codigo" name="codigo">
				</td>
				<td colspan="2" align="center" id="subtitulo"><input type="button" name="buscar" id="buscar" value="Buscar" style="height: 40px;"></td>
			</tr>
		</table>
	</center>


	<br>
	<br>
	<center>
        <div id="paquetes"></div>
    </center>
	<!-- Fin de contenido -->

	<br>
	<br>
	<br>
	<br>
</body>
</html>