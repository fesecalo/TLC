<?
include_once("../lib/url.php");
include_once("../lib/db.php");
if ($_REQUEST['test']==1) {
	//session_register("id_usuario");
$_SESSION['id_usuario'] = $id_usuario;
} else {
	$id_usuario=1;
}	


function permisos($p,$u) {
// Verfica los permisos del usuario conectado, para el despliegue del menu.
global $db;
$result2 = dbselect($db,"usuarios_permisos",array("*"),"id_usuario='$u'","id_secciones"); 

while($arrayofcountries = dbfetch($result2)) 
	{
		if ($arrayofcountries->id_secciones==$p)
		{
			return 1;
		}
	}
return 0;	
}

$result = dbselect2($db,"secciones",array("*")); 
$str="";
$largo="";
$a=0;
while ($Rs2=dbfetch($result)) {
		if (permisos($Rs2->id_seccion,$_SESSION['id_usuario'])==1) {
			$a=$a+1;
			//if ($a==1){$menu="<li>MENU: <li>";}else{$menu="";};
			$largo .=$Rs2->descripcion;
			if (strlen($largo)>90){$salto="<table width=100% height=7 border=0>
  <tr>
    <td></td>
  </tr>
</table>"; $largo="";}else{$salto="";}
			$str .= $salto ."<li><a href=javascript:jumpto('" . $Rs2->directorio . "') class='cofyd_titulo_azul'>" . $Rs2->descripcion . "</a><li>";
		}
}

?>

<!--[if IE]>
<style type="text/css">
p.iepara{ /*Conditional CSS- For IE (inc IE7), create 1em spacing between menu and paragraph that follows*/
padding-top: 1em;
}
</style>
<![endif]-->

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<link rel="stylesheet" type="text/css" href="../lib/webpanel.css">
<style type="text/css">
<!--
.style1 {color: #003366}
-->
</style>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="halfmoon"  >
  <tr valign="middle"> 
    <td colspan="6" align="right" valign="top" > 
      <div> 
        <ul>
          <li> <a href="<?= $_SERVER['PHP_SELF'];?>" class="halfmoon">Test</a> 
            <? echo $str;?> <a href="../tags/tags.php" target="popup" class="halfmoon2" onClick="window.open(this.href, this.target,'width=550,height=400,left=300,top=300,scrollbars',''); return false;">Tags</a> 
            <a href="../webpanel/manual_editor.php" target="popup" class="halfmoon2" onClick="window.open(this.href, this.target,'width=650,height=600,left=300,top=300,scrollbars',''); return false;">HTML 
            Editor</a> <a href="logout.php" class="halfmoon2 style1"><font color="#FF6600">Salir</font></a
			> 
        </ul>
        </span></li></ul></div></td>
  </tr>
</table>
