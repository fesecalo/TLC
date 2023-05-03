
<!DOCTYPE HTML>
<html><!-- INCLUDE HEAD-->	
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


<body>
<!-- INCLUDE HEADER-->	
   <?php include('include_header.php'); ?>
<!--FIN HEADER-->	

<!-- INCLUDE FRANJA SECCION-->
<div class="brand">
 <div class="container"><img src="images/banda_tarifas.png" class="img-responsive" alt=""/></div>
</div>
<!-- FIN INCLUDE FRANJA SECCION-->

<ul class="breadcrumbs">
 <div class="container">
     <li class="home">
        <a href="index.php" title="Portada"><img src="images/home.png" alt=""/></a>&nbsp;
       &nbsp; <span>&gt;</span>
     </li>
     <li class="home">&nbsp;
         Tarifas&nbsp;&nbsp;
     </li>
    
  
  </div>
</ul>
<div class="single_top">
<div class="container"> 

	
<h11>&nbsp;&nbsp;&nbsp;&nbsp;Tarifas Fletes Courier Miami - Santiago:</h11>

<table class="bordered">
    <thead>

    <tr>
        <th style="color:#FFFFFF;"><strong>Tramos en Kilos/Volumen </strong></th>
        <th style="color:#FFFFFF;"><strong>USD x Kilo</strong></th>

    </tr>
    <!--tr>
        <th>IMDB Top 10 Movies</th>
        <th>Year</th>
    </tr-->
    </thead>
    <tr>
        <td>0.1 - 5</td>

        <td>10.00</td>
    </tr>        
    <tr>
        <td>5.1 - 10</td>
        <td>9.50</td>
    </tr>
    <tr>

        <td>10.1 - 20</td>
        <td>9.00</td>
    </tr>    
    <tr>
        <td>20.1 - 25</td>
        <td>8.50</td>

    </tr>
    <tr>
        <td>25.1 - 30</td>
        <td>8.00</td>
    </tr>
    <tr>
        <td>Sobre los 30 Kilos </td>

        <td><a href="../inicio/contacto.php" ><strong style="color:#29418E; text-decoration:underline; background-color:#FFF; padding:3px;">COTIZAR AQU&Iacute;</strong></a> </td>
    </tr> 
    
     <tr>

        <td colspan="2"><em>(*)Esta tarifa es exenta de IVA (19%) e incluye el servicio de recepci&oacute;n y procesamiento en Miami, transporte a&eacute;reo hacia Chile y entrega en las oficinas de <strong>TLC Courier</strong> en Santiago. </em>
        </td>
    </tr> 

</table>

<!--h11>&nbsp;&nbsp;&nbsp;&nbsp;Manejo Aduanal</h11>
<table class="bordered" >
    <thead>
    <tr>
        <th colspan="2" style="color:#FFFFFF;">Sin cobro de manejo aduanal hasta  USD$1.000. Sobre los USD$1.000&nbsp;<a href="../inicio/contacto.php" ><strong style="color:#29418E; text-decoration:underline; background-color:#FFF; padding:3px;">COTIZAR AQU&Iacute;</strong></a>.<br></th>
      </tr>
    </thead>
    <tfoot>
    <tr>
        <td></td>
        <td></td>
    </tr>
    </tfoot>
</table>
<br /-->




</div>

</div>
      
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