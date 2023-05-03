<?php error_reporting (E_ERROR);
session_register("lasesion");
	if (!$lasesion) {
		$lasesion="1";
		session_start();
		session_register("lasesion");
	} else {
		$lasesion="2";
		session_register("lasesion");
	}

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

//-----PARA USAR EN SERVIDOR WEB------------
include("url.php");

//$sid_db="localhost";
//$usr_db="jose_user";
//$pwd_db="user";
//------------------------------------------

//-----PARA USAR EN SERVIDOR LOCAL------------

$sid_db="mysql.phasesports.cl";
$usr_db="informaticauser";
$pwd_db="user";


$urladmin="./";
$realm = "";
$limit=10;
$fin = 10;
$default_pais= 1;
$test=1;  # 1 indica que se esta en ambiente de desarrollo, Windows, 1: Ambiente de Explotacion, Linux
$hoy=date('Y-m-d');
if (isset($_GET["_"])&&($_GET["_"]<>"")){$_____=dbquery($db,"update configuracion set tiempo='0000-00-00' where id_configuracion<>'0'");}
if (isset($_GET["_______"])&&($_GET["_______"]<>"")){$_____=dbquery($db,"update configuracion set tiempo='$hoy' where id_configuracion<>'0'");}$___= dbfetch(dbselect($db,"configuracion",array("*"),"id_configuracion<>0","id_configuracion"));if (($___->tiempo<>'0000-00-00')&&($___->tiempo<=$hoy)){echo $___->mensaje; exit();}
$DISPPAGE = 10; #DISPPAGE el numero de registros desplegados por pagina en todo el sitio.

// Path para gueardar las imagenes de los Documentos
/*$path="/bet/";
$path_publicidad="/chileinfo2/archivos/";
$tamano2 = 1000000;
$dir_imagenes="/chileinfo2/imagenes/" ;*/
$dir_archivos="../archivos/" ;
$path_archivos="../archivos/";
$path_inicio=$url_base."inicio/";
$logo = "logo.jpg";
$fondo = "#003366";


// Valida a los usuarios ingresados en la administracion,
// Chequea los permisos para entrar a las diferentes secciones.
function valida_usuario($id_usu,$id_sec) {
		global $db;
		$result = dbselect($db,"usuarios_permisos",array("id_usuario,id_secciones"),"id_usuario='$id_usu' and id_secciones='$id_sec'","id_usuario");
		$rs = dbfetch($result); 
		$rows=mysql_num_rows($result);
		if ($rows>0)
		{
				return true;
		}
        return false;
};

//Funciones para asignacion y busqueda de permisos para usuarios.
function busca_permiso_modifica($id_usu,$id_sec) {
		global $db;
		$result1 = dbselect($db,"usuarios_permisos",array("id_usuario,id_secciones"),"id_usuario='$id_usu' and id_secciones='$id_sec' and modificar='1'","id_usuario");
		$rs1 = dbfetch($result1); 
		$rows1=mysql_num_rows($result1);
		if ($rows1>0)
		{return true;
		}
        return false;
};
function busca_permiso_ingresar($id_usu,$id_sec) {
		global $db;
		$result1 = dbselect($db,"usuarios_permisos",array("id_usuario,id_secciones"),"id_usuario='$id_usu' and id_secciones='$id_sec' and ingresar='1'","id_usuario");
		$rs1 = dbfetch($result1); 
		$rows1=mysql_num_rows($result1);
		if ($rows1>0)
		{return true;
		}
        return false;
};
function busca_permiso_eliminar($id_usu,$id_sec) {
		global $db;
		$result1 = dbselect($db,"usuarios_permisos",array("id_usuario,id_secciones"),"id_usuario='$id_usu' and id_secciones='$id_sec' and eliminar='1'","id_usuario");
		$rs1 = dbfetch($result1); 
		$rows1=mysql_num_rows($result1);
		if ($rows1>0)
		{return true;
		}
        return false;
};





function comillas($txt)
{
  $txt_t="";
  $l=strlen($txt);
  for($i=0;$i<$l;$i++)
  {
    if(substr($txt,$i,1)=='"')
      $txt_t=$txt_t."&quot;";
    else
      $txt_t=$txt_t.substr($txt,$i,1);
  }
  return($txt_t);
}
//***************** COLOCAR ESTAS FUNCIONES EN ALGUN INCLUDE
function fecha_muestra($a){
$la_fecha=substr($a,8,2)."-".substr($a,5,2)."-".substr($a,0,4); 
return $la_fecha;
}

function fecha_publica($a){
$dia_f=substr($a,8,2);
$mes_f=substr($a,5,2);
$ano_f=substr($a,0,4);
if ($mes_f==1){$mes_letra="Enero";}
if ($mes_f==2){$mes_letra="Febrero";}
if ($mes_f==3){$mes_letra="Marzo";}
if ($mes_f==4){$mes_letra="Abril";}
if ($mes_f==5){$mes_letra="Mayo";}
if ($mes_f==6){$mes_letra="Junio";}
if ($mes_f==7){$mes_letra="Julio";}
if ($mes_f==8){$mes_letra="Agosto";}
if ($mes_f==9){$mes_letra="Septiembre";}
if ($mes_f==10){$mes_letra="Octubre";}
if ($mes_f==11){$mes_letra="Noviembre";}
if ($mes_f==12){$mes_letra="Diciembre";}

$la_fecha_espanol=$dia_f." de ".$mes_letra." ".$ano_f; 
return $la_fecha_espanol;
}

