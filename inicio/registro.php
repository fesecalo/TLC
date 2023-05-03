<?php
include("../lib/conf.php");
//-------CONFIGURACION-----/////////***************
	$q_rs2 = "SELECT * from configuracion WHERE 1 LIMIT 1";
	$arr_rs2 = mysqli_query($connection, $q_rs2) or die('Error en llamada 86');
	$ROW_CONF = mysqli_fetch_assoc($arr_rs2);

//***************************************************
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><!-- INCLUDE HEAD-->
<!--ESTA LINEA ES IMPORTANTE PARA MOSTRAR ACENTOS--><meta content="text/html; charset=iso-8859-1" http-equiv=Content-Type> <!--ESTA LINEA ES IMPORTANTE PARA MOSTRAR ACENTOS-->
<?php include('include_head.php'); ?>	
<!--FIN HEAD-->	
<!--initiate accordion-->
<script type="text/javascript">
	$(function() {
	
	    var menu_ul = $('.menu > li > ul'),
	           menu_a  = $('.menu > li > a');
	    
	    menu_ul.hide();
	
	    menu_a.click(function(e) {
	        e.preventDefault();
	        if(!$(this).hasClass('active')) {
	            menu_a.removeClass('active');
	            menu_ul.filter(':visible').slideUp('normal');
	            $(this).addClass('active').next().stop(true,true).slideDown('normal');
	        } else {
	            $(this).removeClass('active');
	            $(this).next().stop(true,true).slideUp('normal');
	        }
	    });
	
	});
</script>

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


<body>
<!-- INCLUDE HEADER-->	
   <?php include('include_header.php'); ?>
<!--FIN HEADER-->	
<!-- INCLUDE FRANJA SECCION-->
<div class="brand">
 <div class="container"><img src="images/banda_registro.png" class="img-responsive" alt=""/></div>
</div>
<!-- FIN INCLUDE FRANJA SECCION-->

<ul class="breadcrumbs">
 <div class="container">
     <li class="home">
        <a href="index.php" title="Portada"><img src="images/home.png" alt=""/></a>&nbsp;
       &nbsp; <span>&gt;</span>
     </li>
     <li class="home">&nbsp;
         Registro&nbsp;&nbsp;
     </li>
    
  
  </div>
</ul>


      <!-- INCLUDE REGISTRO-->	
<?php include('include_registro.php'); ?>
<!-- INCLUDE REGISTRO-->	

<!-- INCLUDE 4 PASOS-->	
<? //php include('include_4_pasos.php'); ?>	
<!--FIN INCLUDE 4 PASOS-->	
	
      
      <!-- INCLUDE MEDIO PAGO-->	
<? //php include('include_medio_pago.php'); ?>
<!-- INCLUDE MEDIO PAGO-->	


   <!-- INCLUDE FOOTER  TOP-->	
<?php include('include_footer_top.php'); ?>
<!-- INCLUDE FOOTER  TOP-->	
    

         <!-- INCLUDE FOOTER  BOTTOM-->	
<?php include('include_footer_bottom.php'); ?>
<!-- INCLUDE FOOTER  BOTTOM-->	 


</body>
</html>		