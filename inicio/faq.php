
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
 <div class="container"><img src="images/banda_calculadora.png" class="img-responsive" alt=""/></div>
</div>
<!-- FIN INCLUDE FRANJA SECCION-->


<ul class="breadcrumbs">
 <div class="container">
     <li class="home">
        <a href="index.php" title="Portada"><img src="images/home.png" alt=""/></a>&nbsp;
       &nbsp; <span>&gt;</span>
     </li>
     <li class="home">&nbsp;
        Preguntas Frecuentes
     </li>
    
  
  </div>
</ul>
<div class="single_top">
	 <div class="container"> 
	      <div class="single_grid">
				<div class="grid-1">
       	<div class="container" style="text-align:left">
       		<h1>Preguntas Frecuentes</h1>

       	</div>
       </div> 
				  
          	    <div class="clearfix"></div>
          	   </div>
        


<!--UL MENU--><ul class="menu">
<li class="item1"><a href="#" style="text-decoration:none;"><img src="images/product_arrow.png">&iquest;Se necesita direcci&oacute;n en USA para poder comprar?</a>
      <ul>
        <li class="subitem1">
        
            <a href="#"  style="text-decoration:none;">
                 <table class="bordered">
                  <tr><td> Alrededor del 80% de las tiendas en Estados Unidos no realizan env&iacute;os Internacionales, entra a www.tlccourier.cl obt&eacute;n tu casilla en Estados Unidos y te daremos una direcci&oacute;n personal y &uacute;nica para realizar todas tus compras.</td></tr>        
                </table>
         </a>
         </li>
      </ul>
</li>


<li class="item2"><a href="#"  style="text-decoration:none;"><img src="images/product_arrow.png">&iquest;Cu&aacute;nto demoran en llegar los productos?</a>
	<ul>
		<li class="subitem1"><a href="#"  style="text-decoration:none;">                        
            <table class="bordered">
                <tr><td>Una vez que TLC COURIER en Miami recibe tus env&iacute;os en un plazo m&aacute;ximo de 24 a 48 horas podr&aacute;s retirar tu mercanc&aacute;a en nuestra oficina ubicada en Coquimbo 348, Santiago.</td></tr>        
            </table>       
    </a></li>
    </ul>
</li>


<li class="item3"><a href="#"  style="text-decoration:none;"><img src="images/product_arrow.png">&iquest;C&oacute;mo se pagan los env&iacute;os?</a>
	<ul>
	<li class="subitem1">
    <a href="#"  style="text-decoration:none;">
        <table class="bordered">
            <tr><td>El pago de tus env&iacute;os se realizaran a contra entrega.</td></tr>        
        </table>       

 	</a>
    </li>				
 	</ul>
</li>







<li class="item4"><a href="#"  style="text-decoration:none;"><img src="images/product_arrow.png">&iquest;Qu&eacute; mercanc&iacute;as pagan impuestos aduaneros?</a>
	<ul>
        <li class="subitem1">
        <a href="#"  style="text-decoration:none;">
            <table class="bordered">
              <tr><td>

    De acuerdo a la legislaci&oacute;n vigente y por regla general las importaciones est&aacute;n afectas al pago del derecho ad valorem (6%) sobre su valor CIF.
    (costo de la mercanc&iacute;a + prima del seguro + valor del flete de traslado), pago del IVA (19%) sobre el valor CIF, verificaci&oacute;n y aforo (1%) sobre el valor CIF.
    Sin embargo existen algunas mercanc&iacute;as que quedan exentos de algunos impuestos:<br>

    Todas aquellas que sean manufacturadas en Estados Unidos, adjuntando un certificado de origen (6%).<br>

    Todas las partes y piezas de computadores (6%).<br>
Libros y revistas (6%).<br>

    Quedan libres de todo impuesto aquellas mercanc&iacute;as cuyo valor FOB sea inferior a 30 USD.<br>

    Y todas aquellas mercanc&iacute;as que se acojan a alg&uacute;n tratado de libre comercio vigente.
</td></tr>        
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