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
            var fecha_inicio;
            var fecha_termino;
            var id_cliente;

            $(".numero_cliente").hide();

            $("#opcion").change(function(){
                if($("#opcion").val()==13){
                    $(".numero_cliente").show();
                }else{
                    $(".numero_cliente").hide();
                }
            });

            $("#buscar").click(function(){

                if($("#fecha_inicio").val()==""){
                    alert("Ingrese fecha de inicio");
                    $("#fecha_inicio").focus();
                    return false;
                }

                if($("#fecha_termino").val()==""){
                    alert("Ingrese fecha de termino");
                    $("#fecha_termino").focus();
                    return false;
                }

                if($("#opcion").val()==13){
                    if($("#cliente").val()==""){
                        alert("Ingrese el numero de cuenta del cliente.");
                        $("#cliente").focus();
                        return false;
                    }else{
                        id_cliente=$("#cliente").val();
                    }
                }

                op=$("#opcion").val();
                fecha_inicio=$("#fecha_inicio").val();
                fecha_termino=$("#fecha_termino").val();
                
                switch(op){
                    case '1':
                    $("#paquetes").load("reporte_prealerta_cliente.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
                    break;

                    case '2':
                    $("#paquetes").load("reporte_listo_embarque.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
                    break;

                    case '3':
                    $("#paquetes").load("reporte_en_vuelo.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
                    break;

                    case '4':
                    $("#paquetes").load("reporte_recibidos_aduana.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
                    break;

                    case '5':
                    $("#paquetes").load("reporte_retenidos_aduana.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
                    break;

                    case '6':
                    $("#paquetes").load("reporte_garve_home.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
                    break;

                    case '7':
                    $("#paquetes").load("reporte_despachos.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
                    break;

                    case '8':
                    $("#paquetes").load("reporte_entregados.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
                    break;

                    case '9':
                    $("#paquetes").load("reporte_procesados_miami.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
                    break;

                    case '10':
                    $("#paquetes").load("reporte_entregado_sin_pago.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
                    break;

                    case '11':
                    $("#paquetes").load("reporte_pagado_sin_entrega.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
                    break;

                    case '12':
                    $("#paquetes").load("reporte_caja.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
                    break;

                    case '13':
                        if (id_cliente==0) {
                            $("#paquetes").load("historial_compra_full.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
                        }else{
                            $("#paquetes").load("historial_compra.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino+"&id="+id_cliente);
                        }
                    break;

                    case '14':
                    $("#paquetes").load("preparando_despacho.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
                    break;

                    case '19':
                    $("#paquetes").load("paquetes_procesando.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
                    break;
                    
                    case '20':
                    $("#paquetes").load("paquetes_sin_factura.php?fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino);
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
                            <option value="12">Caja</option>
                            <option value="13">Historial de compras</option>
                            <option value="14">Paquetes preparando para despacho</option>
                            <option value="19">Paquetes procesando en SCL</option>
                            <option value="20">Paquetes sin factura</option>
                        </select>
                    </td>
                </tr>
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

                <tr class="numero_cliente">
                    <td>Ingrese numero de cliente</td>
                    <td>
                        <input type="text" id="cliente" name="cliente">
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="center" id="subtitulo">
                        <input type="button" name="buscar" id="buscar" value="Buscar" style="height: 40px;">
                    </td>
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
