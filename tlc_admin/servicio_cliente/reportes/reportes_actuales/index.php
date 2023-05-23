<?php
    require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
    require $conf['path_host'].'/EasyPDO/conexionPDO.php';
    require $conf['path_host'].'/include/include_sesion.php';
?>
<!DOCTYPE html>
<html>
    <!-- header con css -->
    <?php require $conf['path_host'].'/include/include_head.php'; ?> 
    <!-- fin header y css -->

    <!-- java scripts -->
    <?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
    <!-- fin java scripts-->

    <!-- Validaciones js -->
    <script type="text/javascript">
        $(document).ready(function(){

            $("#buscar").click(function(){
                op=$("#opcion").val();

                switch(op){
                    case '1':
                    $("#paquetes").load("reporte_prealerta_cliente.php");
                    break;

                    case '2':
                    $("#paquetes").load("reporte_listo_embarque.php");
                    break;

                    case '3':
                    $("#paquetes").load("reporte_en_vuelo.php");
                    break;

                    case '4':
                    $("#paquetes").load("reporte_recibidos_aduana.php");
                    break;

                    case '5':
                    $("#paquetes").load("reporte_retenidos_aduana.php");
                    break;

                    case '6':
                    $("#paquetes").load("reporte_garve_home.php");
                    break;

                    case '7':
                    $("#paquetes").load("reporte_despachos.php");
                    break;

                    case '8':
                    $("#paquetes").load("reporte_entregados.php");
                    break;

                    case '9':
                    $("#paquetes").load("reporte_procesados_miami.php");
                    break;

                    case '10':
                    $("#paquetes").load("reporte_entregado_sin_pago.php");
                    break;

                    case '11':
                    $("#paquetes").load("reporte_pagado_sin_entrega.php");
                    break;

                    default:
                    alert("Seleccione un Tipo de reporte");
                    break;
                }  
            });
        });
    </script>
    <!-- fin validaciones js -->

<body>

    <!-- menu-->
    <?php 
        if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==5){
            require $conf['path_host'].'/include/include_menu_servicio_cliente.php'; 
        }else{
            die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
        }
    ?> 
    <!--menu-->

    <!-- inicio datos cliente -->
    <?php require $conf['path_host'].'/include/include_datos_usuario.php'; ?> 
    <!-- Fin datos cliente -->

    <!--Inicio Contenido -->
    <h2>REPORTES</h2>

    <center>
        <table >
            <tr>
                <td>Seleccione un reporte</td>
                <td>
                    <select name="opcion" id="opcion" class="form-control">
                        <option value="0">Seleccione un reporte</option>
                        <option value="1">Paquetes prealertados</option>
                        <option value="2">Paquetes listos para embarcar en vuelo</option>
                        <option value="3">Paquetes en vuelo a Chile</option>
                        <option value="4">Paquetes recibidos en aduana (Chile)</option>
                        <option value="5">Paquetes retenidos en aduana (chile)</option>
                        <option value="6">Paquetes en counter</option>
                        <option value="7">Paquetes despachados</option>
                        <option value="8">Paquetes entregado</option>
                        <option value="9">Paquetes procesados en Miami</option>
                        <option value="10">Paquetes entregados sin pagar</option>
                        <option value="11">Paquetes pagados sin entregar</option>
                    </select>
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

    <br>
    <br>
    <!-- Fin de contenido -->

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

</body>
</html>
