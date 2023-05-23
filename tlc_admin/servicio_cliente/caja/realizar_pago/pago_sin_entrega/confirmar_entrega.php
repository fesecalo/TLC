<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	
	$codigo=$_GET['codigo'];
	$c=1;

	$db->prepare("SELECT 
		paquete.id_paquete,
		paquete.id_usuario,

		usuario.nombre,
		usuario.apellidos,
		usuario.rut,

		paquete.numero_miami,
		paquete.tracking_eu,
		paquete.tracking_garve,
		paquete.descripcion_producto,
		paquete.pieza,

		cargo.id_cargo,
		cargo.aduana,
		cargo.flete,
		cargo.manejo,
		cargo.proteccion,
		cargo.total

		FROM paquete 
		LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
		INNER JOIN cargos AS cargo ON cargo.id_cargo=paquete.id_cargo

		WHERE paquete.id_transaccion=:codigo
		ORDER BY id_paquete DESC
	");
	$db->execute(array(':codigo' => $codigo));
	$resPaquete=$db->get_results();

	$db->prepare("SELECT 
		
		numero_recibo,
		total,
		total_aduana

		FROM transaccion 
		
		WHERE id_transaccion=:codigo
		ORDER BY id_transaccion DESC
	");
	$db->execute(array(':codigo' => $codigo));

	$resSub=$db->get_results();

	// calcula el totla mas aduana
	$recargoPagar=$resSub[0]->total_aduana*0.05;
	$totalPagoTarjeta=$resSub[0]->total+($resSub[0]->total_aduana*0.05);

	$db->prepare("SELECT * FROM transaccion WHERE id_transaccion=:codigo AND status=0");
	$db->execute(array(':codigo' => $codigo));
	$resTransaccion=$db->get_results();

	$resTipoTarjeta=$db->get_results("SELECT * FROM data_tipo_tarjeta WHERE status=1");

	$resBanco=$db->get_results("SELECT * FROM data_banco WHERE status=1");

	$resCheque=$db->get_results("SELECT * FROM data_tipo_cheque WHERE status=1");

	$resCuenta=$db->get_results("SELECT * FROM data_tipo_cuenta WHERE status=1");

	if (empty($resTransaccion)) {
		header("location: ".$conf['path_host_url']."/servicio_cliente/caja/entrega_paquete/entregar_paquete.php");
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

<!-- validacion de rut -->
<?php include $conf['path_host'].'/include/include_validar_rut_pagos.php'; ?>  
<!-- fin validacion de rut -->

<!-- scripts de validaciones -->
<script type="text/javascript">
	$(document).ready(function(){

		var er_numeros=/^[0-9]+([.][0-9]+)?$/;
		var er_numeros2=/[0-9]$/;

		$(".subtotal").show();
		$(".recargo").hide();

		// oculta los cheques
		for(i=1; i<10; i++){
			$(".cheque".concat(i)).hide();
		}
		// fin ocultar botones

		// agrega cheques
		cont=0;
		for(j=0; j<10; j++){
			$("#agregar_cheque".concat(j)).click(function(){
				cont=cont+1;
				if(cont>9){
					cont=9;
				}
				$(".cheque".concat(cont)).show();
			});
		}
		// fin agregar cheque

		// elimina cheque
		$("#eliminar_cheque").click(function(){
			if(cont!=0){
				$(".cheque".concat(cont)).hide();
				cont=cont-1;
			}	
		});
		// fin eliina cheque

		$('#monto_pagado_efectivo').blur(function(){
			var monto_efectivo=parseInt($("#monto_efectivo").val());
			var monto_pagado_efectivo=parseInt($("#monto_pagado_efectivo").val());

			var vuelto=monto_pagado_efectivo-monto_efectivo;

			$('#vuelto_efectivo').val(vuelto);
		});

		$('#monto_efectivo').blur(function(){
			var monto_efectivo=parseInt($("#monto_efectivo").val());
			var monto_pagado_efectivo=parseInt($("#monto_pagado_efectivo").val());

			var vuelto=monto_pagado_efectivo-monto_efectivo;

			$('#vuelto_efectivo').val(vuelto);
		});
		
		$("#pago_tarjeta").change(function() {
		    if(this.checked) {
		        $("#monto_tarjeta").attr("disabled",false);

		        var totalMontoPorPagar=0;

		        totalMontoPorPagar=$("#totalPagoTarjeta").val()-$("#monto_efectivo").val()-$("#monto_deposito").val()-$("#monto_cheque0").val()-$("#monto_cheque1").val()-$("#monto_cheque2").val()-$("#monto_cheque3").val()-$("#monto_cheque4").val()-$("#monto_cheque5").val()-$("#monto_cheque6").val()-$("#monto_cheque7").val()-$("#monto_cheque8").val()-$("#monto_cheque9").val();

		        $("#monto_tarjeta").val(totalMontoPorPagar);

				$("#tipo_tarjeta").attr("disabled",false);
				$("#comprobante_tarjeta").attr("disabled",false);
				$(".subtotal").hide();
				$(".recargo").show();
		    }else{
		    	$("#monto_tarjeta").attr("disabled",true);
		    	$("#monto_tarjeta").val("0");
				$("#tipo_tarjeta").attr("disabled",true);
				$("#comprobante_tarjeta").attr("disabled",true);
				$(".subtotal").show();
				$(".recargo").hide();
		    }
		});

		$("#pago_efectivo").change(function() {
		    if(this.checked) {
		        $("#monto_efectivo").attr("disabled",false);

		        var totalMontoPorPagar=0;
		        var totalPago=0;

		        if($("#pago_tarjeta").is(":checked")){
		        	totalPago=$("#totalPagoTarjeta").val()
		        }else{
		        	totalPago=$("#subtotal").val()
		        }

		        totalMontoPorPagar=totalPago-$("#monto_tarjeta").val()-$("#monto_deposito").val()-$("#monto_cheque0").val()-$("#monto_cheque1").val()-$("#monto_cheque2").val()-$("#monto_cheque3").val()-$("#monto_cheque4").val()-$("#monto_cheque5").val()-$("#monto_cheque6").val()-$("#monto_cheque7").val()-$("#monto_cheque8").val()-$("#monto_cheque9").val();

		        $("#monto_efectivo").val(totalMontoPorPagar);

				$("#monto_pagado_efectivo").attr("disabled",false);
				$("#vuelto_efectivo").attr("disabled",false);
		    }else{
		    	$("#monto_efectivo").attr("disabled",true);
		    	$("#monto_efectivo").val("0");
				$("#monto_pagado_efectivo").attr("disabled",true);
				$("#vuelto_efectivo").attr("disabled",true);
		    }
		});

		$("#pago_deposito").change(function() {
		    if(this.checked) {
		    	$("#monto_deposito").attr("disabled",false);

		    	var totalMontoPorPagar=0;
		    	var totalPago=0;

		        if($("#pago_tarjeta").is(":checked")){
		        	totalPago=$("#totalPagoTarjeta").val()
		        }else{
		        	totalPago=$("#subtotal").val()
		        }
		        
		        totalMontoPorPagar=totalPago-$("#monto_tarjeta").val()-$("#monto_efectivo").val()-$("#monto_cheque0").val()-$("#monto_cheque1").val()-$("#monto_cheque2").val()-$("#monto_cheque3").val()-$("#monto_cheque4").val()-$("#monto_cheque5").val()-$("#monto_cheque6").val()-$("#monto_cheque7").val()-$("#monto_cheque8").val()-$("#monto_cheque9").val();

		    	$("#monto_deposito").val(totalMontoPorPagar);
		    	$("#comprobante_transferencia").attr("disabled",false);
		    }else{
		    	$("#monto_deposito").attr("disabled",true);
		    	$("#comprobante_transferencia").attr("disabled",true);
		    	$("#monto_deposito").val("0");
		    }
		});

		// cheques0
		$("#pago_cheque0").change(function() {
		    if(this.checked) {
		    	$("#monto_cheque0").attr("disabled",false);

		    	var totalMontoPorPagar=0;
		    	var totalPago=0;

		        if($("#pago_tarjeta").is(":checked")){
		        	totalPago=$("#totalPagoTarjeta").val()
		        }else{
		        	totalPago=$("#subtotal").val()
		        }
		        
		        totalMontoPorPagar=totalPago-$("#monto_tarjeta").val()-$("#monto_efectivo").val()-$("#monto_deposito").val()-$("#monto_cheque1").val()-$("#monto_cheque2").val()-$("#monto_cheque3").val()-$("#monto_cheque4").val()-$("#monto_cheque5").val()-$("#monto_cheque6").val()-$("#monto_cheque7").val()-$("#monto_cheque8").val()-$("#monto_cheque9").val();

		    	$("#monto_cheque0").val(totalMontoPorPagar);
		        $("#numero_cheque0").attr("disabled",false);
		    }else{
		    	$("#monto_cheque0").attr("disabled",true);
		    	$("#monto_cheque0").val("0");
		    	$("#numero_cheque0").attr("disabled",true);
		    }
		});

		// cheques1
		$("#pago_cheque1").change(function() {
		    if(this.checked) {
		    	$("#monto_cheque1").attr("disabled",false);

		    	var totalMontoPorPagar=0;
		    	var totalPago=0;

		        if($("#pago_tarjeta").is(":checked")){
		        	totalPago=$("#totalPagoTarjeta").val()
		        }else{
		        	totalPago=$("#subtotal").val()
		        }
		        
		        totalMontoPorPagar=totalPago-$("#monto_tarjeta").val()-$("#monto_efectivo").val()-$("#monto_deposito").val()-$("#monto_cheque0").val()-$("#monto_cheque2").val()-$("#monto_cheque3").val()-$("#monto_cheque4").val()-$("#monto_cheque5").val()-$("#monto_cheque6").val()-$("#monto_cheque7").val()-$("#monto_cheque8").val()-$("#monto_cheque9").val();

		    	$("#monto_cheque1").val(totalMontoPorPagar);
		        $("#numero_cheque1").attr("disabled",false);
		    }else{
		    	$("#monto_cheque1").attr("disabled",true);
		    	$("#monto_cheque1").val("0");
		    	$("#numero_cheque1").attr("disabled",true);
		    }
		});

		// cheques2
		$("#pago_cheque2").change(function() {
		    if(this.checked) {
		    	$("#monto_cheque2").attr("disabled",false);

		    	var totalMontoPorPagar=0;
		    	var totalPago=0;

		        if($("#pago_tarjeta").is(":checked")){
		        	totalPago=$("#totalPagoTarjeta").val()
		        }else{
		        	totalPago=$("#subtotal").val()
		        }
		        
		        totalMontoPorPagar=totalPago-$("#monto_tarjeta").val()-$("#monto_efectivo").val()-$("#monto_deposito").val()-$("#monto_cheque0").val()-$("#monto_cheque1").val()-$("#monto_cheque3").val()-$("#monto_cheque4").val()-$("#monto_cheque5").val()-$("#monto_cheque6").val()-$("#monto_cheque7").val()-$("#monto_cheque8").val()-$("#monto_cheque9").val();

		    	$("#monto_cheque2").val(totalMontoPorPagar);
		        $("#numero_cheque2").attr("disabled",false);
		    }else{
		    	$("#monto_cheque2").attr("disabled",true);
		    	$("#monto_cheque2").val("0");
		    	$("#numero_cheque2").attr("disabled",true);
		    }
		});

		// cheques3
		$("#pago_cheque3").change(function() {
		    if(this.checked) {
		    	$("#monto_cheque3").attr("disabled",false);

		    	var totalMontoPorPagar=0;
		    	var totalPago=0;

		        if($("#pago_tarjeta").is(":checked")){
		        	totalPago=$("#totalPagoTarjeta").val()
		        }else{
		        	totalPago=$("#subtotal").val()
		        }
		        
		        totalMontoPorPagar=totalPago-$("#monto_tarjeta").val()-$("#monto_efectivo").val()-$("#monto_deposito").val()-$("#monto_cheque0").val()-$("#monto_cheque1").val()-$("#monto_cheque2").val()-$("#monto_cheque4").val()-$("#monto_cheque5").val()-$("#monto_cheque6").val()-$("#monto_cheque7").val()-$("#monto_cheque8").val()-$("#monto_cheque9").val();

		    	$("#monto_cheque3").val(totalMontoPorPagar);
		        $("#numero_cheque3").attr("disabled",false);
		    }else{
		    	$("#monto_cheque3").attr("disabled",true);
		    	$("#monto_cheque3").val("0");
		    	$("#numero_cheque3").attr("disabled",true);
		    }
		});

		// cheques4
		$("#pago_cheque4").change(function() {
		    if(this.checked) {
		    	$("#monto_cheque4").attr("disabled",false);

		    	var totalMontoPorPagar=0;
		    	var totalPago=0;

		        if($("#pago_tarjeta").is(":checked")){
		        	totalPago=$("#totalPagoTarjeta").val()
		        }else{
		        	totalPago=$("#subtotal").val()
		        }
		        
		        totalMontoPorPagar=totalPago-$("#monto_tarjeta").val()-$("#monto_efectivo").val()-$("#monto_deposito").val()-$("#monto_cheque0").val()-$("#monto_cheque1").val()-$("#monto_cheque2").val()-$("#monto_cheque3").val()-$("#monto_cheque5").val()-$("#monto_cheque6").val()-$("#monto_cheque7").val()-$("#monto_cheque8").val()-$("#monto_cheque9").val();

		    	$("#monto_cheque4").val(totalMontoPorPagar);
		        $("#numero_cheque4").attr("disabled",false);
		    }else{
		    	$("#monto_cheque4").attr("disabled",true);
		    	$("#monto_cheque4").val("0");
		    	$("#numero_cheque4").attr("disabled",true);
		    }
		});

		// cheques5
		$("#pago_cheque5").change(function() {
		    if(this.checked) {
		    	$("#monto_cheque5").attr("disabled",false);

		    	var totalMontoPorPagar=0;
		    	var totalPago=0;

		        if($("#pago_tarjeta").is(":checked")){
		        	totalPago=$("#totalPagoTarjeta").val()
		        }else{
		        	totalPago=$("#subtotal").val()
		        }
		        
		        totalMontoPorPagar=totalPago-$("#monto_tarjeta").val()-$("#monto_efectivo").val()-$("#monto_deposito").val()-$("#monto_cheque0").val()-$("#monto_cheque1").val()-$("#monto_cheque2").val()-$("#monto_cheque3").val()-$("#monto_cheque4").val()-$("#monto_cheque6").val()-$("#monto_cheque7").val()-$("#monto_cheque8").val()-$("#monto_cheque9").val();

		    	$("#monto_cheque5").val(totalMontoPorPagar);
		        $("#numero_cheque5").attr("disabled",false);
		    }else{
		    	$("#monto_cheque5").attr("disabled",true);
		    	$("#monto_cheque5").val("0");
		    	$("#numero_cheque5").attr("disabled",true);
		    }
		});

		// cheques6
		$("#pago_cheque6").change(function() {
		    if(this.checked) {
		    	$("#monto_cheque6").attr("disabled",false);

		    	var totalMontoPorPagar=0;
		    	var totalPago=0;

		        if($("#pago_tarjeta").is(":checked")){
		        	totalPago=$("#totalPagoTarjeta").val()
		        }else{
		        	totalPago=$("#subtotal").val()
		        }
		        
		        totalMontoPorPagar=totalPago-$("#monto_tarjeta").val()-$("#monto_efectivo").val()-$("#monto_deposito").val()-$("#monto_cheque0").val()-$("#monto_cheque1").val()-$("#monto_cheque2").val()-$("#monto_cheque3").val()-$("#monto_cheque4").val()-$("#monto_cheque5").val()-$("#monto_cheque7").val()-$("#monto_cheque8").val()-$("#monto_cheque9").val();

		    	$("#monto_cheque6").val(totalMontoPorPagar);
		        $("#numero_cheque6").attr("disabled",false);
		    }else{
		    	$("#monto_cheque6").attr("disabled",true);
		    	$("#monto_cheque6").val("0");
		    	$("#numero_cheque6").attr("disabled",true);
		    }
		});

		// cheques7
		$("#pago_cheque7").change(function() {
		    if(this.checked) {
		    	$("#monto_cheque7").attr("disabled",false);

		    	var totalMontoPorPagar=0;
		    	var totalPago=0;

		        if($("#pago_tarjeta").is(":checked")){
		        	totalPago=$("#totalPagoTarjeta").val()
		        }else{
		        	totalPago=$("#subtotal").val()
		        }
		        
		        totalMontoPorPagar=totalPago-$("#monto_tarjeta").val()-$("#monto_efectivo").val()-$("#monto_deposito").val()-$("#monto_cheque0").val()-$("#monto_cheque1").val()-$("#monto_cheque2").val()-$("#monto_cheque3").val()-$("#monto_cheque4").val()-$("#monto_cheque5").val()-$("#monto_cheque6").val()-$("#monto_cheque8").val()-$("#monto_cheque9").val();

		    	$("#monto_cheque7").val(totalMontoPorPagar);
		        $("#numero_cheque7").attr("disabled",false);
		    }else{
		    	$("#monto_cheque7").attr("disabled",true);
		    	$("#monto_cheque7").val("0");
		    	$("#numero_cheque7").attr("disabled",true);
		    }
		});

		// cheques8
		$("#pago_cheque8").change(function() {
		    if(this.checked) {
		    	$("#monto_cheque8").attr("disabled",false);

		    	var totalMontoPorPagar=0;
		    	var totalPago=0;

		        if($("#pago_tarjeta").is(":checked")){
		        	totalPago=$("#totalPagoTarjeta").val()
		        }else{
		        	totalPago=$("#subtotal").val()
		        }
		        
		        totalMontoPorPagar=totalPago-$("#monto_tarjeta").val()-$("#monto_efectivo").val()-$("#monto_deposito").val()-$("#monto_cheque0").val()-$("#monto_cheque1").val()-$("#monto_cheque2").val()-$("#monto_cheque3").val()-$("#monto_cheque4").val()-$("#monto_cheque5").val()-$("#monto_cheque6").val()-$("#monto_cheque7").val()-$("#monto_cheque9").val();

		    	$("#monto_cheque8").val(totalMontoPorPagar);
		        $("#numero_cheque8").attr("disabled",false);
		    }else{
		    	$("#monto_cheque8").attr("disabled",true);
		    	$("#monto_cheque8").val("0");
		    	$("#numero_cheque8").attr("disabled",true);
		    }
		});

		// cheques9
		$("#pago_cheque9").change(function() {
		    if(this.checked) {
		    	$("#monto_cheque9").attr("disabled",false);

		    	var totalMontoPorPagar=0;
		    	var totalPago=0;

		        if($("#pago_tarjeta").is(":checked")){
		        	totalPago=$("#totalPagoTarjeta").val()
		        }else{
		        	totalPago=$("#subtotal").val()
		        }
		        
		        totalMontoPorPagar=totalPago-$("#monto_tarjeta").val()-$("#monto_efectivo").val()-$("#monto_deposito").val()-$("#monto_cheque0").val()-$("#monto_cheque1").val()-$("#monto_cheque2").val()-$("#monto_cheque3").val()-$("#monto_cheque4").val()-$("#monto_cheque5").val()-$("#monto_cheque6").val()-$("#monto_cheque7").val()-$("#monto_cheque8").val();

		    	$("#monto_cheque9").val(totalMontoPorPagar);
		        $("#numero_cheque9").attr("disabled",false);
		    }else{
		    	$("#monto_cheque9").attr("disabled",true);
		    	$("#monto_cheque9").val("0");
		    	$("#numero_cheque9").attr("disabled",true);
		    }
		});

		$("#entregar_paquetes").click(function(){
			var totalMontoPorPagar=0;
	    	var totalPago=0;

			if($("#pago_tarjeta").is(":checked")){

				if($("#monto_tarjeta").val()==0){
					alert("Ingrese el monto.");
					$("#monto_tarjeta").focus();
					return false;
				}

				if($("#monto_tarjeta").val().match(er_numeros)==null){
					alert("Solo son permitidos numeros en el monto de pago con tarjeta, si ingresara un decimal separe con un punto.");
					$("#monto_tarjeta").select();
					return false;
				}

				if($("#tipo_tarjeta").val()==0){
					alert("Seleccione un tipo de tarjeta.");
					$("#tipo_tarjeta").focus();
					return false;
				}
			}

			if($("#pago_efectivo").is(":checked")){

				if($("#monto_efectivo").val()==0){
					alert("Ingrese el monto.");
					$("#monto_efectivo").focus();
					return false;
				}

				if($("#monto_efectivo").val().match(er_numeros)==null){
					alert("Solo son permitidos numeros en el monto efectivo, si ingresara un decimal separe con un punto.");
					$("#monto_efectivo").select();
					return false;
				}

				if($("#monto_pagado_efectivo").val()==0){
					alert("Ingrese el monto pagado.");
					$("#monto_pagado_efectivo").focus();
					return false;
				}

				if($("#monto_pagado_efectivo").val().match(er_numeros)==null){
					alert("Solo son permitidos numeros en el monto pago efectivo. si ingresara un decimal separe con un punto.");
					$("#monto_pagado_efectivo").select();
					return false;
				}

				if (parseInt($("#monto_efectivo").val()) > parseInt($("#monto_pagado_efectivo").val()) ) {
					alert("Revise el monto en efectivo pagado.");
					$("#monto_pagado_efectivo").focus();
					return false;
				}
			}

			if($("#pago_deposito").is(":checked")){

				if($("#monto_deposito").val()==0){
					alert("Ingrese el monto.");
					$("#monto_deposito").focus();
					return false;
				}

				if($("#monto_deposito").val().match(er_numeros)==null){
					alert("Solo son permitidos numeros en el monto del deposito, si ingresara un decimal separe con un punto.");
					$("#monto_deposito").select();
					return false;
				}
			}

			for(r=0; r<(cont+1); r++){
				if($("#pago_cheque".concat(r)).is(":checked")){

					if($("#monto_cheque".concat(r)).val()==0){
						alert("Ingrese el monto del cheque.");
						$("#monto_cheque".concat(r)).focus();
						return false;
					}

					if($("#monto_cheque".concat(r)).val().match(er_numeros)==null){
						alert("Solo son permitidos numeros en el monto del deposito, si ingresara un decimal separe con un punto.");
						$("#monto_cheque".concat(r)).select();
						return false;
					}

					if($("#numero_cheque".concat(r)).val()==""){
						alert("Ingrese el numero de cuenta.");
						$("#numero_cheque".concat(r)).focus();
						return false;
					}

					if($("#numero_cheque".concat(r)).val().match(er_numeros2)==null){
						alert("Solo son permitidos numeros en el numero de cuenta.");
						$("#numero_cheque".concat(r)).select();
						return false;
					}
				}
			}

			$("#cantidad_cheque").val(cont+1);

	        if($("#pago_tarjeta").is(":checked")){
	        	totalPago=parseInt($("#totalPagoTarjeta").val());
	        }else{
	        	totalPago=parseInt($("#subtotal").val());
	        }
	        
	        totalMontoPorPagar=parseInt($("#monto_tarjeta").val())+parseInt($("#monto_efectivo").val())+parseInt($("#monto_deposito").val())+parseInt($("#monto_cheque0").val())+parseInt($("#monto_cheque1").val())+parseInt($("#monto_cheque2").val())+parseInt($("#monto_cheque3").val())+parseInt($("#monto_cheque4").val())+parseInt($("#monto_cheque5").val())+parseInt($("#monto_cheque6").val())+parseInt($("#monto_cheque7").val())+parseInt($("#monto_cheque8").val())+parseInt($("#monto_cheque9").val());

	        if(totalPago==totalMontoPorPagar){
				if(!($("#pago_tarjeta").is(":checked") || $("#pago_efectivo").is(":checked") || $("#pago_deposito").is(":checked") || $("#pago_cheque0").is(":checked"))){
					alert("Seleccione un metodo de pago");
					return false;
				}else{
					if (confirm('Los paquetes seleccionados seran pagados. Desea continuar?')){
						document.entregar.submit();
					}
				}
			}else{
				alert("Verifique montos pagados");
				return false;
			}

	 		
	 	});

   	});
</script>
<!-- fin scripts de validaciones -->
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
	<h2>CONFIRMAR ENTREGA</h2>

	<!--Inicio Contenido -->
	<form id="entregar" name="entregar" action="procesa_confirmar_entrega.php" method="post" enctype="multipart/form-data">
		<input type="hidden" id="id_transaccion" name="id_transaccion" value="<?php echo $codigo; ?>">
		<input type="hidden" id="numero_recibo" name="numero_recibo" value="<?php echo $resSub[0]->numero_recibo; ?>">
		<input type="hidden" id="id_cliente" name="id_cliente" value="<?php echo $resPaquete[0]->id_usuario;?>">
		<input type="hidden" id="subtotal" name="subtotal" value="<?php echo $resSub[0]->total;?>">
		<input type="hidden" id="totalPagoTarjeta" name="totalPagoTarjeta" value="<?php echo round($totalPagoTarjeta);?>">
		<input type="hidden" id="cantidad_cheque" name="cantidad_cheque" value="0">
		<input type="hidden" id="rut_provisorio" name="rut_provisorio">
		<input type="hidden" id="recargo" name="recargo" value="<?php echo round($recargoPagar);?>">
		<table>
			<tr>
				<td>Item</td>
				<td><?php echo $conf['path_company_name']; ?> Track</td>
				<td>Cantidad</td>
				<td>Descripci&oacute;n</td>
				<td>Aduana</td>
				<td>Flete</td>
				<td>Manejo</td>
				<td>Protecci&oacute;n</td>
				<td>Total</td>
			</tr>
			<?php foreach ($resPaquete as $key => $paquete) { ?>
			<tr>
				<td><?php echo $c; ?></td>

				<?php if(!empty($paquete->tracking_garve)){ ?>
					<td><?php echo $paquete->tracking_garve; ?></td>
				<?php }else{ ?>
					<td><?php echo $paquete->numero_miami; ?></td>
				<?php } ?>

				<td><?php echo $paquete->pieza; ?></td>
				<td><?php echo $paquete->descripcion_producto; ?></td>
				<td>$ <?php echo number_format($paquete->aduana);?></td>
				<td>$ <?php echo number_format($paquete->flete);?></td>
				<td>$ <?php echo number_format($paquete->manejo);?></td>
				<td>$ <?php echo number_format($paquete->proteccion);?></td>
				<td>$ <?php echo number_format($paquete->total);?></td>
				
				<td>
					<a href="eliminar_paquete.php?id_paquete=<?php echo $paquete->id_paquete; ?>&codigo=<?php echo $codigo; ?>">Eliminar</a>
				</td>
			</tr>
			<tr>
				<td colspan="12"><hr size="1" color="#FF6600" /></td>
			</tr>
			<?php $c++; } ?>
		</table>
		
		<table class="subtotal">
			<tr>
				<td align="left"><h3>Total: $</h3></td>
				<td align="right"><h3><?php echo number_format($resSub[0]->total);?></h3></td>
			</tr>
		</table>

		<table class="recargo">
			<tr>
				<td align="left"><h3>Sub Total: $</h3></td>
				<td align="right"><h3><?php echo number_format($resSub[0]->total);?></h3></td>
			</tr>
			<tr>
				<td align="left"><h3>Recargo: $</h3></td>
				<td align="right"><h3><?php echo number_format(round($resSub[0]->total_aduana*0.05));?></h3></td>
			</tr>
			<tr>
				<td align="left"><h3>Total: $</h3></td>
				<td align="right"><h3><?php echo number_format(round($totalPagoTarjeta));?></h3></td>
			</tr>
		</table>

		<br>

		<table>
			<tr>
				<td colspan="6"><hr size="1" color="#FF6600" /></td>
			</tr>
			
			<tr>
				<th><input type="checkbox" class="form-control" id="pago_tarjeta" name="pago_tarjeta" value="5"></th>
				<th><h4>Tarjeta credito/debito (Transbank)</h4></th>
			</tr>
			<tr>
				<td>Monto</td>
				<td><input type="text" id="monto_tarjeta" name="monto_tarjeta" disabled="true" value="0"></td>
				<td>Tipo tarjeta</td>
				<td>
					<select class="form-control" id="tipo_tarjeta" name="tipo_tarjeta" disabled="true">
						<option value="0">Seleccione una opci&oacute;n</option>
						<?php foreach ($resTipoTarjeta as $key => $tipoTarjeta) { ?>
							<option value="<?php echo $tipoTarjeta->id_tipo_tarjeta; ?>"><?php echo $tipoTarjeta->nombre_tarjeta; ?></option>
						<?php } ?>
				 	</select>
				</td>
				<td>Adjuntar documento (*opcional)</td>
				<td><input type="file" id="comprobante_tarjeta" name="comprobante_tarjeta" disabled="true"></td>
			</tr>

			<tr>
				<td colspan="6"><hr size="1" color="#FF6600" /></td>
			</tr>

			<tr>
				<th><input type="checkbox" class="form-control" id="pago_efectivo" name="pago_efectivo" value="1"></th>
				<th><h4>Efectivo</h4></th>
			</tr>
			<tr>
				<td>Monto pagado</td>
				<td><input type="text" id="monto_efectivo" name="monto_efectivo" disabled="true" value="0"></td>
				<td>Monto efectivo</td>
				<td><input type="text" id="monto_pagado_efectivo" name="monto_pagado_efectivo" disabled="true" value="0"></td>
				<td>vuelto</td>
				<td><input type="text" id="vuelto_efectivo" name="vuelto_efectivo" disabled="true" readonly="true"></td>
			</tr>

			<tr>
				<td colspan="6"><hr size="1" color="#FF6600" /></td>
			</tr>

			<tr>
				<th><input type="checkbox" class="form-control" id="pago_deposito" name="pago_deposito" value="2"></th>
				<th><h4>Deposito(Transferencia)</h4></th>
			</tr>
			<tr>
				<td>Monto</td>
				<td><input type="text" id="monto_deposito" name="monto_deposito" disabled="true" value="0"></td>
				<td>Adjuntar documento (*opcional)</td>
				<td><input type="file" id="comprobante_transferencia" name="comprobante_transferencia" disabled="true"></td>
			</tr>


			<tr>
				<td colspan="6"><hr size="1" color="#FF6600" /></td>
			</tr>

			<?php for ($i=0; $i <10 ; $i++) { ?>
				<tr class="cheque<?php echo $i ?>">
					<th><input type="checkbox" class="form-control" id="pago_cheque<?php echo $i ?>" name="pago_cheque<?php echo $i ?>" value="3"></th>
					<th><h4>Cheque <?php echo $i+1; ?></h4></th>
				</tr>
				<tr class="cheque<?php echo $i ?>">
					<td>Monto</td>
					<td><input type="text" id="monto_cheque<?php echo $i ?>" name="monto_cheque<?php echo $i ?>" disabled="true" value="0"></td>
					<td>N° cheque</td>
					<td><input type="text" id="numero_cheque<?php echo $i ?>" name="numero_cheque<?php echo $i ?>" disabled="true"></td>
					<?php if($i==0){ ?>
						<td>
							<input class="trabajar-btn" type="button" id="agregar_cheque<?php echo $i ?>" name="agregar_cheque<?php echo $i ?>" value="+" disabled="true">
							<input class="trabajar-btn" type="button" id="eliminar_cheque" name="eliminar_cheque" value="-" disabled="true">
						</td>
					<?php } ?>
				</tr>
				<tr class="cheque<?php echo $i ?>">
					<td colspan="6"><hr size="1" color="#FF6600" /></td>
				</tr>
			<?php } ?>
		</table>

		<br>

		<center>
			<input type="button" class="button solid-color" name="entregar_paquetes" id="entregar_paquetes" value="Entregar Paquetes">
			<a class="button solid-color" href="procesa_cancelar_entrega.php?codigo=<?php echo $codigo; ?>">Cancelar entrega</a>
		</center>
	</form>

	<br><br><br><br>
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