<?php
class Accion {
	public static function encriptar($cadena){
		$key='vitorio';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
		$e = base64_encode($cadena);
		return $e; //Devuelve el string encriptado
	}
 
	public static function desencriptar($cadena){
		 $key='vitorio';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
		 $d = base64_decode($cadena);
		return $d;  //Devuelve el string desencriptado	
	}
	
	 public static function activo($v){
		switch ($v) {
			case '1':
				 return '<span class="label label-success">SI</span>';
				break;
			case '0':
				 return '<span class="label label-danger">NO</span>';
				break;
		}  
	}

	public static function estado($v){
		switch ($v) {
			case '1':
				 return '<span class="label label-success">activo</span>';
				break;
			case '0':
				 return '<span class="label label-danger">inactivo</span>';
				break;
			case '2':
				return '<span class="label label-info">c.clave</span>';
			    break;
		}  
	}

	public static function estadoManifiesto($v){
		switch ($v) {
			case '1':
				 return '<span class="label label-danger">En Aduana</span>';
				break;
			case '0':
				 return '<span class="label label-danger">inactivo</span>';
				break;
			case '2':
				return '<span class="label label-info">Cerrado</span>';
			    break;
		}  
	}

	public static function estadoManifiestoCSV($v){
		switch ($v) {
			case '1':
				 return 'En Aduana';
				break;
			case '0':
				 return 'inactivo';
				break;
			case '2':
				return 'Cerrado';
			    break;
		}  
	}

	public static function estadoGuia($v){
		switch ($v) {
			case '0':
				 return '<span class="label label-info">Pendiente</span>';
				break;
			case '1':
				 return '<span class="label label-success">Cerrado Ok</span>';
				break;
			case '2':
				return '<span class="label label-danger">Cerrado No Ok</span>';
			    break;
		}  
	}

	public static function estadoGuiaCSV($v){
		switch ($v) {
			case '0':
				 return 'Pendiente';
				break;
			case '1':
				 return 'Cerrado Ok';
				break;
			case '2':
				return 'Cerrado No Ok';
			    break;
		}  
	}

	public static function miniBox($v,$txt){
		switch ($v) {
			case '0':
				 return '<label class="label label-info"><i class="fa fa-info" ></i></label><sub> '.$txt.'</sub>';
				break;
			case '1':
				return '<label class="label label-danger"><i class="fa fa-times" ></i></label> '.$txt.'';
				break;
			case '2':
				return '<label class="label label-success"><i class="fa fa-check" ></i></label> '.$txt.'';
			    break;
		}  
	}

	public static function traePerfilF($v){
			$sql = "select * from ".DB_PRE."_parametro where tipo='perfil' and id=".$v."";
		return BD::Consulta($sql);
	}
	
	public static function traeOrigenF($v){
		$sql = "select * from ".DB_PRE."_origen where id=".$v."";
	return BD::Consulta($sql);
	}

	public static function traeClienteF($v){
		$sql = "select * from ".DB_PRE."_cliente where id=".$v."";
	return BD::Consulta($sql);
	}

	public static function traeTipoManifiestoF($v){
		return BD::Select(DB_PRE."_parametro","*","tipo='tipoManifiesto' and id=".$v);
	}

	public static function traeTipoGuiaF($v){
		return BD::Select(DB_PRE."_parametro","*","tipo='tipoGuia' and id=".$v);
	}
	
	public static function traeDocumentoF($v){
		return BD::Select(DB_PRE."_parametro","*","tipo='documento' and id=".$v);
	}
	
	public static function perfil($v){
		$row = Accion::traePerfilF($v);
		if($r = $row->fetch_object()){
				return $r->glosa;
		} else{
				return 'N/A';		
		}  
	}

	public static function origen($v){
		$row = Accion::traeOrigenF($v);
		if($r = $row->fetch_object()){
				return $r->nombre;
		} else{
				return 'N/A';		
		}  
	}

	public static function cliente($v){
		$row = Accion::traeClienteF($v);
		if($r = $row->fetch_object()){
				return $r->nombre;
		} else{
				return 'N/A';		
		}  
	}

	public static function tipoManifiesto($v){
		$row = Accion::traeTipoManifiestoF($v);
		if($r = $row->fetch_object()){
				return $r->glosa;
		} else{
				return 'N/A';		
		}  
	}

	public static function tipoGuia($v){
		$row = Accion::traeTipoGuiaF($v);
		if($r = $row->fetch_object()){
				return $r->glosa;
		} else{
				return 'N/A';		
		}  
	}

	public static function tipoDocumento($v){
		$row = Accion::traeDocumentoF($v);
		if($r = $row->fetch_object()){
				return $r->glosa;
		} else{
				return 'N/A';		
		}  
	}

	public static function traeOrigen(){
		return BD::Select(DB_PRE."_origen","*","estado=1","nombre");
	}

	public static function traeCliente(){
		return BD::Select(DB_PRE."_cliente","*","estado=1","nombre");
	}

	public static function traeTipoManifiesto(){
		return BD::Select(DB_PRE."_parametro","*","tipo='tipoManifiesto'");
	}
	
	public static function traeTipoGuia(){
		return BD::Select(DB_PRE."_parametro","*","tipo='tipoGuia'");
	}
	
	public static function traeDocumento(){
		return BD::Select(DB_PRE."_parametro","*","tipo='documento'");
	}
	
	public static function traeRevisado(){
		return BD::Select(DB_PRE."_parametro","*","tipo='revisado'");
	}

	public static function creaUrl($pagina,$opcion,$msg,$logo,$param = false){
		return URL_SITIO.$pagina."/".$pagina.".php?p=".$opcion.$param."&msg=".Accion::encriptar($msg)."&clr=".Accion::encriptar($logo);
	}
}
?>