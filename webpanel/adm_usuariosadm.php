<?php $no_visible_superior = false;$no_visible_lateral  = false;include("header2.php");$seccion=1;$sw=0;$rs_sec = dbfetch(dbselect($db,"configuracion",array("*"),"id_configuracion='1'","id_configuracion"));//#######################......MODIFICA USUARIO........#######################################if (isset($_POST['modificar']) and ($_POST['modificar']<>"")){	$rs_uusuario = dbfetch(dbselect($db,"rfi_usuarios",array("*"),"IdUsuarios='".$_GET['sec']."'","IdUsuarios"));	$sec_persona=$rs_uusuario->idPersona;		$resp=dbselect($db,"rfi_usuarios",array("*"),"NombreUsuario='".$_POST['c_usuario']."' and IdUsuarios<>'".$_GET['sec']."'","NombreUsuario");	$QNUM = mysqli_num_rows($resp);	if($QNUM<>0)  		 { 	       			  			 			  echo "<script languaje='javascript'>";			  echo"alert('NombreUsuario : ".$_POST['c_usuario']." ya existe. Vuelva a ingresar usuario nuevamente');";			  echo "window.location.href = 'adm_usuariosadm.php'";			  echo "</script>";				  exit();		  				    }//modifico datos de usuario	$camposu = array("NombreUsuario","ClaveUsuario","Estado","IdTipoUsuario","id_tipousuario");	$valoresu = array("'".$_POST['c_usuario']."'","'".$_POST['c_contrasena']."'","'".$_POST['c_estado']."'","'1'","'".$_POST['c_tipousuario']."'");			   	dbupdate($db, "rfi_usuarios", $camposu, $valoresu,array("IdUsuarios"),array("'".$_GET['sec']."'"));	chequearerror();//modifico los campos de persona	$camposp = array("RutPersona","Nombres","Apellidos","cargopersona","eMail","UsuarioModifico","FechaModificacion");	$valoresp = array("'".$_POST['c_rut']."'","'".$_POST['c_nombres']."'","'".$_POST['c_apellido']."'","'".$_POST['c_cargo']."'","'".$_POST['c_email']."'","'".$_SESSION['id_usuario']."'","'$fechadehoy'");			   	dbupdate($db, "rfi_personas", $camposp, $valoresp,array("idPersona"),array("'$sec_persona'"));	chequearerror();//no modifico los otros campos de relacion usuario persona}//##############################FIN MODIFICCA##################################//#######################......INGRESA ........#######################################if (isset($_POST['ingresar']) and ($_POST['ingresar']<>"")){//Registro a la persona$resp=dbselect($db,"rfi_usuarios",array("*"),"NombreUsuario='".$_POST['c_usuario']."'","NombreUsuario");$QNUM = mysqli_num_rows($resp);if($QNUM<>0)  		 { 	       			  			 			  echo "<script languaje='javascript'>";			  echo"alert('NombreUsuario : ".$_POST['c_usuario']." ya existe. Vuelva a ingresar usuario nuevamente');";			  echo "window.location.href = 'adm_usuariosadm.php'";			  echo "</script>";				  exit();		  				     }	$camposp = array("RutPersona","Nombres","Apellidos","cargopersona","eMail","UsuarioCreo","UsuarioModifico","FecheCreacion","FechaModificacion");	$valoresp = array("'".$_POST['c_rut']."'","'".$_POST['c_nombres']."'","'".$_POST['c_apellido']."'","'".$_POST['c_cargo']."'","'".$_POST['c_email']."'","'".$_SESSION['id_usuario']."'","'".$_SESSION['id_usuario']."'","'$fechadehoy'","'$fechadehoy'");			   	dbinsert($db,"rfi_personas", $camposp,$valoresp);	$identificadorpersona = mysql_insert_id();	chequearerror();		//Registro al usuario	$camposu = array("idPersona","NombreUsuario","ClaveUsuario","Estado","IdTipoUsuario","id_tipousuario");	$valoresu = array("'$identificadorpersona'","'".$_POST['c_usuario']."'","'".$_POST['c_contrasena']."'","'".$_POST['c_estado']."'","'1'","'".$_POST['c_tipousuario']."'");			   	dbinsert($db,"rfi_usuarios", $camposu,$valoresu);	$identificadorusuario = mysql_insert_id();	chequearerror();}//##############################################################################//#######################......ELIMINA USUARIO........#######################################if (isset($_GET['elimina']) and ($_GET['elimina']<>"")){	dbdelete($db, "rfi_usuarios",array("IdUsuarios"),array("'".$_GET['sec']."'"));		chequearerror();	dbdelete($db, "rfi_personas",array("idPersona"),array("'".$_GET['secpersona']."'"));		chequearerror();unset($elimina);}//#################################FINELIMINA###############################if ($_GET['opc']=='E') {	$rs2 = dbfetch(dbselect($db,"rfi_usuarios",array("*"),"IdUsuarios='".$_GET['sec']."'","IdUsuarios"));	$rs2p = dbfetch(dbselect($db,"rfi_personas",array("*"),"idPersona='".$rs2->idPersona."'","idPersona"));}?><script language="JavaScript" type="text/JavaScript">function elimina(idpersona,idusuario){	   if (confirm("Desea eliminar?")) 	  {		window.location.href="adm_usuariosadm.php?secpersona="+idpersona+"&sec="+idusuario+"&elimina=eliminar";	    return true;	      }  }</script><META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1"> <div id="content"><table class="table">    <tr>     <td align="center" valign="top">		<table >        <tr>           <td align="left" valign="top" width="90%">             <?if ($sw==0) {?>            <div align="center">               <?php if ($_GET['opc']=='E') {?>              <form name="form_" enctype="multipart/form-data" method="post" action="<?= $_SERVER['PHP_SELF'];?>?opc=E&sec=<?php echo $_GET['sec'];?>" >                <?php } else {?>              </form>              <form name="form_" enctype="multipart/form-data" method="post" action="<?= $_SERVER['PHP_SELF'];?>" onSubmit="javascript:return v_1()">                <?php } ?>				          <div class="panel panel-primary">                   <div class="panel-heading">                     <div align="left">Administraci&oacute;n de Usuarios Panel-Barlo </div>                  </div>            <div class="panel-body">                                            <table>                      <tr >                         <td width="250" align="right" valign="middle" bgcolor="#DDDDFF">&nbsp;</td>                        <td width="226" align="left" valign="middle" bgcolor="#DDDDFF">&nbsp;</td>                        <td align="right" valign="middle" bgcolor="#DDDDFF">&nbsp;</td>                        <td align="left" valign="middle" bgcolor="#DDDDFF">&nbsp;</td>                      </tr>                      <tr >                         <td align="right" bgcolor="#DDDDFF">Rut:(12.366.522-k)</td>                        <td width="226" align="left" valign="middle" bgcolor="#DDDDFF">                           <input name="c_rut" id="Rut" type="text" required="required" value="<? if (isset($rs2p)) { echo $rs2p->RutPersona; } ?>"   class="form-control"/>                         </td>                        <td width="163"  align="right" valign="middle" bgcolor="#DDDDFF">                           <div align="right"><font size="2"></font></div></td>                        <td  align="left" valign="middle" bgcolor="#DDDDFF"> <font size="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                           </font></td>                      </tr>                      <tr >                         <td width="250" align="right" valign="middle" bgcolor="#DDDDFF">Nombres:</td>                        <td width="226" align="left" valign="middle" bgcolor="#DDDDFF">                           <input name="c_nombres" id="Apellido_Materno" required="required" type="text" value="<? if (isset($rs2p)) { echo $rs2p->Nombres; } ?>" class="form-control"/>                         </td>                        <td  align="right" valign="middle" bgcolor="#DDDDFF">Cargo</td>                        <td align="left" valign="middle" bgcolor="#DDDDFF"> <input name="c_cargo"  id="c_cargo" type="text" required="required" value="<? if (isset($rs2p)) { echo $rs2p->cargopersona; } ?>"  class="form-control" /> </font>                         </td>                      </tr>                      <tr >                         <td width="250" align="right" valign="middle" bgcolor="#DDDDFF">                           Apellidos:</td>                        <td width="226" align="left" valign="middle" bgcolor="#DDDDFF">                           <input name="c_apellido" type="text" required="required" value="<? if (isset($rs2p)) { echo $rs2p->Apellidos; } ?>" id="c_apellidom"  class="form-control"/>                         </td>                        <td align="right" valign="middle" bgcolor="#DDDDFF">Email:                         </td>                        <td align="left" valign="middle" bgcolor="#DDDDFF"> <input name="c_email"  id="Email"type="text" required="required" value="<? if (isset($rs2p)) { echo $rs2p->eMail; } ?>"  class="form-control" /> </font>                         </td>                      </tr>                      <tr >                         <td width="250" align="right" valign="middle" bgcolor="#DDDDFF">&nbsp;</td>                        <td width="226" align="left" valign="middle" bgcolor="#DDDDFF">&nbsp;</td>                        <td align="right" valign="middle" bgcolor="#DDDDFF">&nbsp;</td>                        <td align="left" valign="middle" bgcolor="#DDDDFF">&nbsp;</td>                      </tr>                      <tr >                         <td colspan="4" align="center" valign="top"> <div align="left">                             Datos Usuario </div></td>                      </tr>					                         <tr bgcolor="FFFFCC" >                         <td width="250" align="right" valign="middle">&nbsp;</td>                        <td width="226" align="left" valign="middle">&nbsp;</td>                        <td align="right" valign="middle">&nbsp;</td>                        <td align="left" valign="middle">&nbsp;</td>                      </tr>                      <tr >                         <td width="250" align="right" valign="middle" bgcolor="#FFFFCC">Usuario</td>                        <td width="226" align="left" valign="middle" bgcolor="#FFFFCC">                           <input name="c_usuario" id="usuario" required="required" type="text" value="<? if (isset($rs2)) { echo $rs2->NombreUsuario; } ?>" class="form-control" />                         </td>                        <td align="right" valign="middle" bgcolor="#FFFFCC">Estado:</td>                        <td width="319" align="left" valign="middle" bgcolor="#FFFFCC">                           <select name="c_estado"  class="form-control">                            <option value="1" <?php if (isset($rs2)) {if ($rs2->Estado==1) {echo "selected";}}?>>Habilitado                             <option value="2" <?php if (isset($rs2)) {if ($rs2->Estado==0) {echo "selected";}}?>>Deshabilitado                             </option>                          </select> </td>                      </tr>                      <tr >                         <td width="250" align="right" valign="middle" bgcolor="#FFFFCC">Password</td>                        <td width="226" align="left" valign="middle" bgcolor="#FFFFCC">                           <input name="c_contrasena" id="password" required="required" type="password"  class="form-control" value="<? if (isset($rs2)) { echo $rs2->ClaveUsuario; } ?>"  /> </font>                         </td>                        <td align="right" valign="middle" bgcolor="#FFFFCC">Tipo                           Usuario</td>                        <td  align="left" valign="middle" bgcolor="#FFFFCC"> <select name="c_tipousuario" required="required" class="form-control">                            <option value="">Seleccione Tipo de Usuario</option>                            <option value="1" <?php if (isset($rs2)) {if ($rs2->id_tipousuario==1) {echo "selected";}}?>>Administrador</option>                            <option value="2" <?php if (isset($rs2)) {if ($rs2->id_tipousuario==2) {echo "selected";}}?>>Cotizador</option>							<option value="7" <?php if (isset($rs2)) {if ($rs2->id_tipousuario==7) {echo "selected";}}?>>Vendedor Interno</option>                          </select> </td>                      </tr>					                         <tr bgcolor="FFFFCC" >                         <td width="250" align="right" valign="middle">&nbsp;</td>                        <td width="226" align="left" valign="middle">&nbsp;</td>                        <td align="right" valign="middle">&nbsp;</td>                        <td align="left" valign="middle">&nbsp;</td>                      </tr>                    </table>				              <div class="panel-footer">                   <table width="90%" border="0" cellpadding="0" cellspacing="0"  >                    <tr>                       <td width="100%" height="25" align="right" valign="middle"  >                         <font face="Arial, Helvetica, sans-serif">                         <? if ($_GET['opc']=='E') {?>                        <input name="modificar" type="submit"  class="btn btn-primary btn-sm " value="MODIFICAR">                        <br>                        </font>                         <a   href="<?php echo $_SERVER['PHP_SELF'];?>"  class="linkazul">Ingresar                         <strong>Nuevo </strong> </a>                         <br>                         <?php } else {?>                        <input name="ingresar" type="submit" class="btn btn-primary btn-sm" value="INGRESAR">                         <?php } ?>    						</td>                    </tr>                  </table>				    </div>          </div>                  <font face="Arial, Helvetica, sans-serif">                  <?if ($QNUM>0) {?>                    </font> <font face="Arial, Helvetica, sans-serif"> </font>              </div>              </form>                                        <? } ?>            </div></td>        </tr>        <tr>           <td width="90%" align="right">             <? } else {include('acceso_denegado.php'); 				exit();			}?>  </td>        </tr>      </table></td>  </tr></table><?php $query_parti = "select USUARIO.IdUsuarios , USUARIO.NombreUsuario,USUARIO.Estado, PERSONA.Nombres as nombres, USUARIO.id_tipousuario,PERSONA.Apellidos, PERSONA.RutPersona, PERSONA.eMail, PERSONA.idPersonaFROM rfi_usuarios USUARIO INNER JOIN rfi_personas PERSONA ON USUARIO.idPersona = PERSONA.idPersona where USUARIO.IdTipoUsuario= 1 and USUARIO.IdUsuarios<>1";//echo $query_parti;$parti = mysqli_query($connection, $query_parti) or die ('Error en llamada 147');				  				  				   ?><div class="row">   <div class="col-lg-12">     <div class="panel panel-default">       <div class="panel-heading">         <h4>Listado de Usuarios ADM </h4>      </div>                <table class="table table-striped table-bordered table-hover" id="dataTables-example">        <thead>          <tr bgcolor="#C1E0FF">             <th><font size="2">RUT</font></th>            <th><font size="2">Apellidos Nombres</font></th>            <th><font size="2">Nick-User</font></th>            <th><font size="2">Email</font></th>            <th><font size="2">Estado</font></th>			 <th><font size="2">Tipo Usuario</font></th>            <th><font size="2">Accion</font></th>          </tr>        </thead>        <tbody>          <?php while($socip = dbfetch($parti)) { ?>          <tr>             <td> <font size="2">               <?= $socip->RutPersona;?>              </font></td>            <td> <font size="2">               <?php echo $socip->nombres." ".$socip->Apellidos;?>              </font></td>            <td> <font size="2">               <?= $socip->NombreUsuario;?>              </font></td>            <td> <font size="2">               <?= $socip->eMail;?>              </font></td>            <td > <font size="2"> 			   <?php if ($socip->Estado == 1) {echo "<span class='label label-success'>Activo</span>";}else{echo "<span class='label label-warning'>Inactivo</span>";};?> 			   			  			                 </font></td>			  <td>			  <font size="2"> 			   <?php if ($socip->id_tipousuario == 1) {echo "<span class='label label-primary'>Administrador</span>";};			   		 if ($socip->id_tipousuario == 2) {echo "<span class='label label-default'>Cotizador</span>";};					 if ($socip->id_tipousuario == 7) {echo "<span class='label label-info'>Vendedor Interno</span>";};?>               </font>			  </td>				<td class="center"><font size="2">				<a href="<?php echo  $_SERVER['PHP_SELF'];?>?sec=<?=  $socip->IdUsuarios;?>&opc=E"><img src="../wimages/edit.gif" alt="Editar" width="18" height="15"  border="0"></a> 				  <!--a href="javascript:elimina(<?= $socip->idepersona;?>,<?= $socip->ideusuario;?>)" class="cofyd_texto_normal_link" > 				  <img src="../wimages/del.gif" width="14" height="14" border="0"> 				  </a--> 			 				  </font></td>			  </tr>			  <? } ?>        </tbody>      </table>    </div>  </div>      </div>		 <?php  include("footer2.php");?>       