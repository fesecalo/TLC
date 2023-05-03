
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
   <?php include('include_header_tlc_fb.php'); ?>
<!--FIN HEADER-->	

<!-- INCLUDE FRANJA SECCION-->
<div class="brand">
 <div class="container"><img src="images/banda_calculadora.png" class="img-responsive" alt=""/></div>
</div>
<!-- FIN INCLUDE FRANJA SECCION-->


<ul class="breadcrumbs">
 <div class="container">
     <li class="home">
        <a href="http://tlccourier.cl/inicio/tlc_fb.php" title="Portada"><img src="images/home.png" alt=""/></a>&nbsp;
       &nbsp; <span>&gt;</span>
     </li>
     <li class="home">&nbsp;
         Registro Completo&nbsp;&nbsp;
         <span>&gt;</span>
     </li>
    
  
  </div>
</ul>
<div class="single_top">
	 <div class="container"> 
	      
      
<!-- INCLUDE OK-->	
<?php include('include_ok_tlc_venezuela.php'); ?>	
<!--FIN INCLUDE OK-->	
  
   
         
   <!-- INCLUDE MENU COMO-->	
<?php include('menu_como_tlc_venezuela.php'); ?>
<!-- INCLUDE MENU COMO-->	    
             
             
             
   </div>
   
      </div>
      




         <!-- INCLUDE FOOTER  BOTTOM-->	
<?php include('include_footer_bottom_tlc_venezuela.php'); ?>
<!-- INCLUDE FOOTER  BOTTOM-->	 

        
</body>
</html>		