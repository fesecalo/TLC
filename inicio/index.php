<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><!-- INCLUDE HEAD-->
<!--ESTA LINEA ES IMPORTANTE PARA MOSTRAR ACENTOS--><meta content="text/html; charset=iso-8859-1" http-equiv=Content-Type> 	
<!-- INCLUDE HEAD-->	
<?php include('include_head.php'); ?>	
<!--FIN HEAD-->	

<!--POPUP EMERGENTE-->
<!--script>

// definimos la anchura y altura de la ventana
var altura=500;
var anchura=500;
// calculamos la posicion x e y para centrar la ventana
var y=parseInt((window.screen.height/2)-(altura/2));
var x=parseInt((window.screen.width/2)-(anchura/2));

// mostramos la ventana centrada
function abrir() {
open('http://tlccourier.cl/inicio/images/CORP4.png',target='blank','width='+anchura+',height='+altura+',top='+y+',left='+x+',toolbar=no,location=no,status=no,menubar=no,scrollbars=no,directories=no,resizable=no') ;
}
</script-->


<!--body onload="abrir()"-->

<!--FIN POPUP EMERGENTE-->

<body>


<!--input type="checkbox" id="cerrar">
        <label for="cerrar" id="btn-cerrar">CERRAR</label>
        <div class="modal">
     
            <div class="contenido">
                <a href="http://www.tlccourier.cl/inicio/registro.php"><img src="images/oferta.png" alt=""></a>
                
                
            </div>
        </div-->
<!-- INCLUDE HEADER-->	
   <?php include('include_header.php'); ?>
<!--FIN HEADER-->	




<!-- INCLUDE SLIDER-->	
<?php include('include_slider.php'); ?>	
<!--FIN SLIDER-->	




	<div class="clearfix"> </div>



<!-- INCLUDE 4 PASOS-->	
<?php include('include_4_pasos.php'); ?>	
<!--FIN INCLUDE 4 PASOS-->	


<!-- INCLUDE SEGUIMIENTO-->	
<?php include('include_4_tr.php'); ?>	
<!--FIN INCLUDE SEGUIMIENTO-->	



<!-- INCLUDE TIENDAS RECOMENDADAS-->
<? //php include('include_tiendas_recomendadas.php'); ?>
<!--FIN INCLUDE RECOMENDADAS-->	

<!-- INCLUDE MARCAS FAVORITAS-->	
<? //php include('include_marcas_favoritas.php'); ?>
<!--FIN INCLUDE MARCAS FAVORITAS-->	

<!-- INCLUDE SOBRE AEROEXPRESS-->	
<?php include('include_sobre_aeroexpress.php'); ?>
<!-- INCLUDE SOBRE AEROEXPRESS-->	

<!-- INCLUDE MEDIO PAGO-->	
<? //php include('include_medio_pago.php'); ?>
<!-- INCLUDE MEDIO PAGO-->	


   <!-- INCLUDE FOOTER  TOP-->	
<?php include('include_footer_top.php'); ?>
<!-- INCLUDE FOOTER  TOP-->	
    

         <!-- INCLUDE FOOTER  BOTTOM-->	
<?php include('include_footer_bottom.php'); ?>
<!-- INCLUDE FOOTER  BOTTOM-->	 
<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script-->
   
       
       
</body>
</html>		