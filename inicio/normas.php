
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
 <div class="container"><img src="images/banda_normas.png" class="img-responsive" alt=""/></div>
</div>
<!-- FIN INCLUDE FRANJA SECCION-->

<ul class="breadcrumbs">
 <div class="container">
     <li class="home">
        <a href="index.php" title="Portada"><img src="images/home.png" alt=""/></a>&nbsp;
       &nbsp; <span>&gt;</span>
     </li>
     <li class="home">&nbsp;
         Normas y Restricciones&nbsp;&nbsp;
     </li>
    
  
  </div>
</ul>
<div class="single_top">
<div class="container"> 
	
<div class="single_grid">
				 

<table class="bordered">
    <thead>

    <tr>
        <th style="color:#FFFFFF;"><strong>Mercanc&iacute;as que no se pueden importar</strong></th>
        </tr>
 
    </thead>
    <tr><td>Veh&iacute;culos usados (sin perjuicio de las franquicias establecidas en la normas vigentes)</td></tr>        
    <tr><td>Motos usadas</td></tr>
    <tr><td>Neum&aacute;ticos usados y recauchados</td></tr>    
    <tr><td>Asbesto en cualquiera de sus formas</td></tr>
    <tr><td>Pornograf&iacute;a</td></tr>
    <tr><td>Desechos industriales t&oacute;xicos </td></tr> 
    <tr><td>Mercanc&iacute;as que sean peligrosas para los animales, para la agricultura o la salud humana (por ejemplo; algunos plaguicidas de uso agr&iacute;cola, juguetes y art&iacute;culos de uso infantil que contengan tolueno, adhesivos fabricados en base a solventes vol&aacute;tiles), las que se encuentran prohibidas por Decreto del Ministerio de Salud, del Ministerio de Agricultura y otros organismos del Estado.<br>
Otras mercanc&iacute;as, que de acuerdo a la legislaci&oacute;n vigente, se encuentren con prohibici&oacute;n de importar.</td></tr> 


</table>

<div class="single_grid">
				<div class="grid-1">
       	<div class="container" style="text-align:left">
       		<h1>Mercanc&iacute;as que requieren visaciones, certificaciones o vistos buenos para su importaci&oacute;n:</h1>

       	</div>
       </div> 
				  
          	    <div class="clearfix"></div>
    </div>

<table class="bordered">
    <thead>

    <tr>
        <th style="color:#FFFFFF;"><strong>MERCANCIAS </strong></th>
        <th style="color:#FFFFFF;"><strong>ORGANISMOS</strong></th>

    </tr>
   
    </thead>
    <tr>
        <td>Armas de fuego, municiones, explosivos y sustancias qu&iacute;micas, inflamables y asfixiantes</td>

        <td>Direcci&oacute;n General de Movilizaci&oacute;n Nacional<br>
(www.dgmn.cl)</td>
    </tr>        
    <tr>
        <td>Material escrito o audiovisual relativo a las artes marciales destinado a la ense&ntilde;anza, sin limitaci&oacuten alguna, cualquiera que sea la persona, establecimiento o entidad que efect&uacute;e la operaci&oacuten.</td>
        <td>Direcci&oacuten General de Movilizaci&oacuten Nacional<br>
(www.dgmn.cl)</td>
    </tr>
    <tr>

        <td>Alcoholes, bebidas alcoh&oacutelicas y vinagres</td>
        <td>Servicio Agr&iacute;cola y Ganadero<br>
(www.sag.gob.cl)</td>
    </tr>    
    <tr>
        <td>Productos vegetales y mercanc&iacute;as que tengan el car&aacute;cter de peligrosas para los vegetales.</td>
        <td>Servicio Agr&iacute;cola y Ganadero<br>
(www.sag.gob.cl)</td>

    </tr>
    <tr>
        <td>Animales, productos, subproductos y despojos de origen animal o vegetal. </td>
        <td>Servicio Agr&iacute;cola y Ganadero<br>
(www.sag.gob.cl)</td>
    </tr>
    <tr>
        <td>Fertilizantes y pesticidas</td>
        <td>Servicio Agr&iacute;cola y Ganadero<br>
(www.sag.gob.cl)</td>
    </tr> 
    
        <tr>
        <td>Productos o subproductos alimenticios de origen animal o vegetal.</td>
        <td>Servicio Agr&iacute;cola y Ganadero<br>
