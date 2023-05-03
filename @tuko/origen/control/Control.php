<?php
$nox=isset($_GET['p'])?$_GET['p']:$_POST["p"];
switch ($nox) {
case 'Lista':
	$p = new datos();
	$row1 = $p->traeTodo((isset($_POST['b'])?$_POST['b']:$_GET['b']));
	$pag = (isset($_REQUEST['pag']) && !empty($_REQUEST['pag']))?$_REQUEST['pag']:1;
	$totalReg = $row1->num_rows;
	$total_paginas = ceil($totalReg / NPAG);
	$inicioPag = ($pag - 1) * NPAG;
	$row = $p->traeFiltro((isset($_POST['b'])?$_POST['b']:$_GET['b']),$inicioPag);

	include("vista/Lista_vista.php");
	break;
case 'Nuevo':
	if(isset($_POST["idnv"])){
		$p = new datos();
		$p->nombre = $_POST["nombre"];
		$p->rut = $_POST["rut"];
		$p->mas = $_POST["mas"];
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
		$p->nombre = $_POST["nombre"];
		$p->rut = $_POST["rut"];
		$p->mas = $_POST["mas"];
		$nox =$p->editar();
		echo Accion::creaUrl($pagina,'Editar',$nox[0],$nox[1],"&id=".$p->id);
	}
	if($_GET["id"]){
		$p = new datos();
		$p->id = $_GET["id"];
		$p = $p->traeXid();
		include("vista/Editar_vista.php");
	}
	break;
case 'Eliminar':
	if(isset($_POST["idel"])){
		$p = new datos();
		$p->id = $_POST["idel"];
		$p->nombre = $_POST["nombre"];
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
default:
	$p = new datos();
	$row1 = $p->traeTodo((isset($_POST['b'])?$_POST['b']:$_GET['b']));
	$pag = (isset($_REQUEST['pag']) && !empty($_REQUEST['pag']))?$_REQUEST['pag']:1;
	$totalReg = $row1->num_rows;
	$total_paginas = ceil($totalReg / NPAG);
	$inicioPag = ($pag - 1) * NPAG;
	$row = $p->traeFiltro((isset($_POST['b'])?$_POST['b']:$_GET['b']),$inicioPag);

	include("vista/Lista_vista.php");
	break;
}
?>