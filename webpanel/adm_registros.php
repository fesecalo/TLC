<?php 
$no_visible_superior = false;
$no_visible_lateral  = false;
include("header.php");
$seccion=41;
$sw=0;
if (!valida_usuario($_SESSION['id_usuario'],$seccion)) {
	include('acceso_denegado_secciones.php');
	exit(); 
};


//#######################......MODIFICA ........#######################################
if (isset($_POST['modificar']) and ($_POST['modificar']<>"")){
//modifico datos 
	$q_modif = "UPDATE gar_usuarios SET 
	promoap = '".$_POST['c_promoap']."',
	email = '".$_POST['c_email']."',
	nombre = '".$_POST['c_nombre']."',
	apellidos = '".$_POST['c_apellidos']."',
	rut = '".$_POST['c_rut']."',
	telefono = '".$_POST['c_telefono']."',
	direccion = '".$_POST['c_direccion']."',
	id_region = '".$_POST['categoria']."',
	id_comuna = '".$_POST['subcategoria']."'
	WHERE id_usuario='".$_GET['sec']."'";
	$arr_m = mysqli_query($connection, $q_modif) or die('Error en llamada 15');
	$RS_MODIFICA = mysqli_fetch_assoc($arr_m);
}
//##############################FIN MODIFICCA##################################


//#######################......INGRESA ........#######################################
if (isset($_POST['ingresar']) and ($_POST['ingresar']<>"")){

//INSERTO datos

	$q_= "SELECT MAX(id_usuario) as id_usuam FROM gar_usuarios";
	$arr_ = mysqli_query($connection, $q_) or die('Error en llamada 86');
	$RS_ = mysqli_fetch_assoc($arr_);
	$numeroid = $RS_['id_usuam']+1;
	$numerocliente= "721-".$numeroid;
	
	
	$q_insert = "INSERT INTO gar_usuarios 
	(id_cliente, tipo, promoap, email, nombre, apellidos, rut, telefono ,	direccion,	id_region, id_comuna)
	VALUES
	('".$numerocliente."','PERSONA','".$_POST['c_promoap']."','".$_POST['c_email']."','".$_POST['c_nombre']."','".$_POST['c_apellidos']."','".$_POST['c_rut']."','".$_POST['c_telefono']."','".$_POST['c_direccion']."','".$_POST['categoria']."','".$_POST['subcategoria']."')";
	//echo $q_insert;
	$arr_i = mysqli_query($connection, $q_insert) or die('Error en llamada 15');
	$RS_INSERTA = mysqli_fetch_assoc($arr_i);




}

//###########################################################################################
//#######################......ELIMINA USUARIO........#######################################
if (isset($_GET['elimina']) and ($_GET['elimina']<>"")){

	$q_borra = "DELETE FROM gar_usuarios
				 WHERE id_usuario = '".$_GET['sec']."'";
	$arr_b = mysqli_query($connection, $q_borra) or die('Error en llamada 15');
	$RS_BORRA = mysqli_fetch_assoc($arr_b);
unset($_GET['elimina']);

}
//#################################FINELIMINA###############################
if ($_GET['opc']=='E') {
	$q_rs2 = "SELECT * FROM gar_usuarios where id_usuario='".$_GET['sec']."' limit 0,1";
	$arr_rs2 = mysqli_query($connection, $q_rs2) or die('Error en llamada 86');
	$RS2 = mysqli_fetch_assoc($arr_rs2);
	//$RS2['id_usuario'];
}

?>


<script language="JavaScript" type="text/JavaScript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function elimina(id_usuario){
	   if (confirm("Desea eliminar?")) 
	  {
		window.location.href="adm_registros.php?sec="+id_usuario+"&elimina=eliminar";
	    return true;	
   
   }  
}
</script>
<script language="JavaScript">
<!--
<?php $sstq="select * from comunas";
$slinkq = mysqli_query($connection, $sstq) or die('Error en llamada 76r');
while ($srow3q = mysqli_fetch_assoc($slinkq)) { 
$sajys.= '"'.$srow3q['nombre_comuna'].'",';
$iajys.= $srow3q['id_comuna'].',';
$ajys.= $srow3q['id_region'].',';
}
$sajys = substr($sajys,0,(strlen($sajys)-1));
$iajys = substr($iajys,0,(strlen($iajys)-1));
$ajys = substr($ajys,0,(strlen($ajys)-1));
?>