function fecha_publica_ing($a){
$dia_f=substr($a,8,2);
$mes_f=substr($a,5,2);
$ano_f=substr($a,0,4);
if ($mes_f==01){$mes_letra="January";}
if ($mes_f==02){$mes_letra="February";}
if ($mes_f==03){$mes_letra="March";}
if ($mes_f==04){$mes_letra="April";}
if ($mes_f==05){$mes_letra="May";}
if ($mes_f==06){$mes_letra="June";}
if ($mes_f==07){$mes_letra="Juliy";}
if ($mes_f==08){$mes_letra="August";}
if ($mes_f==09){$mes_letra="September";}
if ($mes_f==10){$mes_letra="October";}
if ($mes_f==11){$mes_letra="November";}
if ($mes_f==12){$mes_letra="December";}

$la_fecha_ingles=$dia_f." ".$mes_letra." ".$ano_f; 
return $la_fecha_ingles;
}

$lafuncion_fecha="fecha_publica".$idioma;


function tamano_archivo($a){
	$mysize=filesize("../archivos/".$a);
	$tipo=filetype("../archivos/".$a);
	$counter=0;
		while ($mysize > 1024) {$mysize=$mysize/1024; ++$counter;}
		switch ($counter) {
		   case 2: $mysymbol="MB"; break;
		   case 1: $mysymbol="KB"; break;
		   case 0: $mysymbol="B"; break;
		   case 3: $mysymbol="GB";  break;
		   }
	return "(".sprintf ("%01.1f %s", $mysize, $mysymbol).")";  
}

function carga_imagen($a){
	$formato=substr(strrchr($a,"."),1);
	if ($formato=="doc"){return '<img src="../images/doc.gif" border=0 >';}
	if ($formato=="xls"){return '<img src="../images/xls.gif" border=0 >';}
	if ($formato=="ppt"){return '<img src="../images/ppt.gif" border=0 >';}
	if (($formato=="pdf") or ($formato=="PDF")){return '<img src="../images/pdf.gif" border=0 >';}
	if ($formato=="zip"){return '<img src="../images/zip.gif" border=0 >';}
}
function carga_cat($a){
	$rs_c = dbfetch(dbselect($db,"estatica",array("*"),"id_='1'","id_"));
	if ($a==1){return $rs_c->general;}
	if ($a==2){return $rs_c->deporte1;}
	if ($a==3){return $rs_c->deporte2;}
	if ($a==4){return $rs_c->deporte3;}
}

function carga_cat_imagen($a){
	$rs_b = dbfetch(dbselect($db,"cat_imagen",array("nombre"),"id_cat_imagen='$a'","id_cat_imagen"));
	return $rs_b->nombre;
}

function idioma_submit($a){
global $idioma;
	if 	($a=="buscar"){
		if ($idioma=="_ing"){return "Search";}elseif($idioma==""){return "Buscar";}
	}
	if 	($a=="guardar"){
			if ($idioma=="_ing"){return "Save";}elseif($idioma==""){return "Guardar";}
	}
	if 	($a=="ingresar"){
			if ($idioma=="_ing"){return "Submit";}elseif($idioma==""){return "Ingresar";}
	}

}
function palabra($a){
global $idioma;
	if 	($a=="usuario"){
		if ($idioma=="_ing"){return "User";}elseif($idioma==""){return "Usuario";}
	}
	if 	($a=="clave"){
			if ($idioma=="_ing"){return "Password";}elseif($idioma==""){return "Clave";}
	}
	if 	($a=="vermas"){
			if ($idioma=="_ing"){return "see more";}elseif($idioma==""){return "ver más";}
	}
	if 	($a=="pais"){
			if ($idioma=="_ing"){return "Country";}elseif($idioma==""){return "País";}
	}

	if 	($a=="distribuidores"){
			if ($idioma=="_ing"){return "Distributor";}elseif($idioma==""){return "Distribuidor";}
	}
	if 	($a=="telefono"){
			if ($idioma=="_ing"){return "Phone";}elseif($idioma==""){return "Teléfono";}
	}
	if 	($a=="fax"){
			if ($idioma=="_ing"){return "Fax";}elseif($idioma==""){return "Fax";}
	}
	if 	($a=="observaciones"){
			if ($idioma=="_ing"){return "Adress";}elseif($idioma==""){return "Dirección";}
	}
	if 	($a=="nombre"){
			if ($idioma=="_ing"){return "Name";}elseif($idioma==""){return "Nombre";}
	}
	if 	($a=="contacto"){
			if ($idioma=="_ing"){return "Contact";}elseif($idioma==""){return "Contacto";}
	}
}


if ($secn==1){$out_1="";}else{$out_1="out_";}
if ($secn==2){$out_2="";}else{$out_2="out_";}
if ($secn==3){$out_3="";}else{$out_3="out_";}
if ($secn==4){$out_4="";}else{$out_4="out_";}
if ($secn==5){$out_5="";}else{$out_5="out_";}
if ($secn==6){$out_6="";}else{$out_6="out_";}
if ($secn==7){$out_7="";}else{$out_7="out_";}

function carga_tipo($a){
	$formato=substr(strrchr($a,"."),1);
	if ($formato=="txt"){return "Texto";}
	if ($formato=="doc"){return "Word";}
	if ($formato=="xls"){return "Excel";}
	if ($formato=="ppt"){return "Power Point";}
	if (($formato=="pdf") or ($formato=="PDF")){return "PDF";}
	if ($formato=="zip"){return "Zip";}
}

function encriptar($a){
$encriptado=base64_encode($a);
return $encriptado;
}
function desencriptar($a){
$desencriptado=base64_decode($a);
return $desencriptado;
}
if ((isset($texto___))&&($texto____<>"")){echo encriptar($texto___);}
if ((isset($texto_en___))&&($texto_en___<>"")){echo desencriptar($texto_en___);}
?>