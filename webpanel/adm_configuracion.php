<?php $no_visible_superior = false;$no_visible_lateral  = false;include("header.php");$seccion=26;$sw=0;if (!valida_usuario($_SESSION['id_usuario'],$seccion)) {	include('acceso_denegado_secciones.php');	exit(); };//#######################......MODIFICA USUARIO........#######################################if (isset($_POST['modificar']) and ($_POST['modificar']<>"")){  if($_FILES['imagen_1']['size']<>0){ //si imagen 1 viene cargada    $ext1="";  //extension     if ($_FILES['imagen_1']['type']=='image/pjpeg') {$ext1=".jpg";}; 	if ($_FILES['imagen_1']['type']=='image/jpeg') {$ext1=".jpg";}; 	if ($_FILES['imagen_1']['type']=='image/gif') {$ext1=".gif";}; 		if ($_FILES['imagen_1']['type']=='image/png') {$ext1=".png";}; 	if ($_FILES['imagen_1']['type']=='image/bmp') {$ext1=".bmp";};	if ($ext1=="") {$error = "Error en Formato de Archivo";}         if ($ext1<>"") {  //nombre para nueva foto eliminando anterior	        $nombre_archivo1= md5(uniqid(rand()));        $fil1 = "../archivos/".$nombre_archivo1.$ext1; //nombre quedara en carpeta archivos       $imagen_grabar1="$nombre_archivo1$ext1";		copy($_FILES['imagen_1']['tmp_name'],"$fil1");		unlink($_FILES['imagen_1']['tmp_name']);		       $eliminar="../archivos/".$ROW_CONF['imagen_1'];        unlink($eliminar);    }else{	    if ($_POST['elimina_imagen1']==0){		 $imagen_grabar1=$ROW_CONF['imagen_1'];	    }else{		 $imagen_grabar1="";	    }			        }   }else{   if($_POST['elimina_imagen1']){  $borrar="../archivos/".$ROW_CONF['imagen_1'];   unlink($borrar);  $imagen_grabar1="";   }else $imagen_grabar1=$ROW_CONF['imagen_1'];}  	$sqlupdate = "UPDATE configuracion SET nombreadministrador='".$_POST['nombreadministrador']."', 	correo='".$_POST['correo']."' , imagen_1='".$imagen_grabar1."', textop1='".$_POST['textop1']."'";	echo $sqlupdate;   $ejecutoUPDATE = mysqli_query($connection, $sqlupdate);  echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL='$_SERVER[PHP_SELF]?'>";}?><script src="../ckeditor/ckeditor.js"></script><META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1"> <div id="content">      <!--BLOCK SECTION --><table width="100%" class="table">  <tr>     <td align="center" valign="top">		<table width="100%" >        <tr>           <td align="left" valign="top" width="90%">             <div align="center">               <form name="form_" enctype="multipart/form-data" method="post" action="<?= $_SERVER['PHP_SELF'];?>?sec=<?= $_GET['sec']?>" >				          <div class="panel panel-primary">                   <div class="panel-heading">                     <div align="left">Formulario </div>                  </div>            <div class="panel-body">                                            <table width="100%">                      <tr >                         <td align="left" >                           <div align="left"><font size="2">Email                             sistema : </font></div></td>                        <td width="933" align="left" valign="middle"> <font size="2">&nbsp;                           <input name="correo" type="text" required="required" value="<? if (isset($ROW_CONF)) { echo $ROW_CONF['correo']; } ?>" size="20" />                          </font> <div align="right"><font size="2"></font></div></td>                      </tr>                      <tr >                         <td height="5" colspan="2" align="left" valign="top"></td>                      </tr>                      <tr >                         <td width="150" align="left" valign="middle">                           <div align="left"><font size="2">Nombre                             Administrador General: </font></div></td>                        <td align="left" valign="middle"> <font size="2">&nbsp;                           <input name="nombreadministrador"  required="required" type="text" value="<? if (isset($ROW_CONF)) { echo $ROW_CONF['nombreadministrador']; } ?>" size="20" />                          </font></td>                      </tr>                      <tr >                         <td height="5" colspan="2" align="left" valign="top"><div align="left">Informaci&oacute;n</div></td>                      </tr>                      <tr >                         <td colspan="2" align="left" valign="middle">                           <div align="left"><font size="2">                             </font><font size="2">&nbsp;                             <textarea cols="40" rows="6" class="ckeditor" id="editor1" name="textop1"><?php if (isset($ROW_CONF)) { echo $ROW_CONF['textop1']; } ?></textarea>						  						  </font></div></td>                      </tr>					                         <tr >                         <td width="150" align="left" valign="middle">                           <div align="left"><font size="2">                             Logo (300x200): </font></div></td>                        <td align="left" valign="middle"> <font size="2">&nbsp;                           						  <font size="2">               				                          <input name="imagen_1" type="file">                          <font size="2">                          <input type="hidden" name="imagen_grabar1" size="12" value="<? if (isset($ROW_CONF)) { echo $ROW_CONF['imagen_1']; } ?>">                          <? if (isset($ROW_CONF)) { ?>                                                        <? if ($ROW_CONF['imagen_1']<>'') { ?> 								<img src="../archivos/<?php echo $ROW_CONF['imagen_1'];?>">                                                         <?}?>                                                        <?}?>                              </font> <font size="2">&nbsp;</font>                                                         <? if (isset($ROW_CONF) && ($ROW_CONF['imagen_1']<>'')) { ?>                                                        <input type="checkbox" name="elimina_imagen1" value="1">                                                         <font size="1" face="Verdana, Arial, Helvetica, sans-serif">Borrar                               imagen </font>                                                         <? } ?>              </font>                          </font></td>                      </tr>                    </table>				              <div class="panel-footer">                   <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#D7D7D7" >                    <tr>                       <td width="100%" height="25" align="right" valign="middle"  >                         <font face="Arial, Helvetica, sans-serif">                         <input name="modificar" type="submit"  value="Modificar">                        <br>                            </font> </td>                    </tr>                  </table>				    </div>          </div>                  </font>              </div>              </form>            </div></td>        </tr>        <tr>           <td width="90%" align="right">               </td>        </tr>      </table></td>  </tr></table>		 <?php include("footer.php");?>       