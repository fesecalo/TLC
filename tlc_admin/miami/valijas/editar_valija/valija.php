<?php
    require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
?>
<!DOCTYPE html>
<!-- header con css -->
<?php require $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

    <!-- Validaciones js -->
    <script type="text/javascript">
        $(document).ready(function(){
            var fecha_inicio;
            var fecha_termino;

            $("#buscar").click(function(){

                fecha_inicio=$("#fecha_inicio").val();
                fecha_termino=$("#fecha_termino").val();

                $("#valijas").load("tabla_valijas_cerradas.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino); 
            });
        });
    </script>
    <!-- fin validaciones js -->
<html lang="es">

<body>

	<!-- menu-->
	<?php require $conf['path_host'].'/include/include_menu_operador_externo.php'; ?>  
	<!--menu-->

	<!--Inicio Contenido -->
	<h2>Buscar valija para editar</h2>
	<center>
        <table >
            <tr>
                <tr class="date">
                    <td>Inicio</td>
                    <td>
                        <div class="control-group">
                            <div class="controls input-append date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                                <input size="16" type="text" value="" readonly>
                                <span class="add-on"><i class="icon-remove"></i></span>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                            <input type="hidden" id="fecha_inicio" name="fecha_inicio" value="" /><br/>
                        </div>
                    </td>
                </tr>
                <tr class="date">
                    <td>T&eacute;rmino</td>
                    <td>
                        <div class="control-group">
                            <div class="controls input-append date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="fecha_termino" data-link-format="yyyy-mm-dd">
                                <input size="16" type="text" value="" readonly>
                                <span class="add-on"><i class="icon-remove"></i></span>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                            <input type="hidden" id="fecha_termino" name="fecha_termino" value="" /><br/>
                        </div>
                    </td>
                </tr>
                <td colspan="2" align="center" id="subtitulo"><input type="button" name="buscar" id="buscar" value="Buscar" style="height: 40px;"></td>
            </tr>
        </table>
    </center>

	<center>
        <div id="valijas"></div>
    </center>

	<br>
	<br>
	
	<!-- funcion js para que funcione la fecha -->
    <script type="text/javascript">
    	$('.form_date').datetimepicker({
            language:  'es',
            weekStart: 1,
            todayBtn:  1,
    		autoclose: 1,
    		todayHighlight: 1,
    		startView: 2,
    		minView: 2,
    		forceParse: 0
        });
    </script>
    <!-- fin funcion js para que funcione la fecha -->
    
<!-- Fin de contenido -->
</body>

</html>