(www.sag.gob.cl)</td>
    </tr> 
    
    
         <tr>
        <td>Productos alimenticios de cualquier tipo</td>
        <td>Servicio de Salud</td>
    </tr> 
    
         <tr>
        <td>Productos farmac&eacute;uticos o alimenticios de uso m&eacute;dico y/o cosm&eacute;tico</td>
        <td>Servicio de Salud</td>
    </tr> 
    
         <tr>
        <td>Estupefacientes y sustancias psicotr&oacutepicas que causen dependencia.</td>
        <td>Servicio de Salud</td>
    </tr> 
    
         <tr>
        <td>Sustancias t&oacutexicas o peligrosas para la salud.</td>
        <td> 	Control Alimentos</td>
    </tr> 
    
         <tr>
        <td>Elementos o materiales f&eacute;rtiles, fisionables o radioactivos, sustancias radioactivas, equipos o instrumentos que generan radiaciones ionizantes</td>
        <td>Comisi&oacuten Chilena de Energ&iacute;a Nuclear<br>
(www.cchen.cl)</td>
    </tr> 
    
         <tr>
        <td>Recursos hidrobiol&oacutegicos, cualquiera sea su estado de desarrollo, incluidas las especies de car&aacute;cter ornamental</td>
        <td>Subsecretar&iacute;a de Pesca<br>
(www.subpesca.cl)</td>
    </tr> 
         <tr>
        <td>Productos pesqueros</td>
        <td>Subsecretar&iacute;a de Pesca
( www.subpesca.cl )</td>
    </tr> 
    
    
     <tr>
        <td>Equipos de radiocomunicaciones. Requieren autorizaci&oacuten previa de uso de banda de transmisi&oacuten</td>
        <td>Subsecretar&iacute;a de Telecomunicaciones<br>
(www.subtel.cl)</td>
    </tr> 
    
    
    
     <tr>
        <td>Restos humanos o cenizas de incineraci&oacuten de los mismos</td>
        <td>Ministerio de Salud, Hospital San Juan de Dios</td>
    </tr> 
    
     <tr>
        <td>Desperdicios y desechos de pilas, bater&iacute;as y acumuladores; desechos de cinc, de plomo, de antimonio, berilio, cadmio, cromo, de productos farmac&eacute;uticos, de disolventes org&aacute;nicos.</td>
        <td>Ministerio de Salud<br>
(www.minsal.cl)</td>
    </tr> 
    
     <tr>
        <td>Especies de fauna y flora silvestres protegidas por el Convenio CITES</td>
        <td>Autoridad definida de acuerdo al art&iacute;culo IX de la Convenci&oacuten<br>
(www.cites.org)</td>
    </tr> 
    
</table><br>
<table class="bordered">
    <thead>

    <tr>
        <th style="color:#FFFFFF;"><strong>Mercanc&iacute;as que deben pagar impuestos adicionales.</strong></th>
        </tr>
 
    </thead>
    <tr><td>Art&iacute;culos de oro, platino y marfil</td></tr>        
    <tr><td>Joyas, piedras preciosas naturales o sint&eacute;ticas</td></tr>
    <tr><td>Alfombras finas y tapices finos y cualquier otro art&iacute;culo de similar naturaleza; calificados como tales por el Servicio de Impuestos Internos</td></tr>    
    <tr><td>Pieles finas, calificadas como tales por el Servicio de Impuestos Internos, manufacturadas o no</td></tr>
    <tr><td>Conservas de caviar y sus suced&aacute;os</td></tr>
    <tr><td>Armas de aire o gas comprimido, sus accesorios y proyectiles, con excepci&oacute;n de las de caza submarina </td></tr> 
    <tr><td>Veh&iacute;culos casa rodantes autopropulsados</td></tr> 
    <tr><td>Art&iacute;culos de pirotecnia, tales como fuegos artificiales, petardos y similares, excepto los de uso industrial, minero o agr&iacute;cola o de se&ntilde;alizaci&oacute;n luminosa</td></tr> 
    <tr><td>Bebidas Alcoh&oacute;licas</td></tr> 
    <tr><td>Tabaco</td></tr> 

</table>



</div>
</div><br>
<br>

      



   <!-- INCLUDE FOOTER  TOP-->	
<?php include('include_footer_top.php'); ?>
<!-- INCLUDE FOOTER  TOP-->	
    

         <!-- INCLUDE FOOTER  BOTTOM-->	
<?php include('include_footer_bottom.php'); ?>
<!-- INCLUDE FOOTER  BOTTOM-->	 
 
</body>
</html>		