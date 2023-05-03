<?php
class datos{
	private $con = null;

	public function __construct(){
		$this->fi= '';
		$this->ff= '';
		$this->tabla= DB_PRE."_".'vw_maestra';
	}

	public function traeFiltro($e){
		$nox = "STR_TO_DATE(left(fecha,10), '%d-%m-%Y') between STR_TO_DATE('".BD::Escape($this->fi)."', '%d-%m-%Y') and STR_TO_DATE('".BD::Escape($this->ff)."', '%d-%m-%Y') and estado=".$e;
		$row = BD::Select($this->tabla,"count(distinct codigo) as codigo",$nox,"estado");
		while($r = $row->fetch_object()){
			return $r->codigo;
		}
	}
	public function traeFiltroGuia($e){
		$nox = "STR_TO_DATE(left(fecha,10), '%d-%m-%Y') between STR_TO_DATE('".BD::Escape($this->fi)."', '%d-%m-%Y') and STR_TO_DATE('".BD::Escape($this->ff)."', '%d-%m-%Y') and estadoGuia=".$e;
		$row = BD::Select($this->tabla,"count(distinct guia) as codigo",$nox,"estado");
		while($r = $row->fetch_object()){
			return $r->codigo;
		}
	}
	public function traeFiltroCsv(){
		$nox = "STR_TO_DATE(left(fecha,10), '%d-%m-%Y') between STR_TO_DATE('".BD::Escape($this->fi)."', '%d-%m-%Y') and STR_TO_DATE('".BD::Escape($this->ff)."', '%d-%m-%Y') ";
		return BD::Select($this->tabla,"*",$nox,"estado");
	}
}
?>