<?php $no_visible_superior = false;$no_visible_lateral  = false;include("header.php");$seccion=43;$sw=0;if (!valida_usuario($_SESSION['id_usuario'],$seccion)) {	include('acceso_denegado_secciones.php');	exit(); };?><script language="JavaScript" type="text/JavaScript">function MM_openBrWindow(theURL,winName,features) { //v2.0  window.open(theURL,winName,features);}</script><script src="../libreriajs/libreria.js"></script><META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1"> <link href="assets/css/jquery-ui.css" rel="stylesheet" /><link rel="stylesheet" href="assets/plugins/uniform/themes/default/css/uniform.default.css" /><link rel="stylesheet" href="assets/plugins/inputlimiter/jquery.inputlimiter.1.0.css" /><link rel="stylesheet" href="assets/plugins/chosen/chosen.min.css" /><link rel="stylesheet" href="assets/plugins/colorpicker/css/colorpicker.css" /><link rel="stylesheet" href="assets/plugins/tagsinput/jquery.tagsinput.css" /><link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker-bs3.css" /><link rel="stylesheet" href="assets/plugins/datepicker/css/datepicker.css" /><link rel="stylesheet" href="assets/plugins/timepicker/css/bootstrap-timepicker.min.css" /><link rel="stylesheet" href="assets/plugins/switch/static/stylesheets/bootstrap-switch.css" /><div id="content"><table class="table" width="80%">    <tr>     <td align="center" valign="top">		<table >        <tr>           <td align="left" valign="top" width="90%">            </td>        </tr>        <tr>           <td width="90%" align="right">                          </td>        </tr>      </table></td>  </tr></table><?php$q_ru = "select * from registro_calculadora order by id_registro desc";$arr_ru = mysqli_query($connection, $q_ru) or die('Error en llamada 37r');//$n_ru = mysql_num_rows($arr_ru);		  				  				   ?><table width="80%" align="center"><tr><td><div class="row">                      <div class="panel panel-default">               <div class="panel-heading">             <h4 >&nbsp;</h4></div>                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">            <thead>              <tr bgcolor="#C1E0FF">                 <th width="62" height="27"><font size="2">id_registro</font></th>                <th width="77"><font size="2">Fecha Reg.</font></th>                <th width="164"><font size="2"> IP publica</font></th>                <th width="140"><font size="2"> Producto</font></th>                <th width="97"><font size="2"> valor</font></th>                <th width="142"><font size="2"> Peso</font></th>                <th width="123"><font size="2"> Tipo Peso</font></th>              </tr>            </thead>            <tbody>              <?php while ($ROW_CV = mysqli_fetch_assoc($arr_ru)) { ?>              <tr>                 <td> <font size="2"><?php echo $ROW_CV['id_registro'];?> </font></td>                <td nowrap> <font size="2"><?php echo $ROW_CV['fechaconsulta'];?>                   </font></td>                <td> <font size="2"><?php echo $ROW_CV['ippublica'];?>                   </font></td>                <td> <font size="2"><?php echo $ROW_CV['producto'];?> </font></td>                <td> <font size="2"><?php echo $ROW_CV['valor'];?> </font></td>                <td> <font size="2"><?php echo $ROW_CV['peso'];?> </font></td>                <td> <font size="2"><?php echo $ROW_CV['tipo_peso'];?> </font></td>              </tr>              <?php } ?>            </tbody>          </table>            </div>               </div>		</td></tr></table>  <?php  include("footer2.php");?>   <script src="assets/js/jquery-ui.min.js"></script> <script src="assets/plugins/uniform/jquery.uniform.min.js"></script><script src="assets/plugins/inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script><script src="assets/plugins/chosen/chosen.jquery.min.js"></script><script src="assets/plugins/colorpicker/js/bootstrap-colorpicker.js"></script><script src="assets/plugins/tagsinput/jquery.tagsinput.min.js"></script><script src="assets/plugins/validVal/js/jquery.validVal.min.js"></script><script src="assets/plugins/daterangepicker/daterangepicker.js"></script><script src="assets/plugins/daterangepicker/moment.min.js"></script><script src="assets/plugins/datepicker/js/bootstrap-datepicker.js"></script><script src="assets/plugins/timepicker/js/bootstrap-timepicker.min.js"></script><script src="assets/plugins/switch/static/js/bootstrap-switch.min.js"></script><script src="assets/plugins/jquery.dualListbox-1.3/jquery.dualListBox-1.3.min.js"></script><script src="assets/plugins/autosize/jquery.autosize.min.js"></script><script src="assets/plugins/jasny/js/bootstrap-inputmask.js"></script>       <script src="assets/js/formsInit.js"></script>        <script>            $(function () { formInit(); });        </script>  