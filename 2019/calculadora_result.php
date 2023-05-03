<?php
include_once("../lib/conf.php");
//-------CONFIGURACION-----/////////***************
	$q_rs2 = "SELECT * from configuracion WHERE 1 LIMIT 1";
	$arr_rs2 = mysqli_query($connection, $q_rs2) or die('Error en llamada 86');
	$ROW_CONF = mysqli_fetch_assoc($arr_rs2);
//***************************************************
?>
<!DOCTYPE html>
<html lang="es">

<!-- INCLUDE HEAD-->	
<?php include('include_head.php'); ?>	

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



<!--   ESCONDER Y MOSTRAR/-->

   <script type="text/javascript">
function mostrar(){
document.getElementById('oculto').style.display = 'block';}
</script>


<body data-theme="theme-6">

<!-- INCLUDE HEADER--><!-- LOADER -->
    <div id="loader-wrapper">
        <img src="img/theme-1/logo.png" alt=""/>
        <span></span>
    </div>
    
    <div id="content-wrapper">
        
        <div class="blocks-container">
            
   <!-- INCLUDE HEADER-->	
<?php include('include_header_int.php'); ?>	        
           
    

                          
<!--  CALCULADORA-->	
<?php include('include_calculadora_result.php'); ?>
     
     
      
            
          <!-- FOOTER-->	
<?php include('include_footer.php'); ?>

   
    
    

 <script src="js/jquery-2.1.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/idangerous.swiper.min.js"></script>
    <script src="js/global.js"></script>

    <script src="js/wow.min.js"></script>
    <script>
        var wow = new WOW(
            {
                boxClass:     'wow',      // animated element css class (default is wow)
                animateClass: 'animated', // animation css class (default is animated)
                offset:       100,          // distance to the element when triggering the animation (default is 0)
                mobile:       true,       // trigger animations on mobile devices (default is true)
                live:         true,       // act on asynchronously loaded content (default is true)
                callback:     function(box) {
                  // the callback is fired every time an animation is started
                  // the argument that is passed in is the DOM node being animated
                }
            }
        );
        $(window).load(function(){
            wow.init();    
        });
        
    </script>

    <script src="js/isotope.pkgd.min.js"></script>
    <script>
        $(function(){
            $(window).load(function(){
                var $container = $('.sorting-container').isotope({
                    itemSelector: '.sorting-item',
                    masonry: {
                        columnWidth: '.grid-sizer'
                    }
                });

                $('.sorting-menu a').click(function() {
                    if($(this).hasClass('active')) return false;
                    $(this).parent().find('.active').removeClass('active');
                    $(this).addClass('active');
                    var filterValue = $(this).attr('data-filter');

                      $container.isotope({ filter: filterValue });
                });
            });
        });
    </script>

    <script src="js/subscription.js"></script>
</body>
</html>
