<?php
class datos{
	private $con = null;

	public function __construct(){
        $this->id = "";
		$this->codigo = "";
		$this->origen = "";
		$this->tipo = "";
		$this->cantidad = "";
		$this->kilo = "";
		$this->revisado = "";
		$this->observacion = "";
		$this->fecha = "";
		$this->estado = "";
		$this->manifiesto = "";
		$this->cliente = "";
		$this->documento = "";
		$this->neto = "";
		$this->iva = "";
		$this->total = "";
		$this->din = "";
		$this->nroTipo = "";
		$this->totalDin = "";
		$this->tabla= DB_PRE."_".'manifiesto';
		$this->tablaF= DB_PRE."_".'vw_manifiesto';
		$this->tablaG= DB_PRE."_".'guia';
		$this->fncTT= 'Manifiesto';
		$this->fncTTG= 'Guia';
	}

	public function crear(){
		$QCol="codigo,origen,tipo,cantidad,kilo,fecha,estado";
		$QVal = "'".BD::Escape($this->codigo)."',";
		$QVal .= "'".BD::Escape($this->origen)."',";
		$QVal .= "'".BD::Escape($this->tipo)."',";
		$QVal .= "'".BD::Escape($this->cantidad)."',";
		$QVal .= "'".BD::Escape($this->kilo)."',";
		$QVal .= "'".BD::Escape($this->fecha)."',";
		$QVal .= "'".BD::Escape($this->estado)."'";
		if ($this->traeXcodigo() == false || $this->traeXcodigo() == $this->id) {
			if (BD::Insert($this->tabla,$QCol,$QVal)){
				$msg = 'Creacion de '.$this->fncTT.' "'.$this->codigo.'" exitosa.';
				$logo = 'ok';
			}else{
				$msg = 'Error al crear '.$this->fncTT.' "'.$this->codigo.'".';
				$logo = 'nok';
			}
		}else{
			$msg = 'Error al crear '.$this->fncTT.' "'.$this->codigo.'", ya existe.';
			$logo = 'nok';
		}
		return array ($msg,$logo);
	}

	public function crearGuia(){
		$QCol="manifiesto,codigo,cliente,kilo,tipo,nroTipo,neto,iva,total,documento,din,totalDin,estado,observacion,fecha";
		$QVal = "'".BD::Escape($this->manifiesto)."',";
		$QVal .= "'".BD::Escape($this->codigo)."',";
		$QVal .= "'".BD::Escape($this->cliente)."',";
		$QVal .= "'".BD::Escape($this->kilo)."',";
		$QVal .= "'".BD::Escape($this->tipo)."',";
		$QVal .= "'".BD::Escape($this->nroTipo)."',";
		$QVal .= "'".BD::Escape(preg_replace('/[^0-9]/','',$this->neto))."',";
		$QVal .= "'".BD::Escape(preg_replace('/[^0-9]/','',$this->iva))."',";
		$QVal .= "'".BD::Escape(preg_replace('/[^0-9]/','',$this->total))."',";
		$QVal .= "'".BD::Escape($this->documento)."',";
		$QVal .= "'".BD::Escape($this->din)."',";
		$QVal .= "'".BD::Escape(preg_replace('/[^0-9]/','',$this->totalDin))."',";
		$QVal .= "'".BD::Escape($this->estado)."',";
		$QVal .= "'',";
		$QVal .= "'".BD::Escape($this->fecha)."'";
		if ($this->traeXguia() == false || $this->traeXguia() == $this->id) {
			if (BD::Insert($this->tablaG,$QCol,$QVal)){
				$msg = 'Creacion de '.$this->fncTTG.' "'.$this->codigo.'" exitosa.';
				$logo = 'ok';
			}else{
				$msg = 'Error al crear '.$this->fncTTG.' "'.$this->codigo.'".';
				$logo = 'nok';
			}
		}else{
			$msg = 'Error al crear '.$this->fncTTG.' "'.$this->codigo.'", ya existe.';
			$logo = 'nok';
		}
		return array ($msg,$logo);
	}

	public function eliminar(){
		if (BD::Delete($this->tabla,"id=".BD::Escape($this->id))){
			$msg = 'Eliminacion de '.$this->fncTT.' "'.$this->codigo.'" exitosa.';
			$logo = 'ok';
		}else{
			$msg = 'Error al eliminar '.$this->fncTT.' "'.$this->codigo.'".';
			$logo = 'nok';
		}
		return array ($msg,$logo);
	}

	public function eliminarGuia(){
		if (BD::Delete($this->tablaG,"id=".BD::Escape($this->id))){
			$msg = 'Eliminacion de '.$this->fncTTG.' "'.$this->codigo.'" exitosa.';
			$logo = 'ok';
		}else{
			$msg = 'Error al eliminar '.$this->fncTTG.' "'.$this->codigo.'".';
			$logo = 'nok';
		}
		return array ($msg,$logo);
	}

	public function editar(){
		$QVal = "codigo='".BD::Escape($this->codigo)."',";
		$QVal .= "origen='".BD::Escape($this->origen)."',";
		$QVal .= "tipo='".BD::Escape($this->tipo)."',";
		$QVal .= "cantidad='".BD::Escape($this->cantidad)."',";
		$QVal .= "kilo='".BD::Escape($this->kilo)."',";
		$QVal .= "estado='".BD::Escape($this->estado)."'";

		if ($this->traeXcodigo() == false || $this->traeXcodigo() == $this->id) {
			if (BD::Update($this->tabla,$QVal,"id=".BD::Escape($this->id))){
				$msg = 'Edicion de '.$this->fncTT.' "'.$this->codigo.'" exitosa.';
				$logo = 'ok';
			}else{
				$msg = 'Error al editar '.$this->fncTT.' "'.$this->codigo.'".';
				$logo = 'nok';
			}
		}else{
			$msg = 'Error al editar '.$this->fncTT.' "'.$this->codigo.'", ya existe.';
			$logo = 'nok';
		}
		return array ($msg,$logo);
	}

