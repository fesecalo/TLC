<?php 
	// se inicia sesion
	session_start();
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	include $conf['path_host'].'/conexion.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	include $conf['path_host'].'/include/include_validar_rut.php';
	require $conf['path_host'].'/funciones/generar_csrf.php'; //agregar input hidden en form para enviar el token

	$sql_region=$db->get_results("SELECT * FROM region ORDER BY id_region");
?>

<!DOCTYPE html>
<html lang="es">

	<!-- HEAD-->
	<?php require_once $conf['path_host'].'/include/include_head.php'; ?>	
	<!--FIN HEAD-->

	<!-- java scripts -->
	<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
	<!-- fin java scripts-->

	<!-- Script de validaciones -->
	<script type="text/javascript">
		$(document).ready(function(){
			// Formato de email
			var er_correo = /^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/;
			// Fin formato email

			// formato de contraseña ... mayuscula, letras y numeros
			var er_pass = /(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
			// fin formato contraseña

			// Boton mostrar y ocultar terminos y condiciones
			$("#ocultar").hide();
			$(".vFlotante").hide();

			$("#ocultar").click(function(){
				$(".vFlotante").hide('200');
				$("#ocultar").hide();
			});

			$("#mostrar").click(function(){
				$(".vFlotante").show('200');
				$("#ocultar").show();
			});
			// fin botones terminos y condiciones

			// bloquear la funcion cortar,copiar y pegar de los input
			$("#email").bind("cut copy paste",function(e) {
	     		e.preventDefault();
	    	});

	    	$("#reemail").bind("cut copy paste",function(e) {
	     		e.preventDefault();
	    	});
	    	// fin bloquear la funcion cortar,copiar y pegar de los input

			// funcion que valida las comunas al seleccionar una region
			$("#region").change(function(){
				recargarLista();
			});
			// fin funcion validacion comunas

			// validacion de datos al presionar el botonregistrar
			$("#registrar").click(function(){
				// if($("#nombre").val()==""){
				// 	alert("Ingrese su nombre.");
				// 	$("#nombre").focus();
				// 	return false;
				// }

				// if($("#apellido_p").val()==""){
				// 	alert("Ingrese sus apellidos.");
				// 	$("#apellido_p").focus();
				// 	return false;
				// }

				// if($("#rut").val()==""){
				// 	alert("Ingrese su rut.");
				// 	$("#rut").focus();
				// 	return false;
				// }else{
				// 	if (validacion_rut($("#rut").val())==2) {
				// 		return false;
				// 	}
				// }
				
				// if($("#email").val()==""){
				// 	alert("Ingrese email.");
				// 	$("#email").focus();
				// 	return false;
				// }

				// if($("#reemail").val()==""){
				// 	alert("Debe repetir el email ingresado.");
				// 	$("#reemail").focus();
				// 	return false;
				// }

				// if($("#email").val()!=$("#reemail").val()){
				// 	alert("los emails ingresados no coinciden");
				// 	$("#email").focus();	
				// 	return false;
				// }else{
				// 	if($("#email").val().match(er_correo)==null){
				// 		alert("Email no valido");
				// 		$("#email").focus();	
				// 		return false;
				// 	}
				// }

				// if($("#telefono").val()==""){
				// 	alert("Ingrese su numero de celular.");
				// 	$("#telefono").focus();
				// 	return false;
				// }

				// if($("#region").val()==0){
				// 	alert("Seleccione una región.");
				// 	$("#region").focus();
				// 	return false;
				// }

				// if($("#comuna").val()==0){
				// 	alert("Seleccione una comuna.");
				// 	$("#comuna").focus();
				// 	return false;
				// }

				// if($("#direccion").val()==""){
				// 	alert("Ingrese una direccion de entrega.");
				// 	$("#direccion").focus();
				// 	return false;
				// }

				// if($("#pass").val()==""){
				// 	alert("Ingrese contraseña.");
				// 	$("#pass").focus();
				// 	return false;
				// }

				// if($("#pass2").val()==""){
				// 	alert("Debe repetir la contraseña.");
				// 	$("#pass2").focus();
				// 	return false;
				// }

				// if($("#pass").val()!=$("#pass2").val()){
				// 	alert("Contrase\u00f1as no coinciden");
				// 	$("#pass").val("");
				// 	$("#pass2").val("");
				// 	$("#pass").focus();	
				// 	return false;
				// }else{
				// 	if($("#pass").val().match(er_pass)==null){
				// 		alert("Contrase\u00f1a no v\u00e1lida, debe contener m\u00ednimo 8 caracteres, una letra may\u00fascula, una m\u00faniscula y un n\u00famero.");
				// 		$("#pass").val("");
				// 		$("#pass2").val("");
				// 		$("#pass").focus();	
				// 		return false;
				// 	}
				// }

			    if($("#terminos").is(":checked")){
			        document.registro.submit();
			    }else{
			    	alert("Debe confirmar los terminos y condiciones.");
					$("#terminos").focus();
					return false;
			    }	
			});	
			// Fin boton registrar
		});
	</script>
	<!-- Fin script de validaciones -->

	<!-- stilo div terminos y condiciones -->
	<script language="Javascript">
		function aparecer(id) {
			var d = document.getElementById(id);
			d.style.display = "block";
			d.style.visibility = "visible";
		}
		function ocultar(id) {
			var d = document.getElementById(id);
			d.style.display = "none";
			d.style.visibility = "hidden";
		}
		window.onload = function () {
			//Al cargar la página se oculta el div de consulta
			ocultar("condiciones");
		}
	</script> 
	<!-- Fin estilo -->
	<!-- script que realiza el volcado de datos en el select comuna segun la region seleccionada -->
	<script type="text/javascript">
		function recargarLista(){
			$.ajax({
				type:"POST",
				url:"comunas.php",
				data:"idRegion=" + $('#region').val(),
				success:function(r){
					$('#comuna').html(r);
				}
			});
		}
		
		function gotToRegisterUser(){
		    window.location.href =  '../usuario_registro/registro_empresa.php';
		}
		
	</script>
	<!-- Fin script de validaciones -->

	<body>

		<!-- HEADER-->
		<?php require $conf['path_host'].'/include/include_menu.php'; ?> 
		<!--FIN HEADER-->

        <!--Inicio Contenido -->
		<div class="container-fluid">
            <div class="container">
                 <div class="row">
            		<div class="col-xs-10">
            	        <h2>Crear cuenta persona</h2>	
            	    </div>
            	    <div class="col-xs-2 text-right">
        		        <button class="btn btn-primary" type="button" title="Crea una cuenta empresa aquí" id="boton-new-user" onclick="gotToRegisterUser();">
                            Crea una cuenta empresa aquí
                        </button>
        		    </div>  
            	</div>
            	<div class="row">
	            <div class="col-lg-12">
	        
	        
    		        <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Información usuario  </h4> 
                        </div>
                        <div class="panel-body">
	        
	        
        		        	<form 
        		        	    name="registro" 
        		        	    id="registro" 
        		        	    action="procesa_usuario.php" 
        		        	    method="POST" 
        		        	    >
        		        	    
        		        	    <input type="hidden" name="_token" value="<?php echo $token_value; ?>" />
					            <input name="promoap" size="60" maxlength="100" class="form-control" type="hidden" value="BASICA" >
        		        	    
                    		    <div class="col-lg-4">
            		                <div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Nombre
                                            </b>
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="nombre" 
                                            name="nombre" 
                                            maxlength="100"  
                                            placeholder="Nombre">
                                        <p class="help-block">Agregar nombre</p>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Email
                                            </b>
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="email" 
                                            name="email" 
                                            maxlength="100"  
                                            placeholder="ejemplo@ejemplo.com">
                                        <p class="help-block">Agregar el Email del usuario</p>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Regi&oacute;n
                                            </b>
                                        </label>
                                            <select class="form-control" id="region" name="region">
                								<option value="0">Seleccione una regi&oacute;n</option>
                								<?php
                									foreach ($sql_region as $key => $region) { 
                								?>									?>
                								<option value="<?php echo $region->id_region; ?>"><?php echo $region->nombre_region; ?></option>
                								<?php
                								}
                							 	?>
            							 	</select>
                                        <p class="help-block">Seleccionar la regi&oacute;n del usuario</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Contrase&ntilde;a
                                            </b>
                                        </label>
                                        <input 
                                            type="password" 
                                            class="form-control" 
                                            id="pass" name="pass" 
                                            maxlength="100">
                                        <p class="help-block">Agregar contrase&ntilde;a del usuario, debe contener mayúscula y números</p>
                                    </div>
                                </div>
                                
                    			<div class="col-lg-4">
                    			    
                    			    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Apellido paterno y materno
                                            </b>
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="apellido_p" 
                                            name="apellido_p" 
                                            maxlength="100"  
                                            placeholder="Apellido paterno">
                                        <p class="help-block">Agregar apellido paterno y materno</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Confirmar Email
                                            </b>
                                        </label>
                                        <input 
                                            type="text" 
                                                class="form-control" 
                                                id="reemail" 
                                                name="reemail" 
                                                maxlength="100"  
                                                placeholder="ejemplo@ejemplo.com">
                                        <p class="help-block">Confirmar el Email del usuario</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Comuna
                                            </b>
                                        </label>
                                            <select 
                                                class="form-control" 
                                                id="comuna" 
                                                name="comuna" > 
                                                    <option value="0">Seleccione una opci&oacute;n</option> 
                                            </select>
                                        <p class="help-block">Seleccionar la comuna del usuario</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Confirmar contrase&ntilde;a
                                            </b>
                                        </label>
                                        <input 
                                            type="password" 
                                            class="form-control" 
                                            id="pass2" 
                                            name="pass2" 
                                            maxlength="100">
                                        <p class="help-block">Confirmar contrase&ntilde;a</p>
                                    </div>
                                </div>
                    			
                    			<div class="col-lg-4">
                    				<div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                R.U.T
                                            </b>
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="rut" 
                                            name="rut" 
                                            maxlength="100"  
                                            placeholder="12345678-9">
                    				    
                                        <p class="help-block">Agregar R.U.N personal</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                N&uacute;mero celular
                                            </b>
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="telefono" 
                                            name="telefono" 
                                            maxlength="100"  
                                            placeholder="+56912345678">
                                        <p class="help-block">Agregar el n&uacute;mero del usuario</p>
                                    </div>
                    				
                                </div>
                                
            					<div class="col-lg-4">
            					    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <b>
                                                Direcci&oacute;n
                                            </b>
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="direccion" 
                                            name="direccion" 
                                            maxlength="100"  
                                            placeholder="Direccion">
                                        <p class="help-block">Agregar direcci&oacute;n del usuario</p>
                                    </div>
                                    <div class="form-group" style="margin-top:40px">
                                        <label class="col-sm-12 checkbox-inline">
                                        <input class="form-check-input" type="checkbox" id="terminos" value="1" >
                                       	<a href="../my_tlc/include/include_terminos_condiciones.php" style="color:#0045AD;" target="_blank">Acepto los  t&eacute;rminos y condiciones</a>.</label>
                                      </div>
            					</div>
            					
                    	    </form>
                    	        
                    	        <div class="col-lg-12 text-right">
                    	             <input type="button" class="button solid-color" id="registrar" name="registrar" value="Registrar">
                    	        </div>
                    	        
                    	        
                    	        
                    	    </div>
        	            </div>  
    		        
        		    </div>
        	    </div>  
    	    </div>
    	</div>

		<!-- INCLUDE FOOTER-->
		<?php require $conf['path_host'].'/include/include_footer.php'; ?> 
		<!--FIN FOOTER-->
	</body>

</html>