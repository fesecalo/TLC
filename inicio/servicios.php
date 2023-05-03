
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
 <div class="container"><img src="images/banda_ser.png" class="img-responsive" alt=""/></div>
</div>
<!-- FIN INCLUDE FRANJA SECCION-->


<ul class="breadcrumbs">
 <div class="container">
     <li class="home">
        <a href="index.php" title="Portada"><img src="images/home.png" alt=""/></a>&nbsp;
       &nbsp; <span>&gt;</span>
     </li>
     <li class="home">&nbsp;
        Servicios Adicionales
     </li>
    
  
  </div>
</ul>
<div class="single_top">
	 <div class="container"> 
	      <div class="single_grid">
				<div class="grid-1">
       	<div class="container" style="text-align:left">
       		<h1>Servicios Adicionales</h1>
       		<!--p style="text-align:justify">Texto intruductorio...</p-->
       	</div>
       </div> 
				  
          	    <div class="clearfix"></div>
          	   </div>
        


<!--UL MENU--><ul class="menu">
				<li class="item1"><a href="#" style="text-decoration:none;"><img src="images/product_arrow.png">Manejo Operacional</a>
					<ul>
						<li class="subitem1"><a href="#"  style="text-decoration:none;">
   <table class="bordered">

    <tr><td>US$ 6 + IVA (Hasta US$ 30 FOB). </td></tr>        
    <tr><td>US$ 12 + IVA (Desde US$ 30.01 hasta US$ 500 FOB).</td></tr>
    <tr><td>US$ 18 + IVA (De US$ 500.01 a US$ 1.000 FOB). </td></tr>    

</table>
   

 </a></li>
					</ul>
				</li>
                
                
                
                
   <li class="item5"><a href="#"  style="text-decoration:none;"><img src="images/product_arrow.png">Desconsolidaci&oacute;n</a>
	<ul>
	<li class="subitem1">
    <a href="#"  style="text-decoration:none;">
        <table class="bordered">
            <tr><td>US$ 18 + IVA (Todos los env&iacute;os de US$ 500 hasta US$ 1.000).</td></tr>        
            <tr><td>US$ 25 + IVA (Todos los env&iacute;os de US$ 1.000.01 FOB a m&aacute;s).</td></tr>        
        </table>       

 	</a>
    </li>				
 	</ul>
</li>             
                
                
                      
   <li class="item10"><a href="#"  style="text-decoration:none;"><img src="images/product_arrow.png">&nbsp;&nbsp;&nbsp;Consolidaci&oacute;n</a>
	<ul>
	<li class="subitem1">
    <a href="#"  style="text-decoration:none;">
        <table class="bordered">
            <tr><td>Al consolidar tus paquetes, unimos el contenido de cada uno de ellos en una sola caja, eliminando el material de reempaque innecesario y minimizando el peso final del paquete.</td></tr>   
            <tr><td>US$ 35 + IVA.</td></tr>         
        </table>       

 	</a>
    </li>				
 	</ul>
</li>             
         
        
        
        
<li class="item4"><a href="#"  style="text-decoration:none;"><img src="images/product_arrow.png">Cargo Terminal</a>
	<ul>
        <li class="subitem1">
        <a href="#"  style="text-decoration:none;">
            <table class="bordered">
              <tr><td>US$ 25 + IVA ( Todos los env&iacute;os de US$ 1.000 FOB a m&aacute;s).</td></tr>        
            </table>
            </a>
       </li>
					</ul>
				</li>



        
           
                
<li class="item3"><a href="#"  style="text-decoration:none;"><img src="images/product_arrow.png">Agente de Aduana</a>
	<ul>
	<li class="subitem1">
    <a href="#"  style="text-decoration:none;">
        <table class="bordered">
            <tr><td>US$ 90 + IVA (Para mercader&iacute;as desde US$ 1.000 hasta US$ 6000 FOB).</td></tr>        
            <tr><td>Mercader&iacute;as sobre US$6.000.01 FOB, cotizar.</td></tr>        
        </table>       

 	</a>
    </li>				
 	</ul>
</li>



<li class="item8"><a href="#"  style="text-decoration:none;"><img src="images/product_arrow.png">&nbsp;&nbsp;S.E.D</a>
	<ul>
	<li class="subitem1">
    <a href="#"  style="text-decoration:none;">
        <table class="bordered">
            <tr><td>(Shipper's Export Declaration) US$ 35 + IVA por emisi&oacute;n de dicho documento en caso que el proveedor no lo haga. Para toda mercader&iacute;a que iguale o supere los US$ 2.500 por &iacute;tem o la suma de ellos sean considerados dentro de una misma categor&iacute;a alcancen este valor.</td></tr>        
        </table>       

 	</a>
    </li>				
 	</ul>
</li>


             
                
                
				<li class="item2"><a href="#"  style="text-decoration:none;"><img src="images/product_arrow.png">Pick up</a>
					<ul>
					    <li class="subitem1"><a href="#"  style="text-decoration:none;">
                        
                        
<table class="bordered">
    <tr>
      <td> US$ 40 + IVA (Por retiro de mercader&iacute;as dentro del Estado de Florida, Miami Doral). Fuera de este Estado se cotizar&aacute;.</td></tr>        

</table>       

    
    </a></li>
					</ul>
				</li>
                
        









<li class="item6"><a href="#"  style="text-decoration:none;"><img src="images/product_arrow.png">&nbsp;&nbsp;Tramitaci&oacute;n V&deg; B&deg;</a>
	<ul>
	<li class="subitem1">
    <a href="#"  style="text-decoration:none;">
        <table class="bordered">
            <tr><td>US$ 35 + IVA (Todos los env&iacute;os que requieran V&deg; B&deg; del SAG, SNS, CCC, etc).</td></tr>        
        </table>       

 	</a>
    </li>				
 	</ul>
</li>


<li class="item7"><a href="#"  style="text-decoration:none;"><img src="images/product_arrow.png">&nbsp;&nbsp;Courier</a>
	<ul>
	<li class="subitem1">
    <a href="#"  style="text-decoration:none;">
        <table class="bordered">
            <tr><td>Las mercader&iacute;as que "EL CLIENTE" desee transportar por esta v&iacute;a deberan ser cotizadas y solicitadas previamente al embarque. (mercader&iacute;as sobre los 30 kilos).</td></tr>        
        </table>       

 	</a>
    </li>				
 	</ul>
</li>




<li class="item9"><a href="#" style="text-decoration:none;"><img src="images/product_arrow.png">&nbsp;&nbsp;Despacho a Domicilio</a>
	<ul>
	<li class="subitem1">
    <a href="#"  style="text-decoration:none;">
        <table class="bordered">
            <tr><td>A cotizar de acuerdo al peso y volumen del env&iacute;o. Para regiones se hara a travez del transportista designado por EL CLIENTE con flete a pagar, no teniendo LA EMPRESA responsabilidad alguna desde la entrega de la mercader&iacute;a en nuestras oficinas..</td></tr>        
        </table>       

 	</a>
    </li>				
 	</ul>
</li>
				
</ul>
<!--FIN UL MENU-->
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