	public function editarGuia(){
		$QVal = "manifiesto='".BD::Escape($this->manifiesto)."',";
		$QVal .= "codigo='".BD::Escape($this->codigo)."',";
		$QVal .= "cliente='".BD::Escape($this->cliente)."',";
		$QVal .= "kilo='".BD::Escape($this->kilo)."',";
		$QVal .= "tipo='".BD::Escape($this->tipo)."',";
		$QVal .= "nroTipo='".BD::Escape($this->nroTipo)."',";
		$QVal .= "neto='".BD::Escape(preg_replace('/[^0-9]/','',$this->neto))."',";
		$QVal .= "iva='".BD::Escape(preg_replace('/[^0-9]/','',$this->iva))."',";
		$QVal .= "total='".BD::Escape(preg_replace('/[^0-9]/','',$this->total))."',";
		$QVal .= "documento='".BD::Escape($this->documento)."',";
		$QVal .= "din='".BD::Escape($this->din)."',";
		$QVal .= "totalDin='".BD::Escape($this->totalDin)."'";

		if ($this->traeXguia() == false || $this->traeXguia() == $this->id) {
			if (BD::Update($this->tablaG,$QVal,"id=".BD::Escape($this->id))){
				$msg = 'Edicion de '.$this->fncTTG.' "'.$this->codigo.'" exitosa.';
				$logo = 'ok';
			}else{
				$msg = 'Error al editar '.$this->fncTTG.' "'.$this->codigo.'".';
				$logo = 'nok';
			}
		}else{
			$msg = 'Error al editar '.$this->fncTTG.' "'.$this->codigo.'", ya existe.';
			$logo = 'nok';
		}
		return array ($msg,$logo);
	}

	public function cerrarGuia(){
		$QVal = "estado='".BD::Escape($this->estado)."',";
		$QVal .= "observacion='".BD::Escape($this->observacion)."'";

		if ($this->traeXguia() == false || $this->traeXguia() == $this->id) {
			if (BD::Update($this->tablaG,$QVal,"id=".BD::Escape($this->id))){
				$this->cierreXguia();
				$msg = 'Cierre de '.$this->fncTTG.' "'.$this->codigo.'" exitosa.';
				$logo = 'ok';
			}else{
				$msg = 'Error al cerrar '.$this->fncTTG.' "'.$this->codigo.'".';
				$logo = 'nok';
			}
		}else{
			$msg = 'Error al cerrar '.$this->fncTTG.' "'.$this->codigo.'", ya existe.';
			$logo = 'nok';
		}
		return array ($msg,$logo);
	}

	public function traeXid(){
		$row = BD::Select($this->tabla,"*","id=".BD::Escape($this->id));
		return $row->fetch_object();
	}

	public function traeXidGuia(){
		$row = BD::Select($this->tablaG,"*","id=".BD::Escape($this->id));
		return $row->fetch_object();
	}
	
	public function traeTodo($e,$o,$b){
		$nox = "1=1";
		if($e!=''){
			$nox .= " and estado in('".BD::Escape($e)."')";
		}
		if($b!=''){
			$nox .= " and ".$o." like '%".BD::Escape($b)."%'";
		}
		if($nox=='1=1'){
			$nox = false;
		}
		return BD::Select($this->tablaF,"id,codigo,origen,estado",$nox,"estado","id,codigo,origen,estado");
	}

	public function traeTodoGuia(){
		return BD::Select($this->tablaG,"*",'manifiesto='.$this->id,"codigo");
	}

	public function traeFiltro($e,$o,$b,$ini){
		$nox = "1=1";
		if($e!=''){
			$nox .= " and estado in('".BD::Escape($e)."')";
		}
		if($b!=''){
			$nox .= " and ".$o." like '%".BD::Escape($b)."%'";
		}
		if($nox=='1=1'){
			$nox = false;
		}
		return BD::Select($this->tablaF,"id,codigo,origen,estado",$nox,"estado","id,codigo,origen,estado"," LIMIT ".$ini.",".NPAG."");
	}

	public function traeXcodigo(){
		$rt= false;
		$row = BD::Select($this->tabla,"*","codigo='".BD::Escape($this->codigo)."'");
		return ($r = $row->fetch_object())?$r->id:$rt;
	}

	public function traeXguia(){
		$rt= false;
		$row = BD::Select($this->tablaG,"*","codigo='".BD::Escape($this->codigo)."'");
		return ($r = $row->fetch_object())?$r->id:$rt;
	}
	public function cierreXguia(){
		$row = BD::Select($this->tablaG,"*","estado=0 and manifiesto=".BD::Escape($this->manifiesto));
		$b = ($r = $row->fetch_object())?'ok':'';
		if($b==''){
			$QVal = "estado=2";
			BD::Update($this->tabla,$QVal,"id=".BD::Escape($this->manifiesto));
			return true;
		}else{
			$QVal = "estado=1";
			BD::Update($this->tabla,$QVal,"id=".BD::Escape($this->manifiesto));
			return false;
		}
	}
}
?>
