<?php
$nox=isset($_GET['p'])?$_GET['p']:$_POST["p"];
switch ($nox) {
case 'Lista':
	$p = new datos();
	$row1 = $p->traeTodo((isset($_POST['e'])?$_POST['e']:$_GET['e']),(isset($_POST['o'])?$_POST['o']:$_GET['o']),(isset($_POST['b'])?$_POST['b']:$_GET['b']));
	$pag = (isset($_REQUEST['pag']) && !empty($_REQUEST['pag']))?$_REQUEST['pag']:1;
	$totalReg = $row1->num_rows;
	$total_paginas = ceil($totalReg / NPAG);
	$inicioPag = ($pag - 1) * NPAG;
	$row = $p->traeFiltro((isset($_POST['e'])?$_POST['e']:$_GET['e']),(isset($_POST['o'])?$_POST['o']:$_GET['o']),(isset($_POST['b'])?$_POST['b']:$_GET['b']),$inicioPag);

	include("vista/Lista_vista.php");
	break;
case 'Nuevo':
	if(isset($_POST["idnv"])){
		$p = new datos();
		$p->codigo = $_POST["codigo"];
		$p->origen = $_POST["origen"];
		$p->tipo = $_POST["tipo"];
		$p->cantidad = $_POST["cantidad"];
		$p->kilo = $_POST["kilo"];
		$p->estado = 1;
		$p->fecha = date("d-m-Y H:i:s");
		$nox =$p->crear();
		echo Accion::creaUrl($pagina,'Lista',$nox[0],$nox[1]);
	}
	if($_GET["id"]){
		$p = new datos();
		include("vista/Nuevo_vista.php");
	}
	break;
case 'Editar':
	if(isset($_POST["ided"])){
		$p = new datos();
		$p->id = $_POST["ided"];
		$p->codigo = $_POST["codigo"];
		$p->origen = $_POST["origen"];
		$p->tipo = $_POST["tipo"];
		$p->cantidad = $_POST["cantidad"];
		$p->kilo = $_POST["kilo"];
		$p->estado = 1;
		$nox =$p->editar();
		echo Accion::creaUrl($pagina,'Editar',$nox[0],$nox[1],"&id=".$p->id);
	}
	if($_GET["id"]){
		$p = new datos();
		$p->id = $_GET["id"];
		$rwg = $p->traeTodoGuia();
		$p = $p->traeXid();
		include("vista/Manifiesto.php");
	}
	break;
case 'EditarGuia':
	if(isset($_POST["idedg"])){
		$p = new datos();
		$p->id = $_POST["idedg"];
		$p->manifiesto = $_POST["idm"];
		$p->codigo = $_POST["guia"];
		$p->cliente = $_POST["cliente"];
		$p->kilo = $_POST["kiloGuia"];
		$p->documento = $_POST["documento"];
		$p->din = $_POST["din"];
		$p->totalDin = $_POST["totalDin"];
		$p->tipo = $_POST["tipo"];
		$p->nroTipo = $_POST["nroTipo"];
		$p->neto = $_POST["neto"];
		$p->iva = $_POST["iva"];
		$p->total = $_POST["total"];
		$nox =$p->editarGuia();
		echo Accion::creaUrl($pagina,'Editar',$nox[0],$nox[1],"&id=".$p->manifiesto);
	}
	if(isset($_POST["idcg"])){
		$p = new datos();
		$p->id = $_POST["idcg"];
		$p->manifiesto = $_POST["idm"];
		$p->codigo = $_POST["guia"];
		$p->estado = $_POST["estado"];
		$p->observacion = $_POST["observacion"];
		$nox =$p->CerrarGuia();
		echo Accion::creaUrl($pagina,'Editar',$nox[0],$nox[1],"&id=".$p->manifiesto);
	}
	if($_GET["id"]){
		$p = new datos();
		$p->id = $_GET["id"];
		$p = $p->traeXidGuia();
		include("vista/Editar_guia.php");
	}
	if($_GET["idc"]){
		$p = new datos();
		$p->id = $_GET["idc"];
		$p = $p->traeXidGuia();
		include("vista/Cerrar_guia.php");
	}
	break;
case 'Eliminar':
	if(isset($_POST["idel"])){
		$p = new datos();
		$p->id = $_POST["idel"];
		$p->codigo = $_POST["codigo"];
		$nox =$p->eliminar();
		echo Accion::creaUrl($pagina,'Lista',$nox[0],$nox[1]);
	}
	if($_GET["id"]){
		$p = new datos();
		$p->id = $_GET["id"];
		$p = $p->traeXid();
		include("vista/Eliminar_vista.php");
	}
	break;
case 'EliminarGuia':
	if(isset($_POST["idelg"])){
		$p = new datos();
		$p->id = $_POST["idelg"];
		$p->manifiesto = $_POST["idm"];
		$p->codigo = $_POST["codigo"];
		$nox =$p->eliminarGuia();
		echo Accion::creaUrl($pagina,'Editar',$nox[0],$nox[1],"&id=".$p->manifiesto);
	}
	if($_GET["id"]){
		$p = new datos();
		$p->id = $_GET["id"];
		$p = $p->traeXidGuia();
		include("vista/Eliminar_guia.php");
	}
	break;
case 'NuevoGuia':
	if(isset($_POST["idnvg"])){
		$p = new datos();
		$p->manifiesto = $_POST["idm"];
		$p->codigo = $_POST["guia"];
		$p->cliente = $_POST["cliente"];
		$p->kilo = $_POST["kiloGuia"];
		$p->documento = $_POST["documento"];
		$p->din = $_POST["din"];
		$p->totalDin = $_POST["totalDin"];
		$p->tipo = $_POST["tipo"];
		$p->nroTipo = $_POST["nroTipo"];
		$p->neto = $_POST["neto"];
		$p->iva = $_POST["iva"];
		$p->total = $_POST["total"];
		$p->estado = 0;
		$p->fecha = date("d-m-Y H:i:s");
		$nox =$p->crearGuia();
		echo Accion::creaUrl($pagina,'Editar',$nox[0],$nox[1],"&id=".$_POST["idm"]);
		
	}
	if($_GET["id"]){
		$p = new datos();
		include("vista/Nuevo_vista.php");
	}
	break;
case 'PDF':
	if($_GET["id"]){
		$p = new datos();
		$p->id = $_GET["id"];
		$rwg = $p->traeTodoGuia();
		$p = $p->traeXid();
		include("vista/pdf.php");
	}
	break;
default:
	$p = new datos();
	$row1 = $p->traeTodo((isset($_POST['e'])?$_POST['e']:$_GET['e']),(isset($_POST['o'])?$_POST['o']:$_GET['o']),(isset($_POST['b'])?$_POST['b']:$_GET['b']));
	$pag = (isset($_REQUEST['pag']) && !empty($_REQUEST['pag']))?$_REQUEST['pag']:1;
	$totalReg = $row1->num_rows;
	$total_paginas = ceil($totalReg / NPAG);
	$inicioPag = ($pag - 1) * NPAG;
	$row = $p->traeFiltro((isset($_POST['e'])?$_POST['e']:$_GET['e']),(isset($_POST['o'])?$_POST['o']:$_GET['o']),(isset($_POST['b'])?$_POST['b']:$_GET['b']),$inicioPag);

	include("vista/Lista_vista.php");
	break;
}
?>