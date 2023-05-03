
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
<div class="contact">
      	<div class="container">
      	   <div class="register">
		  	 <form action="enviar.php" method="post" enctype="multipart/form-data" onSubmit="javascript:return valida()" class="row" name="form1">

				 <div class="register-top-grid">
					<h3>DATOS PERSONALES</h3>
					 <div>
						<span>Email<label>*</label></span>
						<input id="emailAddress" name="email_usu"  type="text" value="" title="Ingresa tu email"  placeholder="email" required="required"  >

					 </div>
					 <div>
						<span>Nombre<label>*</label></span>
					<input id="firstName" name="nombre_usu"  type="text" value="" title="Nombre" placeholder="Nombre" required="required">
          </div>
					 <div>
						 <span>Apellido<label>*</label></span>
						             <input id="lastName" type="text" name="apellidos_usu" placeholder="Apellidos"  value="" title="Ingresa tu Apellido" required="required" >
					 </div>
                     
                      <div>
						 <span>RUT: E.j. 11.111.111-1 <label>*</label></span>
						 <input name="rut_usu" type="text"  id="customerID_Number" value=""   placeholder="RUT"   title="Ingresa tu RUT" required="required">  
					 </div>
                     
                      <div>
						<span>Tel&eacute;fono<label>*</label></span>
						<input id="mobileNumber" name="fono_usu"  type="text" value=""  placeholder="Tel&eacute;fono"  title="Ingresa un n&uacute;mero de tel&eacute;fono">
					 </div>
					 <div>
						<span>Direcci&oacute;n<label>*</label></span>
						<input id="direccion" name="direccion_usu"  type="text" value="" title="Ingresa tu Direcci&oacute;n" placeholder="Direcci&oacute;n" >

					 </div>
					
                     
                      <div>
						 <span>Regi&oacute;n<label>*</label></span>
						<select name="categoria" class="form-control"    id="id_comuna_scl" title="Ingresa Comuna" onChange="act_categoria(this);" required="required">
<option value="">Seleccione Region</option>
	
							<option value="" >REGIONES</option>

</select>
					 </div>
                     
                      <div>
						 <span>Comuna<label>*</label></span>
						 <select name="subcategoria" class="form-control" title="Comuna" id="subcategoria" required="required">
						<option value="0"></option>
						 </select>
					 </div>
					 <div class="clearfix"> </div>
					   <a class="news-letter" href="#">
						 <label class="checkbox"><input type="checkbox" name="checkbox" checked="" required="required"><i> </i>Acepto Los T&eacute;rminos y Condiciones</label>
					   </a>
					 </div>
				     <!--div class="register-bottom-grid">
						    <h3>DATOS DE ACCESO</h3>
							 <div>
								<span>Password<label>*</label></span>
								<input type="text">
							 </div>
							 <div>
								<span>Confirmar Password<label>*</label></span>
								<input type="text">
							 </div>
							 <div class="clearfix"> </div>
                             
					 </div-->
                 	
				<div class="clearfix"> </div>
				<div class="register-but">
				  
                  
                  
					   <input type="submit" style="float: right; background-color:#005FAC; border:none; padding:15px; font-size:90%; font-weight:bold; color:#FFF; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif" value="Registrarme">
					   <div class="clearfix"> </div>
				  
				</div> </form>
		   </div>
      	 </div>
      </div>