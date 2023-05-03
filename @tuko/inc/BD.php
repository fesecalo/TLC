<?php
include("Card.php");
class BD {
	private static $con;
	public static $debug_sql = false;

	public function __construct(){}
	
	private static function Conn(){
		if(!isset(self::$con)){
			self::$con = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (@mysqli_connect_errno()) {
				die("Conexi�n fall�: ".mysqli_connect_errno()." : ". mysqli_connect_error());
			}
			self::$con->set_charset("utf8");
			return self::$con;
		}
	}
	
	private static function closeCon(){
		@mysqli_close(self::$con);
		self::$con= null;
	}
	
	public static function Consulta($sql){
		$con =  self::Conn();
		if(self::$debug_sql){
			print "<pre>".$sql."</pre>";
		}
		
		$query = @mysqli_query($con, $sql);
		if (mysqli_error($con)){
			echo "Error en la base de datos: ".mysqli_error($con);
			//exit;
		}
		self::closeCon();
		return $query;
	}
	
	public static function Escape($d){
		$con =  self::Conn();
		$var = $con->real_escape_string($d);
		self::closeCon();
		return $var;
	}

	public static function Insert($tabla,$columnas,$valores){
		$sql = "insert into ".$tabla." (".$columnas.") values (".$valores.");";
		return BD::Consulta($sql);
	}

	public static function Delete($tabla,$filtro){
		$sql = "delete from ".$tabla." where ".$filtro;
		return BD::Consulta($sql);
	}

	public static function Update($tabla,$valores,$filtro){
		$sql = "update ".$tabla." set ".$valores." where ".$filtro;
		return BD::Consulta($sql);
	}

	public static function Select($tabla,$columnas,$filtro = false,$orden = false,$agrupacion = false,$extras = false){
		$sql = "select ".$columnas." from ".$tabla;
		if($filtro){
			$sql .= " where ".$filtro;
		}
		if($agrupacion){
			$sql .= " group by ".$agrupacion;
		}
		if($orden){
			$sql .= " order by ".$orden;
		}
		if($extras){
			$sql .= " ".$extras;
		}
		return BD::Consulta($sql);
	}
}
?>