function act_categoria (parent_select, curr_id) {
categoria = new Array(4);
categoria[0] = new Array (<?php echo $iajys?>); 
categoria[1] = new Array (<?php echo $sajys?>);
categoria[2] = new Array (<?php echo $ajys?>);

// Sincronización dinámica de areas y subareas

var current_parent_id = parent_select.options[parent_select.selectedIndex].value; // id para filtrar
var currSelect = document.form1["subcategoria"];

currSelect.length = 0;
var myOption = new Option("[Seleccione Comuna]", "", true, true);
currSelect.options[currSelect.length] = myOption;

var CurrItem = 1;
for (var i=0; i < categoria[0].length; i++) {
	if (categoria[2][i] == current_parent_id) {
		var myOption = new Option(categoria[1][i], categoria[0][i]);
		currSelect.options[CurrItem++] = myOption;
	}
}

currSelect.selectedIndex = 0;

if (! isNaN(curr_id)) {
	for (var i=0; i < currSelect.length; i++) {
		if (currSelect.options[i].value == curr_id)  {
			currSelect.selectedIndex = i;
		}
	}
}

}

//-->//-->
</script>
<script src="../libreriajs/libreria.js"></script>
<META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
 <link href="assets/css/jquery-ui.css" rel="stylesheet" />
<link rel="stylesheet" href="assets/plugins/uniform/themes/default/css/uniform.default.css" />
<link rel="stylesheet" href="assets/plugins/inputlimiter/jquery.inputlimiter.1.0.css" />
<link rel="stylesheet" href="assets/plugins/chosen/chosen.min.css" />
<link rel="stylesheet" href="assets/plugins/colorpicker/css/colorpicker.css" />
<link rel="stylesheet" href="assets/plugins/tagsinput/jquery.tagsinput.css" />
<link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker-bs3.css" />
<link rel="stylesheet" href="assets/plugins/datepicker/css/datepicker.css" />
<link rel="stylesheet" href="assets/plugins/timepicker/css/bootstrap-timepicker.min.css" />
<link rel="stylesheet" href="assets/plugins/switch/static/stylesheets/bootstrap-switch.css" />

<div id="content">

