<?php
include("../lib/conf.php");
//-------CONFIGURACION-----/////////***************
	$qr_conf = "SELECT * from configuracion WHERE 1 LIMIT 1";
	$arr_conf = mysqli_query($connection, $qr_conf) or die('Error en llamada 37');
	$ROW_CONF = mysqli_fetch_assoc($arr_conf);
//***************************************************

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=clientes_tlc_2018.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<?php
$q_ru = "SELECT GARUSU.fecharegistro, GARUSU.id_usuario, GARUSU.id_cliente, GARUSU.promoap, GARUSU.email, GARUSU.nombre, GARUSU.apellidos,	GARUSU.rut, GARUSU.telefono, GARUSU.direccion, REGION.nombre_region, COMUNA.nombre_comuna 
FROM gar_usuarios GARUSU
LEFT JOIN region REGION ON GARUSU.id_region = REGION.id_region
LEFT JOIN comunas COMUNA ON GARUSU.id_comuna = COMUNA.id_comuna";
$arr_ru = mysqli_query($connection, $q_ru) or die('Error en llamada 37r');
//$n_ru = mysqli_num_rows($arr_ru);
		  				  				   
?><META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
<table width="798" border="1" cellpadding="0" cellspacing="0" bordercolor="#333333" >
     <tr bgcolor="#C1E0FF">
				  
                
    <th width="20"><font size="2">ID</font></th>
	<th width="20"><font size="2">Numero cliente</font></th>
				<th width="215" nowrap><font size="2">Fecha Registro</font></th> 
                		<th width="215" nowrap><font size="2">Promo Code</font></th> 
                <th width="215"><font size="2"> Nombre-Apellido</font></th>
				               
                <th width="147"><font size="2"> Rut</font></th>

                <th width="101"><font size="2"> Email</font></th>
				<th width="149"><font size="2"> Fono</font></th>
				<th width="149"><font size="2"> Direccion</font></th>
				<th width="128"><font size="2"> Region</font></th>
				<th width="114"><font size="2"> Comuna</font></th>
			

              </tr>
  <?php while ($ROW_CV = mysqli_fetch_assoc($arr_ru)) { ?>
    <tr> 
				   
                <td>
              <?php echo $ROW_CV['id_usuario'];?>
             </td>
			 <td>
              <?php echo $ROW_CV['id_cliente'];?>
             </td>
			 <td>
              <?php echo $ROW_CV['fecharegistro'];?>
             </td>
             <td>
              <?php echo $ROW_CV['promoap'];?>
             </td>
              <td>
              <?php echo $ROW_CV['nombre']." ".$ROW_CV['apellidos'];?>
             </td>
			  <td>
              <?php echo $ROW_CV['rut'];?>
             </td>
			  <td>
              <?php echo $ROW_CV['email'];?>
             </td>
			  <td>
              <?php echo $ROW_CV['telefono'];?>
             </td>
			  <td>
              <?php echo $ROW_CV['direccion'];?>
             </td>
			  <td>
              <?php echo $ROW_CV['nombre_region'];?>
             </td>
			   <td>
              <?php echo $ROW_CV['nombre_comuna'];?>
             </td>
               
              </tr>
<?php  } ; ?>
</table>
<?php exit();?>
