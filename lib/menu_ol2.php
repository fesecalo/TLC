<?
include_once("../lib/url.php");
include_once("../lib/db.php");
if ($test==1) {
	session_register("id_usuario");
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
 <?php 
 function muestra_url($a=null){
 $url1 = $_SERVER['REQUEST_URI'];
 $invertida=strrev($url1);
 $mi_cadena = $invertida;
 $caracter   = '/';
 $posicion = strpos($mi_cadena, $caracter);
 $a_url=substr($invertida,0,$posicion);
 $archivo_def=strrev($a_url);
 //echo $archivo_def;
 $invertida2=$archivo_def;
 $mi_cadena2 = $invertida2;
 $caracter2   = 'php';
 $posicion2 = strpos($mi_cadena2, $caracter2);
 $a_url2=substr($invertida2,0,$posicion2+3);
 $archivo_def2=$a_url2;
 return $archivo_def2;
};
$laurl2=muestra_url();?>
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

<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="halfmoon"  >
  <tr valign="middle"> 
    <td height="100" colspan="6" align="right" valign="top"  width="290"> 
      <div id="menu9">
		<ul>
			<li ><a href="<?= $_SERVER['PHP_SELF'];?>" >Test</a>
			<? echo $str;?>
			<a href="#" class="halfmoon" onClick="MM_openBrWindow('../tags/tags.php','','scrollbars=yes,width=520,height=500')">Tags</a>
			<em><a href="#" class="halfmoon" onClick="MM_openBrWindow('../webpanel/manual_editor.php','','scrollbars=yes,width=520,height=500')">Editor</a></em>
          <a href="logout.php" class="halfmoon2 style1"><font color="#FF0000"><strong>Salir</strong></font></a> 
          </li>
		</ul>
</div>	
	</td>
  </tr>
</table>