<table class="table" width="80%">
  
  <tr> 
    <td align="center" valign="top">
		<table >
        <tr> 
          <td align="left" valign="top" width="90%"> 
            <?if ($sw==0) {?>
            <div align="center"> 
              <?php if ($_GET['opc']=='E') {?>
              <form name="form1" enctype="multipart/form-data" method="post" action="<?= $_SERVER['PHP_SELF'];?>?opc=E&sec=<?php echo $_GET['sec'];?>" >
                <?php } else {?>
              </form>
              <form name="form1" enctype="multipart/form-data" method="post" action="<?= $_SERVER['PHP_SELF'];?>" onSubmit="javascript:return v_1()">
                <?php } ?>
				
          <div class="panel panel-primary"> 
                  <div class="panel-heading">
				 
                    <div align="left">Administraci&oacute;n de Listado - Registros</div>
                  </div>
            <div class="panel-body"> 
                       
                    <table border="1" cellpadding="0" cellspacing="5" bordercolor="#CCCCCC">
                      <tr > 
                        <td colspan="4" align="left" valign="middle" bgcolor="#DDDDFF">&nbsp;<strong><font size="3">Numero Cliente <?php echo $RS2['id_cliente'];?></font></strong></td>
                      </tr>
                      <tr > 
                        <td width="112" align="right" bgcolor="#DDDDFF">Nombre: </td>
                        <td width="327" align="left" valign="middle" bgcolor="#DDDDFF"> 
                          <input name="c_nombre" id="c_nombre" required="required" type="text" value="<?php if (isset($RS2)) { echo $RS2['nombre']; } ?>" class="form-control"/> 
                        </td>
                        <td  align="right" valign="middle" bgcolor="#DDDDFF"> 
                          <font size="2">&nbsp; </font>Apellidos:</td>
                        <td width="339"  align="right" valign="middle" bgcolor="#DDDDFF"><input name="c_apellidos" id="c_apellidos" required="required" type="text" value="<?php if (isset($RS2)) { echo $RS2['apellidos']; } ?>" class="form-control"/>
                          </td>
                      </tr>
                      <tr > 
                        <td width="112" align="right" bgcolor="#DDDDFF">Rut:</td>
                        <td width="327" align="left" valign="middle" bgcolor="#DDDDFF"> 
                          <input name="c_rut" id="c_rut" required="required" type="text" value="<?php if (isset($RS2)) { echo $RS2['rut']; } ?>" class="form-control"/> 
                        </td>
                        <td  align="right" valign="middle" bgcolor="#DDDDFF"> 
                          <font size="2">&nbsp; </font>Email:</td>
                        <td width="339"  align="right" valign="middle" bgcolor="#DDDDFF"><font size="2"> 
                          <input name="c_email" id="c_email" required="required" type="text" value="<?php if (isset($RS2)) { echo $RS2['email']; } ?>" class="form-control"/>
                          </font></td>
                      </tr>
                      <tr > 
                        <td width="112" align="right" bgcolor="#DDDDFF">Telefono:</td>
                        <td width="327" align="left" valign="middle" bgcolor="#DDDDFF"> 
                          <input name="c_telefono" id="c_telefono" required="required" type="text" value="<?php if (isset($RS2)) { echo $RS2['telefono']; } ?>" class="form-control"/> 
                        </td>
                        <td  align="right" valign="middle" bgcolor="#DDDDFF"> 
                          <font size="2">&nbsp; </font>Direcci&oacute;n:</td>
                        <td width="339"  align="right" valign="middle" bgcolor="#DDDDFF"><font size="2"> 
                          <input name="c_direccion" id="c_direccion" required="required" type="text" value="<?php if (isset($RS2)) { echo $RS2['direccion']; } ?>" class="form-control"/>
                         </font></td>
                      </tr>
					  <tr > 
                        <td width="112" align="right" bgcolor="#DDDDFF">Region:</td>
                        <td width="327" align="left" valign="middle" bgcolor="#DDDDFF"> 
                      <select name="categoria"  class="form-control"  id="id_comuna_scl" title="Ingresa Comuna" onchange="act_categoria(this);">
<option value="">Seleccione Region</option>
<?php mysqli_query($connection ,"SET NAMES 'utf8'"); $result4 = "select * from region where id_region<>0";
	$arr_vend = mysqli_query($connection, $result4) or die('Error en llamada 483');
	while ($Rs2 = mysqli_fetch_assoc($arr_vend)) { ?>
	
							<option value="<?php echo $Rs2['id_region'] ?>"  <?php if ($RS2['id_region'] == $Rs2['id_region']) { echo "selected"; };?> ><?php	echo $Rs2['nombre_region']; ?>	</option>
							<?php }; ?>
</select>
					    </td>
                        <td  align="right" valign="middle" bgcolor="#DDDDFF"> 
                          <font size="2">&nbsp; </font>Comuna:</td>
                        <td width="339"  align="right" valign="middle" bgcolor="#DDDDFF"><font size="2"> 
						  <select name="subcategoria" class="form-control" title="Comuna" id="subcategoria" >
						<option value=''></option>
						<?php if (isset($RS2['id_comuna'])){ 
					$result8 = "select * from comunas where id_region='".$RS2['id_region']."'";
					
	$arr_vend = mysqli_query($connection, $result8) or die('Error en llamada 483');
	while ($Rs4 = mysqli_fetch_assoc($arr_vend)) { ?>
                            <option value="<?php echo $Rs4['id_comuna'];?>" <?php if ($Rs4['id_comuna']==$RS2['id_comuna']) {echo "selected";}?>> 
                            <?php echo $Rs4['nombre_comuna']; ?> </option>
                            <? 
				}}?>
						 </select>
						 </font></td>
                      </tr>
                      <tr > 
                        <td width="112" align="right" bgcolor="#DDDDFF">PromoCode:</td>
                        <td width="327" align="left" valign="middle" bgcolor="#DDDDFF">
<input name="c_promoap" id="c_promoap" required="required" type="text" value="<?php if (isset($RS2)) { echo $RS2['promoap']; } ?>" class="form-control"/>
                                                </td>
                        <td colspan="2"  align="left" valign="middle" bgcolor="#DDDDFF"> 
                          &nbsp;&nbsp;&nbsp;&nbsp;<font size="3">Fecha de Registro:</font><strong style=" background-color:#FFF; padding:5px; border: 1px #CCCCCC solid;"><font size="2">&nbsp;<?php echo $RS2['fecharegistro'];?></font></strong></td>
                      </tr>
                      <tr > 
                        <td colspan="4" align="right" valign="middle" bgcolor="#DDDDFF"> 
 
                        </td>
                      </tr>
                    </table>

<?php include("boton_permiso.php");?>
          </div>
                  <font face="Arial, Helvetica, sans-serif">
                  <?php if ($QNUM>0) {?>
  
                  </font> <font face="Arial, Helvetica, sans-serif"> </font>              </div>
              </form>
             
             
              <? } ?>
            </div></td>
        </tr>
        <tr> 
          <td width="90%" align="right"> 
            <? } else {
include('acceso_denegado.php'); 
				exit();
			}?>
              </td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
