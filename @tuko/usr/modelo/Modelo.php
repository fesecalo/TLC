<?php
class datos{
	private $con = null;

	public function __construct(){
        $this->id = "";
		$this->nombre = "";
		$this->clave = "";
		$this->tipo = "";
		$this->fecha = "";
		$this->tabla= DB_PRE."_".'usuario';
		$this->fncTT= 'Usuario';
	}

	public function crear(){
		$QCol="nombre,usuario,clave,tipo,estado,fecha";
		$QVal = "'".BD::Escape($this->nombre)."',";
		$QVal .= "'".BD::Escape($this->usuario)."',";
		$QVal .= "'".BD::Escape($this->clave)."',";
		$QVal .= "'".BD::Escape($this->tipo)."',";
		$QVal .= "".BD::Escape($this->estado).",";
		$QVal .= "'".$this->fecha."'";

		if ($this->traeXusuario() == false || $this->traeXusuario() == $this->id) {
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
		$QVal .= "usuario='".BD::Escape($this->usuario)."',";
		$QVal .= "tipo='".BD::Escape($this->tipo)."'";

		if ($this->traeXusuario() == false || $this->traeXusuario() == $this->id) {
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

	public function editarPass($ca,$car,$usuario){
		$QVal = "clave='".crypt(BD::Escape($ca),$usuario)."', estado=".$this->estado;

		if ($this->traeXusuario() == false || $this->traeXusuario() == $this->id) {
			if (BD::Update($this->tabla,$QVal,"id=".BD::Escape($this->id))){
				session_start();
				$_SESSION['VyS']=$this->estado;
				$msg = 'Contraseña de '.$this->fncTT.' "'.$this->nombre.'" exitosa.';
				$logo = 'ok';
			}else{
				$msg = 'Error al editar Contraseña '.$this->fncTT.' "'.$this->nombre.'".';
				$logo = 'nok';
			}
		}else{
			$msg = 'Error al editar Contraseña '.$this->fncTT.' "'.$this->nombre.'", ya existe.';
			$logo = 'nok';
		}
		return array ($msg,$logo);
	}

	public function traeXid(){
		$row = BD::Select($this->tabla,"*","id=".BD::Escape($this->id));
		return $row->fetch_object();
	}
	
	public function traeXusuario(){
		$rt= false;
		$row = BD::Select($this->tabla,"*","usuario='".BD::Escape($this->usuario)."'");
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
