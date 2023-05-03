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
<?php include('include_head_venezuela.php'); ?>	
<!--FIN HEAD-->	

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5c472c06ab5284048d0e0c82/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
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
   <?php include('include_header_tlc_venezuela.php'); ?>
<!--FIN HEADER-->	


<!-- INCLUDE SLIDER-->	
<?php include('include_slider_tlc_vene_mov.php'); ?>	
<!--FIN SLIDER-->	


	

<!-- INCLUDE SOBRE VENEZUELA-->	
<?php include('include_sobre_venezuela_mov.php'); ?>

      <!-- INCLUDE REGISTRO-->	
<?php include('include_registro_tlc_venezuela.php'); ?>


<!-- INCLUDE SOBRE VENEZUELA FOTO-->	
<?php include('include_sobre_venezuela_foto_mov.php'); ?>
   
  <!-- INCLUDE 4 PASOS-->	
<? //php include('include_4_pasos_tlc_venezuela.php'); ?>	
  
<!-- INCLUDE TIENDAS RECOMENDADAS-->
<? //php include('include_tiendas_recomendadas_tlc8.php'); ?>


<!-- INCLUDE TRACKING-->	
<? //php include('include_4_tr_tlc_venezuela.php'); ?>

<!-- INCLUDE SOBRE TLCCOURIER-->	
<?php include('include_sobre_aeroexpress.php'); ?>

   <!-- INCLUDE CONTACTO-->	
<?php include('include_contacto_venezuela.php'); ?>
<!-- INCLUDE CONTACTO-->	

         <!-- INCLUDE FOOTER  BOTTOM-->	
<?php include('include_footer_bottom_tlc_venezuela.php'); ?>
<!-- INCLUDE FOOTER  BOTTOM-->	 


</body>
</html>		