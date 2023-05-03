<?php
class datos{
	private $con = null;

	public function __construct(){
        $this->id = "";
		$this->nombre = "";
		$this->mas = "";
		$this->rut = "";
		$this->fecha = "";
		$this->estado = "";
		$this->tabla= DB_PRE."_".'cliente';
		$this->fncTT= 'Cliente';
	}

	public function crear(){
		$QCol="nombre,mas,rut,fecha,estado";
		$QVal = "'".BD::Escape($this->nombre)."',";
		$QVal .= "'".BD::Escape($this->mas)."',";
		$QVal .= "'".BD::Escape($this->rut)."',";
		$QVal .= "'".BD::Escape($this->fecha)."',";
		$QVal .= "'".$this->estado."'";

		if ($this->traeXrut() == false || $this->traeXrut() == $this->id) {
			if (BD::Insert($this->tabla,$QCol,$QVal)){
				$msg = 'Creacion de '.$this->fncTT.' "'.$this->nombre.'" exitosa.';
				$logo = 'ok';
			}else{
				$msg = 'Error al crear '.$this->fncTT.' "'.$this->nombre.'".';
				$logo = 'nok';
			}
		}else{
			$msg = 'Error al crear '.$this->fncTT.' "'.$this->nombre.'", ya existe.';
			$logo = 'nok';
		}
		return array ($msg,$logo);
	}

	public function eliminar(){
		if (BD::Delete($this->tabla,"id=".BD::Escape($this->id))){
			$msg = 'Eliminacion de '.$this->fncTT.' "'.$this->nombre.'" exitosa.';
			$logo = 'ok';
		}else{
			$msg = 'Error al eliminar '.$this->fncTT.' "'.$this->nombre.'".';
			$logo = 'nok';
		}
		return array ($msg,$logo);
	}

	public function editar(){
		$QVal = "nombre='".BD::Escape($this->nombre)."',";
		$QVal .= "mas='".BD::Escape($this->mas)."'";

		if ($this->traeXrut() == false || $this->traeXrut() == $this->id) {
			if (BD::Update($this->tabla,$QVal,"id=".BD::Escape($this->id))){
				$msg = 'Edicion de '.$this->fncTT.' "'.$this->nombre.'" exitosa.';
				$logo = 'ok';
			}else{
				$msg = 'Error al editar '.$this->fncTT.' "'.$this->nombre.'".';
				$logo = 'nok';
			}
		}else{
			$msg = 'Error al editar '.$this->fncTT.' "'.$this->nombre.'", ya existe.';
			$logo = 'nok';
		}
		return array ($msg,$logo);
	}

	public function traeXid(){
		$row = BD::Select($this->tabla,"*","id=".BD::Escape($this->id));
		return $row->fetch_object();
	}
	
	public function traeXrut(){
		$rt= false;
		$row = BD::Select($this->tabla,"*","rut='".BD::Escape($this->rut)."'");
		return ($r = $row->fetch_object())?$r->id:$rt;
	}

	public function traeTodo($b){
		if($b==''){
			return BD::Select($this->tabla,"*",false,"nombre");
		}else{
			return BD::Select($this->tabla,"*","nombre like '%".BD::Escape($b)."%'","nombre");
		}
	}

	public function traeFiltro($b,$ini){
		if($b==''){
			return BD::Select($this->tabla,"*",false,"nombre",false," LIMIT ".$ini.",".NPAG."");
		}else{
			return BD::Select($this->tabla,"*","nombre like '%".BD::Escape($b)."%'","nombre",false," LIMIT ".$ini.",".NPAG."");
		}
	}
}
?>