$q_ru = "SELECT GARUSU.fecharegistro, GARUSU.tipo, GARUSU.id_usuario, GARUSU.promoap, GARUSU.id_cliente, GARUSU.email, GARUSU.nombre, GARUSU.apellidos,	GARUSU.rut, GARUSU.telefono, GARUSU.direccion, REGION.nombre_region, COMUNA.nombre_comuna 
FROM gar_usuarios GARUSU
LEFT JOIN region REGION ON GARUSU.id_region = REGION.id_region
LEFT JOIN comunas COMUNA ON GARUSU.id_comuna = COMUNA.id_comuna
WHERE GARUSU.tipo='PERSONA'
ORDER BY GARUSU.fecharegistro DESC
";
$arr_ru = mysqli_query($connection, $q_ru) or die('Error en llamada 37r');
//$n_ru = mysqli_num_rows($arr_ru);
		  				  				   
?>
<table width="80%" align="center"><tr><td>

<div class="row"> 
         
            <div class="panel panel-default"> 
              
<div class="panel-heading"> 
            <h4 ><a href="excel_registros.php?excel=1"><img src="../wimages/xls.gif" width="16" height="16" border=0> 
              <font size="2">Exportar listado a excel</font></a></h4>
</div>
              
		   <table width="100%" cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-condensed table-hover" >
            <thead>
              <tr bgcolor="#C1E0FF"> 
                <th width="20" height="39"><font size="2">ID</font></th>
				 <th width="75"><font size="2">N&uacute;mero Cliente</font></th>
				  <th width="75"><font size="2">TIPO</font></th>
			    <th width="118">PromoCode</th>
				 <th width="118"><font size="2">Fecha Reg.</font></th>
                <th width="100"><font size="2"> Nombre-Apellido</font></th>
                <th width="78"><font size="2"> Rut</font></th>
                <th width="64"><font size="2"> Email</font></th>
                <th width="71"><font size="2"> Fono</font></th>
                <th width="59"><font size="2"> Regi&oacute;n</font></th>
                <th width="80"><font size="2"> Comuna</font></th>
                <th width="172"><font size="2"> </font></th>
              </tr>
            </thead>
            <tbody>
              <?php while ($ROW_CV = mysqli_fetch_assoc($arr_ru)) { ?>
              <tr> 
			   <td> <font size="2"><?php echo $ROW_CV['id_usuario'];?> </font></td>
                <td> <font size="2"><?php echo $ROW_CV['id_cliente'];?> </font></td>
				<td> <font size="2"><?php echo $ROW_CV['tipo'];?> </font></td>
                <td nowrap><font size="2"><?php echo $ROW_CV['promoap'];?></font></td>
				<td nowrap> <font size="2"><?php echo $ROW_CV['fecharegistro'];?> </font></td>
                <td> <font size="2"><?php echo $ROW_CV['nombre']." ".$ROW_CV['apellidos'];?> 
                  </font></td>
                <td> <font size="2"><?php echo $ROW_CV['rut'];?> </font></td>
                <td> <font size="2"><?php echo $ROW_CV['email'];?> </font></td>
                <td> <font size="2"><?php echo $ROW_CV['telefono'];?> </font></td>
                <td> <font size="2"><?php echo $ROW_CV['nombre_region'];?> </font></td>
                <td> <font size="2"><?php echo $ROW_CV['nombre_comuna'];?> </font></td>
                <td> <a href="<?php echo $_SERVER['PHP_SELF'];?>?sec=<?php echo $ROW_CV['id_usuario'];?>&opc=E"> 
                  <img src="../wimages/edit.gif" alt="Editar" width="18" height="15"  border="0"> 
                  </a> 
                  <?php if (!busca_permiso_eliminar($_SESSION['id_usuario'],$seccion)) { echo " ";}else{ ?>
                  <a href="javascript:elimina(<?php  echo $ROW_CV['id_usuario'];?>)"> 
                  <img src="../wimages/del.gif" width="14" height="14" border="0"> 
                  </a> 
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
            </div>
       
        </div>
		</td></tr></table>
  <?php  include("footer2.php");?>
<script src="assets/js/jquery-ui.min.js"></script>
 
<script src="assets/plugins/uniform/jquery.uniform.min.js"></script>
<script src="assets/plugins/inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script>
<script src="assets/plugins/chosen/chosen.jquery.min.js"></script>
<script src="assets/plugins/colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="assets/plugins/tagsinput/jquery.tagsinput.min.js"></script>
<script src="assets/plugins/validVal/js/jquery.validVal.min.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="assets/plugins/daterangepicker/moment.min.js"></script>
<script src="assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="assets/plugins/timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="assets/plugins/switch/static/js/bootstrap-switch.min.js"></script>
<script src="assets/plugins/jquery.dualListbox-1.3/jquery.dualListBox-1.3.min.js"></script>
<script src="assets/plugins/autosize/jquery.autosize.min.js"></script>
<script src="assets/plugins/jasny/js/bootstrap-inputmask.js"></script>
       
<script src="assets/js/formsInit.js"></script>
        
<script>
            $(function () { formInit(); });
        </script>