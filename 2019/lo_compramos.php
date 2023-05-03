<!DOCTYPE html>
<html lang="es">

<!-- INCLUDE HEAD-->	
<?php include('include_head.php'); ?>	


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
           
    

                          
<!--  INCLUDE LO COMPRAMOS-->	
<?php include('include_lo_compramos_int.php'); ?>
     
     
      
            
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
