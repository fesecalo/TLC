<?phpinclude_once("../lib/conf.php");session_start();//echo "sesision ".$_SESSION['id_usuario'];function permisos($p,$u) {// Verfica los permisos del usuario conectado, para el despliegue del menu.global $connection;$qr_res2 = "SELECT * from usuarios_permisos WHERE id_usuario='".$u."'";$arr_per = mysqli_query($connection, $qr_res2) or die('Error en llamada 37');while ($ROW_PERMISOS = mysqli_fetch_assoc($arr_per)) {		if ($ROW_PERMISOS['id_secciones']==$p)		{			return 1;		}	}return 0;	}$str="";$largo="";$a=0;$qr_secc = "SELECT * from secciones";$arr_secc = mysqli_query($connection, $qr_secc) or die('Error en llamada 37');while ($ROW_SECCIONES = mysqli_fetch_assoc($arr_secc)) {//echo $ROW_SECCIONES['id_seccion'];		if (permisos($ROW_SECCIONES['id_seccion'],$_SESSION['id_usuario'])==1) {			$a=$a+1;			//if ($a==1){$menu="<li>MENU: <li>";}else{$menu="";};			$largo .=$ROW_SECCIONES['descripcion'];			if (strlen($largo)>90){$salto="<table width=100% height=7 border=0>  <tr>    <td></td>  </tr></table>"; $largo="";}else{$salto="";}			$str .= $salto ."<li class=\" panel ".paginaactiva($ROW_SECCIONES['directorio'])." \" >			<a href='".$ROW_SECCIONES['directorio']."'><i class=\"icon-".$ROW_SECCIONES['iconoboots']."\"></i> " . $ROW_SECCIONES['descripcion'] . "</a><li>";				}}?><META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1"><?php if (!isset($no_visible_lateral) || !$no_visible_lateral) { ?>        <!-- MENU SECTION -->       <div id="left" >			  <ul id="menu">    			<li class="panel <?= paginaactiva("inicio.php");?>"> <a href="inicio.php" > <i class="icon-home"></i>&nbsp;Inicio </a> </li>	<?php echo $str;?> 	    <li> 		 <div align="center"><br><a href="logout.php">      <button class="btn btn-danger  btn-sm">      <i class="icon-off "></i>&nbsp;&nbsp;SALIR DE LA APLICACION      </button></a></div>                      </a> </li>   </ul><br><br><br><br><br><br><br><br><br><br>        </div>        <!--END MENU SECTION --> <? } ?>